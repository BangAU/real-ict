<?php
if (! class_exists ( 'hcPCBLocation' )):
class hcPCBLocation extends hcPCBContent{    
    private $galleryOptions = [];
    private $hasGallery=false;
    private $galleryImages = [];
    private $mediaDisplay = 'gallery';
    private $terms=[];
    private $mapContent = "";
    private $location = "";
    private $email = "";
    private $phone = "";
    private $website = "";
    private $is_public = TRUE;

    public function __construct(){
        $this->title = "";
        $this->content = "";
        $this->image = new hcPCBLink;
        $this->icon = "";
        $this->imageIcon = "";
        $this->useImageIcon = "";
        $this->video = new hcPCBLink;
        $this->video2 = new hcPCBLink;
        $this->button = new hcPCBButtonElement;
        $this->classes= ["hic-box-container" => [], "hic-box" => [], 'hic-image-container' => []];
        $this->contentName ='location';
        $this->defaultSectionClasses=["location-element"];
        $this->mediaDisplay = 'gallery';
        $this->galleryImages = [];
        $this->hasGallery = false;
        $this->galleryOptions = [];
        $this->mapContent = "";
        $this->terms=[];
        $this->location;
        $this->email;
        $this->phone;
        $this->website;
        $this->is_public;
    }

    public function setTerms(Array $terms){
        $this->terms = array_merge($this->terms, $terms);
    }

    public function getTerms(){
        return $this->terms;
    }
    
    public function setMapContent($mapContent){
        $this->mapContent = $mapContent;
    }

    public function getMapContent(){
        return $this->mapContent;
    }

    public function setTerm(WP_TERM $term){
        if($term) array_push($this->terms, $term);
    }
    
    public function setGalleryImages(Array $images){
        if(count($images) > 0){
            $this->galleryImages = $images;
            array_push($this->classes['hic-image-container'], ' has-gallery-slider');
            $this->hasGallery = true;
        } else $this->hasGallery = false;
    }
    
    public function getGalleryImages(){
        return $this->galleryImages;
    }

    public function setGalleryOptions(Array $options){
        $this->galleryOptions = $options;
    }

    public function getGalleryOptions(){
        return $this->galleryOptions;
    }

    public function setMediaDisplay($mediaDisplay){
        $this->mediaDisplay = $mediaDisplay;
    }

    public function getMediaDisplay(){
        return $this->mediaDisplay;
    }
    
    public function setLocation($location){
        $this->location = $location;
    }
    public function getLocation(){
        return $this->location;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getEmail(){
        return $this->email;
    }
    
    public function setPhone($phone){
        $this->phone = $phone;
    }
    public function getPhone(){
        return $this->phone;
    }
    
    public function setWebsite($website){
        $this->website = $website;
    }
    public function getWebsite(){
        return $this->website;
    }
    
    public function setIsPublic($is_public){
        $this->is_public = $is_public;
    }
    
    public function displayContent(){
        
        ob_start(); ?>
        <div class="cell <?php echo isset($this->classes['hic-box-container']) ? $this->getClassesOf('hic-box-container') : ''; ?>">
            <?php if($this->button && $this->button->isBoxLink()) : 
                if(!$this->button->isModalButton()) : ?>
                <a href="<?php echo $this->button->getURL(); ?>"<?php 
                    if($this->button->getTarget()) _e(" target='".$this->button->getTarget() . "'");
                ?>>
                <?php else : ?>
                <button data-open='<?php echo $this->button->getDataOpen(); ?>'>
            <?php endif; 
            endif; ?>
            <div class="hic-box <?php echo isset($this->classes['hic-box']) ? $this->getClassesOf('hic-box') : ''; ?>">
                <?php
                    if( $this->image && $this->image->url ) : 
                ?>
                <div class="hic-image-container <?php echo isset($this->classes['hic-image-container']) ? $this->getClassesOf('hic-image-container') : ''; ?>">

                    <?php if($this->button && !$this->button->isBoxLink()): ?>
                    
                    <?php if(!$this->button->isModalButton() && !$this->hasGallery) : ?>
                             <?php if($this->is_public) : ?>
                                <a class="" href="<?php echo $this->button->getURL(); ?>"<?php 
                                    if($this->button->getTarget()) _e(" target='".$this->button->getTarget() . "'");
                                ?>>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if($this->hasGallery && class_exists('PROJECT_VIEW') ) : 
                        echo PROJECT_VIEW::gallery($this->galleryImages, $this->video2, $this->galleryOptions, false);
                    else : ?>
                        <div class="overlay"></div>
                        <?php if( isset($this->image->url) ) :                            
                               
                            if($this->video2->url) : ?>
                            <a href="<?php echo $this->video2->url; ?>" data-fancybox>  
                            <?php endif; ?>

                        <div class="hic-image" style="background-image: url(<?php echo $this->image->url; ?>);">

                            <?php if($this->video2->url) : ?>
                                  <div class="v-align-container vpv-container">
                                    <div class="table-cell-mid">
                                        <img class="video-play-button" src="<?php echo ASSETS_IMG . '/play-button.png'; ?>">
                                    </div>
                                  </div>
                            <?php endif;  ?>

                        </div>
                        <?php if($this->video2->url) : ?>
                        </a>
                        <?php endif; ?>

                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if($this->button && !$this->button->isBoxLink() && !$this->hasGallery): ?>
                        <?php if($this->is_public) : ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
                <?php endif; ?>   
                                                                                                
                <div class="hic-content">
                    <?php if( $this->icon || ($this->imageIcon && isset($this->imageIcon->url)) ): ?>
                        <div class="hic-icon">
                            <?php if($this->icon && !$this->useImageIcon) echo $this->icon; ?>
                            <?php if($this->imageIcon && isset($this->imageIcon->url) && $this->useImageIcon): ?>
                                <img src="<?php echo $this->imageIcon->url; ?>" alt="content box icon"/>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if($this->title): ?>
                    <div class="hic-title">
                        <?php if($this->button  && !$this->button->isBoxLink()): ?>
                            
                            
                        <?php if($this->is_public) : ?>
                            <a href="<?php echo $this->button->getURL(); ?>"<?php 
                                if($this->button->getTarget()) _e(" target='".$this->button->getTarget() . "'"); ?>>
                            <?php endif; ?>
                                <h3><?php echo $this->title; ?></h3>
                                <?php if($this->is_public) : ?>
                            </a>
                            <?php endif; ?>
                        <?php else : ?>
                            <h3><?php echo $this->title; ?></h3>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php 
                        $total = 0;
                        $counter = 0;
                        if(is_array($this->terms) ? ($total = count($this->terms)) > 0 : false): $counter = 1;?>
                    <div class="hic-category"><?php 
                        foreach($this->terms as $term) : ?>
                        
                            <?php if($this->is_public) : ?>
                                <a href="<?php echo get_category_link($term->term_id); ?>">
                            <?php endif; ?>    
                            
                                <?php echo $term->name; ?>
                                
                            <?php if($this->is_public) : ?>
                            </a>
                            <?php endif; ?>    
                            
                        <?php if($counter < $total && $counter != $total) : ?><span class="hic-seperator"></span><?php endif;
                            $counter++;
                        endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="contact-details">
                        <?php if($this->location) : ?>
                        <div class="location"><?php echo $this->location; ?></div>
                        <?php endif; ?>
                        <?php if($this->email) : 
                            $default_email_label = _get_field_value("ls_email_address_label", "options");
                            $default_email_label = $default_email_label ? $default_email_label : $this->phone; ?>
                        <div class="email"><a href="mailto:<?php echo $this->email; ?>"><?php echo $default_email_label; ?></a></div>
                        <?php endif; ?>
                        <?php if($this->phone) : 
                            $default_phone_label = _get_field_value("ls_phone_number_label", "options");
                            $default_phone_label = $default_phone_label ? $default_phone_label : $this->phone; ?>
                        <div class="phone"><a href="tel:<?php echo $this->phone; ?>"><?php echo $default_phone_label; ?></a></div>
                        <?php endif; ?>
                        <?php if($this->website) : 
                            $default_website_label = _get_field_value("ls_visit_website_label", "options");
                            $default_website_label = $default_website_label ? $default_website_label : "Visit Site"; ?>
                        <div class="site"><a href="<?php echo $this->website; ?>" target="_blank"><?php echo $default_website_label; ?></a></div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($this->content): ?>
                    <div class="hic-blurb"><?php echo $this->content; ?></div>
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
            <?php if($this->button && $this->button->isBoxLink()) :
                if(!$this->button->isModalButton()) : ?>
                </a>
                <?php else: ?>
                </button> 
            <?php endif; endif; ?>
        </div>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
    
    public function displayCustomContent(){
        
        ob_start(); ?>
        <div class="cell <?php echo isset($this->classes['hic-box-container']) ? $this->getClassesOf('hic-box-container') : ''; ?>">
            <?php if($this->mapContent) :
                 echo $this->mapContent;
            endif;?>
        </div>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
}
endif;
?>