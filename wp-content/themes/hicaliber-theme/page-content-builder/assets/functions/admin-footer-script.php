<?php
add_action( 'admin_print_footer_scripts', 'add_admin_footer_script' );

function add_admin_footer_script(){ ?>

<script>

jQuery(document).ready(function($) {
    
    // Add Check All checkbox on all ACF taxonmoy field
    
    // var taxonomyChecklist = $('.acf-field-taxonomy ul.acf-checkbox-list');
    
    // taxonomyChecklist.prepend('<li><label class="selectit"><input type="checkbox" class="toggle-all-terms"/> Check All</label>');

    // $('.toggle-all-terms').on('change', function(){
    //     $(this).closest('ul').find(':checkbox').prop('checked', this.checked );
    // });

});
</script>

<?php }