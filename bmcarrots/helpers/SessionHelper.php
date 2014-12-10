<?php

/**
 * Clase de ayuda para el core de la aplicación, manejo de las variable de sesión
 * @package helpers
 * @author Leonardo López <leonard_156@hotmail.com>
 */
class SessionHelper {
    
    /**
     * Comprueba si una variable de sesión existe.
     * @param string $name Nombre de la variable de sesión a comprobar.
     * @return boolean Devuelve True si la sesión existe. False en caso contrario.
    */
    public static function sessionExists($name){
        if(isset($_SESSION[$name]) && !empty($_SESSION[$name]))
            return true;
        else {            
            return false;        
        }
    }
    
    /**
     * Crea una varabiable de sesión
     * @param string $name Nombre de la nueva variable de sesión.
     * @param mexed $value Valor que guardara la variable de sesión.
     * @return void
    */
    public static function sessionWrite($name, $value){
        $_SESSION[$name] = $value;
    }
    
    /**
     * Verifica que existe una variable de sesión y devuelve su valor.
     * @param string $name Nombre de la sesión a leer.
     * @return Devuelve el valor de la sesión si la variable de sesion existe. NULL en caso contrario.
    */
    public static function sessionRead($name){
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        }
        else{
            return NULL;
        }
    }
    
    /**
     * Borra una variable de sesión
     * @param string $name Nombre de la variable de sesión a borrar
    */
    public static function sessionDelete($name){
        if(self::sessionExists($name))
            unset ($_SESSION[$name]);
    }
    
    /**
     * Guarda un mensaje de retroalimentación para el usuario.
     * @param string $msj Frase o mensaje, que es retroalimentación para el usuario.
     * @param boolean $type Si se pasa como TRUE, creara un elemeto html de aprobacion (o accion correcta). Si es FALSE, crea un elemento html de error (o advertencia, color rojo)
     */
    public static function setMessage($msj, $type = FALSE){
        if($type){
            $msj = '<div class="alert alert-success col-md-14">'.$msj.'</div>
            <script type="text/javascript">
                $(document).ready(function(e){
                    setTimeout(function(){
                        $(".alert-success").slideUp(200);
                        },4500
                    );
                });
            </script>';
        }else{
            $msj = '<div class="alert alert-warning col-md-14">'.$msj.'</div>
            <script type="text/javascript">
                $(document).ready(function(e){
                    setTimeout(function(){
                        $(".alert-warning").slideUp(200);
                        },4500
                    );
                });
            </script>';
        }
        self::sessionWrite('message', $msj);
    }
    
    /**
     * Elimina todas las variables de sesion
     * @return void 
    */
    public static function sessionDestroy(){
        session_destroy();
    }
}
?>