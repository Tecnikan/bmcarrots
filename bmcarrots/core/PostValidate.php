<?php
abstract class PostValidate {
    private static $fields_types = array('email','pass','phone','rfc','curp');
    private static $message = '';
    protected static $errno = 0;    
    protected static $valid = false;
    
    private static function expectedFields($fields){
        $post = array_keys($_POST);
        $keys = array_keys($fields);
        $valid = true;
        foreach ($keys as $key){
            if(!in_array($key,$post)){
                $valid = false;
                self::$errno++;
                self::$message = "Error en la validación de los campos. Por favor verifique los datos.";
                break;
            }                    
        }
        return $valid;      
    }
    
    private static function filterEmail($value, $name, $required){
        $email = $value;
        if($required == TRUE){
            if(strlen($value) <= 0){
                self::$message.="El campo ".$name." es obligatorio y no debe estar vac&iacute;o.<br />";
                self::$errno++;
            }else{
                $value=filter_var($value,FILTER_VALIDATE_EMAIL);
                if($value == false){
                    self::$message.="El campo ".$name." no es una dirección v&aacute;lida. Intente de nuevo<br />";
                    self::$errno++;
                    return $email;
                }else{
                    return $value;
                }
            }
        }elseif(!empty ($value) && strlen($value) > 0){
            $value=filter_var($value,FILTER_VALIDATE_EMAIL);
            if($value == false){
                self::$message.="El campo ".$name." no es una dirección v&aacute;lida. Intente de nuevo<br />";
                self::$errno++;
                return $email;
            }else{
                return $value;
            }
        }
    }
    
    private static function filterPhone($value, $name, $required){
        $chars = 10;
        if($required == TRUE){
            if (strlen($value) <= 0){
                self::$message.="El campo ".$name." es obligatorio y no debe estar vac&iacute;o.<br />";
                self::$errno++;
            }elseif (strlen($value) != $chars || !is_numeric($value)) {
                self::$message.="El campo ".$name." no es un valor válido. Debe ser valor númerico de 10 caracteres<br />";
                self::$errno++;
            }
        }elseif(!empty ($value) && strlen($value) > 0){
            if (strlen($value) != $chars || !is_numeric($value)) {
                self::$message.="El campo ".$name." no es un valor válido. Debe ser valor númerico de 10 caracteres<br />";
                self::$errno++;
            }
        }
        return $value;
    }
    
    
    private static function filterPass($value, $name, $required){
        $min_chars = 6;
        $max_chars = 16;
        if(strlen($value) <= 0){
            self::$message.="El campo ".$name." es obligatorio y no debe estar vac&iacute;o.<br />";
            self::$errno++;
        }elseif(strlen($value) >= $min_chars && strlen($value) <= $max_chars){
            $value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);          
        }
        else{
            self::$message.="El campo ".$name." no es válido. Debe ser unvalor entre ".$min_chars." y ".$max_chars." caracteres. Intente de nuevo.<br />";
            self::$errno++;
        }
        return $value;
    }
    
    private static function filterString($value, $name, $required){
        if($required === TRUE){
            if(!empty($value) && strlen($value) > 0){
                $value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            else{
                self::$message.="El campo ".$name." es obligatorio y no debe estar vac&iacute;o.<br />";
                self::$errno++;
            }
        }else{
            $value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $value;
    }
    
    private static function startValidation($fields){       
        foreach($_POST as $key=>$value) {
            $special = false;
            $type = '';
            $value = trim($value);
            foreach (self::$fields_types as $field){
                if(strpos($key,$field)!== FALSE){
                    $special = true;
                    $type = $field;
                    break;
                }
            }
            if($special){
                $function = "filter".ucwords($type);           
                $_POST[$key] = self::$function($value, $fields[$key]['name'], $fields[$key]['required']);
            }            
            else{
                $_POST[$key] = self::filterString($value, $fields[$key]['name'], $fields[$key]['required']);
            }
        }
        if(self::$errno)
            return true;
        else           
            return false;    
    }
    public static function validation($FIELDS){
        $fields = unserialize($FIELDS);
        self::$valid = self::expectedFields($fields);
        SessionHelper::setMessage(self::$message);
        return self::$valid;
    }  
}
?>
