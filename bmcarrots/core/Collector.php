<?php
/**
 * Clase para crear colecciones de objetos de objetos
 * @package core
 * @author Leonardo López <leonard_156@hotmail.com>
 */
class Collector {
   
    /**
     * Contiene una instancia unica de esta clase.
     * @var Object
     * @access private static
    */
    private static $Collector;
    
    /**
     * Contiene la coleccion de objetos de un modelo.
     * @var mixed
     * @access private static
    */
    private static $collection;
    
    /**
     * Inicializa la propiedad $collection en un array vacio.
     * @access private static
    */
    private function __construct() {    
        self::$collection = array();
    }
    
    /**
     * Agrega un elemento a la propiedad $collection.
     * @param Object $Object Instancia de un modelo
     * @return void 
     * @access private static
    */
    private function addObject($Object) {
        self::$collection[] = $Object;
    }
    
    /**
     * Listar los registros de la base de datos correspodientes a un modelo.
     * @param Object $Object Instancia de un modelo a listar
     * @return mixed Devuelve una coleccion de objetos del modelo pasado en el parametro $Objetc 
     * @access public static
    */
    public static function get($Object) {
        if(empty(self::$Collector)) {
            self::$Collector = new Collector();
        }
        else{
            self::$collection = array();
        }
        $class_name = get_class($Object);
        $id_name = MVCHelper::getIdName($class_name);
        $sql = "SELECT ".$id_name." FROM ".$class_name." WHERE ".$id_name." > ?";
        $data = array("i", "0");
        $fields = array($id_name => "");
        
        DBModel::execute($sql, $data, $fields);
        foreach(DBModel::$results as $array) {
            self::$Collector->addObject(Factory::createObject($class_name, $array[$id_name]));
        }
        return self::$collection;
    }
    
    /**
     * Listar los registros de la base de datos correspodientes a un modelo, ejecutando una consulta SQL personalizada.
     * @param Object $Object Instancia de un modelo a listar,
     * @param string $sql Sentencia SQL personaliza con SENTENCIAS WHERE, ORDER, LIMIT, etc.
     * @param mixed $data Parametros a sustituir en la sentencia SQL ( valor en ligar de "?")
     * @param mixed $fields Array con los Alias de los campos de la tabla en base de datos.
     * @return mixed Devuelve una coleccion de objetos del modelo pasado en el parametro $Objetc 
     * @access public static
    */
    public static function customGet($Object, $sql, $data, $fields){
        if(empty(self::$Collector)) {
            self::$Collector = new Collector();
        }
        else{
            self::$collection = array();
        }
        $class_name = get_class($Object);
        $id_name = MVCHelper::getIdName($class_name);
        DBModel::execute($sql, $data, $fields);
        foreach(DBModel::$results as $array) {
            self::$Collector->addObject(Factory::createObject($class_name, $array[$id_name]));
        }
        return self::$collection;
    }
}
?>