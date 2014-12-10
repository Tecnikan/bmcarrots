<?php
import('helpers.SessionHelper');
import('helpers.AppHelper');
import('helpers.MVCHelper');
import('core.ApiREST');
/**
 * Clase que inicia la ejecución de la aplicación
 * @license    http://www.gnu.org/licenses/gpl.txt  GNU GPL 3.0
 * @author     Eugenia Bahit <ebahit@member.fsf.org>
 * @link       http://www.europio.org
 * @package core
 */
class FrontController {
    
    /**
     * Inicia la ejecucion de la aplicacion y procesa la peticion que se hace desde la URI
     *
     * @return void
     * @access protected
    */
    
    public static function initApp(){
        //Obtiene los elementos de la URI
        list($module, $model, $resource, $arg, $api) = AppHelper::handler();
        
        self::verifyAccess();
        
        $cfile = MVCHelper::setName('file', $model);
        $_cfile = MVCHelper::setName('resource', $model);
        $controller_name = MVCHelper::setName('controller', $model);
        $resource_name = MVCHelper::setName('resource', $resource);
        $file = APP_DIR . "modules/$module/controllers/$cfile.php";        
        $_file = APP_DIR . "modules/$module/controllers/$_cfile.php";
        if(file_exists($file) || file_exists($_file)) {
            $file = file_exists($file) ? $file : $_file;            
            require_once "$file";            
            $controller = new $controller_name($resource_name, $arg,$api);
	    if($api){
	   	ApiREST::get($controller->data, $module, $model, $resource);
	    }
        } 
        else {
            HttpHelper::notFound();
        }        
    }
    
    /**
     * Comprueba el acceso al sistema por cada tipo de usuario.
     *
     * @return void
     * @access private
    */
    private static function verifyAccess(){              
        if(ACL == TRUE){
            import('core.ACLModel');                                        
            ACLModel::checkAccess();
        }
    }
}
?>
