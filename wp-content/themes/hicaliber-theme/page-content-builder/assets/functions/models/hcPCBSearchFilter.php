<?php
if (! class_exists ( 'hcPCBSearchFilter' )):
class hcPCBSearchFilter {
    
    // ERROR CATCH MESSAGES
    public $INVALID_NAME_ARGUMENT = "Invalid name argument of setFilterOptions(String name, Array options[, Array defaultOption]): 'name' must be string";
    public $INVALID_OPTIONS_ARGUMENT = "Invalid options argument of setFilterOptions(String name, Array options[, Array defaultOption]): 'options' is an array of ['val'=>'', 'name'=>''] element";
    public $INVALID_DEFAULT_OPTIONS_ARGUMENT = "Invalid defaultOptions argument of setFilterOptions(String name, Array options[, String defaultOption]): 'defaultOptions' must be string";

    public $INVALID_NAME_ARGUMENT_P = "Invalid name argument of setFilterProperties(String name, Array properties): 'name' must be string";
    public $INVALID_PROPERTIES_ARGUMENT = "Invalid properties argument of setFilterProperties(String name, Array properties): properties is an array with indices (name, selected[, queryType][, orderby][, class][, id])";
    
    public $MISSING_FILTER_OPTIONS = "Missing Filter Options in %name%: use setFilterOptions() method to add options to the filter";
    public $MISSING_FILTER_PROPERTY = "Missing Filter Properties in %name%: use setFilterProperties() method to add properties to the filter";
    
    
    public $NO_RESULT_MSG = "No result found. Please try again.";
    
    // DEFAULT FILTER OPTIONS
    public $SORT_FILTER_OPTION_DEFAULT = [ 
                        ['val'   => 'ASC', 'name'  => 'A-Z'],
        		        ['val'   => 'DESC', 'name'  => 'Z-A'] 
        		    ];
    
    public $DATE_FILTER_OPTION_DEFAULT = [
                        [ 'val' => '01', 'name' => 'Jan'],
                        [ 'val' => '02', 'name' => 'Feb'],
                        [ 'val' => '03', 'name' => 'March'],
                        [ 'val' => '04', 'name' => 'April'],
                        [ 'val' => '05', 'name' => 'May'],
                        [ 'val' => '06', 'name' => 'June'],
                        [ 'val' => '07', 'name' => 'July'],
                        [ 'val' => '08', 'name' => 'August'],
                        [ 'val' => '09', 'name' => 'September'],
                        [ 'val' => '10', 'name' => 'October'],
                        [ 'val' => '11', 'name' => 'November'],
                        [ 'val' => '12', 'name' => 'Decemeber'],
                    ];
                    
    private $title = '';
    private $postType = '';
    
    private $contentLoadType = 'paginated';

    private $postCategory = '';
    
    private $filters = [];

    private $clearFilter = array(
        'enable' => false,
        'label' => 'Clear all'
    );

    private $buttonFilters = [];
    
    private $category_filter_type = 'select';
    
    private $query = array();
    private $default_query = array(
                'posts_per_page' => -1,
                'post_type' => 'post',
                'status'	=> 'publish',
        		'orderby'	=> 'meta_value_num',
        		'order'		=> 'DESC'
            );

    public function __construct($title, $postType, $postCategory, $categories=""){
        $this->title = $title;
        
        $this->postType = $postType;
        $this->query = $this->default_query;
        $this->query['post_type'] = $postType;
        
        $this->postCategory = $postCategory;

        if($categories && is_array($categories)){
            $taxonomy = $this->getCatOptionsBy($categories);
        } //else $taxonomy = $this->getCatOptionsBy($postCategory);
        if( isset( $taxonomy ) && is_array($taxonomy) ){
            $defaultTax = [];
            foreach($taxonomy as $tax){
                if(isset($tax['val'])) array_push($defaultTax, $tax['val']);
            }
            $this->setTaxQuery($postCategory, $defaultTax);
        }
    }
    
    public function setPostType($postType){
        $this->postType = $postType;
    }

    public function setcontentLoadType($clt){
        $this->contentLoadType = $clt;
    }
    
    public function getPostType(){
        return $this->postType;
    }
    
    public function setPostCategory($postCategory){
        $this->postCategory = $postCategory;
    }
    
    public function getPostCategory(){
        return $this->postCategory;
    }

    public function getcontentLoadType(){
        return $this->contentLoadType;
    }
    
    public function setQuery($query){
        $this->query = $query;
    }
    
    public function getQuery(){
        return $this->query;
    }
    
    public function getFilters(){
        return $this->filters;
    }

    public function setClearFilter($label="Clear all"){
        if($label){
            $this->clearFilter = array(
                'enable' => true,
                'label' => $label
            );
        }
    }
    
    public function setCategoryFilterType($category_filter_type){
        $this->category_filter_type = $category_filter_type;
    }
    
    public function getCategoryFilterType(){
        return $this->category_filter_type;
    }
    
    public function setFilterProperties( $name, $properties ){
        try{
            if( isset($name) && is_string($name) )
                if( isset($properties) && $this->is_valid_properties($properties) )
                    $this->filters[$name]['property'] = $properties; 
                else throw new Exception($this->INVALID_PROPERTIES_ARGUMENT);
            else throw new Exception($this->INVALID_NAME_ARGUMENT_P);
        } catch (Exception $e){
            echo $e;
        }
    }

    public function setButtonFilterProperties( $name, $properties ){
        try{
            if( isset($name) && is_string($name) )
                if( isset($properties) && $this->is_valid_properties($properties) ){
                    $this->buttonFilters[$name]['property'] = $properties;}
                else throw new Exception($this->INVALID_PROPERTIES_ARGUMENT);
            else throw new Exception($this->INVALID_NAME_ARGUMENT_P);
        } catch (Exception $e){
            echo $e;
        }
    }
    
    public function is_valid_properties( $properties ){
        $validity = true;
        if(isset($properties) && is_array($properties))
            if(!isset($properties['name']) || !isset($properties['selected']) ) $validity = false;
        return $validity;
    }
    
    public function setFilterOptions( $name, $options, $defaultOption ){
        try{
            if( isset($name) && is_string($name) )
                if( $this->is_valid_options($options) ){
                    if( isset($defaultOption) ){
                        if( is_string($defaultOption) ) {
                            $this->filters[$name]['options'] = array_merge([ ['val' => 'any', 'name' => $defaultOption] ], $options); 
                        }
                        else throw new Exception($this->INVALID_DEFAULT_OPTIONS_ARGUMENT);
                    } else {
                        $this->filters[$name]['options'] = $options; 
                    }
                } else throw new Exception($this->INVALID_OPTIONS_ARGUMENT);
            else throw new Exception($this->INVALID_NAME_ARGUMENT);
            
        } catch (Exception $e){
            echo $e;
        }
    }

    public function setButtonFilterOptions( $name, $options ){
        try{
            if( isset($name) && is_string($name) )
                if( $this->is_valid_options($options) ){
                    $this->buttonFilters[$name]['options'] = $options; 
                } else throw new Exception($this->INVALID_OPTIONS_ARGUMENT);
            else throw new Exception($this->INVALID_NAME_ARGUMENT);
            
        } catch (Exception $e){
            echo $e;
        }
    }
    
    public function is_valid_options( $options ){
        // options is valid only if its an unempty array with all elements having val and name indices 
        $validity = true;
        if(isset($options) && is_array($options))
            if(count($options) > 0)
                foreach($options as $option){
                    if( !isset($option['val']) || !isset($option['name'])) $validity =  false;
                }
        return $validity;
    }

    public function getCatOptionsBy( $by ) {
        $val = [];
        
        if(isset($by)){
            if(is_string($by)){ // use BY as post category if string
        	    
        	    // get all terms by CPT category
        	    $terms =  get_terms( $by, array('hide_empty' => 0, 'parent' =>0) );
        	    if(is_array($terms)){
            	    foreach( $terms as $term ){
            	        $val[] = $this->termToOption($term);
            	    }
        	    }
        	    
            } elseif(is_array($by) && function($by){ // use BY as id's if array of numbers
                foreach($by as $id){ // check if all elements are number
                        !is_numeric($id);
                        return false;
                    } return true;
                }){
                
                // get all terms by ID
                foreach($by as $id){
                    $val[] = $this->termToOption(get_term($id));
                }
            }
        }
        
	    return $val;
    }
    
    public function getTagOptions() {
        $val = [];
            
        // get all terms
        $tags =  get_tags();
        foreach( $tags as $tag ){
            $val[] = $this->tagToOption($tag);
        }
	    return $val;
    }
    
    private function tagToOption($tag) {
	    return ['val' => $tag->term_id, 'name' => $tag->name];
    }
    
	private function termToOption($term) {
        if( isset( $term->slug ) && isset( $term->slug ) ) {
	        return ['val' => $term->slug, 'name' => $term->name];    
	    }
    }
	
	public function displaySearchFilter(){
	    if( count($this->filters) > 0 ) : 
	    ob_start(); ?>
	    <section class="page-element widget-form-wrap theme-section" id="hic-search-filter-form">
	        <div class="inner-section">
                <div class="grid-container">
                    <div class="grid-x grid-padding-x">
                        <div class="cell">
                            <div class="widget-form-inner-wrap">
                                <?php if($this->title) : ?>
                                    <h3 class="widget-search-title"><?php echo $this->title; ?></h3>
                                <?php endif; ?>

                                <?php if( $this->getCategoryFilterType() == 'list' ) : echo $this->list_options(); ?>

                                <?php else: ?>

                                <form class="search-widget filter-form" method="GET">
                                    <ul class="qs-ul id="search_filters"">
                                        <?php $this->displaySearchFilterField(); ?>                                        
                                        <?php  $this->displayFilterFields();  ?>
                                     
                                        <?php //$this->displayButtonFilterFields(); ?>

                                        <li class="field left s-cf last">
                                            <input class="button" type="submit" value="Search">

                                            <?php if($this->clearFilter['enable']) : ?>
                                                <a class="clear-filter" href="#"><?php
                                                    echo $this->clearFilter['label']; 
                                                ?></a>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </form>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
    	   </div>
	    </section>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
        endif;
	}
	
	public function displaySearchFilterV2(){
	    if( count($this->filters) > 0 ) : 
	    ob_start(); ?>
	    
	    
	    <div class="cell">
	        <div id="hic-search-filter-form">
                            <div class="widget-form-inner-wrap">
                                <?php if($this->title) : ?>
                                    <h3 class="widget-search-title"><?php echo $this->title; ?></h3>
                                <?php endif; ?>


                                <?php if( $this->getCategoryFilterType() == 'list' ) : echo $this->list_options(); ?>

                                <?php else: ?>

                                <form class="search-widget filter-form" method="GET">
                                    <ul class="qs-ul">
                                        <?php $this->displaySearchFilterField(); ?>                                        
                                        <?php  $this->displayFilterFields();  ?>
                                     
                                        <?php //$this->displayButtonFilterFields(); ?>

                                        <li class="field left s-cf last">
                                            <input class="button" type="submit" value="Search">
                                            <?php if($this->clearFilter['enable'] && $_SERVER['QUERY_STRING'] && count($_REQUEST) > 1) : ?>
                                                <a class="clear-filter" href="<?php echo $_SERVER['REDIRECT_URL']; ?>"><?php
                                                    echo $this->clearFilter['label']; 
                                                ?></a>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </form>
                                <?php endif; ?>
                            </div>
                            </div>
                        </div>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
        endif;
	}
	
	public function displaySearchFilterField(){
	    ob_start(); ?>
    	    <?php 
    	    if(count($this->filters) > 0) : 
	            foreach($this->filters as $filter) : 
	                if(isset($filter['property']['queryType'])) : 
                        if($filter['property']['queryType'] == 'post_query') : 
                            $key = $filter['property']['selected'];
	        ?>
                <li class="field left s-cf first" id="search_filter_field">
                    <input type="text" name="<?php echo $filter['property']['name']; ?>" id="keywords" class="txtKeyword" autocomplete="off" placeholder="<?php echo $filter['property']['placeholder']; ?>" <?php echo $key ? 'value="'.$key.'"' : ''; ?>>
                    <div class="subBox" id="subBox" style="display:none;">
                        <div class="autoSubList" id="autoSubList"></div>
                    </div>
                </li>
	        <?php
	                    endif;
	                endif;
	            endforeach;
	        endif;
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
    

    /******************
     * DROP field filter
     *******************/

    public function checkbox_options( $options , $name , $selected ) {
        $html="";
        
        if( is_array( $selected ) ) {
            $selected = implode(',',$selected);
        }

        $category_name = $selected  ;
        $category_selected_filter = explode( ",",  $category_name );
        
        $html .= '<ul>';
        foreach( $options as $opt ) {
            $id=$opt['val']."_opt";
            if( 'any' == $opt['val'] ) continue;
            $checked = in_array( $opt['val'] , $category_selected_filter  ) ? 'checked="checked"' : '' ;
            $html .= "<li><input $checked class='search-category-input' data-target-field-hidden='{$name}' value='{$opt['val']}' type='checkbox' id='{$id}' ><label for='{$id}'>{$opt['name']}</label></li>";
        }
        $html .= '</ul>';
        $html .= "<input type='hidden' name='{$name}' value='{$selected}'>";
        return $html;
    }
	

    /**
    LIST OPTIONS
    **/
    public function list_options( ){
        foreach($this->filters as $filter) :
            $isfilterOption = true;
            $isfilterOption = isset($filter['property']['queryType']) ? ($filter['property']['queryType'] == 'post_query' ? false : true) : true;                   
            if($isfilterOption) : 
                $selected = isset($filter['property']['selected']) ? $filter['property']['selected'] : 'any';
                $options = $filter['options'];

                $html = '<ul class="list-option element-filter">';
                foreach( $options as $opt ) {
                    $link = esc_url(add_query_arg("posts_category", empty($opt['val']) || $opt['val'] == "any" ? "any" : $opt['val'], get_permalink()));
                    $selected_class = is_array($selected) && in_array($opt["val"], $selected) || $selected == $opt["val"] ? "class='active'" : "";

                    if(empty($opt['val']) || $opt['val'] == "any"){
                        $html .= sprintf("<li %s><a class='button' href='%s'>%s</a></li>", $selected_class, $link, __("All"));
                    }else{
                        $html .= sprintf("<li %s><a class='button' href='%s'>%s</a></li>", $selected_class, $link, $opt['name']);
                    }
                }

                $html .= '</ul>';
                return $html;
            endif;
        endforeach;
    }
    
	public function displayFilterFields(){        
	    ob_start(); 
	        if(count($this->filters) > 0) : ?>
	        <?php
	            foreach($this->filters as $filter) :
	                $isfilterOption = true;
	                $isfilterOption = isset($filter['property']['queryType']) ? ($filter['property']['queryType'] == 'post_query' ? false : true) : true;	                
	                if($isfilterOption) : 
        	            $class = isset($filter['property']['class']) ? $filter['property']['class'] : '';
    	                $name = isset($filter['property']['name']) ? $filter['property']['name'] : '';
    	                $id = isset($filter['property']['id']) ? $filter['property']['id'] : '';
    	                $selected = isset($filter['property']['selected']) ? $filter['property']['selected'] : 'any';
	        ?>
        	    <li class='field left alt s-cf shrink filter-<?php echo $this->getCategoryFilterType(); ?> field-group inline-search-field lg <?php echo $class ?>'>
                    
                    <?php 
                    
                        
                        if( $this->getCategoryFilterType() == 'checkbox' ) : echo $this->checkbox_options( $filter['options'], $name , $selected) ; ?>
                        
                    <?php else : ?>
                    <select name='<?php echo $name; ?>' id='<?php echo $id; ?>'>        		
                    <?php 
                    if(count($filter['options']) > 0) : 
                        foreach($filter['options'] as $option) :
                            $selected_attr = "";					
                            if( $selected == $option['val'] ) {
                                $selected_attr = "selected";
                            }?>    					
                            <option <?php echo $selected_attr; ?> value='<?php echo $option['val']; ?>'><?php echo $option['name']; ?></option>		    							
                            <?php 
                        endforeach;
                    ?> <?php
                    endif;
                    ?>
                    </select>
                    
                    <?php endif; ?>

    	        </li>
            <?php   
                    endif;
                endforeach;
            endif;
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
    
    public function displayButtonFilterFields(){
        ob_start(); 
            
	        if(count($this->buttonFilters) > 0) : ?>
	            <li class="field-button-group left alt s-cf shrink" id="button_filters">
	        <?php
	            foreach($this->buttonFilters as $filter) : 
	                $isfilterOption = true;
	                
	                $isfilterOption = isset($filter['property']['queryType']) ? ($filter['property']['queryType'] == 'post_query' ? false : true) : true;
	                
	                if($isfilterOption) : 
        	            $class = isset($filter['property']['class']) ? $filter['property']['class'] : '';
    	                $name = isset($filter['property']['name']) ? $filter['property']['name'] : '';
    	                $id = isset($filter['property']['id']) ? $filter['property']['id'] : '';
    	                $selected = isset($filter['property']['selected']) ? $filter['property']['selected'] : 'any';
            ?>
                <div class="hic-button-wrap <?php echo $class ?>">
                    <input name='<?php echo $name; ?>' type="hidden" value="<?php echo $selected; ?>" id='<?php echo $id ?>'>
                    <?php
                    if(count($filter['options']) > 0) :  
                        foreach($filter['options'] as $option) : 
                            $active = "";
					
                            if( $selected == $option['val'] ) {
                                $active = "active";
                            }
                        ?>
                            <div class="button-title <?php echo $active; ?>">
                                <a href="#" data-id="<?php echo $option['val']; ?>"><?php echo $option['name']; ?></a>
                            </div>
                    <?php 
                        endforeach;
                    endif; 
                    ?>
                </div>
            <?php   
                    endif;
                endforeach;
                ?> </li> <?php
            endif;
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
	
	public function setOrderByQuery($orderby, $value){
	    if( isset($orderby) && !empty($orderby) && isset($value) && !empty($value)) {
	        if($value == 'any'){
	            $this->query['orderby']  = 'meta_value_num';
                $this->query['order'] = 'DESC';
	        }else{
                $this->query['orderby']  = $orderby;
                $this->query['order'] = $value;
	        }
        }
	}
	
	public function setPostQuery($value){
	    if( isset($value) && !empty($value) ) {
	        if($value != 'any'){
	            $this->query['s']  = $value;
	        }
        }
	}
	
	public function setTaxQuery($taxonomy, $terms){
	    if( isset($terms) && !empty($terms) && isset($taxonomy) && !empty($taxonomy) ) {
	        if($terms != 'any')
                $this->query['tax_query'] = array(
            		array(
            			'taxonomy'  => $taxonomy,
            			'field'     => 'slug', 
            			'terms'     => $terms,
            			'operator' => 'IN'
            		)
            	);
        }
	}
	
	public function setDateQuery($date){
        if( isset($date) && !empty($date) ) {
	        if($date != 'any'){
	            $start_date = date('Y-'.$date.'-01');
                $end_date = date('Y-'.$date.'-t');
	            
	            $this->query['date_query'] = array(
            		array(
                        'after'     => $start_date,
                        'before'    => $end_date,
                        'inclusive' => true
            		)
            	);
	        }
        }
    }
    
    public function setTagQuery($tag){
	    if( isset($tag) && !empty($tag)) {
	        if($tag != 'any'){
	            $this->query['tag_id']  = $tag;
	        }
        }
	}
	
	public function getPosts() {
        if(count($this->filters)>0){
            
            foreach($this->filters as $filter){
                try{
                    if( isset($filter['options']) ){
                        if( isset($filter['property']) ){
                            if( isset($filter['property']['orderby']) ) 
                                $this->setOrderByQuery($filter['property']['orderby'], $filter['property']['selected']);
                            if( isset($filter['property']['queryType']) ){
                                if( $filter['property']['queryType'] == 'tax_query' )
                                    $this->setTaxQuery($this->postCategory, $filter['property']['selected']);
                                elseif( $filter['property']['queryType'] == 'date_query' ) 
                                    $this->setDateQuery($filter['property']['selected']);
                                elseif( $filter['property']['queryType'] == 'post_query' ) 
                                    $this->setPostQuery($filter['property']['selected']);
                            }
                        }
                        //else throw new Exception($this->MISSING_FILTER_PROPERTY);
                    } //else throw new Exception($this->MISSING_FILTER_OPTIONS);
                } catch (Exception $e){
                    echo $e;
                }
                 
            }
        }

        // if(count($this->buttonFilters)>0){
            
        //     foreach($this->buttonFilters as $filter){
        //         try{
        //             if( isset($filter['options']) ){
        //                 if( isset($filter['property']) ){
        //                     if( $filter['property']['queryType'] == 'tag_query' ) 
        //                     $this->setTagQuery($filter['property']['selected']);
        //                 }
        //                 //else throw new Exception(self::MISSING_FILTER_PROPERTY);
        //             } //else throw new Exception(self::MISSING_FILTER_OPTIONS);
        //         } catch (Exception $e){
        //             echo $e;
        //         }
                 
        //     }
        // } 
        
        return new WP_Query( $this->query ); 
	}
	
	public function getPostData($relQuery){
	    $data = [];
	    
		if ($relQuery -> have_posts()) : 
		    while ($relQuery -> have_posts()) : $relQuery -> the_post(); 
		        $data[] = [
		            'id'            => get_the_ID(),
		            'title'         => get_the_title(),
		            'image'         => get_featured_image( get_the_ID() ),
		            'link'          => get_the_permalink(),
		            'content'       => get_the_content(),
		            'post_class'    => get_post_class( ''),
		            'time'          => get_the_time('j F Y')
		        ];
		    endwhile;
		  
		endif;
	    
	    wp_reset_postdata();
	    
	    return $data;
	}
	
	public function getPagination($itemPerPage, $isScroll=true, $scrollSpeed=5, $containerClass="", $paginationClass=""){
	    ob_start(); ?>
            <div class="grid-x grid-padding-x">
                <div class="cell">
                    <div class="hic-paginate-pagination page-navigation <?php echo $containerClass ?>" data-per-page="<?php echo $itemPerPage; ?>" data-smooth-scroll="<?php 
                            echo $isScroll; ?>" data-scroll-speed="<?php echo $scrollSpeed; ?>">
                        <ul class="hic-pagination-page pagination <?php echo $paginationClass; ?>"></ul>
                    </div>
                </div>
            </div>
        <?php

        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public function displayPagination($itemPerPage, $totalItems=0, $isScroll=true, $scrollSpeed=5, $containerClass="", $paginationClass=""){
        if($totalItems > $itemPerPage ) :
            echo $this->getPagination($itemPerPage, $isScroll, $scrollSpeed, $containerClass, $paginationClass);
        endif;
    }
    
    public function displayLoadMore(){
        echo $this->getLoadMore();
    }

    public function getLoadMore(){
        ob_start(); ?>
            <div class="grid-x grid-padding-x section-footer">
                <div class="cell small-12 text-center">
                    <div class="load-more-button button">Load More</div>
                </div>
            </div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
	
	public function displayNoResult($message="", $class=""){
	    ob_start(); ?>
	    
	    <div class='cell text-center <?php echo $class; ?>'><?php echo $message ? $message : $this->NO_RESULT_MSG; ?></div>
	    
	    <?php
	    $html = ob_get_contents();
        ob_end_clean();
        echo $html;
	}
}

endif;