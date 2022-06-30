<?php
if (! class_exists ( 'hcPCBArticle' )):
class hcPCBArticle extends hcPCBContent{
    
    protected $date ="";
    protected $author ="";
    protected $category_list ="";

    public function __construct(){
        $this->contentName = "articles";
        $this->defaultSectionClasses=["content-boxes", "articles"];
        $this->title ="";
        $this->content="";
        $this->image="";
        $this->date="";
        $this->author="";
        $this->category_list="";
        $this->classes=["hic-box-container" => [], "hic-box" => [], 'hic-image-container' => []];
        $this->meta =[];
    }
	
	public function setDate($date){
        $this->date = $date;
        if(!in_array('has-post-meta', $this->classes['hic-box'])){
            array_push($this->classes['hic-box'], 'has-post-meta');
        }
    }
    
    public function getDate(){
        return $this->date;
    }

    public function setAuthor($author){
        $this->author = $author;
        if(!in_array('has-post-meta', $this->classes['hic-box'])){
            array_push($this->classes['hic-box'], 'has-post-meta');
        }
    }
    
    public function getAuthor(){
        return $this->author;
    }

    public function setCategoryList($category_list){
        $this->category_list = $category_list;
        if(!in_array('has-post-meta', $this->classes['hic-box'])){
            array_push($this->classes['hic-box'], 'has-post-meta');
        }
    }
    
    public function getCategoryList(){
        return $this->category_list;
    }

    public function setMetaOption($meta){
        $this->meta = $meta;      
    }
    
    public function getMetaOption(){
        return $this->meta;
    }

    
	public function displayContent(){
	    ob_start(); ?>
	    <div class="cell article-item <?php echo !empty($this->classes['hic-box-container']) ? $this->getClassesOf('hic-box-container') : ''; ?>">
    	    <div class="hic-box article-inner <?php echo isset($this->classes['hic-box']) ? $this->getClassesOf('hic-box') : ''; ?>">
                
                <div class="hic-image-container image-wrap <?php echo isset($this->classes['hic-image-container']) ? $this->getClassesOf('hic-image-container') : ''; ?>">
                    <div class="overlay"></div>
                    <?php if( isset($this->image->url) ) : ?>
                        <a href="<?php echo$this->button->getURL(); ?>">
                            <div class="hic-image" style="background-image: url(<?php echo $this->image->url; ?>);"></div>
                        </a>
                    <?php endif; ?>
                </div>   
                                                                                                
                <div class="hic-content content-wrap">
                    
                    <?php if($this->title): ?>

						<header>
						    <div class="hic-title">
                                 <a href="<?php echo $this->button->getURL(); ?>"> <h3><?php echo $this->title; ?></h3></a>
                            </div>
                            <?php 

                                if($this->meta) :
                                
                                    echo '<ul class="no-bullet post-byline">';
                                  if(in_array('date', $this->meta)) {
                                    echo '<li class="published-date"><span>Posted on </span>' . $this->date . '</li>';
                                }
                                if(in_array('author', $this->meta)) {
                                    echo '<li class="author"><span>by</span> ' . $this->author . '</li>';
                                }
                                if(in_array('category', $this->meta)) {
                                    echo '<li class="category">' . $this->category_list . '</li>';
                                }

                                echo '</ul>';

                                endif;
                            ?>

                          
                        
                            
                               
                            
						</header>
                    <?php endif; ?>
                    
                    <?php if($this->content): ?>
						<div class="hic-blurb">
							<?php echo $this->content; ?>                            
						</div>
                    <?php endif; ?>

                    <?php
                    if($this->button):
                        if($this->button->getURL()): 
                    ?>
							<div class="hic-button-wrap">
								<?php if( $this->icon ): ?>
									<div class="hic-icon"><?php echo $this->icon; ?></div>
								<?php endif; ?>
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
}

endif;