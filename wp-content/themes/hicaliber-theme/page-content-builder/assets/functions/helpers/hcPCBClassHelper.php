<?php
if (! class_exists ( 'hcPCBClassHelper' )):
class hcPCBClassHelper {
    private static $classes = [];
    
    public function __construct($classes){
        if(is_array($classes)) array_merge(self::$classes, $classes);
        elseif(is_string($classes)) array_merge(self::$classes, explode(" ", $classes));
    }
    
    public static function toggleClass($class = ""){
        $index = array_search($class, self::$classes);
        if($index !== false){
            unset($classes[$index]);
        }
        else array_push(self::$classes, $class);
    }
    
     public static function removeClass($class = ""){
        $index = array_search($class, self::$classes);
        if($index !== false){
            unset($classes[$index]);
        }
    }
    
    public static function getClasses($asArray=false){
        if($asArray) return self::$classes;
        else return implode(" ", self::$classes);
    }
}

endif;