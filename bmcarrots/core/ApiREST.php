<?php

class ApiREST {

    public static function get($datosapi='', $module='', $model='', $resource='') {
        $model = MVCHelper::setName('model', $model);
        $resource = MVCHelper::setName('resource', $resource);
        self::check_resource($module, $model, $resource);
        header("Content-Type: text/json; charset=utf-8");
        print json_encode($datosapi);
    }
    
    private static function check_resource($module, $model, $resource) {
        self::check_module($module);
        $resources = self::check_model($module,$model);
        if(!in_array($resource, $resources)) HttpHelper::notFound();
    }
    
    private static function check_model($module='',$model='') {
        global $allowed_resources;
        
        $m = str_replace('-', '', $model);
        if(array_key_exists($m, $allowed_resources[$module])) {
            return $allowed_resources[$module][$m];
        } else {
            HttpHelper::notFound();
        }
    }
    
    private static function check_module($module='') {
        global $allowed_resources;
        $m = str_replace('-', '', $module);
        if(array_key_exists($m, $allowed_resources)) {
            return $allowed_resources[$m];
        } else {
            HttpHelper::notFound();
        }
    }
}
?>
