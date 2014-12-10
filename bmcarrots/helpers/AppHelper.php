<?php
import('helpers.HttpHelper');


/**
 * Procesa la URL solicitada y prepara el nombre del modulo, modelo, recurso y args, a ejecutar.
 *
 * @package helpers
 * @author Leonardo López <leonard_156@hotmail.com>
*/
class AppHelper {
    
   /**
     * Contiene la url solicitada en la barra de direcciones del navegador (/modulo/modelo/recurso/argumento).
     * @var string
     * @access private static
    */
    private static $uri = '';
    
    /**
     * Contiene un array con los elementos de la URL (explode por diagonal / (/modulo/modelo/recurso/argumento) ).
     * @var mixed
     * @access private static
    */
    private static $requests = array();
    
    /**
     * Nombre del modulo solicitad por url (/modulo/modelo/recurso/argumento).
     * @var string
     * @access private static
    */
    protected static $module = '';
    
    /**
     * Nombre del modelo solicitad por url (/modulo/modelo/recurso/argumento.
     * @var string
     * @access private static
    */
    protected static $model = '';
    
    /**
     * Nombre del recurso solicitad por url (/modulo/modelo/recurso/argumento).
     * @var string
     * @access private static
    */
    protected static $resource = '';
    
    /**
     * Valor pasado como parametro al recurso (/modulo/modelo/recurso/argumento).
     * @var string
     * @access private static
    */
    protected static $arg = '';
    
    /**
     * Valor pasado como solicitud APIRest al recurso (api/modulo/modelo/recurso/argumento).
     * @var boolean
     * @access private static
    */
    protected static $api = False;
    
    /**
     * Inicia el procesamiento de la url (/modulo/modelo/recurso/argumento).
     * @return mixed Devuelve un array con el nombre de modulo, modelo, recurso y argumento como elementos.
     * @access private static
    */
    static function handler() {
        self::setUristr();
        self::setArray();
        self::setRequests();
        self::check();
        return array(self::$module, self::$model, self::$resource, self::$arg, self::$api);
    }
    
    /**
     * Obtiene la url y deja los elementos correspondientes a modulo, modelo, recurso y argumento. Sustituye el WEB_DIR existente.
     * @return void
     * @access private static
    */
    private static function setUristr() {
        $uri_request = HttpHelper::getUri();
        if(WEB_DIR != "/") {
            self::$uri = str_replace(WEB_DIR, "", $uri_request);
        } else {
            self::$uri = substr($uri_request, 1);
        }
    }
    
    /**
     * Separa los elementos de la url (/modulo/modelo/recurso/argumento) por la diagonal.
     * @return mixed Devuelve un array con el nombre de modulo, modelo, recurso y argumento como elementos.
     * @access private static
    */
    private static function setArray() {
	self::$requests = explode("/", self::$uri);
        if(self::$requests[0] == 'api') {
            array_shift(self::$requests);
            self::$api = True;
        }
    }
    
    /**
     * Determina cuantos elementos tiene la url y guarda cada uno en las variables, $module, $model, $resource, $arg, respectivamente.
     * @return void.
     * @access private static
    */
    private static function setRequests() {
        if(count(self::$requests) == 3) {
            list(self::$module, self::$model, self::$resource) = self::$requests;
        }
        elseif(count(self::$requests) == 4) {
            list(self::$module, self::$model, self::$resource, self::$arg) = self::$requests;
        }
        elseif(count(self::$requests) > 4){
            list(self::$module, self::$model, self::$resource) = self::$requests;
            unset(self::$requests[0],self::$requests[1],self::$requests[2]);
            $args = implode('/', self::$requests);
            self::$arg = $args;
        }
    }
    
    /**
     * Comprueba si existen mínimo 3 elementos en la url y permite su ejecución. 
     * Si permite su ejecución, comprueba si el ACL esta habilitado y ejecuta el ACL. 
     * Sino hay ACl se ejecuta la peticion normal. 
     * Si no existen minimo 3 elementos en la URl, se redirecciona al DFAULT_VIEW definido en settings.php
     * @return void.
     * @access private static
    */
    private static function check() {
        $mu = empty(self::$module);
        $mo = empty(self::$model);
        $re = empty(self::$resource);
        
        if($mu || $mo || $re){
            HttpHelper::redirect(WEB_DIR.DEFAULT_VIEW);
        }
    }
}
?>
