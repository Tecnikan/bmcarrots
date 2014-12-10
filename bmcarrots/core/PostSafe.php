<?php
/**
 * Capa de seguridad para sanitizar los datos enviador por $_POST
 * @package core
 * @abstract
 * @license    http://www.gnu.org/licenses/gpl.txt  GNU GPL 3.0
 * @author     Eugenia Bahit <ebahit@member.fsf.org>
 */
class PostSafe {

    public function __construct($strict=False) {
        $this->strict = $strict;
    }

    public function cleanPostData() {
        foreach($_POST as $key=>$value) {            
            $array = (is_array($value));
            if($array) $this->sanitizeArray($key);
            if($this->strict && !$array) $this->removeAndConvert($key);
            if(strpos($key, 'mail') !== False) $this->purgeEmail($key);
            $mocknum = str_replace(',', '', $value);
            if(is_numeric($mocknum) && (strlen($mocknum)) < 11
                ) $this->sanitizeNumber($key);
            if(!$array) $this->encodeString($key);
        }
    }

    public function removeAndConvert($key='') {
        $_POST[$key] = htmlentities(strip_tags($_POST[$key]));
        if(defined('SECURITY_LAYER_UPPERCASE_MODE')) {
            if(ucwords(SECURITY_LAYER_UPPERCASE_MODE) == 'On') {
                $_POST[$key] = strtr(strtoupper($_POST[$key]),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
            }
        }
    }

    public function encodeString($key='') {
        if(!self::isPassword($key)) {
            $options = array('flags'=>FILTER_FLAG_ENCODE_LOW);
            $_POST[$key] = filter_var($_POST[$key],FILTER_SANITIZE_SPECIAL_CHARS, $options);
            if(defined('SECURITY_LAYER_UPPERCASE_MODE')) {
                if(ucwords(SECURITY_LAYER_UPPERCASE_MODE) == 'On') {                   
                    $_POST[$key] = strtr(strtoupper($_POST[$key]),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
                    
                }
            }
        } else {
            self::hashingPassword($key);
        }
    }

    private static function isPassword($key='') {
        $password_names = array('pass', 'clave', 'contrasenia');
        foreach($password_names as $name) {
            if(strpos($key, $name) !== False) return True;
        }
    }

    private static function hashingPassword($key='') {
        if(SECURITY_LAYER_ENCRYPT_PASSWORD) {
            $hash = SECURITY_LAYER_ENCRYPT_PASSWORD_HASH;
            $_POST[$key] = hash($hash, $_POST[$key]);
        }
    }

    public function purgeEmail($key='') {
        $_POST[$key] = filter_var($_POST[$key], FILTER_SANITIZE_EMAIL);
        if(defined('SECURITY_LAYER_UPPERCASE_MODE')) {
            if(ucwords(SECURITY_LAYER_UPPERCASE_MODE) == 'On') {
                $_POST[$key] = strtr(strtoupper($_POST[$key]),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
            }
        }
    }

    public function sanitizeNumber($key='') {
        $pos_colon = strpos($_POST[$key], ',');
        $pos_dot = strpos($_POST[$key], '.');
        $has_colon = ($pos_colon !== False);
        $has_dot = ($pos_dot !== False);
        $filterid = FILTER_VALIDATE_FLOAT;

        if($has_colon && $has_dot) {
            if($pos_colon > $pos_dot) {
                $this->helpernum('.', '', $key);
                $this->helpernum(',', '.', $key);
            } else {
                $this->helpernum(',', '', $key);
            }
        } elseif($has_colon xor $has_dot) {
            $this->helpernum(',', '.', $key);
            settype($_POST[$key], 'float');
        } else {
            settype($_POST[$key], 'integer');
            $filterid = FILTER_VALIDATE_INT;
        }

        $_POST[$key] = filter_var($_POST[$key], $filterid);
    }

    private function helpernum($search, $replace, $key) {
        $_POST[$key] = str_replace($search, $replace, $_POST[$key]);
    }

    private function sanitizeArray($key) {
        if(defined('SECURITY_LAYER_SANITIZE_ARRAY')) {
            if(SECURITY_LAYER_SANITIZE_ARRAY) {
                foreach($_POST[$key] as &$value) settype($value, 'int');
            }
        }
    }
}

# Alias para llamada e instancia en un solo paso
function PostSafe($strict=False) {
    return new PostSafe($strict);
}


# Activación y limpieza automática si SECURITY_LAYER_ENGINE = 'On'
if(defined('SECURITY_LAYER_ENGINE')) {
    if(ucwords(SECURITY_LAYER_ENGINE) == 'On') {
        import('core.PostValidate');
        $strict = SECURITY_LAYER_STRICT_MODE;
        $sanitize_array = SECURITY_LAYER_SANITIZE_ARRAY;
        PostSafe($strict)->cleanPostData($sanitize_array);
    }
}
?>
