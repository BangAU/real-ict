<?php
if (! class_exists ( 'hcPCBContent' )):
class hcPCBContent {
    protected $box_id="";
    protected $title="";
    protected $content="";
    protected $image="";
    protected $icon="";
    protected $imageIcon="";
    protected $useImageIcon="";
    protected $media_type="image";
    protected $video="";
    protected $video2="";
    protected $gallery="";
    protected $button="";
    protected $event_date="";	
    private $noColumns = false;
    protected $classes=["hic-box-container" => [], "hic-box" => [], 'hic-image-container' => []];
    public $contentName="content-box";
    public $defaultSectionClasses=["content-box-element"];

    public function __construct(){
		$this->box_id = "";
        $this->title = "";
        $this->content = "";
        $this->image = new hcPCBLink;
        $this->icon = "";
        $this->media_type = "";
        $this->gallery = "";
        $this->imageIcon = "";
        $this->event_date="";
        $this->useImageIcon = "";
        $this->video = new hcPCBLink;
        $this->video2 = new hcPCBLink;
        $this->button = new hcPCBButtonElement;
        $this->noColumns = false;
        $this->classes= ["hic-box-container" => [], "hic-box" => [], 'hic-image-container' => []];
    }

    public function addDefaultSectionClasses($classes){
        array_push($this->defaultSectionClasses, $classes);
    }
    
    public function setTitle($title){
        $this->title = $title;
    }

    public function setNoColumns(bool $value){
        $this->noColumns = $value;
    }
    
    public function setContent($content = ""){
        $this->content = $content;
    }
    
    public function setImage(hcPCBLink $image){
        $this->image = $image;;
        if($image->url) array_push($this->classes['hic-box-container'], 'has-media has-image');
    }
    public function setIcon($icon){
        $this->icon = $icon;
    }
    public function setImageIcon(hcPCBLink $icon){
        $this->imageIcon = $icon;
    }
    public function setUseImageIcon($flag){
        $this->useImageIcon = $flag;
    }
    public function setVideo(hcPCBLink $video){
        $this->video = $video;
        if($this->video->url){
            array_push($this->classes['hic-box-container'], 'has-media has-video');   
            
            if(!$this->image->url){
                $thumb = new hcPCBLink(self::getVideoThumbnail($this->video->url, "maximum"));
                $this->setImage($thumb);
            }
        }
    }
    public function setButton(hcPCBButtonElement $button){
        $this->button = $button;
    }
    
    public function getTitle(){
        return $this->title;
    }
    
    public function getContent(){
        return $this->content;
    }
    
    public function getImage(){
        return $this->image;
    }
    public function getIcon(){
        return $this->icon;
    }
    public function getImageIcon(){
        return $this->imageIcon;
    }
    public function getUseImageIcon(){
        return $this->useImageIcon;
    }
    public function getVideo(){
        return $this->video;
    }
    public function getButton(){
        return $this->button;
    }

    public function setEventDate($event_date){
        $this->event_date = $event_date;
    }
    public function getEventDate(){
        return $this->event_date;
    }

    public function setVideo2(hcPCBLink $video){
        $this->video2 = $video;
        if($this->video2->url){
            array_push($this->classes['hic-box-container'], 'has-media has-video');   
            
            if(!$this->image->url){
                $thumb = new hcPCBLink(self::getVideoThumbnail($this->video2->url, "maximum"));
                $this->setImage($thumb);
            }
        }
    }

    public function setMediaType($media_type){
        $this->media_type = $media_type;          
    }

    public function getVideo2(){
        return $this->video2;
    }


    public function setGallery($gallery){
        $this->gallery = $gallery;     
        if($gallery) array_push($this->classes['hic-box-container'], 'has-media has-gallery');
    }

    public function setClassesOf($element, $classes){
        $this->classes[$element] = is_string($classes) ? explode(" ", $classes) : (is_array($classes) ? $classes : '');
    }
    
    public function getClassesOf($element){
        if(isset($this->classes[$element]))
            return implode(" ", $this->classes[$element]);
    }
	
	 public function setBoxID($box_id){
        return $this->box_id = str_replace(' ', '', $box_id);
    }
   
    public function displayContent(){
        
        ob_start(); ?>
        <?php if(!$this->noColumns) : ?>
        <div <?php echo !empty($this->box_id) ? 'id="'.$this->box_id.'"' : '';  ?> class="cell <?php echo !empty($this->classes['hic-box-container']) ? $this->getClassesOf('hic-box-container') : ''; ?>">
        <?php endif; ?>
            <?php if($this->button && $this->button->isBoxLink()) : 
                if(!$this->button->isModalButton()) : ?>
                <a href="<?php echo $this->button->getURL(); ?>"<?php 
                    if($this->button->getTarget()) _e(" target='".$this->button->getTarget() . "'");
                ?>>
                <?php else : ?>
                <button data-open='<?php echo $this->button->getDataOpen(); ?>'>
            <?php endif; 
            endif; ?>
					
			<?php /* <div class="hic-box <?php echo isset($this->classes['hic-box']) ? $this->getClassesOf('hic-box') : ''; ?>"> */ ?>		
					
            <div class="hic-box <?php echo isset($this->classes['hic-box']) ? $this->getClassesOf('hic-box') : ''; ?>">


                <?php switch ($this->media_type) {
                    case 'gallery':
                            
                            $gallery = isset($this->gallery) ? $this->gallery : '';

                            ?>

                           <?php if( $gallery ): ?>
                                <div class="hic-image-container">
                                    <ul class="pcb-gallery-slider">
                                        <?php foreach( $gallery as $image ): ?>
                                            <li>                                   
                                                <div class="hic-image" style="background-image: url(<?php echo $image['url']; ?>);"></div>                                    
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                            <?php endif; ?>

                            <?php


                        break;

                    case 'video':
                    default:
                   
                            ?>

                            <?php
                    if( $this->image && $this->image->url ) : 
                ?>
                <div class="hic-image-container <?php echo isset($this->classes['hic-image-container']) ? $this->getClassesOf('hic-image-container') : ''; ?>">

                    <?php if($this->button->getURL() && !$this->button->isBoxLink()): ?>
                    
                    <?php if(!$this->button->isModalButton()) : ?>
                    <a href="<?php echo $this->button->getURL(); ?>"<?php 
                        if($this->button->getTarget()) _e(" target='".$this->button->getTarget() . "'");
                    ?>>
                        <?php endif; ?>
                    <?php endif; ?>

                        <div class="overlay"></div>





                        <?php if( isset($this->image->url) ) : ?>
                        
                        
                            

                            <?php 
                            
                               
                            if($this->video2->url) : ?>
                            <a href="<?php echo $this->video2->url; ?>" data-fancybox>  
                            <?php endif; ?>

                        <div class="hic-image" style="background-image: url(<?php echo $this->image->url; ?>);">

                            <?php if($this->video2->url) : ?>                                
                                  <div class="v-align-container vpv-container">
                                    <div class="table-cell-mid">
                                        <img class="video-play-button" src="<?php echo ASSETS_IMG . 'play-button.png'; ?>">
                                    </div>
                                  </div>
                            <?php endif;  ?>

                        </div>
                        <?php if($this->video2->url) : ?>
                        </a>
                        <?php endif; ?>

                        <?php endif; ?>

                    <?php if($this->button->getURL() && !$this->button->isBoxLink()): ?>
                    <?php if(!$this->button->isModalButton()) : ?>
                    </a>
                    <?php endif; ?>
                    <?php endif; ?>

                </div>
                <?php endif; ?>  

                            <?php


                        break;
                } 
                
                if($this->icon || ($this->imageIcon && isset($this->imageIcon->url)) || $this->title || $this->event_date || $this->content || $this->button->getButton()) : ?>
                    <div class="hic-content"><?php 
                        if( $this->icon || ($this->imageIcon && isset($this->imageIcon->url)) ): ?>
                            <div class="hic-icon">
                                <?php if($this->icon && !$this->useImageIcon) echo $this->icon; ?>
                                <?php if($this->imageIcon && $this->imageIcon->url && $this->useImageIcon): ?>
                                    <img src="<?php echo $this->imageIcon->url; ?>" alt="content box icon"/>
                                <?php endif; ?>
                            </div><?php 
                        endif; 
                        
                        if($this->title): 
                            ?><div class="hic-title">
                                <?php if($this->button  && !$this->button->isBoxLink()): ?>
                                    <h3><?php echo $this->title; ?></h3>
                                <?php else : ?>
                                    <h3><?php echo $this->title; ?></h3>
                                <?php endif; ?>

                                
                                <?php if( $this->event_date ) : ?>
                                <ul class="no-bullet post-byline">
                                    <li class="event-time"><?php echo $this->event_date; ?></li>
                                </ul>
                                <?php endif; ?>
                            </div><?php 
                        endif;
                        
                        if($this->content): 
                            ?><div class="hic-blurb"><?php echo $this->content; ?></div><?php 
                        endif; 
                        
                        if($this->button && !$this->button->isBoxLink()):
                            if($this->button->getButton()): 
                                ?><div class="hic-button-wrap">
                                    <?php $this->button->displayButtonElement(); ?>
                                </div><?php 
                            endif; 
                        endif;
                        
                        ?></div><?php
                endif; ?>
            </div>
            <?php if($this->button && $this->button->isBoxLink()) :
                if(!$this->button->isModalButton()) : ?>
                </a>
                <?php else: ?>
                </button> 
            <?php endif; endif; ?>
        <?php if(!$this->noColumns) : ?>
        </div>
        <?php endif; ?>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }

    public static function getVideoThumbnail($url, $quality){
        $thumbnail = NULL;
        
        if($url){
            $youtube_regexp = "/^http:\/\/|https:\/\/(?:www.)?(?:youtube.com|youtu.be)\/(?:watch?(?=.*v=([\w-]+))(?:\S+)?|([\w-]+))$/";
            $vimeo_regexp = "/^http:\/\/|https:\/\/(?:www.)?(?:vimeo.com)\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)$/";
            
            preg_match($youtube_regexp, $url, $youtube_matches);
            preg_match($vimeo_regexp, $url, $vimeo_matches);
            
            if(sizeof($youtube_matches) == 2){
                $thumbnail = self::getYouTubeThumbnail($youtube_matches[1], $quality);
            } elseif(sizeof($vimeo_matches) == 3){
                $thumbnail = self::getVimeoThumbnail($vimeo_matches[2], $quality);
            }   
        }
        
        return $thumbnail;
    }
    
    public static function getYouTubeThumbnail($id, $quality){
        $thumbnail = "";
        $vid_quality = array(
                    'low' => 'sddefault.jpg',
                    'medium' => 'mqdefault.jpg',
                    'high' => 'hqdefault.jpg',
                    'maximum' => 'maxresdefault.jpg'
                );
       
        if($id) {
            $quality = array_key_exists($quality, $vid_quality) ? $vid_quality[$quality] : $vid_quality['maximum'];
            $thumbnail = "http://img.youtube.com/vi/".$id."/".$quality;
        }
        return $thumbnail;
    }
    
    public static function getVimeoThumbnail($id, $quality){
        $thumbnail = "";
        $vid_quality = array(
                    'low' => 'thumbnail_small',
                    'medium' => 'thumbnail_medium',
                    'high' => 'thumbnail_large'
                );
       
        if($id){
            $vimeo_thumbs = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"))[0];
            $quality = array_key_exists($quality, $vid_quality) ? $vid_quality[$quality] : $vid_quality['high'];
            $thumbnail = $vimeo_thumbs[$quality];
        }
        
        return $thumbnail;
    }
}
endif;