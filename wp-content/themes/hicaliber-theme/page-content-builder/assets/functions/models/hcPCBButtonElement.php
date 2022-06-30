<?php
if (! class_exists ( 'hcPCBButtonElement' )):
class hcPCBButtonElement {
    private $invalid_url = "Button object must be an array[url=>value, title=>value, target=>value]";
    public $button="";
    public $buttonElement="";
    private $error="";
    private $class=[];
    private $id="";
    private $bclass="";
    private $linkOnly = false;
    private $isBox = false;
    private $data=[];
    private $icon="";

    public function __construct($btn=""){
        $this->class = ['button'];
        $this->icon="";
        $this->data = [];
        $this->linkOnly = false;
        $this->isBox = false;
        $this->id="";
        $this->bclass;
        $this->error="";
        if(is_array($btn)) $this->button = $btn;
        //else $this->error = $this->INVALID_ARRAY_BUTTON;
    }

    public function constructButton($link = "", $title = "", $target = "", $linkOnly=false){
        if($linkOnly && is_bool($linkOnly)) $this->linkOnly = $linkOnly;
        $btn = [
          'url'          => $link,
          'title'        => $title,
          'target'       => $target
        ];
        $this->button = $btn;
    }
    
    public function constructModalButton($dataOpen = "", $title = ""){
        $btn = [
          'title'        => $title,
          'data_open'    => $dataOpen,
        ];
        $this->button = $btn;
    }
    
    public function setData($dataname, $value){
        array_push($this->data, ['name' => 'data-'.$dataname, 'value' => $value]);
    }
    
    public function setIcon($icon){
        $this->icon = $icon;
    }
    
    public function getIcon(){
        return $this->icon;
    }

    public function setButtonClass($class="") {
        $this->bclass = $class;
    }
    
      public function getButtonClass() {
        return $this->bclass;
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
    
    public function toggleClass($class){
        $index = array_search($class, $this->class);
        if($index !== false){
            unset($this->class[$index]);
        }
        else array_push($this->class, $class);
    }
    
    public function toggleClasses($classes){
        if(is_array($classes)){
            foreach($classes as $class){
                $index = array_search($class, $this->class);
                if($index !== false){
                    unset($this->class[$index]);
                }
                else array_push($this->class, $class);
            }
        }
    }
    
     public function removeClass($class){
        $index = array_search($class, $this->class);
        if($index !== false){
            unset($this->class[$index]);
        }
    }
    
    public function getClasses(){
        return implode(" ", $this->class);
    }
    
    public function setID($id = ""){
        $this->id = $id;
    }
    
    public function getID(){
        return $this->id;
    }

    public function setButton($btn = ""){
        if(is_array($btn)) $this->button = $btn;
        //else $this->error = $this->INVALID_ARRAY_BUTTON;
    }

    public function getButton(){
        return $this->button;
    }

    public function setButtonElement($btnElem){
        $this->buttonElement = $btnElem;
    }

    public function getButtonElement(){
        return $this->buttonElement;
    }
    
    public function setLinkOnly($linkOnly){
        if($linkOnly && is_bool($linkOnly)) $this->linkOnly = $linkOnly;
    }

    public function setIsBoxLink($isbox){
        if($isbox && is_bool($isbox)) $this->isBox = $isbox;
    }

    public function IsBoxLink(){
        return $this->isBox;
    }

    public function generateButtonElement() {
        if($this->isButtonSet()) {
            if($this->linkOnly) $this->generateLink();
            else{
                if( $this->isEmailButton() ) $this->generateEmailButton();
                elseif($this->isPhoneButton()) $this->generatePhoneButton();
                elseif($this->isModalButton()) $this->generateModalButton();
                else $this->generateButton();
            }
        }

        return $this->getButtonElement();
    }

    public function displayButtonElement() {
        $this->generateButtonElement();
        echo $this->isNorError() ? $this->getButtonElement() : $this->error;
    }

    private function isNorError() {
        return $this->error == "";
    }

    private function isButtonSet() {
        return isset($this->button) && ( isset($this->button['url']) || isset($this->button['title']) );
    }

    private function isEmailButton() {
        return isset($this->button['url']) ? strpos( $this->button['url'] , 'mailto:') !== false : false;
    }

    private function isPhoneButton() {
        return isset($this->button['url']) ? strpos( $this->button['url'] , 'tel:') !== false : false;
    }
    
    public function isModalButton() {
        return isset($this->button['data_open']) ? true : false;
    }

    private function generateEmailButton() {
        ob_start(); ?>
            <a<?php 
                if( isset($this->button['url']) ? $this->button['url'] : false ) _e(" href='".$this->button['url']."'");
                if( isset($this->button['target']) ? $this->button['target'] : false ) _e(" target='".$this->button['target']."'");
                if($this->id) _e(" id='".$this->id."'");
            ?> class="<?php _e($this->getClasses()); ?> show-for-medium" <?php
                if($this->data) _e( $this->getData() );
            ?>><i class="far fa-envelope"></i><span><?php _e($this->button['title'] ? $this->button['title'] : "Email"); ?></span></a>

            <a<?php 
                if( isset($this->button['url']) ? $this->button['url'] : false ) _e(" href='".$this->button['url']."'");
                if( isset($this->button['target']) ? $this->button['target'] : false ) _e(" target='".$this->button['target']."'");
                if($this->id) _e(" id='".$this->id."'");
            ?> class="<?php _e($this->getClasses()); ?> hide-for-medium" <?php
                if($this->data) _e( $this->getData() );
            ?>><i class="far fa-envelope"></i><span>Email</span></a>
        <?php 
        $this->setButtonElement( ob_get_contents() );
        ob_end_clean();
    }    

    private function generatePhoneButton() {
        ob_start(); ?>
            <a<?php 
                if( isset($this->button['url']) ? $this->button['url'] : false ) _e(" href='tel:".hic_force_phone_number(str_replace('tel:', '', str_replace(' ', '', $this->button['url'])))."'");
                if( isset($this->button['target']) ? $this->button['target'] : false ) _e(" target='".$this->button['target']."'");
                if($this->id) _e(" id='".$this->id."'");
            ?> class="<?php _e($this->getClasses()); ?> show-for-medium" <?php
                if($this->data) _e( $this->getData() );
            ?>><i class="fa fa-phone" aria-hidden="true"></i><span><?php _e($this->button['title'] ? $this->button['title'] : "Phone"); ?></span></a>

            <a<?php 
                if( isset($this->button['url']) ? $this->button['url'] : false ) _e(" href='".str_replace(' ', '', $this->button['url'])."'");
                if( isset($this->button['target']) ? $this->button['target'] : false)  _e(" target='".$this->button['target']."'");
                if($this->id) _e(" id='".$this->id."'");
            ?> class="<?php _e($this->getClasses()); ?> hide-for-medium" <?php
                if($this->data) _e( $this->getData() );
            ?>><i class="fa fa-phone"></i><span>Call</span></a>
        <?php 
        $this->setButtonElement( ob_get_contents() );
        ob_end_clean();
    }    
    
    private function generateModalButton() {
        ob_start(); ?>
            <button<?php 
                if( isset($this->button['data_open']) ? $this->button['data_open'] : false ) _e(" data-open='".$this->button['data_open']."'");
                if($this->id) _e(" id='".$this->id."'");
                $this->toggleClass('modal-button');
            ?> class="<?php _e($this->getClasses()); ?>" <?php
                if($this->data) _e( $this->getData() );
            ?>><?php 
                if($this->icon) _e($this->icon."<span>".html_entity_decode($this->button['title'] ? $this->button['title'] : "View")."</span>");
                else _e(html_entity_decode($this->button['title'] ? $this->button['title'] : "View")); 
            ?></button>
            
        <?php 
        $this->setButtonElement( ob_get_contents() );
        ob_end_clean();
    }

    private function generateButton() {
        ob_start(); ?>
            <a<?php 
                if( isset($this->button['url']) ? $this->button['url'] : false ) _e(" href='".$this->button['url']."'");
                if( isset($this->button['target']) ? $this->button['target'] : false ) _e(" target='".$this->button['target']."'");
                if($this->id) _e(" id='".$this->id."'");
            ?> class="<?php _e($this->getClasses()); ?>" <?php
                if($this->data) _e( $this->getData() );
            ?>><?php 
                if($this->icon) _e($this->icon."<span>".html_entity_decode($this->button['title'] ? $this->button['title'] : "View")."</span>");
                else _e(html_entity_decode($this->button['title'] ? $this->button['title'] : "View")); 
            ?></a>
        <?php 
        $this->setButtonElement( ob_get_contents() );
        ob_end_clean();
    }
    
    private function generateLink() {
        $this->removeClass('button');
        ob_start(); ?>
            <a<?php 
                if($this->button['url']) _e(" href='".$this->button['url']."'");
                if($this->button['target']) _e(" target='".$this->button['target']."'");
                if($this->id) _e(" id='".$this->id."'");
            ?> class="<?php _e($this->getClasses()); ?>" <?php
                if($this->data) _e( $this->getData() );
            ?>><?php 
                if($this->icon) _e($this->icon."<span>".$this->button['title']."</span>");
                else _e($this->button['title']); 
            ?></a>
        <?php 
        $this->setButtonElement( ob_get_contents() );
        ob_end_clean();
    }
    
    public function getURL(){
        if( isset($this->button['url']) ? $this->button['url'] : false ){
            return $this->button['url'];
        } else return '';
    }
    
    public function getTitle(){
        if( isset($this->button['title']) ? $this->button['title'] : false ){
            return $this->button['title'];
        } else return '';
    }
    
    public function getTarget(){
        if( isset($this->button['target']) ? $this->button['target'] : false ){
            return $this->button['target'];
        } else return '';
    }

    public function getDataOpen(){
        if( isset($this->button['data_open']) ? $this->button['data_open'] : false ){
            return $this->button['data_open'];
        } else return '';
    }


}

endif;