<?php
/**
  * Contralador (Super clase), todos los controladores de la aplicacion heredan sus metodos y propiedades
  *
  * @package abstract
  * @author Leonardo López <leonard_156@hotmail.com>
 */
class AppController {
    
   /**
    * Contiene la instancia del MODELO a usar por el controlador en ejecución.
    * @var Object
    * @access protected
   */
    protected $model;
    
    /**
     * Contiene la instancia de la VISTA LÓGICA a usar por el controlador en ejecución.
     * @var Object
     * @access protected
    */
    protected $view;
    
    /**
     * Sin uso 
     * @var int
     * @access protected
    */
    protected $errno;
    
    /**
     * Contiene la URI de la última pagina visitada (NO MEDIANTE AJAX).
     * @var string
     * @access protected
    */
    protected $last_page;
    
    
    /**
     * Setea el modelo y vista a usar por el controlador y ejecuta el metodo que fue solicitado por URI.
     * @param string $resource Nombre del recurso (método) del controlador solicitado por la URI
     * @param string $args Parametro que espera recibir el metodo solocitado por la URI
     * @access public
    */
    public function __construct($resource = '', $arg = '') {
        $this->model = MVCHelper::getModel($this);
        $this->view = MVCHelper::getView($this);
        $this->errno = 0;
        if(method_exists($this, $resource)) {
            $this->_setLastPage();            
            call_user_func(array($this, $resource), $arg);
        } else {
            $this->errno = 1;
            HTTPHelper::notFound();
        }
    }
    
    /**
     * Setea el modelo y vista a usar por el controlador y ejecuta el metodo del que fue solicitado por URI.
     * 
     * @param mixed $value Puede ser una cadena o un array unidimensional con valores numericos o cadenas
     * @return mixed Devuleve la cadena o array pasados por parametros, con sus valores sanitizados
     * @access protected
    */
    protected function _filterGet($value){
        if(is_array($value)){
            foreach ($value as $key => $val) {
                $val = trim($val);
                $value[$key] = htmlentities($val);
            }
        }
        else{            
            $value = htmlentities($value);
        }
        return $value;
    }
    
    /**
     * Guarda la ultima pagina visitada (NO AJAX) en $this->last_page.
     * @return void
     * @access private
    */    
    private function _setLastPage(){        
        if(!HttpHelper::requestIs('ajax')){
            $url = HttpHelper::getReferer();
            $this->last_page = $url;
        }
    }
    
    /**
     * Genera el diccionario con nombres y valores de los campos de un formulario especifico.
     * @param mixed $FIELDS Es un array definido en los archivos dictionary de cada modulo.
     * @return mixed Devuelve un diccionario con los marcadores listo para sustituis en las vistas.
     * @access protected
    */  
    protected function _getFieldsValues($FIELDS){
        $fields = array_keys(unserialize($FIELDS));
        $post_values = SessionHelper::sessionExists('POST') ? array_values(SessionHelper::sessionRead('POST')) : null;
        $ind = 0;
        foreach ($fields as $key=>$val){
           $fields['{'.strtoupper($val).'}']  = SessionHelper::sessionExists('POST') ? $post_values[$ind]: '';
           $ind++;
           unset($fields[$key]);
        }
        SessionHelper::sessionDelete('POST');
        $this->_deleteId();
        return $fields;
    }
    
    /**
     * Elimina el ID del modelo, guardado al momento de ejecutar el metodo edit ($this->edit) del controlador.
     * @return void
     * @access private
    */ 
    private function _deleteId(){
        $class_name = get_class($this->model);
        $id_name = MVCHelper::getIdName($class_name);
        SessionHelper::sessionDelete($id_name);
    }

    /**
     * Sube un archivo al servidor.
     * @param string $file Nombre temporal del archivo
     * @param string $name Nombre que tendrá el archivo en el servidor
     * @param string $PATH Ruta donde se guardará el archivo
     * @return bool Devuelve True si el archivo se subió al servidor, False en caso contrario.
     * @access protected
    */
    protected function _uploadFile($file, $name,$PATH){
         $PATH .= $name;
         if (copy($file['tmp_name'],$PATH)) {                
             return true;
         }else {
             return false;
         }
     }
     
    /**
     * Genera y devuelve un password aleatorio usando el valor de la CONSTANTE HASH definido en settings.php
     * @return mixed Devuelve un array asociativo: pass => password texto plano, pass_enc => encriptada.
     * @access protected
    */
     protected function _generatePassword(){
         $pass = time();
         $pass_enc = md5($pass.HASH);
         return array('pass' => $pass, 'pass_enc' => $pass_enc);
     }
     
    /**
     * Genera una coleccion de objetos de un modelo.
     * @param string $class_name Nombre del modelo del cual se desea obtener una colección
     * @return mixed Devuelve un array con una coleccion de objetos del tipo $class_name.
     * @access protected
    */
    protected function _getObjectCollection($class_name){
         $Object = new $class_name();
         $collection = $Object->_listed();
         unset($Object);
         return $collection;
    }
    
    /**
     * Crear instancia de un modelo.
     * @param string $class_name Nombre del modelo del cual se desea crear una instancia.
     * @param int $id_value Si se pasa este segundo parametro, se hace la asignacion de esta valor a la propidad ID de la instancia.
     * @return Object Devuelve una instancia del modelo $class_name
     * @access protected
    */
    protected function _getEmptyObject($class_name, $id_value=null){
        $Object = new $class_name();         
        if($id_value != NULL){
            $id_name = MVCHelper::getIdName($class_name);
            $Object->$id_name = $id_value;
        }
        return $Object;
    }
}
?>