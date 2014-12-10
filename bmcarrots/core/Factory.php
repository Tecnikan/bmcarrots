<?php

/**
 * Clase para fabricar un objetos de un modelo de manera dinamica
 * @package core
 * @author Leonardo Lopez <leonard_156@hotmail.com>
 */
class Factory {

    /**
     * Crea una instacia de un modelo y obtiene su informacion de la base de datos     * 
     * @param string $class_name Nombre del modelo del cual se creará una instancia
     * @param int $id_value Valor del ID del modelo a crear
     * @return Object Devuleve una instancia de un modelo con sus valores guardados en la base de datos.
     * @access public
    */
    public static function createObject($class_name, $id_value, $id_name='') {
        $id = ($id_name) ? $id_name : MVCHelper::getIdName($class_name);
        $object = new $class_name();
        $object->$id = $id_value;
        $object->get();
        return $object;
    }
    
    /**
     * Crea una coleccion de objetos pertenecientes a una instancia de otro modelo 
     * @param Object $Object Instancia del modelo compuesto
     * @param string $class_name Nombre de la clase peteneciente a $Object
     * @return void
     * @access public
    */
    public static function createObjectsCollection($Object,$class_name){
        $Obj = new $class_name($Object);
        $get_method = '_get'.$class_name;
        $add_method = '_add'.$class_name;
        //COLLECIÓN DE OBJETOS
        $datas = $Obj->$get_method();
        foreach ($datas as $data){
           $Object->$add_method(Factory::createObject(get_class($Obj), $data['ID']));
        }
    }
}
?>