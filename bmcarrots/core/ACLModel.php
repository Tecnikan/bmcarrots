<?php

abstract class ACLModel {
    
    private static $acl_id = 0 ;
    private static $user_type_id = 0;
    private static $module = '';
    private static $model = '';
    private static $src_model = '';
    private static $resource = '';
    private static $free_def = false;
    
    public static function addFunctions($module, $model, $user_type){
        self::$user_type_id = $user_type;
        self::$free_def = 0;
        self::$module = $module;
        self::$src_model = $model;
        self::$model = MVCHelper::setName('model',self::$src_model);
        import('modules.'.self::$module.'.controllers.'.self::$model);
        $methods = self::getMethods();        
        foreach ($methods as $key=>$method){
            self::setResourceName($method->name);
            self::save();
            echo self::$resource;
        }
        echo "DONE!";
        exit;
    }
    
    public static function checkAccess(){
        list(self::$module , self::$model, self::$resource, $arg, $api) = AppHelper::handler();
        if(!SessionHelper::sessionExists(AUTH_NAME)){
            self::checkFree();
            if(self::$acl_id == 0){
                HttpHelper::redirect(WEB_DIR.DEFAULT_VIEW_LOGIN);
            }
        }else{
            $user = SessionHelper::sessionRead(AUTH_NAME);
            self::$user_type_id = $user['usertype_id'];
            self::checkSql();           
            if(self::$acl_id == 0){  
                if(!HttpHelper::requestIs('ajax')){
                    $current_page = SessionHelper::sessionRead('current_page');
                    SessionHelper::setMessage("Su usuario no cuenta con los permisos suficientes para ejecutar esa acción");
                    if(empty($current_page))
                        HttpHelper::redirect (WEB_DIR.DEFAULT_VIEW);                       
                    else
                        HttpHelper::redirect(WEB_DIR.$current_page);
                }else {
                    die('<div class="alert alert-error col-md-14">Su usuario no cuenta con los permisos suficientes para ejecutar esa acción</div>');
                }
            }
        }                           
    }
    
    private static function getMethods(){
        $controller = MVCHelper::setName('controller',self::$src_model);
        $clase = new ReflectionClass($controller);
        $methods = $clase->getMethods(ReflectionMethod::IS_PUBLIC);
        array_pop($methods);
        return $methods;
    }

    private static function setResourceName($name){
        $tmp = preg_replace('/([a-z])?([A-Z])/','$1 $2',$name);
        $tmp = trim(strtolower($tmp));
        self::$resource = str_replace(' ','-',$tmp);
    }

    private static function save(){
        $sql = "INSERT INTO acl (user_type_id, module, model, resource, free_def)
            VALUES (?,'".self::$module."','".self::$src_model."','".self::$resource."',".self::$free_def.")";
        $type = self::$user_type_id;
        $data = array(
            "i","{$type}"
        );
        DBModel::execute($sql, $data);
    }

    private static function checkSql(){
        $sql = "SELECT acl_id,free_def FROM acl WHERE user_type_id = ? AND module = '".self::$module."' AND model = '".self::$model."'
            AND resource = '".self::$resource."'";
        $type = self::$user_type_id;
        $data = array("i","{$type}");
        $fields = array(
            'ACL_ID' => '',
            'FREE_DEF' => ''
        );
        
        DBModel::execute($sql, $data, $fields);
        
        self::$acl_id = $fields['ACL_ID'];
        self::$free_def = $fields['FREE_DEF'];
    }
    
    private static function checkFree(){
        $sql = "SELECT acl_id, free_def FROM acl
            WHERE user_type_id IS NULL AND free_def = ? AND module = '".self::$module."' AND model = '".self::$model."'
            AND resource = '".self::$resource."'";
        $data = array("i",1);
        $fields = array(
            'ACL_ID' => '', 
            'FREE_DEF' => ''
        );
        DBModel::execute($sql, $data, $fields);
        self::$acl_id = $fields['ACL_ID'];
        self::$free_def = $fields['FREE_DEF']; 
    }
}
?>