<?php
$evh = new hcElementController(_get_field_value('sites_elements', 'options'));
if($evh::isVisible('faq', true)) :

	require_once 'faq-post-type.php';
	require_once 'faq-custom-admin-filter.php';

endif;
?>