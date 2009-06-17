<?php
/***************************************************************
* Copyright notice
*
* (c) 2006-2009 Oliver Klee (typo3-coding@oliverklee.de)
* All rights reserved
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(PATH_t3lib . 'class.t3lib_basicfilefunc.php');

require_once(t3lib_extMgm::extPath('seminars') . 'lib/tx_seminars_constants.php');

/**
 * Class 'tx_seminars_pi1_eventEditor' for the 'seminars' extension.
 *
 * This class is a controller which allows to create and edit events on the FE.
 *
 * @package TYPO3
 * @subpackage tx_seminars
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class tx_seminars_pi1_eventEditor extends tx_seminars_pi1_frontEndEditor {
	/**
	 * @var string path to this script relative to the extension directory
	 */
	public $scriptRelPath = 'pi1/class.tx_seminars_pi1_eventEditor.php';

	/**
	 * @var string stores a validation error message if there was one
	 */
	private $validationError = '';

	/**
	 * @var array currently attached files
	 */
	private $attachedFiles = array();

	/**
	 * The constructor.
	 *
	 * After the constructor has been called, hasAccessMessage() must be called
	 * to ensure that the logged-in user is allowed to edit a given seminar.
	 *
	 * @param array TypoScript configuration for the plugin
	 * @param tslib_cObj the parent cObj content, needed for the flexforms
	 */
	public function __construct(array $configuration, tslib_cObj $cObj) {
		parent::__construct($configuration, $cObj);
	}

	/**
	 * Stores the currently attached files.
	 *
	 * Attached files are stored in a member variable and added to the form data
	 * afterwards, as the FORMidable renderlet is not usable for this.
	 */
	private function storeAttachedFiles() {
		if (!$this->isTestMode()) {
			$this->attachedFiles = t3lib_div::trimExplode(
				',',
				$this->getFormCreator()->oDataHandler
					->__aStoredData['attached_files'],
				true
			);
		} else {
			$this->attachedFiles = array();
		}
	}

	/**
	 * Declares the additional data handler for m:n relations.
	 */
	private function declareDataHandler() {
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ameos_formidable']
			['declaredobjects']['datahandlers']['DBMM'] = array(
				'key' => 'dh_dbmm', 'base' => true
			);
	}

	/**
	 * Gets the path to the HTML template as set in the TS setup or flexforms.
	 * The returned path will always be an absolute path in the file system;
	 * EXT: references will automatically get resolved.
	 *
	 * @return string the path to the HTML template as an absolute path in
	 *                the file system, will not be empty in a correct
	 *                configuration, will never be null
	 */
	public function getTemplatePath() {
		return t3lib_div::getFileAbsFileName($this->getConfValueString(
			'templateFile', 's_template_special', true
		));
	}

	/**
	 * Creates the HTML output.
	 *
	 * @return string HTML of the create/edit form
	 */
	public function render() {
		$this->setFormConfiguration($this->conf['form.']['eventEditor.']);
		$this->declareDataHandler();

		$this->storeAttachedFiles();

		$template = tx_oelib_ObjectFactory::make('tx_oelib_Template');
		$template->processTemplate(parent::render());

		// The redirect to the FE editor with the current record loaded can
		// only work with the record's UID, but new records do not have a UID
		// before they are saved.
		if ($this->getObjectUid() == 0) {
			$template->hideSubparts('submit_and_stay');
		}

		return $this->getHtmlWithAttachedFilesList($template);
	}

	/**
	 * Returns the complete HTML for the FE editor.
	 *
	 * As FORMidable does not provide any formatting for the list of
	 * attachments and saves the list with the first letter snipped, we provide
	 * our own formatted list to ensure correctly displayed attachments, even if
	 * there was a validation error.
	 *
	 * @param tx_oelib_Template holds the raw HTML output, must be already
	 *                          processed by FORMidable
	 *
	 * @return string HTML for the FE editor with the formatted attachment
	 *                list if there are attached files, will not be empty
	 */
	private function getHtmlWithAttachedFilesList(tx_oelib_Template $template) {
		foreach (array(
			'label_delete', 'label_really_delete', 'label_save',
			'label_save_and_back',
		) as $label) {
			$template->setMarker($label, $this->translate($label));
		}

		$originalAttachmentList = $this->getFormCreator()->oDataHandler->oForm
			->aORenderlets['attached_files']->mForcedValue;

		if (($originalAttachmentList != '') && !empty($this->attachedFiles)) {
			$attachmentList = '';
			$fileNumber = 1;
			foreach ($this->attachedFiles as $fileName) {
				$template->setMarker('file_name', $fileName);
				$template->setMarker(
					'single_attached_file_id', 'attached_file_' . $fileNumber
				);
				$fileNumber++;
				$attachmentList .= $template->getSubpart('SINGLE_ATTACHED_FILE');
			}
			$template->setSubpart('single_attached_file', $attachmentList);
		} else {
			$template->hideSubparts('attached_files');
		}

		$result = $template->getSubpart();

		// Removes FORMidable's original attachment list from the result.
		if ($originalAttachmentList != '') {
			$result = str_replace($originalAttachmentList . '<br />', '', $result);
		}

		return $result;
	}

	/**
	 * Provides data items for the list of available categories.
	 *
	 * @param array any pre-filled data (may be empty)
	 *
	 * @return array $items with additional items from the categories
	 *               table as an array with the keys "caption" (for the
	 *               title) and "value" (for the UID)
	 */
	public function populateListCategories(array $items) {
		return $this->populateList($items, SEMINARS_TABLE_CATEGORIES);
	}

	/**
	 * Provides data items for the list of available event types.
	 *
	 * @param array any pre-filled data (may be empty)
	 *
	 * @return array $items with additional items from the event_types
	 *               table as an array with the keys "caption" (for the
	 *               title) and "value" (for the UID)
	 */
	public function populateListEventTypes(array $items) {
		return $this->populateList($items, SEMINARS_TABLE_EVENT_TYPES);
	}

	/**
	 * Provides data items for the list of available lodgings.
	 *
	 * @param array any pre-filled data (may be empty)
	 *
	 * @return array $items with additional items from the lodgings table
	 *               as an array with the keys "caption" (for the title)
	 *               and "value" (for the UID)
	 */
	public function populateListLodgings(array $items) {
		return $this->populateList($items, SEMINARS_TABLE_LODGINGS);
	}

	/**
	 * Provides data items for the list of available foods.
	 *
	 * @param array any pre-filled data (may be empty)
	 *
	 * @return array $items with additional items from the foods table
	 *               as an array with the keys "caption" (for the title)
	 *               and "value" (for the UID)
	 */
	public function populateListFoods(array $items) {
		return $this->populateList($items, SEMINARS_TABLE_FOODS);
	}

	/**
	 * Provides data items for the list of available payment methods.
	 *
	 * @param array any pre-filled data (may be empty)
	 *
	 * @return array $items with additional items from payment methods
	 *               table as an array with the keys "caption" (for the
	 *               title) and "value" (for the UID)
	 */
	public function populateListPaymentMethods(array $items) {
		return $this->populateList($items, SEMINARS_TABLE_PAYMENT_METHODS);
	}

	/**
	 * Provides data items for the list of available organizers.
	 *
	 * @param array any pre-filled data (may be empty)
	 *
	 * @return array $items with additional items from the organizers
	 *               table as an array with the keys "caption" (for the
	 *               title) and "value" (for the UID)
	 */
	public function populateListOrganizers(array $items) {
		return $this->populateList($items, SEMINARS_TABLE_ORGANIZERS);
	}

	/**
	 * Provides data items for the list of available places.
	 *
	 * @param array any pre-filled data (may be empty)
	 *
	 * @return array $items with additional items from the places table
	 *               as an array with the keys "caption" (for the title)
	 *               and "value" (for the UID)
	 */
	public function populateListPlaces(array $items) {
		return $this->populateList($items, SEMINARS_TABLE_SITES);
	}

	/**
	 * Provides data items for the list of available speakers.
	 *
	 * @param array any pre-filled data (may be empty)
	 *
	 * @return array $items with additional items from the speakers table
	 *               as an array with the keys "caption" (for the title)
	 *               and "value" (for the UID)
	 */
	public function populateListSpeakers(array $items) {
		return $this->populateList($items, SEMINARS_TABLE_SPEAKERS);
	}

	/**
	 * Provides data items for the list of available checkboxes.
	 *
	 * @param array any pre-filled data (may be empty)
	 *
	 * @return array $items with additional items from the checkboxes
	 *               table as an array with the keys "caption" (for the
	 *               title) and "value" (for the UID)
	 */
	public function populateListCheckboxes(array $items) {
		return $this->populateList($items, SEMINARS_TABLE_CHECKBOXES);
	}

	/**
	 * Provides data items for the list of available target groups.
	 *
	 * @param array any pre-filled data (may be empty)
	 *
	 * @return array $items with additional items from the target groups
	 *               table as an array with the keys "caption" (for the
	 *               title) and "value" (for the UID)
	 */
	public function populateListTargetGroups(array $items) {
		return $this->populateList($items, SEMINARS_TABLE_TARGET_GROUPS);
	}

	/**
	 * Gets the URL of the page that should be displayed when an event has been
	 * successfully created.
	 * An URL of the FE editor's page is returned if "submit_and_stay" was
	 * clicked.
	 *
	 * @return string complete URL of the FE page with a message or, if
	 *                "submit_and_stay" was clicked, of the current page
	 */
	public function getEventSuccessfullySavedUrl() {
		$additionalParameters = '';

		if ($this->getFormValue('proceed_file_upload')) {
			$additionalParameters = t3lib_div::implodeArrayForUrl(
				$this->prefixId,
				array('seminar' => $this->getObjectUid())
			);
			$pageId =  $GLOBALS['TSFE']->id;
		} else {
			$pageId =  $this->getConfValueInteger(
				'eventSuccessfullySavedPID', 's_fe_editing'
			);
		}

		return t3lib_div::locationHeaderUrl(
			$this->cObj->typoLink_URL(array(
				'parameter' => $pageId,
				'additionalParams' => $additionalParameters,
			))
		);
	}

	/**
	 * Checks whether the currently logged-in FE user (if any) belongs to the
	 * FE group that is allowed to enter and edit event records in the FE.
	 * This group can be set using plugin.tx_seminars.eventEditorFeGroupID.
	 *
	 * It also is checked whether that event record exists and the logged-in
	 * FE user is the owner or is editing a new record.
	 *
	 * @return string locallang key of an error message, will be an empty
	 *                string if access was granted
	 */
	private function checkAccess() {
		if (!tx_oelib_FrontEndLoginManager::getInstance()->isLoggedIn()) {
			return 'message_notLoggedIn';
		}

		if (($this->getObjectUid() > 0)
			&& !tx_seminars_objectfromdb::recordExists(
				$this->getObjectUid(), SEMINARS_TABLE_SEMINARS
			)
		) {
			return 'message_wrongSeminarNumber';
		}

		if ($this->getObjectUid() > 0) {
			$seminar = tx_oelib_ObjectFactory::make(
				'tx_seminars_seminar', $this->getObjectUid()
			);
			$isUserVip = $seminar->isUserVip(
				$this->getFeUserUid(),
				$this->getConfValueInteger('defaultEventVipsFeGroupID')
			);
			$isUserOwner = $seminar->isOwnerFeUser();
			$seminar->__destruct();
			unset($seminar);
			$mayManagersEditTheirEvents = $this->getConfValueBoolean(
				'mayManagersEditTheirEvents', 's_listView'
			);

			$hasAccess = $isUserOwner
				|| ($mayManagersEditTheirEvents && $isUserVip);
		} else {
			$eventEditorGroupUid = $this->getConfValueInteger(
				'eventEditorFeGroupID', 's_fe_editing'
			);
			$hasAccess = ($eventEditorGroupUid != 0)
				&& tx_oelib_FrontEndLoginManager::getInstance()
					->getLoggedInUser()->hasGroupMembership($eventEditorGroupUid);
		}

		return ($hasAccess ? '' : 'message_noAccessToEventEditor');
	}

	/**
	 * Checks whether the currently logged-in FE user (if any) belongs to the
	 * FE group that is allowed to enter and edit event records in the FE.
	 * This group can be set using plugin.tx_seminars.eventEditorFeGroupID.
	 * If the FE user does not have the necessary permissions, a localized error
	 * message will be returned.
	 *
	 * @return string an empty string if a user is logged in and allowed
	 *                to enter and edit events, a localized error message
	 *                otherwise
	 */
	public function hasAccessMessage() {
		$result = '';
		$errorMessage = $this->checkAccess();

		if ($errorMessage != '') {
			$this->setMarker('error_text', $this->translate($errorMessage));
			$result = $this->getSubpart('ERROR_VIEW');
		}

		return $result;
	}

	/**
	 * Changes all potential decimal separators (commas and dots) in price
	 * fields to dots.
	 *
	 * @param array all entered form data with the field names as keys,
	 *              will be modified, must not be empty
	 */
	private function unifyDecimalSeparators(array &$formData) {
		$priceFields = array(
			'price_regular', 'price_regular_early', 'price_regular_board',
			'price_special', 'price_special_early', 'price_special_board',
		);

		foreach ($priceFields as $key) {
			if (isset($formData[$key])) {
				$formData[$key]
					= str_replace(',', '.', $formData[$key]);
			}
		}
	}

	/**
	 * Processes the deletion of attached files and sets the form value for
	 * "attached_files" to the locally stored value for this field.
	 *
	 * This is done because when FORMidable processes the upload renderlet,
	 * the first character of the string might get lost. In addition, with
	 * FORMidable, it is possible to store the name of an invalid file in the
	 * list of attachments.
	 *
	 * @param array form data, will be modified, must not be empty
	 */
	private function processAttachments(array &$formData) {
		$filesToDelete = t3lib_div::trimExplode(
			',', $formData['delete_attached_files'], true
		);

		foreach ($filesToDelete as $fileName) {
			// saves other files in the upload folder from being deleted
			if (in_array($fileName, $this->attachedFiles)) {
				$this->purgeUploadedFile($fileName);
			}
		}

		$formData['attached_files'] = implode(',', $this->attachedFiles);
	}

	/**
	 * Removes the form data elements "proceed_file_upload" and
	 * "delete_attached_files" as they are no fields in the seminars table.
	 *
	 * @param array form data, will be modified, must not be empty
	 */
	private function purgeNonSeminarsFields(array &$formData) {
		unset(
			$formData['proceed_file_upload'],
			$formData['delete_attached_files']
		);
	}

	/**
	 * Adds some values to the form data before insertion into the database.
	 * Added values for new objects are: 'crdate', 'tstamp', 'pid' and
	 * 'owner_feuser'.
	 * For objects to update, just the 'tstamp' will be refreshed.
	 *
	 * @param array form data, will be modified, must not be empty
	 */
	private function addAdministrativeData(array &$formData) {
		$formData['tstamp'] = mktime();

		// Updating the timestamp is sufficent for existing records.
		if ($this->iEdition) {
			return;
		}

		$formData['crdate'] = mktime();
		$formData['owner_feuser'] = $this->getFeUserUid();
		$formData['pid'] = $this->getConfValueInteger(
			'createEventsPID', 's_fe_editing'
		);
	}

	/**
	 * Checks the publish settings of the user and hides the event record if
	 * necessary.
	 *
	 * @param array form data, will be modified if the seminar must be hidden
	 *              corresponding to the publish settings of the user, must not
	 *              be empty
	 */
	private function checkPublishSettings(array &$formData) {
		$publishSetting	= tx_oelib_FrontEndLoginManager::getLoggedInUser(
			'tx_seminars_Mapper_FrontEndUser')->getPublishSetting();
		$isNew = $this->getObjectUid() == 0;

		$hideEditedObject = !$isNew
			&& ($publishSetting
				== tx_seminars_Model_FrontEndUserGroup::PUBLISH_HIDE_EDITED
			);
		$hideNewObject = $isNew
			&& ($publishSetting
				> tx_seminars_Model_FrontEndUserGroup::PUBLISH_IMMEDIATELY
			);

		if ($hideEditedObject || $hideNewObject) {
			$formData['hidden'] = 1;
		}
	}

	/**
	 * Unifies decimal separators, processes the deletion of attachments and
	 * purges non-seminars-fields.
	 *
	 * @see unifyDecimalSeparators(), processAttachments(),
	 *      purgeNonSeminarsFields(), addAdministrativeData()
	 *
	 * @param array form data, must not be empty
	 *
	 * @return array modified form data, will not be empty
	 */
	public function modifyDataToInsert(array $formData) {
		$modifiedFormData = $formData;

		$this->processAttachments($modifiedFormData);
		$this->purgeNonSeminarsFields($modifiedFormData);
		$this->unifyDecimalSeparators($modifiedFormData);
		$this->addAdministrativeData($modifiedFormData);
		$this->checkPublishSettings($modifiedFormData);

		return $modifiedFormData;
	}

	/**
	 * Checks whether the provided file is of an allowed type and size. If it
	 * is, it is appended to the list of already attached files. If not, the
	 * file deleted becomes from the upload directory and the validation error
	 * is stored in $this->validationError.
	 *
	 * This check is done here because the FORMidable validators do not allow
	 * multiple error messages.
	 *
	 * @param array form data to check, must not be empty
	 *
	 * @return boolean true if the provided file is valid, false otherwise
	 */
	public function checkFile(array $valueToCheck) {
		$this->validationError = '';

		// If these values match, no files have been uploaded and we need no
		// further check.
		if ($valueToCheck['value'] == implode(',', $this->attachedFiles)) {
			return true;
		}

		$fileToCheck = array_pop(
			t3lib_div::trimExplode(',', $valueToCheck['value'], true)
		);

		$this->checkFileSize($fileToCheck);
		$this->checkFileType($fileToCheck);

		// If there is a validation error, the upload has to be done again.
		if (($this->validationError == '')
			&& ($this->isTestMode
				|| $this->getFormCreator()->oDataHandler->_allIsValid()
			)
		) {
			array_push($this->attachedFiles, $fileToCheck);
		} else {
			$this->purgeUploadedFile($fileToCheck);
		}

		return ($this->validationError == '');
	}

	/**
	 * Checks whether an uploaded file is of a valid type.
	 *
	 * @param string file name, must match an uploaded file, must not be empty
	 */
	private function checkFileType($fileName) {
		$allowedExtensions = $this->getConfValueString(
			'allowedExtensionsForUpload', 's_fe_editing'
		);

		if (!preg_match(
			'/^.+\.(' . str_replace(',', '|', $allowedExtensions) . ')$/i',
			$fileName
		)) {
			$this->validationError
				= $this->translate('message_invalid_type') .
					' ' . str_replace(',', ', ', $allowedExtensions) . '.';
		}
	}

	/**
	 * Checks whether an uploaded file is not too large.
	 *
	 * @param string file name, must match an uploaded file, must not be empty
	 */
	private function checkFileSize($fileName) {
		$maximumFileSize = $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'];
		$fileInformation = t3lib_div::makeInstance('t3lib_basicFileFunctions')
			->getTotalFileInfo(PATH_site . 'uploads/tx_seminars/' . $fileName);

		if ($fileInformation['size'] > ($maximumFileSize * 1024)) {
			$this->validationError
				= $this->translate('message_file_too_large') .
					' ' . $maximumFileSize . 'kB.';
		}
	}

	/**
	 * Deletes a file in the seminars upload directory and removes it from the
	 * list of currently attached files.
	 *
	 * @param string file name, must match an uploaded file, must not be empty
	 *
	 * @return string comma-separated list with the still attached files,
	 *                will be empty if the last attachment was removed
	 */
	private function purgeUploadedFile($fileName) {
		@unlink(PATH_site . 'uploads/tx_seminars/' . $fileName);
		$keyToPurge = array_search($fileName, $this->attachedFiles);
		if($keyToPurge !== false) {
			unset($this->attachedFiles[$keyToPurge]);
		}
	}

	/**
	 * Returns an error message if the provided file was invalid.
	 *
	 * @return string localized validation error message, will be empty if
	 *                $this->validationError was empty
	 */
	public function getFileUploadErrorMessage() {
		return $this->validationError;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/seminars/pi1/class.tx_seminars_pi1_eventEditor.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/seminars/pi1/class.tx_seminars_pi1_eventEditor.php']);
}
?>