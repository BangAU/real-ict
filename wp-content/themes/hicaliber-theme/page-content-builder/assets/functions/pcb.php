<?php

	
	define('PCB_DIR', get_template_directory() . '/page-content-builder');
	define('PCB_ASSETS_DIR', PCB_DIR . '/assets');
	define('PCB_FUNCTIONS_DIR', PCB_ASSETS_DIR . '/functions');
	define('PCB_ELEMENTS_DIR', PCB_DIR . '/elements');
	define('PCB_JS_DIR', PCB_ASSETS_DIR. '/js');
	define('PCB_MODEL_DIR', PCB_FUNCTIONS_DIR . '/models');
	define('PCB_HELPER_DIR', PCB_FUNCTIONS_DIR . '/helpers');
	define('SHORT_CODE_DIR', PCB_FUNCTIONS_DIR . '/shortcodes');
	
	require_once(PCB_FUNCTIONS_DIR . '/acfCBSectionTitle.php');
	require_once(PCB_FUNCTIONS_DIR . '/hcElementController.php');
	require_once(PCB_FUNCTIONS_DIR . '/acfPrePopulateChoices.php');
	require_once(PCB_FUNCTIONS_DIR . '/acfLoadImgFieldChoices.php');
	
	require_once(PCB_FUNCTIONS_DIR . '/includeHicJS.php');
	require_once(PCB_FUNCTIONS_DIR . '/admin-footer-script.php');
	
	require_once(PCB_FUNCTIONS_DIR . '/cb-admin-css.php');

	require_once(PCB_FUNCTIONS_DIR . '/hcPCBOptionPage.php');
		
	//Load PCB Models	
	require_once(PCB_MODEL_DIR . '/hcPCBButtonElement.php');
	require_once(PCB_MODEL_DIR . '/hcContentBuilder.php');
	require_once(PCB_MODEL_DIR . '/hcPCBSearchFilter.php');
	require_once(PCB_MODEL_DIR . '/hcPCBContent.php');
	require_once(PCB_MODEL_DIR . '/hcPCBTestimonial.php');
	require_once(PCB_MODEL_DIR . '/hcPCBArticle.php');
	require_once(PCB_MODEL_DIR . '/hcPCBProject.php');	
	require_once(PCB_MODEL_DIR . '/hcPCBCourses.php');
	require_once(PCB_MODEL_DIR . '/hcPCBEvents.php');
	require_once(PCB_MODEL_DIR . '/hcPCBProduct.php');
	require_once(PCB_MODEL_DIR . '/hcPCBRoom.php');
	require_once(PCB_MODEL_DIR . '/hcPCBLocation.php');
	require_once(PCB_MODEL_DIR . '/hcPCBAccProperties.php');
	require_once(PCB_MODEL_DIR . '/hcPCBAccPromotions.php');
	require_once(PCB_MODEL_DIR . '/hcPCBRoomType.php');
	
	
	//Load PCB Helpers
	require_once(PCB_HELPER_DIR . '/hcPCBLink.php');

	//Shortcodes
	require_once(SHORT_CODE_DIR . '/hcPCBGlobalElement.php');
	require_once(SHORT_CODE_DIR . '/hcPCBLocationProfile.php');
	require_once(SHORT_CODE_DIR . '/hcPCBButton.php');
	require_once(SHORT_CODE_DIR . '/hcPCBBox.php');

	// Gform Auto Responder
	//require_once(PCB_FUNCTIONS_DIR . '/hcGFormAutoResponder.php');
?>