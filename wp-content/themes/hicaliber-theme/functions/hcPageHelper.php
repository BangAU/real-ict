<?php
if (! class_exists ( 'hcPageHelper' )):
class hcPageHelper {
    public static $post = "";
    public static $children = "";
    public static $childCount = "";

    public function __construct(){
        global $post;
        self::$post = $post;
        self::$children = get_pages( array( 'child_of' => self::$post->ID ) );
        self::$childCount = count( self::$children );
    }
    
    public static function setPost($post=""){
        self::$post = $post;
    }
    
    public static function hasChildren() {
        if( self::$childCount == 0 ) {
            return false;
        } else {
            return true;
        }
    }

    public static function isSubpage() {
        if ( is_page() && self::$post->post_parent ) {   // test to see if the page has a parent
            return true;                                            // return true, confirming there is a parent
        
        } else {                                   // there is no parent so ...
            return false;                          // ... the answer to the question is false
        }
    }


}

endif;
?>