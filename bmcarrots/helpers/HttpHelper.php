<?php
/**
 * Clase de ayuda para el core de la aplicación, realiza operaciones sobre peticiones http, post, ajax, get, etc.
 * @package helpers
 * @author Leonardo López <leonard_156@hotmail.com>
 */
class HttpHelper {
    
    /**
     * Obtiene la url escrita en el navegador web .
     * @return string Devuelve una cadena con la URL solicitada por el usuario en el navegador(/dir/web/modulo/modelo/recurso/argumento).
     * @access public static
    */
    public static function getUri(){
        if(isset($_SERVER['REQUEST_URI']))
            return $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Dirección de la pagina (si la hay) que emplea el agente de usuario para la pagina actual.
     * @return string Devuelve una cadena con la URL (/dir/web/modulo/modelo/recurso/argumento).
     * @access public static
    */
    public static function getReferer(){
        if(isset($_SERVER['HTTP_REFERER']))
            return $_SERVER['HTTP_REFERER'];
    }
    
    /**
     * Identifica que tipo de peticion se ejecuta.
     * @param string $request_type Recibe como parametro el tipo de petición a validar. Puede ser post, get, ajax, etc.
     * @return bool Devuelve True en caso de coincidir el valor pasado como parametro con el tipo de petición HTTP ejecutada, En caso contrario False.
     * @access public static
    */
    public static function requestIs($request_type){
        $valid = false;
        $request_type = trim(strtolower($request_type));
        switch ($request_type){
            case 'ajax':
                $valid = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ? true : false;
            break;
            case 'get':
                $method = strtolower($_SERVER['REQUEST_METHOD']);
                $valid  = $method == $request_type ? true : false;
            break;
            case 'post':
                $method = strtolower($_SERVER['REQUEST_METHOD']);
                $valid  = $method == $request_type ? true : false;
            break;
        }
        return $valid;
    }
    
    /**
     * Manda error personalizado 404 NOT FOUND
     * @return string Imprime página personalizada 404.
     * @access public static
    */
    public static function notFound(){
        header("HTTP/1.0 404 Not Found");
        include(WEB_ROOT.'404.html');
        exit;
    }
    
    /**
     * Redicciona la pagina a otro lugar dentro o fuera de la aplicación
     * @param string $path Dirección a donde se debe redireccionar.
     * @return string Imprime página personalizada 404.
     * @access public static
    */
    public static function redirect($path){
        header("Location:".$path);
        exit;
    }
}
?>