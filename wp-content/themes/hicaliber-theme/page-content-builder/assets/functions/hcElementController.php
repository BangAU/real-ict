<?php
if (! class_exists ( 'hcElementController' )):
class hcElementController {
    
    // This are the default elements show on the page builder element selections
    // Should be display non-explicitly
    public static $default_elements = array('call_to_Action','content_boxes','global_element','page_content');
    
    public static $show_elements = array();
    public static $elementProperty = array();

    public function __construct($show_elements){
        self::$show_elements = $show_elements ? $show_elements : array();
        
        // initialized element property
        self::$elementProperty = array(                
                'faq'               => array('label'     => 'Accordion / FAQ'),
                'call_to_Action'    => array('label'     => 'Call to Action'),
                'content_boxes'     => array('label'     => 'Content Boxes'),                
                'contact_form'      => array('label'     => 'Form'),
                'courses'          => array('label'     => 'Courses'),
                'designs'           => array(
                    'label'     => 'Design',
                    'post-type' => array('design')),
                'events'            => array('label'     => 'Events'),     
                'gallery'           => array('label'     => 'Gallery'),
                'global_element'    => array('label'     => 'Global Element'),
                'page_content'      => array('label'     => 'Page Content'),
                'products'          => array('label'     => 'Products'),
                'projects'          => array('label'     => 'Projects'),
                'properties_acc'     => array('label'     => 'Properties'),
                'promotions_acc'     => array('label'     => 'Promotions'),  
                'listing_section'   => array(
                        'label'     => 'Property Listing',
                        'related'   => 'search_form',
                        'post-type' => array('property_type', 'booking_inspection')),
                'location'   => array(
                        'label'     => 'Location',
                        'post-type' => array('location')),
                'search_form'       => array('label'     => 'Property Search Form'),
                'recent_posts'      => array('label'     => 'Posts'),
                'social_feeds'      => array('label'     => 'Social Feed'),
                'team'              => array(
                        'label'     => 'Team',
                        'post-type' => array('team')),
                'testimonials'      => array('label'     => 'Reviews'),
                'services'          => array(
                        'label'     => 'Services',
                        'non-element' => true),
                'code_element'              => array('label'     => 'Code Element'),
        );
    }

    public static function getAllElements($explicit=false, $related=false, $no_non_elem=false){
        //initialize elements holder
        $all = array();
        
        //combine default elements and the specified elements to show if not explicitly precised to the specified element
        if(!$explicit && is_array(self::$show_elements)) $all =  array_merge(self::$default_elements, self::$show_elements);
        
        //do not include default elements if explicitly precised only to the specified element
        else $all =  self::$show_elements;
        
        //merge all related elements if the user wish to
        if($related) $all = array_merge($all, self::getRelated($all));
        
        //removes all non-element of Page Builder
       // if($no_non_elem) $all = self::removeNonElement($all);
        
        //sort the elements
        if( is_array($all) ) sort($all);
        return $all;
    }

    public static function isVisible($element, $explicit=false, $related=false){
        return in_array($element, self::getAllElements($explicit, $related));
    }

    
    public static function getProperty($element, $property){
        if( isset(self::$elementProperty[$element][$property]) )
            return self::$elementProperty[$element][$property];
    }
    
    // Get all related elements
    public static function getRelated($elements){
        $relatedElements = array();
        if( $elements ) {
            foreach( $elements as $element ) {
                if(isset(self::$elementProperty[$element]['related'])) 
                    array_push($relatedElements, self::$elementProperty[$element]['related']);
            }
        }
        return $relatedElements;
    }
    
    // Remove All elements that are not elements in the Page Builder
    public static function removeNonElement($elements){
        $newElements = array();
        if( $elements ) {
            foreach( $elements as $element ) {
                if(!isset(self::$elementProperty[$element]['non-element'])) 
                    array_push($newElements, $element);
                elseif(!self::$elementProperty[$element]['non-element'])
                    array_push($newElements, $element);
            }
        }
        return $newElements;
    }
}

endif;