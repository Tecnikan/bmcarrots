<?php
/**
 * Modelo (Super clase), todos los modelos de la aplicacion heredan sus metodos y propiedades
 *
 * @package abstract
 * @author Leonardo López <leonard_156@hotmail.com>
 */
class AppModel {
    
    /**
     * Fecha de creación
     * @var string
     * @access public
    */
    public $created;
    
    /**
     * Fecha de modificación
     * @var string
     * @access public
    */
    public $modified;
    
    /**
     * Inicializa las propiedades modified y created, con la fecha actual.
     * @access public
    */
    function __construct(){
        $this->created = date('Y-m-d H:i:s');
        $this->modified = date('Y-m-d H:i:s');
    }
    
    /**
     * Compruena la existencia de un registro en la base de datos.
     * @return bool Devuelve True si el registro en la base de datos existe, False en caso contrario
     * @access public
    */
    public function _exists(){
        $class_name = get_class($this);     
        $id_name = MVCHelper::getIdName($class_name);
        $id_value = $this->$id_name;
        $sql = "SELECT {$id_name} FROM {$class_name} WHERE {$id_name} = ?";
        $type = MVCHelper::getDataType($id_value);
        $data = array($type,"{$this->$id_name}");
        $fields = array('ID' => '');        
        DBModel::execute($sql, $data, $fields); 
        if(empty($fields['ID']))
            return false;
        else   
            return true;
    }
    
    /**
     * Lista todos los registros del modelo de la base de datos.
     * @return mixed Devuelve una array de instancias del modelo en ejecución
     * @access public
    */
    public function _listed(){
        return Collector::get($this);
    }
    
    /**
     * Elimina un registro de la base de datos.
     * @return void
     * @access public
    */
    public function _destroy(){
        $class_name = get_class($this);
        $id_name = MVCHelper::getIdName($class_name);
        $type = MVCHelper::getDataType($this->$id_name);
        $sql = "DELETE FROM " .$class_name . " WHERE ". $id_name . " = ? ";
        $data = array("{$type}", "{$this->$id_name}");
        DBModel::execute($sql, $data);
    }
}
?>