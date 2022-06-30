<?php
if (! class_exists ( 'hcContentBuilder' )):
class hcContentBuilder {
    private $header=[];
    private $footer=[];
    private $error="";
    private $classes=["section" => [], "section-header" => [], 'section-body' => [], 'section-footer' => []];
    private $id="";
    private $contents=[];
    private $background="";
    private $data=[];
    private $contentType="";
    private $validContent=['hcPCBContent', 'hcPCBTestimonial', 'hcPCBArticle', 'hcPCBProject', 'hcPCBEvents', 'hcPCBCourses', 'hcPCBLocation', 'hcPCBAccProperties', 'hcPCBAccPromotions', 'hcPCBRoomType' ];
    private $extraHTML = [];
    private $noContentMessage = "";

    public function __construct($contentType=""){
        $this->setContentType($contentType);
        $this->header=[];
        $this->footer=[];
        $this->error="";
        $this->classes=["section" => [], "section-header" => [], 'section-body' => [], 'section-footer' => []];
        $this->id="";
        $this->contents=array();
        $this->data=[];
        $this->background="";
        $this->extraHTML = [];
        $this->noContentMessage = "";
    }

    public function setContentType($contentType){
        if(is_string($contentType)) $this->contentType = $contentType;
        elseif( $this->isValidContent($contentType) ){
            $this->contentType = $contentType->contentName;
            $this->addClassesTo('section', $contentType->defaultSectionClasses);
        }
    } 

    public function isValidContent($contentType){
        return in_array( get_class($contentType), $this->validContent );
    }

    public function setHeader($header, $sub=""){
        if( $header && is_string($header) ){
            $this->header['title'] = $header;
            $this->header['sub-heading'] = $sub;
        } elseif( is_array($header) ) {
            $this->header = [
                'title'       => isset($header['peh_section_title']) ? $header['peh_section_title'] : "",
                'sub-heading'  => isset($header['peh_sub_heading']) ? $header['peh_sub_heading'] : ""
            ];
        }
    }

    public function hasHeader($header, $sub=""){
        if( is_string($header) ){
            if( $header || $sub) return true;
            else return false;
        } elseif( is_array($header) ) {
            if( (isset($header['peh_section_title']) ? $header['peh_section_title'] : false) || ( isset($header['peh_sub_heading']) ? $header['peh_sub_heading'] : false ) )
                return true;
            else return false;
        }
    }

    public function setSettings($settings){
        if( is_array($settings) ) {
            if( isset($settings['section_classes']) ) $this->addClassesTo('section', $settings['section_classes']);
            if( isset($settings['theme']) ) $this->addClassesTo('section', $settings['theme']);
            if( isset($settings['element_width']) ) $this->addClassesTo('section', $settings['element_width']);
            if( isset($settings['text_alignment']) ) $this->addClassesTo('section', $settings['text_alignment']);
            if( isset($settings['section_id']) ) $this->setSectionId($settings['section_id']);
            if( isset($settings['background_image']) ) $this->setBackground(new hcPCBLink($settings['background_image']));
        }
    }

    public function getSettings(){
        return $this->settings;
    }
    
    public function setHeaderTitle($title){
        $this->header['title'] = $title;
    }
    
    public function setHeaderSub($sub){
        $this->header['sub-heading'] = $sub;
    }

    public function setNoContentMessage($message){
        $this->noContentMessage = $message;
    }

    public function printHeader($header="", $sub=""){
        if($header || $sub) $this->setHeader($header, $sub);
        
        ob_start(); ?>
            <?php if( isset($this->header['title']) || isset($this->header['sub-heading']) ) : ?>
            <?php if( $this->header['title'] || $this->header['sub-heading'] ) : ?>
                
                <?php
                    $heading_class = '';

                    if($this->header['title'] && $this->header['sub-heading']) {
                        $heading_class = ' heading-and-subheading';
                    }
                    
                    if(empty($this->header['title']) && $this->header['sub-heading']) {
                        $heading_class = ' sub-heading-only';
                    }
                    if($this->header['title'] && empty($this->header['sub-heading'])) {
                        $heading_class = ' heading-only';
                    }
                
                ?>
            
                <div class="grid-x grid-padding-x section-header<?php echo $heading_class; ?>">
                    <div class="cell medium-12 <?php echo isset($this->classes['section-header']) ? $this->getClassesOf('section-header') : ''; ?>">
                        <?php if( $this->header['title'] ) : ?>
                            <h2 class="section-title"><?php echo $this->header['title']; ?></h2>
                        <?php endif; ?>
                        <?php if( $this->header['sub-heading'] ) : ?>
                            <h4 class="sub-heading"><?php echo $this->header['sub-heading']; ?></h4>                    
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; endif; ?>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }

    public function setBackground(hcPCBLink $bg){
        $this->background=$bg;
        if($this->background->url) $this->addClassesTo('section', ['has-bg-img', 'bg-helper']);
    }

    public function getBackground(){
        return $this->background;
    }

    public function setData($dataname, $value){
        array_push($this->data, ['name' => 'data-'.$dataname, 'value' => $value]);
    }

    public function getData(){
        $datas = "";
        if(count($this->data) > 0){
            foreach($this->data as $d){
                $datas .= $d['name'] . '=\'' . $d['value'] . '\' ';
            }
        }
        return $datas;
    }
    
    public function setSectionId($id){
        $this->id = $id;
    }
    
    public function printBodyContent(){
        ob_start(); ?>
            <div class="grid-x grid-padding-x section-body <?php echo isset($this->classes['section-body']) ? $this->getClassesOf('section-body') : ''; ?>" <?php if($this->data) _e( $this->getData() ); ?>>
                <?php
                    if(count($this->contents) > 0) {
                        foreach($this->contents as $content){
                            if( $this->isValidContent($content) ) $content->displayContent();
                        }
                    } else {
                        echo $this->noContentMessage;
                    }
                    
                ?>
            </div>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
    
    public function printCustomBodyContent(){
        ob_start(); ?>
            <div class="grid-x grid-padding-x section-body <?php echo isset($this->classes['section-body']) ? $this->getClassesOf('section-body') : ''; ?>" <?php if($this->data) _e( $this->getData() ); ?>>
                <?php
                    if(count($this->contents) > 0) {
                        foreach($this->contents as $content){
                            if( $this->isValidContent($content) ) $content->displayCustomContent();
                        }
                    } else {
                        echo $this->noContentMessage;
                    }
                    
                ?>
            </div>
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
    
    public function setContentBox(hcPCBContent $content){
        array_push($this->contents, $content);
    }
    
    public function setFooter($footer){
        $this->footer = $footer;
    }
    
    public function printFooter($footer=""){
        if($footer) $this->setFooter($footer);
        
        if(isset($this->footer['group_button'])) :
            if(is_array($this->footer['group_button']) && $this->footer['group_button'] > 0) :
                ob_start(); ?>
                    <div class="grid-x grid-padding-x section-footer">
                        <div class="cell hic-button-wrap<?php echo isset($this->classes['section-footer']) ? $this->getClassesOf('section-footer') : ''; ?>">
                            <?php
                            foreach($this->footer['group_button'] as $btn) :
                                if($btn['button_target'] == 'modal'){
                                    $button = new hcPCBButtonElement($btn['modal']);
                                    $button->toggleClass('footer-button');
                                    $button->displayButtonElement();
                                } else 
                                    if($btn['link']){
                                        $button = new hcPCBButtonElement($btn['link']);
                                        $button->displayButtonElement();
                                    }
                                    
                            endforeach; 
                            
                            ?>
                        </div>
                    </div>
                <?php 
                $html = ob_get_contents();
                ob_end_clean();
                echo $html;
             endif;
        endif;
    }
    
    public function displaySection($customContent = false){
        ob_start(); ?>
        
        <section <?php echo $this->id ? "id='" . $this->id . "'" : ""; ?> class="page-element <?php echo isset($this->classes['section']) ? $this->getClassesOf('section') : ''; ?>">
            <?php if($this->background) : ?>
            <?php if($this->background->url): ?>
            <div class="bg-float bg-helper bg-image" style="background-image:url(<?php echo $this->background->url; ?>)" ></div>
            <?php endif; ?>
            <?php endif; ?>
            <div class="inner-section">
                <div class="grid-container">
                <?php
                    if(isset($this->extraHTML[0])) echo $this->extraHTML[0];
                    $this->printHeader();
                    if(isset($this->extraHTML[1])) echo $this->extraHTML[1];
                    if($customContent) $this->printCustomBodyContent();
                    else $this->printBodyContent();
                    if(isset($this->extraHTML[2])) echo $this->extraHTML[2];
                    $this->printFooter();
                    if(isset($this->extraHTML[3])) echo $this->extraHTML[3];
                ?>
                </div>
            </div>
        </section>
        
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
    
    public function displaySectionTabs($element = ''){
        ob_start(); ?>
        
        <section <?php echo $this->id ? "id='" . $this->id . "'" : ""; ?> class="page-element <?php echo isset($this->classes['section']) ? $this->getClassesOf('section') : ''; ?>">
            <?php if($this->background) : ?>
            <?php if($this->background->url): ?>
            <div class="bg-float bg-helper bg-image" style="background-image:url(<?php echo $this->background->url; ?>)" ></div>
            <?php endif; ?>
            <?php endif; ?>
            <div class="inner-section">
                <div class="grid-container">
                <?php
                    if(isset($this->extraHTML[0])) echo $this->extraHTML[0];
                    $this->printHeader();
                    echo $element;
                    if(isset($this->extraHTML[2])) echo $this->extraHTML[2];
                    $this->printFooter();
                    if(isset($this->extraHTML[3])) echo $this->extraHTML[3];
                ?>
                </div>
            </div>
        </section>
        
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
    
    public function addClassesTo($element, $classes){
        if( is_string($classes) ){
            $this->classes[$element] = array_merge( $this->classes[$element], explode(" ", $classes) );
        }
        elseif( is_array($classes) ){
            $this->classes[$element] = array_merge( $this->classes[$element], $classes);
        }
    }

    public function setClassesOf($element, $classes){
        $this->classes[$element] = is_string($classes) ? explode(" ", $classes) : (is_array($classes) ? $classes : '');
    }
    
    public function getClassesOf($element){
        if(isset($this->classes[$element]))
            return implode(" ", array_filter($this->classes[$element]));
    }

    public function setExtraHTML($html, $position=3){
        $this->extraHTML[$position] = $html;
    }

    public function getExtraHTML($position=false){
        if($position !== false) {
            if(isset($this->extraHTML[$position])){
                return $this->extraHTML[$position];
            } else return false;
        } else {
            return $this->extraHTML;
        }
    }

    public function getNoContentMessage(){
        return $this->noContentMessage;
    }

}

endif;