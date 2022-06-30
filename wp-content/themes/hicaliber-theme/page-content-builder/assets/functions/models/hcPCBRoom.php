<?php


if (! class_exists ( 'hcPCBRoom' ) &&  class_exists ( 'HICALIBER_ACCOMODATION' )  ):

class hcPCBRoom extends hcPCBContent{
    private static $moduleImageDir="";
    private static $roomDetailsIcon="";
    private static $bedTypeIcon="";
    private static $roomViewIcon="";

    protected $ID ="";
    protected $property = "";
    protected $rate="";
    protected $roomSize="";
    protected $bathroom=[];
    protected $roomView=[];
    protected $bedTypes=[];
    protected $occupants="";
    private static $HA = "";


    public function __construct(){
        self::$moduleImageDir=plugins_url('hicaliber-accommodation/images/');
        self::$roomDetailsIcon=get_field('room_type_details_icons', 'options');
        self::$bedTypeIcon=get_field('room_type_bed_icons', 'options');
        self::$roomViewIcon=get_field('room_type_view_icons', 'options');

        self::$HA = new HICALIBER_ACCOMODATION();

        $this->contentName = "accommodation-room-type";
        $this->defaultSectionClasses=["content-boxes", "accommodation-room-type", "relative"];
        $this->title = "";
        $this->content = "";
        $this->image = "";
        $this->icon = "";
        $this->video = "";
        $this->button = "";
        $this->classes= ["hic-box-container" => [], "hic-box" => [], 'hic-image-container' => []];
        $this->ID ="";
        $this->property = "";
        $this->rate="";
        $this->roomSize="";
        $this->bathroom=["qty" => "", "icon" => ""];
        $this->roomView=[];
        $this->bedTypes=[];
        $this->occupants="";
        $this->thumbnail="";
    }

    public function setID($ID){
        $this->ID = $ID;
    }
	
	public function setProperty($property){
        $this->property = $property;
    }

    public function getProperty(){
        return $this->property;
    }
	
	public function setRate($rate){
		$this->rate = $rate;
    }

    public function getRate(){
		return $this->rate;
    }

    public function setRoomSize($roomSize, $unit){
        if($unit) {
            if( strpos($unit, '^') ) $unit =  str_replace('^',"<sup>", $unit) . "</sup>";
        }
        else $unit = "m<sup>2</sup>";
        if($roomSize) $this->roomSize = $roomSize . $unit;
    }

    public function getRoomSize(){
		return $this->roomSize;
    }

    public function setBathroom($qty){
        if($qty){
            $icon = self::getRoomDetailsIcon("room_type_bathroom_icon");
            $this->bathroom["qty"] = $qty;
            if($icon) $this->bathroom['icon'] = $icon;
            else $this->bathroom['icon'] = self::getDefaultIcon("room_type_bathroom_icon");
        }
    }

    public function getBathroomQty(){
		return $this->bathroomQty;
    }

    public function setRoomView($roomView){
        if($roomView){
            $this->roomView = array(
                "id" => $roomView,
                "icon" => self::getRoomViewIcon($roomView - 1), 
                "label" => self::getRoomViewLabel($roomView - 1)
            );
        }
    }

    public function getRoomView(){
		return $this->roomView;
    }

    public function setOccupants($occupants){
		$this->occupants = $occupants;
    }

    public function getOccupants(){
		return $this->occupants;
    }
    
    public function setBedTypes($bedTypes = []){
        if( $bedTypes && count( $bedTypes ) ){
            foreach($bedTypes as $bedType){
                $this->addBedType($bedType);
            }
        }
    }

    public function addBedType($bedType){
        if( is_array( $bedType ) ) {    
            /*
            $this->bedTypes["bed-type-".$bedType] = array(
                "qty" => 1, 
                "icon" => self::getBedTypeIcon($bedType - 1), 
                "label" => self::getBedTypeLabel($bedType - 1)
            );
            // dump( $bedType );            
            
            if( array_key_exists( "bed-type-".$bedType, $this->bedTypes ) ) {
                $this->bedTypes["bed-type-".$bedType]['qty'] = $this->bedTypes["bed-type-".$bedType]['qty'] + 1;
            } else {
                $this->bedTypes["bed-type-".$bedType] = array(
                    "qty" => 1, 
                    "icon" => self::getBedTypeIcon($bedType - 1), 
                    "label" => self::getBedTypeLabel($bedType - 1)
                );
            }   
            */          
       }
    }
    
    public function getBedTypes(){
		return $this->bedTypes;
    }

    public function getID(){
        return $this->ID;
    }

    private static function getRoomDetailsIcon($field){
        if( isset(self::$roomDetailsIcon[$field]) ){
            if(self::$roomDetailsIcon[$field]) return self::$HA::render_svg(self::$roomDetailsIcon[$field]);
            else return self::getDefaultIcon($field);
        }
        else return self::getDefaultIcon($field);
    }

    private static function getBedTypeIcon($id){
        if( isset(self::$bedTypeIcon[$id]['room_type_bed_icon']) ){
            if(self::$bedTypeIcon[$id]['room_type_bed_icon']) return self::$HA::render_svg(self::$bedTypeIcon[$id]['room_type_bed_icon']);
            else return self::getDefaultIcon('room_type_bed_icon');
        }
        else return self::getDefaultIcon('room_type_bed_icon');
    }

    private static function getBedTypeLabel($id){
        if( isset(self::$bedTypeIcon[$id]['room_type_bed_label']) ){
            if(self::$bedTypeIcon[$id]['room_type_bed_label']) return self::$bedTypeIcon[$id]['room_type_bed_label'];
            else return 'Bed';
        }
        else return 'Bed';
    }

    private static function getRoomViewIcon($id){
        if( isset(self::$roomViewIcon[$id]['room_type_view_icon']) ){
            if(self::$roomViewIcon[$id]['room_type_view_icon']) return self::$HA::render_svg(self::$roomViewIcon[$id]['room_type_view_icon']);
            else return self::getDefaultIcon('room_type_view_icon');
        }
        else return self::getDefaultIcon('room_type_view_icon');
    }

    private static function getRoomViewLabel($id){
        if( isset(self::$roomViewIcon[$id]['room_type_view_label']) ){
            if(self::$roomViewIcon[$id]['room_type_view_label']) return self::$roomViewIcon[$id]['room_type_view_label'];
            else return 'View';
        }
        else return 'View';
    }

    private static function getDefaultIcon($id){
        $icon = self::$HA::render_svg(self::$moduleImageDir . $id . ".svg");
        return $icon;
    }
    
	public function displayContent(){
	    ob_start(); ?>
	    <div class="cell <?php echo isset($this->classes['hic-box-container']) ? $this->getClassesOf('hic-box-container') : ''; ?>">

    	    <div class="hic-box <?php echo isset($this->classes['hic-box']) ? $this->getClassesOf('hic-box') : ''; ?>">
                <?php
                    if( $this->image && $this->image->url ) : 
                ?>
                <div class="hic-image-container <?php echo isset($this->classes['hic-image-container']) ? $this->getClassesOf('hic-image-container') : ''; ?>">

                    <a href="<?php echo $this->button->getURL(); ?>">
                        <div class="overlay"></div>
                        <?php if( isset($this->image->url) ) : ?>
                        <div class="hic-image" style="background-image: url(<?php echo $this->thumbnail ? $this->thumbnail->getThumbnailImg(): $this->image->url; ?>);"></div>
                        <?php endif; ?>
                    </a>
                </div>
                <?php endif; ?>   
                                                                                                
                <div class="hic-content">
                    
                    <?php if($this->title): ?>
						<div class="hic-title">
                            <a href="<?php echo $this->button->getURL(); ?>">
                            <h3><?php echo $this->title; ?></h3>
                            </a>
						</div>
                    <?php endif; ?>
                    <?php if($this->property): ?>
						<div class="property"><?php echo $this->property; ?></div>
                    <?php endif; ?>
                    <?php echo $this->getRoomDetails(); ?>
                    <?php if($this->content): ?>
                        <div class="hic-blurb">
                            <?php echo $this->content; ?>
                        </div>
                    <?php endif; ?>
                    <?php
                    if($this->button && !$this->button->isBoxLink()):
                        if($this->button->getButton()): 
                    ?>
							<div class="hic-button-wrap">
								<?php $this->button->displayButtonElement(); ?>
							</div>
                    <?php 
                        endif; 
                    endif;
                    ?>
                                                                                                                    
                </div>
            </div>
        </div>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
    
    public function getRoomDetails(){
        ob_start(); ?>
        <?php if($this->rate || $this->roomSize || $this->bathroom['qty'] || ($this->roomView && isset($this->roomView['label']) && isset($this->roomView['label']) ) || $this->occupants || ( $this->bedTypes && count($this->bedTypes) ) ) : ?>
            <div class="hic-room-details">
            <?php if($this->rate): ?>
                <div class="room-rate"><?php echo $this->getDefaultIcon('dollar') . " " . $this->rate; ?></div>
            <?php endif; ?>
            <?php if($this->roomSize): ?>
                <div class="room-size">
                    <?php echo $this->roomSize; ?>
                </div>
            <?php endif; ?>
            <?php if($this->bathroom['qty']): ?>
                <div class="bathroom">
                    <div class="with-tooltip">
                        <?php echo $this->bathroom['qty'] . " " . $this->bathroom['icon']; ?>
                        <div class="tooltip"><?php echo $this->bathroom['qty']; ?> bathroom</div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if( ($this->roomView && isset($this->roomView['label']) && isset($this->roomView['label']) ) ): ?>
                <div class="room-view">
                    <div class="with-tooltip">
                        <?php echo $this->roomView['icon']; ?>
                        <div class="tooltip"><?php echo $this->roomView['label']; ?></div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($this->occupants): ?>
                <div class="occupants">
                    <?php echo $this->occupants; ?>
                </div>
            <?php endif; ?>
            <?php if($this->bedTypes && count($this->bedTypes)): ?>
                <div class="bed-types">
                    <?php 
                        foreach($this->bedTypes as $bedType => $value) :
                    ?>
                        <div class="with-tooltip">
                            <?php echo $value['qty'] . " " . $value['icon']; ?>
                            <div class="tooltip"><?php echo $value['qty'] . " " . $value['label']; ?></div>
                        </div>
                    <?php
                        endforeach; 
                    ?>
                </div>
            <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }

    public function getRoomOutlinedDetails(){
        ob_start(); ?>
        <?php if($this->rate || $this->roomSize || $this->bathroom['qty'] || ($this->roomView && isset($this->roomView['label']) && isset($this->roomView['label']) ) || $this->occupants || ( $this->bedTypes && count($this->bedTypes) ) ) : ?>
            <div class="hic-room-outlined-details">
            <?php if($this->rate): ?>
                <div class="room-rate"><span class="hic-label">Rate: </span><?php echo "$" . $this->rate; ?></div>
            <?php endif; ?>
            <?php if($this->roomSize): ?>
                <div class="room-size">
                    <span class="hic-label">Room Size: </span>
                    <?php echo $this->roomSize; ?>
                </div>
            <?php endif; ?>
            <?php if($this->bathroom['qty']): ?>
                <div class="bathroom">
                    <span class="hic-label">Bathroom<?php echo $this->bathroom['qty'] > 1 ? "s" : ""; ?>: </span>
                    <?php echo $this->bathroom['qty']; ?>
                </div>
            <?php endif; ?>
            <?php if( ($this->roomView && isset($this->roomView['label']) && isset($this->roomView['label']) ) ): ?>
                <div class="room-view">
                    <span class="hic-label">Room View: </span>
                    <?php echo $this->roomView['label']; ?>
                </div>
            <?php endif; ?>
            <?php if($this->occupants): ?>
                <div class="occupants">
                    <?php echo $this->occupants; ?>
                </div>
            <?php endif; ?>
            <?php if($this->bedTypes && count($this->bedTypes)): ?>
                <div class="bed-types">
                    <span class="hic-label">Bed Type<?php echo count($this->bedTypes) > 1 ? "s" : ""; ?>: </span>
                    <?php 
                        foreach($this->bedTypes as $bedType => $value) :
                    ?>  <div><?php echo $value['qty'] . " " . $value['label']; ?></div>
                    <?php
                        endforeach; 
                    ?>
                </div>
            <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
}

endif;