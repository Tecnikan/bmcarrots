<?php
/**
* Constantes de configuración personalizada.
*
* Este archivo debe renombrarse a settings.php (o ser copiado como tal)
* Al renombrarlo/copiarlo, modificar el valor de todas las constantes.
*
* @package    bmcarrots
* @license    http://www.gnu.org/licenses/gpl.txt  GNU GPL 3.0
* @author     Eugenia Bahit <ebahit@member.fsf.org>
* @link       http://www.europio.org
*/

    /**
     * HABILITAR EL USO DE SESSIONES
     */
    date_default_timezone_set('America/Mexico_City');
    session_start();
    /**
     * ESTADO DE DEPLOY
     * @var Boolean CONSTANTE
     *  
     */
    const PRODUCTION = FALSE;  # True cuando esté en producción
    
    /**
     * ACTIVAR LA LISTA DE CONTROL DE ACCESO
     * @var Boolean CONSTANTE
     *  
     */
    const ACL = FALSE;  # True cuando esté en producción
    
    /**
     * NOMBRE DE SERVIDOR DE BASE DE DATOS
     * @var string CONSTANTE 
     *  
     */
    const DB_HOST = "localhost";
    /**
     * NOMBRE DE USUARIO PARA SERVIDOR DE BASE DE DATOS
     * @var string CONSTANTE 
     *  
     */
    const DB_USER = "root";
     /**
     * CONTRASEÑA DE USUARIO PARA SERVIDOR DE BASE DE DATOS
     * @var string CONSTANTE 
     *  
     */
    #const DB_PASS = "jJs2XFuX";
    const DB_PASS = "";
    
     /**
     * NOMBRE DE BASE DE DATOS
     * @var string CONSTANTE 
     *  
     */
    const DB_NAME = "souvenirs";
    define('APP_DIR',"C:\wamp\www\bmcarrots\\");
    define('WEB_ROOT',"C:\wamp\www\bmcarrots\public_html\\");
        
    
    # Directorio Web (ruta después del dominio. / para directorio raíz)
    define('WEB_DIR',"/bmcarrots/");
 
    
    
    # Ruta de la vista por defecto (despues del dominio)
    const DEFAULT_VIEW = "galleries/gallery/index";
    const DEFAULT_VIEW_LOGIN = "users/user/login";
    
    # Configuraciones para las sesiones
    const SESSION_LIFE_TIME = 1800;  # milisegundos 
    
    #Configuracion para el nombre de session del login (si lo hay)
    const AUTH_NAME = 'Auth_User';
    
    #Activa validacion de contraseñas seguras
    const SAFEPASS = FALSE;
    const HASH = "4e4e53aa080247bc31d0eb4e7aeb07a0";
    
    const TAX_IVA = 0.16;
    
    #Constantes capa de seguridad
    define('SECURITY_LAYER_ENGINE','On');
    
    define('SECURITY_LAYER_STRICT_MODE',False);
    
    define('SECURITY_LAYER_SANITIZE_ARRAY',False);
    
    define('SECURITY_LAYER_ENCRYPT_PASSWORD',True);
    
    define('SECURITY_LAYER_ENCRYPT_PASSWORD_HASH',"sha256");
    
    define('SECURITY_LAYER_UPPERCASE_MODE','On');
    
    /*FUNCIONES LIBRES ACL*/
    define('FREE_ACL_FUNCTION',  serialize(array(
        'users' => array(
            'user' => array(
                'login',
                'signIn'
            )
        )
    )));

    
    # Configuración de directivas de php.ini
    ini_set('include_path', APP_DIR);
   
    if(!PRODUCTION) {
        ini_set('error_reporting', E_ALL | E_NOTICE | E_STRICT);
        ini_set('display_errors', '1');
        ini_set('track_errors', 'On');
    } else {
        ini_set('display_errors', '0');
    }

    # Importación rápida
    function import($str='') {
        $file = str_replace('.', '/', $str);
		
        if(!file_exists(APP_DIR . "$file.php")) 
            exit("FATAL ERROR: No module named $str");        
        require_once "$file.php";
    }
    
    #FUNCION DEBUG
    function pr($mix_value){
        echo '<pre>';
        print_r($mix_value);
        echo '</pre>';
    }
?>
