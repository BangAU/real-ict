<?php
$evh = new hcElementController(_get_field_value('sites_elements', 'options'));
if($evh::isVisible('services', true)) :
    
require_once 'services-post-type.php';

endif;
?>