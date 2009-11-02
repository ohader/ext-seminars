<?php
/***************************************************************
* Copyright notice
*
* (c) 2007-2009 Niels Pardon (mail@niels-pardon.de)
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

require_once(t3lib_extMgm::extPath('seminars') . 'pi2/class.tx_seminars_pi2.php');

/**
 * Class 'events list' for the 'seminars' extension.
 *
 * @package TYPO3
 * @subpackage tx_seminars
 *
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class tx_seminars_BackEnd_EventsList extends tx_seminars_BackEnd_List {
	/**
	 * @var string the name of the table we're working on
	 */
	protected $tableName = 'tx_seminars_seminars';

	/**
	 * @var tx_seminars_seminar the seminar which we want to list
	 */
	private $seminar = null;

	/**
	 * @var string the path to the template file of this list
	 */
	protected $templateFile = 'EXT:seminars/Resources/Private/Templates/BackEnd/EventsList.html';

	/**
	 * Frees as much memory that has been used by this object as possible.
	 */
	public function __destruct() {
		if ($this->seminar) {
			$this->seminar->__destruct();
			unset($this->seminar);
		}

		parent::__destruct();
	}

	/**
	 * Generates and prints out an event list.
	 *
	 * @return string the HTML source code of the event list
	 */
	public function show() {
		$content = '';

		$this->template->setMarker(
			'label_accreditation_number',
			$GLOBALS['LANG']->getLL('eventlist.accreditation_number')
		);
		$this->template->setMarker(
			'label_title', $GLOBALS['LANG']->getLL('eventlist.title')
		);
		$this->template->setMarker(
			'label_date', $GLOBALS['LANG']->getLL('eventlist.date')
		);
		$this->template->setMarker(
			'label_attendees', $GLOBALS['LANG']->getLL('eventlist.attendees')
		);
		$this->template->setMarker(
			'label_number_of_attendees_on_queue',
			$GLOBALS['LANG']->getLL('eventlist.attendeesOnRegistrationQueue')
		);
		$this->template->setMarker(
			'label_minimum_number_of_attendees',
			$GLOBALS['LANG']->getLL('eventlist.attendees_min')
		);
		$this->template->setMarker(
			'label_maximum_number_of_attendees',
			$GLOBALS['LANG']->getLL('eventlist.attendees_max')
		);
		$this->template->setMarker(
			'label_has_enough_attendees',
			$GLOBALS['LANG']->getLL('eventlist.enough_attendees')
		);
		$this->template->setMarker(
			'label_is_fully_booked', $GLOBALS['LANG']->getLL('eventlist.is_full')
		);
		$this->template->setMarker(
			'label_status', $GLOBALS['LANG']->getLL('eventlist_status')
		);

		$builder = tx_oelib_ObjectFactory::make('tx_seminars_seminarbagbuilder');
		$builder->setBackEndMode();

		$pageData = $this->page->getPageData();
		$builder->setSourcePages($pageData['uid'], self::RECURSION_DEPTH);

		$seminarBag = $builder->build();

		$sortList = array();

		// unserializes the configuration array
		$globalConfiguration = unserialize(
			$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['seminars']
		);

		$useManualSorting = $globalConfiguration['useManualSorting']
			&& $GLOBALS['BE_USER']->check('tables_modify', SEMINARS_TABLE_SEMINARS)
			&& $GLOBALS['BE_USER']->doesUserHaveAccess(
				t3lib_BEfunc::getRecord(
					'pages', $pageData['uid']
				),
				16
			);

		if ($useManualSorting) {
			// Initializes the array which holds the two previous records' UIDs.
			$previousUids = array(
				// contains the UID of the predecessor of the current record
				0,
				// contains the negative UID of the predecessor's predecessor
				// or the current PID
				0
			);

			foreach ($seminarBag as $this->seminar) {
				$uid = $this->seminar->getUid();

				// Sets the "previous" and "next" elements in the $sortList
				// array only if we already got the predecessor of the
				// current record in $previousUids[0]. This will be the case
				// after the first iteration.
				if ($previousUids[0]) {
					// Sets the "previous" element of the current record to the
					// predecessor of the previous record.
					// This means when clicking on the "up" button the current
					// record will be moved after the predecessor of the previous
					// record.
					$sortList[$uid]['previous'] = $previousUids[1];

					// Sets the "next" element of the previous record to the
					// negative UID of the current record.
					// This means when clicking on the "down" button the previous
					// record will be moved after the current record.
					$sortList[$previousUids[0]]['next'] = -$uid;
				}

				// Sets the predecessor of the previous record to the negative
				// UID of the previous record if the previous record of the
				// current record is set already. Else set the predecessor of
				// the previous record to the PID.
				// That means if no predecessor of the previous record exists
				// than move the current record to top of the current page.
				$previousUids[1] = isset($sortList[$uid]['previous'])
					? -$previousUids[0] : $pageData['uid'];

				// Sets previous record to the current record's UID.
				$previousUids[0] = $uid;

				// Gets the next record and go to the start of the loop.
			}
		}

		$tableRows = '';

		foreach ($seminarBag as $this->seminar) {
			$this->template->setMarker('uid', $this->seminar->getUid());
			$this->template->setMarker('icon', $this->seminar->getRecordIcon());
			$this->template->setMarker(
				'accreditation_number',
				htmlspecialchars($this->seminar->getAccreditationNumber())
			);
			$this->template->setMarker(
				'title',
				htmlspecialchars(
					t3lib_div::fixed_lgd_cs(
						$this->seminar->getRealTitle(),
						$GLOBALS['BE_USER']->uc['titleLen']
					)
				)
			);
			$this->template->setMarker(
				'date',
				($this->seminar->hasDate() ? $this->seminar->getDate() : '')
			);
			$this->template->setMarker(
				'edit_button',
				$this->getEditIcon(
					$this->seminar->getUid(), $this->seminar->getPageUid()
				)
			);
			$this->template->setMarker(
				'delete_button',
				$this->getDeleteIcon(
					$this->seminar->getUid(), $this->seminar->getPageUid()
				)
			);
			$this->template->setMarker(
				'hide_unhide_button',
				$this->getHideUnhideIcon(
					$this->seminar->getUid(),
					$this->seminar->getPageUid(),
					$this->seminar->isHidden()
				)
			);
			$this->template->setMarker(
				'up_down_buttons',
				$this->getUpDownIcons(
					$useManualSorting, $sortList, $this->seminar->getUid()
				)
			);
			$this->template->setMarker(
				'csv_registration_export_button',
				(($this->seminar->needsRegistration()
						&& !$this->seminar->isHidden())
					? $this->getRegistrationsCsvIcon() : '')
			);
			$this->template->setMarker(
				'number_of_attendees',
				($this->seminar->needsRegistration()
					? $this->seminar->getAttendances() : '')
			);
			$this->template->setMarker(
				'number_of_attendees_on_queue',
				($this->seminar->hasRegistrationQueue()
					? $this->seminar->getAttendancesOnRegistrationQueue()
					: '')
			);
			$this->template->setMarker(
				'minimum_number_of_attendees',
				($this->seminar->needsRegistration()
					? $this->seminar->getAttendancesMin()
					: '')
			);
			$this->template->setMarker(
				'maximum_number_of_attendees',
				($this->seminar->needsRegistration()
					? $this->seminar->getAttendancesMax()
					: '')
			);
			$this->template->setMarker(
				'has_enough_attendees',
				($this->seminar->needsRegistration()
					? (!$this->seminar->hasEnoughAttendances()
						? $GLOBALS['LANG']->getLL('no') : $GLOBALS['LANG']->getLL('yes'))
					: '')
			);
			$this->template->setMarker(
				'is_fully_booked',
				($this->seminar->needsRegistration()
					? (!$this->seminar->isFull()
						? $GLOBALS['LANG']->getLL('no') : $GLOBALS['LANG']->getLL('yes'))
					: '')
			);
			$this->template->setMarker(
				'status', $this->getStatusIcon()
			);

			$this->setCancelButtonMarkers();
			$this->setConfirmButtonMarkers();

			$tableRows .= $this->template->getSubpart('EVENT_ROW');
		}

		$this->template->setSubpart('EVENT_ROW', $tableRows);

		$this->template->setMarker(
			'new_record_button', $this->getNewIcon($pageData['uid'])
		);

		$this->template->setMarker(
			'csv_event_export_button',
			(!$seminarBag->isEmpty() ? $this->getCsvIcon() : '')
		);

		$content .= $this->template->getSubpart('SEMINARS_EVENT_LIST');

		// Checks the BE configuration and the CSV export configuration.
		$content .= $seminarBag->checkConfiguration();
		$seminarBag->__destruct();

		return $content;
	}

	/**
	 * Returns an HTML image tag for an icon that represents the status "canceled"
	 * or "confirmed". If the event's status is "planned", an empty string will be
	 * returned.
	 *
	 * @return string HTML image tag, may be empty
	 */
	private function getStatusIcon() {
		if (!$this->seminar->isCanceled() && !$this->seminar->isConfirmed()) {
			return '';
		}

		if ($this->seminar->isConfirmed()) {
			$icon = 'icon_confirmed.png';
			$labelKey = 'eventlist_status_confirmed';
		} elseif ($this->seminar->isCanceled()) {
			$icon = 'icon_canceled.png';
			$labelKey = 'eventlist_status_canceled';
		}
		$label = $GLOBALS['LANG']->getLL($labelKey);

		return '<img src="' . $icon . '" title="' . $label . '" alt="' . $label . '" />';
	}

	/**
	 * Generates a linked CSV export icon for registrations from $this->seminar
	 * if that event has at least one registration and access to all involved
	 * registration records is granted.
	 *
	 * $this->seminar must be initialized when this function is called.
	 *
	 * @return string the HTML for the linked image (followed by a non-breaking
	 *                space) or an empty string
	 */
	public function getRegistrationsCsvIcon() {
		global $BACK_PATH, $LANG;

		static $accessChecker = null;
		if (!$accessChecker) {
			$accessChecker = tx_oelib_ObjectFactory::make('tx_seminars_pi2');
			$accessChecker->init();
		}

		$result = '';

		$eventUid = $this->seminar->getUid();

		if ($this->seminar->hasAttendances()
			&& $accessChecker->canAccessListOfRegistrations($eventUid)) {
			$pageData = $this->page->getPageData();
			$langCsv = $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xml:labels.csv', 1);
			$result = '<a href="class.tx_seminars_BackEnd_CSV.php?id=' .
				$pageData['uid'] .
				'&amp;tx_seminars_pi2[table]=' . SEMINARS_TABLE_ATTENDANCES .
				'&amp;tx_seminars_pi2[seminar]=' . $eventUid . '">' .
				'<img' .
				t3lib_iconWorks::skinImg(
					$BACK_PATH,
					'gfx/csv.gif',
					'width="27" height="14"'
				) .
				' title="' . $langCsv . '" alt="' . $langCsv . '" class="icon" />' .
				'</a>&nbsp;';
		}

		return $result;
	}

	/**
	 * Sets the markers of a button for canceling an event. The button will only
	 * be visible if
	 * - the current record is either a date or single event record
	 * - the event is not canceled yet
	 * - the event has not started yet
	 * In all other cases the corresponding subpart is hidden.
	 */
	private function setCancelButtonMarkers() {
		$this->template->unhideSubpartsArray(array('CANCEL_BUTTON'));
		$pageData = $this->page->getPageData();

		if (($this->seminar->getRecordType() != SEMINARS_RECORD_TYPE_TOPIC)
			&& !$this->seminar->isHidden()
			&& !$this->seminar->isCanceled()
			&& !$this->seminar->hasStarted()
			&& $GLOBALS['BE_USER']->check('tables_modify', $this->tableName)
			&& $this->doesUserHaveAccess($this->seminar->getPageUid())
		) {
			$this->template->setMarker('uid', $this->seminar->getUid());
			$this->template->setMarker(
				'cancel_button_url',
				'index.php?id=' . $pageData['uid'] . '&amp;subModule=1'
			);
			$this->template->setMarker(
				'label_cancel_button',
				$GLOBALS['LANG']->getLL('eventlist_button_cancel')
			);
		} else {
			$this->template->hideSubpartsArray(array('CANCEL_BUTTON'));
		}
	}

	/**
	 * Sets the markers of a button for confirming an event. The button will
	 * only be visible if
	 * - the current record is either a date or single event record
	 * - the event is not confirmed yet
	 * - the event has not started yet
	 * In all other cases the corresponding subpart is hidden.
	 */
	private function setConfirmButtonMarkers() {
		$this->template->unhideSubpartsArray(array('CONFIRM_BUTTON'));
		$pageData = $this->page->getPageData();

		if (($this->seminar->getRecordType() != SEMINARS_RECORD_TYPE_TOPIC)
			&& !$this->seminar->isHidden()
			&& !$this->seminar->isConfirmed()
			&& !$this->seminar->hasStarted()
			&& $GLOBALS['BE_USER']->check('tables_modify', $this->tableName)
			&& $this->doesUserHaveAccess($this->seminar->getPageUid())
		) {
			$this->template->setMarker('uid', $this->seminar->getUid());
			$this->template->setMarker(
				'confirm_button_url',
				'index.php?id=' . $pageData['uid'] . '&amp;subModule=1'
			);
			$this->template->setMarker(
				'label_confirm_button',
				$GLOBALS['LANG']->getLL('eventlist_button_confirm')
			);
		} else {
			$this->template->hideSubpartsArray(array('CONFIRM_BUTTON'));
		}
	}

	/**
	 * Generates linked up and/or down icons depending on the manual sorting.
	 *
	 * @param boolean if true the linked up and/or down icons get generated
	 *                else they won't get generated
	 * @param array An array which contains elements that have the record's
	 *              UIDs as keys and an array with the two elements "previous"
	 *              and "next" as values. The two elements' values are the
	 *              negative UIDs of the records they should be moved after
	 *              when the up (previous) or down (next) button is clicked.
	 *              Except the second record's "previous" entry will be the
	 *              PID of the current page so the record will be moved to
	 *              the top of the current page when the up button is clicked.
	 * @param integer the UID of the current record, must be > 0
	 *
	 * @return string the HTML source code of the linked up and/or down icons
	 *                (or an empty string if manual sorting is deactivated)
	 */
	protected function getUpDownIcons($useManualSorting, array &$sortList, $uid) {
		$result = '';

		if ($useManualSorting) {
			$params = '&cmd[' . $this->tableName . '][' . $uid . '][move]=';

			$result = $this->getSingleUpOrDownIcon(
					'up',
					$params . $sortList[$uid]['previous'],
					$sortList[$uid]['previous']
				) .
				$this->getSingleUpOrDownIcon(
					'down',
					$params . $sortList[$uid]['next'],
					$sortList[$uid]['next']
				);
		}

		return $result;
	}

	/**
	 * Generates a single linked up or down icon depending on the type parameter.
	 *
	 * @param string the type of the icon ("up" or "down")
	 * @param string the command for TCEmain
	 * @param integer the negative UID of the record where the current record
	 *                will be moved after if the button was clicked or the
	 *                positive PID if the current icon is the second in the
	 *                list and we should generate an up button
	 *
	 * @return string the HTML source code of a single linked up or down icon
	 */
	protected function getSingleUpOrDownIcon($type, $params, $moveToUid) {
		global $LANG, $BACK_PATH;

		$result = '';

		if (isset($moveToUid)) {
			$result = '<a href="' . htmlspecialchars(
					$this->page->doc->issueCommand($params)
				) . '">' .
				'<img'.t3lib_iconWorks::skinImg(
					$BACK_PATH,
					'gfx/button_' . $type . '.gif',
					'width="11" height="10"'
				) . ' title="' . $GLOBALS['LANG']->getLL('move' . ucfirst($type), 1) . '"' .
				' alt="' . $GLOBALS['LANG']->getLL('move' . ucfirst($type), 1) . '" />' .
				'</a>';
		} else {
			$result = '<span class="clearUpDownButton"></span>';
		}

		return $result;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/seminars/BackEnd/class.tx_seminars_BackEnd_EventsList.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/seminars/BackEnd/class.tx_seminars_BackEnd_EventsList.php']);
}
?>