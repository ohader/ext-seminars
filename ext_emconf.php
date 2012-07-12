<?php

########################################################################
# Extension Manager/Repository config file for ext "seminars".
#
# Auto generated 11-02-2012 17:31
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Seminar Manager',
	'description' => 'This extension allows you to create and manage a list of seminars, workshops, lectures, theater performances and other events, allowing front-end users to sign up. FE users also can create and edit events.',
	'category' => 'plugin',
	'shy' => 0,
	'dependencies' => 'cms,css_styled_content,oelib,ameos_formidable,static_info_tables,static_info_tables_taxes',
	'conflicts' => 'dbal,sourceopt',
	'priority' => '',
	'loadOrder' => '',
	'module' => 'BackEnd,BackEndExtJs',
	'state' => 'beta',
	'internal' => 0,
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => 'be_groups,fe_groups,fe_users',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author' => 'Oliver Klee',
	'author_email' => 'typo3-coding@oliverklee.de',
	'author_company' => 'oliverklee.de',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '0.9.73',
	'_md5_values_when_last_written' => 'a:297:{s:13:"changelog.txt";s:4:"4085";s:20:"class.ext_update.php";s:4:"78b4";s:37:"class.tx_seminars_EmailSalutation.php";s:4:"c491";s:33:"class.tx_seminars_configcheck.php";s:4:"a684";s:34:"class.tx_seminars_configgetter.php";s:4:"59ae";s:31:"class.tx_seminars_flexForms.php";s:4:"22d1";s:34:"class.tx_seminars_registration.php";s:4:"d6e7";s:41:"class.tx_seminars_registrationmanager.php";s:4:"3594";s:29:"class.tx_seminars_seminar.php";s:4:"bb1b";s:29:"class.tx_seminars_speaker.php";s:4:"5b37";s:29:"class.tx_seminars_tcemain.php";s:4:"e48d";s:30:"class.tx_seminars_timeslot.php";s:4:"8217";s:30:"class.tx_seminars_timespan.php";s:4:"2312";s:16:"ext_autoload.php";s:4:"30a6";s:21:"ext_conf_template.txt";s:4:"a043";s:12:"ext_icon.gif";s:4:"35fc";s:17:"ext_localconf.php";s:4:"2fc4";s:14:"ext_tables.php";s:4:"a3f1";s:14:"ext_tables.sql";s:4:"b5cd";s:13:"locallang.xml";s:4:"0f11";s:16:"locallang_db.xml";s:4:"671f";s:8:"todo.txt";s:4:"9f3f";s:36:"tx_seminars_modifiedSystemTables.php";s:4:"5f84";s:33:"BackEnd/AbstractEventMailForm.php";s:4:"24c8";s:24:"BackEnd/AbstractList.php";s:4:"753a";s:19:"BackEnd/BackEnd.css";s:4:"b59c";s:15:"BackEnd/CSV.php";s:4:"ed8b";s:31:"BackEnd/CancelEventMailForm.php";s:4:"bb4c";s:32:"BackEnd/ConfirmEventMailForm.php";s:4:"0bb6";s:22:"BackEnd/EventsList.php";s:4:"1a43";s:32:"BackEnd/GeneralEventMailForm.php";s:4:"6241";s:18:"BackEnd/Module.php";s:4:"2279";s:26:"BackEnd/OrganizersList.php";s:4:"b2a5";s:29:"BackEnd/RegistrationsList.php";s:4:"3015";s:24:"BackEnd/SpeakersList.php";s:4:"9c2f";s:16:"BackEnd/conf.php";s:4:"7ce7";s:17:"BackEnd/index.php";s:4:"00a2";s:21:"BackEnd/locallang.xml";s:4:"298f";s:25:"BackEnd/locallang_mod.xml";s:4:"0cdd";s:22:"BackEnd/moduleicon.gif";s:4:"032e";s:27:"BackEndExtJs/ClearCache.php";s:4:"ee52";s:23:"BackEndExtJs/Module.php";s:4:"e528";s:21:"BackEndExtJs/conf.php";s:4:"9c7f";s:22:"BackEndExtJs/index.php";s:4:"d4e0";s:34:"BackEndExtJs/Ajax/AbstractList.php";s:4:"a59d";s:32:"BackEndExtJs/Ajax/Dispatcher.php";s:4:"2e5e";s:32:"BackEndExtJs/Ajax/EventsList.php";s:4:"0628";s:36:"BackEndExtJs/Ajax/OrganizersList.php";s:4:"0577";s:39:"BackEndExtJs/Ajax/RegistrationsList.php";s:4:"06c1";s:34:"BackEndExtJs/Ajax/SpeakersList.php";s:4:"0389";s:35:"BackEndExtJs/Ajax/StateProvider.php";s:4:"78f5";s:16:"Bag/Abstract.php";s:4:"09fc";s:16:"Bag/Category.php";s:4:"5ce2";s:13:"Bag/Event.php";s:4:"1357";s:17:"Bag/Organizer.php";s:4:"43cd";s:20:"Bag/Registration.php";s:4:"4533";s:15:"Bag/Speaker.php";s:4:"656a";s:16:"Bag/TimeSlot.php";s:4:"5f95";s:23:"BagBuilder/Abstract.php";s:4:"39ca";s:23:"BagBuilder/Category.php";s:4:"12cf";s:20:"BagBuilder/Event.php";s:4:"f604";s:24:"BagBuilder/Organizer.php";s:4:"2028";s:27:"BagBuilder/Registration.php";s:4:"0856";s:22:"BagBuilder/Speaker.php";s:4:"23d3";s:41:"Configuration/FlexForms/flexforms_pi1.xml";s:4:"9b64";s:25:"Configuration/TCA/tca.php";s:4:"a2b1";s:38:"Configuration/TypoScript/constants.txt";s:4:"1559";s:34:"Configuration/TypoScript/setup.txt";s:4:"4609";s:25:"FrontEnd/AbstractView.php";s:4:"06a0";s:25:"FrontEnd/CategoryList.php";s:4:"9d0b";s:22:"FrontEnd/Countdown.php";s:4:"f8f2";s:30:"FrontEnd/DefaultController.php";s:4:"223b";s:19:"FrontEnd/Editor.php";s:4:"d1ac";s:24:"FrontEnd/EventEditor.php";s:4:"bec1";s:26:"FrontEnd/EventHeadline.php";s:4:"9507";s:25:"FrontEnd/PublishEvent.php";s:4:"bc66";s:29:"FrontEnd/RegistrationForm.php";s:4:"5bb3";s:30:"FrontEnd/RegistrationsList.php";s:4:"3267";s:29:"FrontEnd/RequirementsList.php";s:4:"9e46";s:27:"FrontEnd/SelectorWidget.php";s:4:"967f";s:23:"FrontEnd/WizardIcon.php";s:4:"2a89";s:32:"Interface/Hook/BackEndModule.php";s:4:"2fe7";s:32:"Interface/Hook/EventListView.php";s:4:"8c83";s:34:"Interface/Hook/EventSingleView.php";s:4:"8a83";s:22:"Mapper/BackEndUser.php";s:4:"4155";s:27:"Mapper/BackEndUserGroup.php";s:4:"2f55";s:19:"Mapper/Category.php";s:4:"e49b";s:19:"Mapper/Checkbox.php";s:4:"87ad";s:16:"Mapper/Event.php";s:4:"7bd0";s:20:"Mapper/EventType.php";s:4:"8ed2";s:15:"Mapper/Food.php";s:4:"4eb1";s:23:"Mapper/FrontEndUser.php";s:4:"d18a";s:28:"Mapper/FrontEndUserGroup.php";s:4:"5a0a";s:18:"Mapper/Lodging.php";s:4:"e9bd";s:20:"Mapper/Organizer.php";s:4:"8eda";s:24:"Mapper/PaymentMethod.php";s:4:"1333";s:16:"Mapper/Place.php";s:4:"f132";s:23:"Mapper/Registration.php";s:4:"ea07";s:16:"Mapper/Skill.php";s:4:"6559";s:18:"Mapper/Speaker.php";s:4:"3a55";s:22:"Mapper/TargetGroup.php";s:4:"0513";s:19:"Mapper/TimeSlot.php";s:4:"8f00";s:26:"Model/AbstractTimeSpan.php";s:4:"5bcf";s:21:"Model/BackEndUser.php";s:4:"93b8";s:26:"Model/BackEndUserGroup.php";s:4:"c699";s:18:"Model/Category.php";s:4:"4a15";s:18:"Model/Checkbox.php";s:4:"86fe";s:15:"Model/Event.php";s:4:"2caf";s:19:"Model/EventType.php";s:4:"61c5";s:14:"Model/Food.php";s:4:"ce70";s:22:"Model/FrontEndUser.php";s:4:"6e98";s:27:"Model/FrontEndUserGroup.php";s:4:"7049";s:17:"Model/Lodging.php";s:4:"c712";s:19:"Model/Organizer.php";s:4:"ef2d";s:23:"Model/PaymentMethod.php";s:4:"7da6";s:15:"Model/Place.php";s:4:"0579";s:22:"Model/Registration.php";s:4:"dce4";s:15:"Model/Skill.php";s:4:"0740";s:17:"Model/Speaker.php";s:4:"7f7b";s:21:"Model/TargetGroup.php";s:4:"ae5e";s:18:"Model/TimeSlot.php";s:4:"e34a";s:21:"OldModel/Abstract.php";s:4:"2b14";s:21:"OldModel/Category.php";s:4:"4b66";s:22:"OldModel/Organizer.php";s:4:"144b";s:38:"Resources/Private/CSS/thankYouMail.css";s:4:"4e2b";s:40:"Resources/Private/Language/locallang.xml";s:4:"d11e";s:54:"Resources/Private/Language/locallang_csh_fe_groups.xml";s:4:"2c9e";s:53:"Resources/Private/Language/locallang_csh_seminars.xml";s:4:"f521";s:49:"Resources/Private/Language/FrontEnd/locallang.xml";s:4:"a1c6";s:51:"Resources/Private/Templates/BackEnd/EventsList.html";s:4:"41ea";s:55:"Resources/Private/Templates/BackEnd/OrganizersList.html";s:4:"abb9";s:58:"Resources/Private/Templates/BackEnd/RegistrationsList.html";s:4:"c80e";s:53:"Resources/Private/Templates/BackEnd/SpeakersList.html";s:4:"cf8a";s:53:"Resources/Private/Templates/FrontEnd/EventEditor.html";s:4:"4498";s:50:"Resources/Private/Templates/FrontEnd/FrontEnd.html";s:4:"41c5";s:60:"Resources/Private/Templates/FrontEnd/RegistrationEditor.html";s:4:"3fd5";s:44:"Resources/Private/Templates/Mail/e-mail.html";s:4:"619c";s:38:"Resources/Public/CSS/BackEnd/Print.css";s:4:"d41d";s:45:"Resources/Public/CSS/BackEndExtJs/BackEnd.css";s:4:"e32a";s:43:"Resources/Public/CSS/BackEndExtJs/Print.css";s:4:"d41d";s:42:"Resources/Public/CSS/FrontEnd/FrontEnd.css";s:4:"bf1f";s:35:"Resources/Public/Icons/Canceled.png";s:4:"4161";s:35:"Resources/Public/Icons/Category.gif";s:4:"c95b";s:35:"Resources/Public/Icons/Checkbox.gif";s:4:"f1f0";s:36:"Resources/Public/Icons/Confirmed.png";s:4:"77af";s:40:"Resources/Public/Icons/ContentWizard.gif";s:4:"5e60";s:40:"Resources/Public/Icons/EventComplete.gif";s:4:"d4db";s:43:"Resources/Public/Icons/EventComplete__h.gif";s:4:"ccf3";s:43:"Resources/Public/Icons/EventComplete__t.gif";s:4:"a5cc";s:36:"Resources/Public/Icons/EventDate.gif";s:4:"7853";s:39:"Resources/Public/Icons/EventDate__h.gif";s:4:"fd86";s:39:"Resources/Public/Icons/EventDate__t.gif";s:4:"acc7";s:37:"Resources/Public/Icons/EventTopic.gif";s:4:"e4b1";s:40:"Resources/Public/Icons/EventTopic__h.gif";s:4:"4689";s:40:"Resources/Public/Icons/EventTopic__t.gif";s:4:"e220";s:36:"Resources/Public/Icons/EventType.gif";s:4:"61a5";s:31:"Resources/Public/Icons/Food.gif";s:4:"1024";s:34:"Resources/Public/Icons/Lodging.gif";s:4:"5fdf";s:36:"Resources/Public/Icons/Organizer.gif";s:4:"1e7e";s:40:"Resources/Public/Icons/PaymentMethod.gif";s:4:"44bd";s:32:"Resources/Public/Icons/Place.gif";s:4:"2694";s:32:"Resources/Public/Icons/Price.gif";s:4:"61a5";s:32:"Resources/Public/Icons/Print.png";s:4:"2424";s:39:"Resources/Public/Icons/Registration.gif";s:4:"d892";s:42:"Resources/Public/Icons/Registration__h.gif";s:4:"5571";s:32:"Resources/Public/Icons/Skill.gif";s:4:"30a2";s:34:"Resources/Public/Icons/Speaker.gif";s:4:"ddc1";s:38:"Resources/Public/Icons/TargetGroup.gif";s:4:"b5a7";s:31:"Resources/Public/Icons/Test.gif";s:4:"bd58";s:35:"Resources/Public/Icons/TimeSlot.gif";s:4:"bb73";s:51:"Resources/Public/JavaScript/BackEndExtJs/BackEnd.js";s:4:"fd09";s:48:"Resources/Public/JavaScript/FrontEnd/FrontEnd.js";s:4:"1301";s:33:"Service/SingleViewLinkBuilder.php";s:4:"c64c";s:42:"cli/class.tx_seminars_cli_MailNotifier.php";s:4:"ceec";s:23:"cli/tx_seminars_cli.php";s:4:"7d2d";s:20:"doc/dutch-manual.pdf";s:4:"beed";s:21:"doc/german-manual.sxw";s:4:"a45a";s:14:"doc/manual.sxw";s:4:"9e47";s:29:"pi2/class.tx_seminars_pi2.php";s:4:"8e50";s:17:"pi2/locallang.xml";s:4:"ef40";s:25:"tests/ConfigCheckTest.php";s:4:"ed9a";s:43:"tests/BackEnd/AbstractEventMailFormTest.php";s:4:"1e3d";s:41:"tests/BackEnd/CancelEventMailFormTest.php";s:4:"c722";s:42:"tests/BackEnd/ConfirmEventMailFormTest.php";s:4:"13e8";s:32:"tests/BackEnd/EventsListTest.php";s:4:"483d";s:31:"tests/BackEnd/FlexFormsTest.php";s:4:"e5fd";s:42:"tests/BackEnd/GeneralEventMailFormTest.php";s:4:"e3ad";s:28:"tests/BackEnd/ModuleTest.php";s:4:"0a93";s:36:"tests/BackEnd/OrganizersListTest.php";s:4:"4983";s:39:"tests/BackEnd/RegistrationsListTest.php";s:4:"5697";s:34:"tests/BackEnd/SpeakersListTest.php";s:4:"0f51";s:33:"tests/BackEndExtJs/ModuleTest.php";s:4:"c1a0";s:44:"tests/BackEndExtJs/Ajax/AbstractListTest.php";s:4:"1039";s:42:"tests/BackEndExtJs/Ajax/DispatcherTest.php";s:4:"8902";s:42:"tests/BackEndExtJs/Ajax/EventsListTest.php";s:4:"3357";s:46:"tests/BackEndExtJs/Ajax/OrganizersListTest.php";s:4:"f98e";s:49:"tests/BackEndExtJs/Ajax/RegistrationsListTest.php";s:4:"eafe";s:44:"tests/BackEndExtJs/Ajax/SpeakersListTest.php";s:4:"9f4c";s:45:"tests/BackEndExtJs/Ajax/StateProviderTest.php";s:4:"cb1b";s:26:"tests/Bag/AbstractTest.php";s:4:"00de";s:26:"tests/Bag/CategoryTest.php";s:4:"3cdd";s:23:"tests/Bag/EventTest.php";s:4:"d28f";s:27:"tests/Bag/OrganizerTest.php";s:4:"4dd0";s:25:"tests/Bag/SpeakerTest.php";s:4:"45b2";s:33:"tests/BagBuilder/AbstractTest.php";s:4:"efd2";s:33:"tests/BagBuilder/CategoryTest.php";s:4:"e8ee";s:30:"tests/BagBuilder/EventTest.php";s:4:"5cc6";s:34:"tests/BagBuilder/OrganizerTest.php";s:4:"28c3";s:37:"tests/BagBuilder/RegistrationTest.php";s:4:"eab6";s:32:"tests/BagBuilder/SpeakerTest.php";s:4:"d789";s:35:"tests/FrontEnd/CategoryListTest.php";s:4:"6836";s:32:"tests/FrontEnd/CountdownTest.php";s:4:"d408";s:40:"tests/FrontEnd/DefaultControllerTest.php";s:4:"de5d";s:29:"tests/FrontEnd/EditorTest.php";s:4:"b451";s:34:"tests/FrontEnd/EventEditorTest.php";s:4:"8917";s:36:"tests/FrontEnd/EventHeadlineTest.php";s:4:"e4f8";s:35:"tests/FrontEnd/PublishEventTest.php";s:4:"3ccc";s:39:"tests/FrontEnd/RegistrationFormTest.php";s:4:"7be3";s:40:"tests/FrontEnd/RegistrationsListTest.php";s:4:"bd1b";s:39:"tests/FrontEnd/RequirementsListTest.php";s:4:"96ec";s:37:"tests/FrontEnd/SelectorWidgetTest.php";s:4:"8d4d";s:34:"tests/FrontEnd/TestingViewTest.php";s:4:"24be";s:37:"tests/Mapper/BackEndUserGroupTest.php";s:4:"c9b4";s:32:"tests/Mapper/BackEndUserTest.php";s:4:"dd70";s:29:"tests/Mapper/CategoryTest.php";s:4:"6282";s:29:"tests/Mapper/CheckboxTest.php";s:4:"2190";s:30:"tests/Mapper/EventDateTest.php";s:4:"ca3b";s:26:"tests/Mapper/EventTest.php";s:4:"c49a";s:31:"tests/Mapper/EventTopicTest.php";s:4:"a62c";s:30:"tests/Mapper/EventTypeTest.php";s:4:"3f85";s:25:"tests/Mapper/FoodTest.php";s:4:"ec98";s:38:"tests/Mapper/FrontEndUserGroupTest.php";s:4:"ab53";s:33:"tests/Mapper/FrontEndUserTest.php";s:4:"6979";s:28:"tests/Mapper/LodgingTest.php";s:4:"b572";s:30:"tests/Mapper/OrganizerTest.php";s:4:"7176";s:34:"tests/Mapper/PaymentMethodTest.php";s:4:"2e11";s:26:"tests/Mapper/PlaceTest.php";s:4:"52bc";s:33:"tests/Mapper/RegistrationTest.php";s:4:"2287";s:32:"tests/Mapper/SingleEventTest.php";s:4:"7269";s:26:"tests/Mapper/SkillTest.php";s:4:"e76e";s:28:"tests/Mapper/SpeakerTest.php";s:4:"5d0f";s:32:"tests/Mapper/TargetGroupTest.php";s:4:"c8b5";s:29:"tests/Mapper/TimeSlotTest.php";s:4:"a093";s:36:"tests/Model/AbstractTimeSpanTest.php";s:4:"2762";s:36:"tests/Model/BackEndUserGroupTest.php";s:4:"8112";s:31:"tests/Model/BackEndUserTest.php";s:4:"b5f3";s:28:"tests/Model/CategoryTest.php";s:4:"d653";s:28:"tests/Model/CheckboxTest.php";s:4:"05bf";s:29:"tests/Model/EventDateTest.php";s:4:"2ca9";s:25:"tests/Model/EventTest.php";s:4:"4835";s:30:"tests/Model/EventTopicTest.php";s:4:"e58f";s:29:"tests/Model/EventTypeTest.php";s:4:"4984";s:24:"tests/Model/FoodTest.php";s:4:"efbe";s:37:"tests/Model/FrontEndUserGroupTest.php";s:4:"9ad0";s:32:"tests/Model/FrontEndUserTest.php";s:4:"f8d0";s:27:"tests/Model/LodgingTest.php";s:4:"b819";s:29:"tests/Model/OrganizerTest.php";s:4:"f7e8";s:33:"tests/Model/PaymentMethodTest.php";s:4:"c41d";s:25:"tests/Model/PlaceTest.php";s:4:"1616";s:32:"tests/Model/RegistrationTest.php";s:4:"99aa";s:31:"tests/Model/SingleEventTest.php";s:4:"9100";s:25:"tests/Model/SkillTest.php";s:4:"c506";s:27:"tests/Model/SpeakerTest.php";s:4:"dd0b";s:31:"tests/Model/TargetGroupTest.php";s:4:"311a";s:28:"tests/Model/TimeSlotTest.php";s:4:"2d02";s:31:"tests/OldModel/AbstractTest.php";s:4:"e2ac";s:31:"tests/OldModel/CategoryTest.php";s:4:"d9fc";s:28:"tests/OldModel/EventTest.php";s:4:"3f22";s:32:"tests/OldModel/OrganizerTest.php";s:4:"a6b3";s:35:"tests/OldModel/RegistrationTest.php";s:4:"8ae3";s:30:"tests/OldModel/SpeakerTest.php";s:4:"7364";s:31:"tests/OldModel/TimeSlotTest.php";s:4:"a065";s:31:"tests/OldModel/TimespanTest.php";s:4:"05bf";s:37:"tests/Service/EMailSalutationTest.php";s:4:"d7fa";s:41:"tests/Service/RegistrationManagerTest.php";s:4:"0370";s:43:"tests/Service/SingleViewLinkBuilderTest.php";s:4:"6fff";s:30:"tests/cli/MailNotifierTest.php";s:4:"33a0";s:54:"tests/fixtures/class.tx_seminars_registrationchild.php";s:4:"9640";s:49:"tests/fixtures/class.tx_seminars_seminarchild.php";s:4:"2492";s:67:"tests/fixtures/class.tx_seminars_tests_fixtures_TestingTimeSpan.php";s:4:"d6ad";s:50:"tests/fixtures/class.tx_seminars_timeslotchild.php";s:4:"92a5";s:50:"tests/fixtures/class.tx_seminars_timespanchild.php";s:4:"ab27";s:28:"tests/fixtures/locallang.xml";s:4:"182e";s:47:"tests/fixtures/BackEnd/TestingEventMailForm.php";s:4:"949e";s:45:"tests/fixtures/BackEndExtJs/TestingModule.php";s:4:"12ee";s:56:"tests/fixtures/BackEndExtJs/Ajax/TestingAbstractList.php";s:4:"cc68";s:54:"tests/fixtures/BackEndExtJs/Ajax/TestingEventsList.php";s:4:"e1c2";s:58:"tests/fixtures/BackEndExtJs/Ajax/TestingOrganizersList.php";s:4:"c7b1";s:61:"tests/fixtures/BackEndExtJs/Ajax/TestingRegistrationsList.php";s:4:"ec82";s:56:"tests/fixtures/BackEndExtJs/Ajax/TestingSpeakersList.php";s:4:"70bd";s:30:"tests/fixtures/Bag/Testing.php";s:4:"ff43";s:43:"tests/fixtures/BagBuilder/BrokenTesting.php";s:4:"7ff6";s:37:"tests/fixtures/BagBuilder/Testing.php";s:4:"aab8";s:39:"tests/fixtures/FrontEnd/TestingView.php";s:4:"927c";s:35:"tests/fixtures/OldModel/Testing.php";s:4:"9a4f";s:55:"tests/fixtures/Service/TestingSingleViewLinkBuilder.php";s:4:"a7d0";s:21:"tests/pi2/pi2Test.php";s:4:"bd1c";}',
	'constraints' => array(
		'depends' => array(
			'php' => '5.3.0-0.0.0',
			'typo3' => '4.5.0-4.7.99',
			'cms' => '',
			'css_styled_content' => '',
			'oelib' => '0.7.62-',
			'ameos_formidable' => '1.1.0-1.9.99',
			'static_info_tables' => '2.1.0-',
			'static_info_tables_taxes' => '',
		),
		'conflicts' => array(
			'dbal' => '',
			'sourceopt' => '',
		),
		'suggests' => array(
			'onetimeaccount' => '',
			'sr_feuser_register' => '',
		),
	),
	'suggests' => array(
	),
);

?>