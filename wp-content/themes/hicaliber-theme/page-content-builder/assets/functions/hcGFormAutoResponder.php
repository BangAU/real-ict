<?php

add_filter( 'gform_notification', 'change_autoresponder_email', 10, 3 );
function change_autoresponder_email( $notification, $form, $entry ) {
        if ( $notification['name'] == 'User Notification' ) {
            ob_start(); ?>
                <html>
                <body>
                <?php echo $notification['message']; ?>
                </body>
                </html>
            <? $html = ob_get_contents();
            ob_end_clean();
            $notification['message'] = str_replace(array("\n", "\r"), '', $html);
        }
    return $notification;
}