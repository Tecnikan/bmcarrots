<?php
/**
 * Clase de ayuda para el core de la aplicacion, convierte nombres para el motor mvc
 * @package helpers
 * @author Leonardo López <leonardo_156@hotmail.com>
 * @license    http://www.gnu.org/licenses/gpl.txt  GNU GPL 3.0
 * @author     Eugenia Bahit <ebahit@member.fsf.org>
 * @link       http://www.europio.org
 */
class MVCHelper {
    
    /**
     * Convierte el nombre del modelo pasado por la URL en un nombre del tipo especificado en su primero parametro.
     * @param string $type Que tipo de "nombre" se requiere.
     * @param string $uristr Cadena que contine los datos a convertir, provienente de la url
     * @return string Devuelve una cadena con el nombre correcto, de acuerdo el tipo solicitado en $type.
     * @access public static
    */
    public static function setName($type='model', $uristr='') {
        switch($type) {
            case 'model':
                $str = self::convertUriToModelName($uristr);
                break;
            case 'controller':
                $str = self::convertUriToControllerName($uristr);
                break;
            case 'resource':
                $str = self::convertUriToResourceName($uristr);
                break;
            case 'file':
                $str = self::convertUriToFileName($uristr);
                break;
            default:
                $str = '';
        }
        return $str;
    }
    
    /**
     * Obtiene el nombre de la propiedad ID de un modelos, a partir del nombre del modelo.
     * @param string $class_name Nombre del modelo (clase).
     * @return string Devuelve una cadena con el nombre de la propiedad ID del modelo.
     * @access public static
    */
    public static function getIdName($class_name){
        $id_name = preg_replace('/([a-z])?([A-Z])/','$1 $2',$class_name);
        $id_name = trim(strtolower($id_name));
        $id_name = str_replace(' ','_',$id_name);
        $id_name.='_id';
        return $id_name;
    }
    
    /**
     * Obtiene el typo de dato de una variable.
     * @param mixed $var Variable a obtener su tipo de dato.
     * @return string Devuelve una cadena con una inicial que indetifica su tipo de dato: ej. strign > s, integet > i.
     * @access public static
    */
    public static function getDataType($var){
        $type = gettype($var);
        $data_type = 'i';
        switch ($type) {           
            case 'boolean':
               $data_type = "i";
            break;
            case 'integer':
               $data_type = "i";
            break;
            case 'double':
                $data_type = "d";
            break;
            case 'string':
               $data_type = "s";
            break;            
            default:
                $data_type = "i";
            break;
        }
        return $data_type;
    }   
    
    /**
     * Convierte el la cedena pasada en la url como nombre del modelo, a un nombre de modelo.(nombre de una clase)
     * @param string $model Nombre de modelo a convertir.
     * @return string Devuelve una cadena con el nombre del modelo.
     * @access private static
    */
    private static function convertUriToModelName($model='') {
        $str = ucwords(str_replace('-', ' ', $model));
        return str_replace(' ', '', $str);
    }
    
    /**
     * Convierte el la cedena pasada en la url como nombre del modelo, a un nombre de controlador.(nombre de una clase)
     * @param string $model Nombre de modelo a convertir.
     * @return string Devuelve una cadena con el nombre del Controlador.
     * @access private static
    */
    private static function convertUriToControllerName($model='') {
        $str = self::convertUriToModelName($model);
        return "{$str}Controller";
    }
    
    /**
     * Convierte el la cedena pasada en la url como nombre del recurso, a un nombre de recurso.(nombre de un metodo de una clase)
     * @param string $str Nombre del recurso a convertir.
     * @return string Devuelve una cadena con el nombre del Recurso.
     * @access private static
    */
    private static function convertUriToResourceName($str='') {
        $resource = ucwords(str_replace('-',' ',$str));
        $resource = str_replace(' ','',$resource);
        $resource = lcfirst($resource);
        return $resource;
    }
    
    /**
     * Convierte el la cedena pasada por parametro a un nombre de archivo .php
     * @param string $str Nombre del archivo a convertir.
     * @return string Devuelve una cadena con el nombre de archivo .php
     * @access private static
    */
    private static function convertUriToFileName($str='') {
        $str = ucwords(str_replace('-', ' ', $str));
        return str_replace(' ', '', $str);
    }
    
    /**
     * Crea una instancia del modelo solictado en la URL 
     * @param Objetc $obj Instancia de una clase Controlador (del contralador correspondiente al modelo solicitado por url).
     * @return Objetc Devuelve una instancia del modelo correspondiente al controlador pasado por parametro.
     * @access public static
    */
    public static function getModel($obj=NULL) {
        $model = str_replace('Controller', '', get_class($obj));
        return new $model();
    }
    
    /**
     * Crea una instancia de la vista logica correspondiente al modelo solictado en la URL 
     * @param Objetc $obj Instancia de una clase Controlador (del contralador correspondiente al modelo solicitado por url).
     * @return Objetc Devuelve una instancia de la vista logica controlador pasado por parametro.
     * @access public static
    */
    public static function getView($obj=NULL) {
        $view = str_replace('Controller', 'View', get_class($obj));
        return new $view();
    }
}
?>