<?php
if (! class_exists ( 'hcPCBTestimonial' )) :
class hcPCBTestimonial extends hcPCBContent{
    protected $location="";
    protected $rating="";
    protected $date="";    
    protected $name="";
    protected $agent="";
    protected $featured=false;

    public function __construct(){
    	$this->contentName = "testimonials";
    	$this->defaultSectionClasses=["testimonial-element"];
    	$this->title = "";
        $this->content = "";
        $this->image = "";
        $this->icon = "";
        $this->video = "";
        $this->button = "";
        $this->classes= ["hic-box-container" => [], "hic-box" => [], 'hic-image-container' => []];
        $this->date="";
        $this->location="";
        $this->rating="";
        $this->name="";
        $this->agent="";
        $this->featured=false;
    }

    public function setFeatured($featured=true){
    	$this->featured = $featured;
    }

	public function setAgent($agent){
    	$this->agent = $agent;
    }

    public function setName($name){
    	$this->name = $name;
    }    

    public function setRating($rating){
    	$this->rating = $rating;
    }

    public function setLocation($location){
    	$this->location = $location;
    }

    public function setDate($date){
    	$this->date = $date;
    }

    public function getLocation(){
    	return $this->location;
    }

    public function getDate(){
    	return $this->date;
    }

    public function getRating(){
    	return $this->rating;
    }

    public function getName(){
    	return $this->name;
    }

    public function getAgent(){
    	return $this->agent;
    } 

    public function isFeatured(){
    	return $this->featured;
    }

    public static function rating( $val = "" ) {
        
        $ratings = ["none-selected","one","two","three","four","five"];
        $html = "";
        $rated = "<i class='fas fa-star'></i>";

        foreach( $ratings as $i => $rating ) {
            
            if( $rating == $val ) {
                $rated = "<i class='far fa-star'></i>";        
            }
            
            if( $i < (count($ratings) -1) ) {
                $html .= $rated;    
            }
        }
        
        return "<div class='testimonial-rating'>".$html."</div>";
    }

    public function displayContent(){
	    
	    ob_start(); ?>
	    <div class="cell testimonial <?php echo isset($this->classes['hic-box-container']) ? $this->getClassesOf('hic-box-container') : ''; ?>">
    	    <div class="hic-box testimonial-slides-wrap <?php echo isset($this->classes['hic-box']) ? $this->getClassesOf('hic-box') : ''; ?>">
                <?php
                    if( $this->image && $this->image->url ) : 
                ?>
                <div class="hic-image-container details <?php echo isset($this->classes['hic-image-container']) ? $this->getClassesOf('hic-image-container') : ''; ?>">
                	<div class="overlay"></div>
                    <?php if( isset($this->image->url) ) : ?>
                            <?php if($this->video->url) : ?>
                                <a href="<?php echo $this->video->url; ?>" data-fancybox>  
                            <?php endif; ?>
                    <div class="hic-image primary-photo" style="background-image: url(<?php echo $this->image->url; ?>);">
                        
                         <?php if($this->video->url) : ?>                                
                              
                                        <img class="video-play-button" src="<?php echo ASSETS_IMG . 'play-button.png'; ?>">
                                 
                            <?php endif;  ?>
                    </div>

                     <?php if($this->video->url) : ?>
                        </a>
                        <?php endif; ?>                    
                    <?php endif; ?>
                </div>
                <?php endif; ?>   
                                                                                                
                <div class="hic-content testimonial-inner-wrap">
                    <div class="testimonial-main-content">
                		<?php if($this->title): ?>
	                    <div class="hic-title"><h4><?php echo $this->title; ?></h4></div>
	                    <?php endif; ?>

                    	<?php if($this->content): ?>
	                    <div class="hic-blurb"><?php echo wpautop($this->content); ?></div>
	                    <?php endif; ?>
                    </div>
                    
                    <?php if( $this->rating != 'none-selected' && $this->rating ) : ?>
                        <div class="rating">
                            <?php echo self::rating( $this->rating ); ?>
                        </div>
                    <?php endif; ?> 
                    
                    <?php /* if( $this->date ) : ?>
                        <div class="rating">
                        <?php //echo $this->date; ?>
                        </div?
                    <?php endif; */ ?>  

					<div class="client-details">
						    
					    <?php if( $this->name ) :?>
						<div class="client-name"><?php echo $this->name; ?></div>
						<?php endif; ?>
						
						<?php if( $this->location ) : ?>
						<div class="client-location">
							<p><?php echo $this->location; ?></p>
						</div>
						<?php endif; ?>
                    </div>
                                                                                                                    
                </div>
            </div>
        </div>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
	}
}
endif;
?>