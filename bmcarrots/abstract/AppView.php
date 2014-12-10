<?php
/**
 * Vista lógica (Super clase), todos los modelos de la aplicacion heredan sus metodos y propiedades
 *
 * @package abstract
 * @author Leonardo López <leonard_156@hotmail.com>
 */

import('helpers.Dict');
class AppView {
    
    /**
     * Obtiene el archivo .html para tratarlo como cadena de texto.
     * @param string $name Nombre del archivo html (index.html carpeta/index.html)
     * @return string Devuelve el archivo como una cadena de texto
     * @access protected
    */
    protected function _getView($name){
        $file = WEB_ROOT.$name;
        if(file_exists($file)){
            $view = file_get_contents($file);
            return $view;
        }
        else{
            exit("El archivo solicitado no esta disponible.");
        }
    }
    
    /**
     * Transforma una coleccion de objectos simple(sin compositores) en diccionario para sustitución dinamica.
     * @param mixed $collection Colección de objetos
     * @return mixed Devuelve un array con diccionarios [n]{CLAVE} => valor
     * @access protected
    */
    protected function _getNormalDicc($collection){
        foreach ($collection as $key=>$object){
            settype($object, 'array');
            foreach ($object as $ind=>$val){
                $object['{'.strtoupper($ind).'}'] = $val;
                unset($object[$ind]);
            }
            array_push($collection, $object);
            unset($collection[$key]);
        }
        return $collection;
    }
    
    /**
     * Transforma un Objeto en un  diccionario para sustitución estatica.
     * @param Object $Object Instancia de un modelo
     * @return mixed Devuelve un diccionario {CLAVE} => valor
     * @access protected
    */
    protected function _getSimpleDicc($Object){
        settype($Object, 'array');
        foreach ($Object as $ind=>$value){
            $Object['{'.strtoupper($ind).'}'] = $value;
            unset($Object[$ind]);
        }
        return $Object;
    }
    
    /**
     * Realiza una sustitución estática.
     * @param mixed $data Array {CLAVE} = valor
     * @param string $view Texto html en el cual se realizará la sustitución
     * @return string Devuelve el html en texto, con los valores de $data
     * @access public
    */
    public function _staticReplace($data, $view){
        $str = str_replace(array_keys($data), array_values($data), $view);
        return $str;
    }
    
    /**
     * Realiza una sustitución dinámica.
     * @param mixed $data Array con diccionarios {CLAVE} = valor
     * @param string $pattern Nombre del IDENTIFICADOR para hacer el regex.
     * @param string $view Texto html en el cual se realizará la sustitución
     * @return string Devuelve el html en texto, con los valores de $data
     * @access public
    */
    public function _dynamicReplace($data, $pattern, $view){
        /*$mark = "<!--".strtoupper($pattern)."-->";        
        $pattern = $this->_getPattern($pattern);
        $matches = array();
        preg_match($pattern, $view, $matches);
        $match = $matches[0];     
        $code = str_replace($mark,'', $match);
        $rend = '';
        foreach($data as $item) {           
            $rend .= str_replace(array_keys($item),array_values($item), $code);
        }
        $str = str_replace($match, $rend, $view);        
        return $str;*/
        $mark = "<!--".strtoupper($pattern)."-->";        
        if(strpos($_SERVER['HTTP_USER_AGENT'],'Windows') === FALSE){
            $pattern = $this->_getPattern($pattern);
            $matches = array();
            preg_match($pattern, $view, $matches);
            $match = $matches[0];
        }
        else{
            $match = $this->_pregMatchWin($mark, $view);
        }       
        $code = str_replace($mark,'', $match);
        $rend = '';
        foreach($data as $item) {           
            $rend .= str_replace(array_keys($item),array_values($item), $code);
        }
        $str = str_replace($match, $rend, $view);        
        return $str;
    }
    
    /**
     * Funcion homologa a preg_match() en entornos Windows
     * @param string $pattern Nombre del IDENTIFICADOR para hacer el regex.
     * @param string $view Texto html en el cual se buscara la coincidencia
     * @return string Devuelve el trozo de código html que coincide con el $pattern
     * @access protected
    */
    protected function _pregMatchWin($pattern, $view){
        $pos1 = strpos($view, $pattern);
        $pos2 = strrpos($view, $pattern);
        $length = $pos2-$pos1;
        $match = substr($view,$pos1,$length);
        return $match.$pattern;
    }
    
     /**
      * Realiza una sustitución vacia.
      * @param string $msj Mensaje que se ha de mostrar en caso de sustitucion vacia.
      * @param string $pattern Nombre del IDENTIFICADOR para hacer el regex.
      * @param string $view Texto html en el cual se buscara la coincidencia
      * @return string Devuelve el html en texto, con los valores de $msj
      * @access public
     */
    public function _emptyReplace($msj, $pattern, $view){
        /*$mark = "<!--".strtoupper($pattern)."-->";          
        $pattern = $this->_getPattern($pattern);
        $matches = array();
        preg_match($pattern, $view, $matches);
        $match = $matches[0];        
        $str = str_replace($match, $msj, $view);
        return $str;*/
        $mark = "<!--".strtoupper($pattern)."-->";  
        if(strpos($_SERVER['HTTP_USER_AGENT'],'Windows') === FALSE){
            $pattern = $this->_getPattern($pattern);
            $matches = array();
            preg_match($pattern, $view, $matches);
            $match = $matches[0];
        }
        else{
            $match = $this->_pregMatchWin($mark, $view);
        }
        $str = str_replace($match, $msj, $view);
        return $str;
    }
    
    /**
     * Función para obtener el mensaje de retroalimentación para el usuario.
     * @return string Devuelve el mensaje de retroalimentación para el usuario.
     * @access protected
    */
    protected function _getMessage(){
        if(SessionHelper::sessionExists('message')){
            $msj = SessionHelper::read('message');
            SessionHelper::delete('message');
            return $msj;
        }
    }
    
    /**
     * Función para renderizar la GUI final para mostrar el usuario.
     * @param string $view Html resultado de todo tipo de sustituciones.
     * @param string $template Nombre del template html donde se sustituirá el contenido de $view
     * @return void Devuelve en pantalla la GUI html para el usuario.
     * @access public
    */
    public function _renderTemplate($view, $template = 'template.html'){
        $template = $this->_getView($template);
        $current_user = SessionHelper::sessionRead(AUTH_NAME);
        $dicc = array(
            "{CURRENT_USER}" =>  $current_user['name']." ".$current_user['last_name'],
            "{CONTENT}" => $view,
            "{WEB_DIR}" => WEB_DIR,
            "{MESSAGE}" => $this->_getMessage()
        );
        
        $GUI = $this->_staticReplace($dicc, $template);
        print($GUI);
    }

    /**
     * Función para renderizar GUI en peticiones AJAX.
     * @param string $view Html resultado de todo tipo de sustituciones.
     * @return string Devuelve en panalla el html resultado de la peticion ajax.
     * @access public
    */
    public function _printRender($view){
        $dicc = array(
            "{WEB_DIR}" => WEB_DIR
        );
        
        $GUI = $this->_staticReplace($dicc, $view);
        print($GUI);
    }
    
    /**
     * Función para generar el regex a utilizar en la funcion preg_match().
     * @param string $name Nombre del marcador.
     * @return string Devuelve el regex para buscar coincidencias en el archivo html.
     * @access protected
    */
    protected function _getPattern($name){
        $str = "/<!--$name-->(.|\n){1,}<!--$name-->/";
        return $str;
    }
}
?>