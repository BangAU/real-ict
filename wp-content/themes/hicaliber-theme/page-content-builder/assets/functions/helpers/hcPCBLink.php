<?php
if (! class_exists ( 'hcPCBLink' )):
class hcPCBLink {
    
    // ERROR CATCH MESSAGES
    private $INVALID_LINK = "Invalid Link";
    public $REGEX = "/^(?:(https?):)?(\/{0,3})([0-9.\-A-Za-z]+)(?::(\d+))?(?:\/([^?#]*))?(?:\?([^#]*))?(?:#(.*))?$/";
    
    private $link = "";
    public $url ="";
    public $protocol ="";
    public $host ="";
    public $path="";
    public $parameters="";
    public $anchor="";

    public function __construct($url = ""){
        $this->link = "";
        $this->protocol = "";
        $this->host = "";
        $this->path = "";
        $this->parameters = "";
        $this->anchor = "";
        $this->url = "";
        
        if($url){
            
            $this->url = $url;
            
            if($this->isValid($url)){
                if(isset($this->link[1])) $this->protocol = $this->link[1];
                if(isset($this->link[3])) $this->host = $this->link[3];
                if(isset($this->link[5])) $this->path = $this->link[5];
                if(isset($this->link[6])) $this->parameters = $this->link[6];
                if(isset($this->link[7])) $this->anchor = $this->link[7];
            }
        }
    }
    
    public function isValid($url = ""){
        $validity = false;
        if(!$url) $url = $this->url;
        try{
                if($url){
                preg_match($this->REGEX, $url, $matches);
                if(count($matches) > 0) {
                    $this->link = $matches;
                    $validity = true;
                } else throw new Exception($this->INVALID_LINK);
            } else throw new Exception($this->INVALID_LINK);
        } catch (Exception $e){
            echo $e;
            $validity = false;
        } finally {
            return $validity;
        }
    }
    
    public function getObject(){
        return [
            'url' => $this->url,
            'protocol' => $this->protocol,
            'host' => $this->host,
            'path' => $this->path,
            'parameters' => $this->parameters,
            'anchor' => $this->anchor,
            ];
    }
}

endif;