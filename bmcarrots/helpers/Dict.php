<?php
/**
 * Clase abstracta para generar los diccionarios de datos, a partir de Objetos o colecciones de objetos (Experimental no concluida)
 * 
 * @package helpers
 * @author Leonardo López <leonard_156@hotmail.com>
 * @version v1.0beta
 */
class Dict {

    public $dict;
    public $collection;
    
    function __construct() {
         $this->dict = array();
         $this->collection = array();
    }
    
    public function processObject($Object){
        $this->setObjetc($Object);
    }
    
    public function proccessCollection($collection){
        foreach ($collection as $Object){
            $this->setCollection($Object);
            $this->collection[] = $this->dict;
            $this->dict = array();
        }
    }
    
    private function setObjetc($Object){
        $class_name = get_class($Object);
        settype($Object,'array');
        foreach ($Object as $ind=>$value){
            if(is_object($value)){
                $this->processObject($value);
            }elseif(!is_array($value)){
                $this->dict['{'.strtoupper($class_name).'.'.strtoupper($ind).'}'] = $value;
            }
        }
    }
    
    private function setCollection($Object){        
        $class_name = get_class($Object);
        settype($Object,'array');
        foreach ($Object as $ind=>$value){
            if(is_object($value)){
                $this->setObjetc($value);
            }elseif(!is_array($value)){
                $this->dict['{'.strtoupper($class_name).'.'.strtoupper($ind).'}'] = $value;
            }
        }
    }
}
function Dict($data,$action){    
    $Dict = new Dict();    
    if($action == 'coll'){
        $Dict->proccessCollection($data);
        return $Dict->collection;
    }elseif ($action == 'obj') {
        $Dict->processObject($data);
        return $Dict->dict;
    }else{
        return false;
    }    
}
?>