<?php
if (! class_exists ( 'hcPCBProduct' )):
class hcPCBProduct extends hcPCBContent{
    protected $add2cart_button="";
    protected $add2wishlist_button="";
    protected $price="";
    protected $priceHtml="";
    protected $salePrice="";
    protected $isPriceHot=false;
    protected $priceUnit="";
    protected $secondaryImage="";
    protected $terms=[];
    protected $productType="";
    public $isWooProduct=false;
    

    public function __construct(){
        $this->id="";
        $this->title = "";
        $this->content = "";
        $this->image = new hcPCBLink();
        $this->secondaryImage = new hcPCBLink();
        $this->icon = "";
        $this->video = "";
        $this->button = new hcPCBButtonElement();
        $this->classes= ["hic-box-container" => [], "hic-box" => [], 'hic-image-container' => []];
        $this->add2cart_button = new hcPCBButtonElement();
        $this->add2wishlist_button = "";
        $this->price="";
        $this->priceHtml="";
        $this->salePrice="";
        $this->isPriceHot=false;
        $this->terms=[];
        $this->productType="";
        $this->isWooProduct=false;
    }

    public function setProductID($id){
        $this->id = $id;
    }

    public function getProductID(){
        return $this->id;
    }

    public function setProductType($productType){
        $this->productType = $productType;
    }

    public function getProductType(){
        return $this->productType;
    }

    public function setTerms(Array $terms){
        $this->terms = array_merge($this->terms, $terms);
    }

    public function getTerms(){
        return $this->terms;
    }

    public function setTerm(WP_TERM $term){
        if($term) array_push($this->terms, $term);
    }

    public function setPrice($price){
        $this->price = $price;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setPriceHtml($priceHtml){
        $this->priceHtml = $priceHtml;
    }

    public function getPriceHtml(){
        return $this->priceHtml;
    }

    public function setSalePrice($price){
        $this->salePrice = $price;
    }

    public function getSalePrice(){
        return $this->salePrice;
    }
    
    public function priceIsHot($hot){
        $this->isPriceHot = $hot;
    }

    public function isPriceHot(){
        return $this->isPriceHot;
    }

    public function setPriceUnit($unit){
        $this->priceUnit = $unit;
    }

    public function getPriceUnit(){
        return $this->priceUnit;
    }

    public function getAdd2Cart(){
        return $this->add2cart_button;
    }

    public function setAdd2Cart(hcPCBButtonElement $button){
        $this->add2cart_button = $button;
    }

    public function getAdd2Wishlist(){
        return $this->add2wishlist_button;
    }

    public function setAdd2Wishlist($buttontxt){
        $this->add2wishlist_button = $buttontxt;
    }

    public function setSecondaryImage(hcPCBLink $image){
        $this->secondaryImage = $image;
        if( isset($image->url) ? $image->url : false ){
            if( isset($this->image->url) ? $this->image->url : false ){
                array_push($this->classes['hic-image-container'], 'has-secondary-image');    
            }
            else {
                if( !in_array('has-image', $this->classes['hic-image-container']) ) 
                    array_push($this->classes['hic-image-container'], 'has-image');
            }
        }
    }


    public function getSecondaryImage(){
        return $this->SecondaryImage;
    }

	public function displayContent(){
	    
	    ob_start(); ?>

	    <div <?php echo $this->id ? 'data-prod-id="'.$this->id.'" ' : '' ?>class="cell product product-item<?php echo $this->getProductType() ? ' product-'.$this->getProductType() : ''; ?> <?php echo isset($this->classes['hic-box-container']) ? $this->getClassesOf('hic-box-container') : ''; ?>">
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
                    // if( $this->image && $this->image->url || $this->secondaryImage && $this->secondaryImage->url ) : 
                ?>
                <div class="hic-image-container <?php echo isset($this->classes['hic-image-container']) ? $this->getClassesOf('hic-image-container') : ''; ?>">

                    <?php if($this->button && !$this->button->isBoxLink()): ?>
                    <a href="<?php echo $this->button->getURL(); ?>"<?php 
                        if($this->button->getTarget()) _e(" target='".$this->button->getTarget() . "'");
                    ?>>
                    <?php endif; ?>

                        <div class="overlay"></div>
                        <?php if( isset($this->image->url)  ? $this->image->url : false ) : ?>
                        <div class="hic-image" style="background-image: url(<?php echo $this->image->url; ?>);"></div>
                        <?php endif; ?>
                        <?php if( isset($this->secondaryImage->url) ? $this->secondaryImage->url : false ) : ?>
                        <div class="hic-image hic-secondary-image" style="background-image: url(<?php echo $this->secondaryImage->url; ?>);"></div>
                        <?php endif; ?>
                        <?php if( !$this->image->url && !$this->secondaryImage->url ) : ?>
                        <div class="hic-image empty-image" style="background-image: url(<?php echo ASSETS_IMG . 'empty-image.png'?>);"></div>
                        <?php endif; ?>

                    <?php if($this->button && !$this->button->isBoxLink()): ?>
                    </a>
                    <?php endif; ?>

                </div>
                <?php //endif; ?>   

                <div class="hic-content">
                    <?php if( $this->icon ): ?>
                        <div class="hic-icon"><?php echo $this->icon; ?></div>
                    <?php endif; ?>
                    <?php if($this->title): ?>
                    <div class="hic-title">
                        <?php if($this->button  && !$this->button->isBoxLink()): ?>
                            <a href="<?php echo $this->button->getURL(); ?>"<?php 
                                if($this->button->getTarget()) _e(" target='".$this->button->getTarget() . "'"); ?>>
                                <h3><?php echo $this->title; ?></h3>
                            </a>
                        <?php else : ?>
                            <h3><?php echo $this->title; ?></h3>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php 
                        $total = 0;
                        $counter = 0;
                        if(is_array($this->terms) ? ($total = count($this->terms)) > 0 : false): $counter = 1;?>
                    <div class="categories"><?php 
                        foreach($this->terms as $term) : ?>
                            <a href="<?php echo get_category_link($term->term_id); ?>"><?php echo $term->name; ?></a><?php 
                            if($counter < $total && $counter != $total) : ?><span class="hic-seperator"></span><?php endif;
                            $counter++;
                        endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                      
                    <?php if($this->priceHtml || $this->price || $this->salePrice || $this->isPriceHot): ?>
                        <?php if($this->isWooProduct) : 
                            echo '<div class="product-price" data-woo>';
                            if( $this->priceHtml && $this->salePrice ) {
                                echo $this->priceHtml; 
                            } elseif($this->price || ($this->price && $this->getProductType() == 'variable')) {
                                echo PRODUCT_VIEW::woo_money_format($this->price);
                            } 
                            echo '</div>';
                        else : 
                            $is_sale = !empty( $this->salePrice ) ? true : false;
                            $html_price = "";
                            $price = $this->price ? PRODUCT_VIEW::money_format( $this->price ) . $this->priceUnit : "";
                            $html_price = $price;
                            if( $is_sale ) {
                                $sale_price = PRODUCT_VIEW::money_format( $this->salePrice ) . $this->priceUnit;                                
                                if( $price ) {
                                    $html_price = "<del>{$html_price}</del> ";
                                    $html_price .= "<ins>{$sale_price}</ins>";
                                } else {
                                    $html_price .= $sale_price;
                                }                               
                                
                            }
                            
                        ?>
                            <div class="hic-price-details<?php
                                echo $this->salePrice || $this->isPriceHot ? ' has-sale-price' : ''; 
                            ?>">
                            <?php 
                            
                            echo "<span class='price'>".$html_price."</span>";

                            /*
                                <?php if($this->price): ?>
                                    <span class="price rrp">
                                        <?php  
                                            if(  $this->priceHtml ) {                                                
                                                echo $this->priceHtml;
                                            } else {                                               
                                                echo PRODUCT_VIEW::money_format( $this->price ) . $this->priceUnit; 
                                            }
                                        ?>
                                    </span>
                                <?php endif; ?>
                                <?php if($this->isPriceHot ): ?>
                                    <span class="price price-hot">Too Hot to List</span>
                                <?php elseif( $this->salePrice ) :  ?>
                                <span class="price sale-price"><?php echo PRODUCT_VIEW::money_format( $this->salePrice ) . $this->priceUnit; ?></span>
                                <?php endif; ?>
                                */ ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php if($this->content): ?>
                    <div class="hic-blurb"><?php echo $this->content; ?></div>
                    <?php endif; ?>
                    
                    <?php 
                    if( ($this->button && !$this->button->isBoxLink()) || $this->add2cart_button || $this->add2wishlist_button):
                        if($this->button->getButton() || $this->add2cart_button->getButton() || $this->add2wishlist_button): 
                    ?>
                    <div class="hic-button-wrap">
                        <?php
                            $this->button->setButtonClass('view-product-button');
                            if($this->add2cart_button->getButton()) $this->add2cart_button->displayButtonElement();
                            if($this->add2wishlist_button) echo $this->add2wishlist_button;
                            if($this->button->getButton()) $this->button->displayButtonElement(); 
                        ?>
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
        return ob_get_contents();
        ob_end_clean();
	}
}
endif;
?>