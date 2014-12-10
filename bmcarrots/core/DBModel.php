<?php

/**
 * Capa de abstraccion mysqli para conexiÓn a base de datos
 * @package core
 * @abstract
 * @license    http://www.gnu.org/licenses/gpl.txt  GNU GPL 3.0
 * @author     Eugenia Bahit <ebahit@member.fsf.org>
 * @link       http://www.europio.org
 */
abstract class DBModel {
    protected static $conn;
    protected static $sql;
    protected static $stmt;
    protected static $reflection;	 
    protected static $data;
    public static $results;

    protected static function open() {
        self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (self::$conn->connect_errno) {
            print("Página no disponible. Intente de nuevo más tarde.");
            exit();
        }
    }

    protected static function prepare() {
        self::$stmt = self::$conn->prepare(self::$sql);
        self::$reflection = new ReflectionClass('mysqli_stmt');
    }
    
    protected static function setParams() {
        $method = self::$reflection->getMethod('bind_param');
        $method->invokeArgs(self::$stmt, self::$data);
    }
    
    protected static function getData($fields) {
        self::$results = array();
        $method = self::$reflection->getMethod('bind_result');
        $method->invokeArgs(self::$stmt, $fields);
        while(self::$stmt->fetch()) {
                self::$results[] = unserialize(serialize($fields));
        }
    }
    protected static function close() {
        self::$stmt->close();
        self::$conn->close();
    }

    public static function execute($sql, $data, $fields=False) {
        self::$sql = strtolower($sql);
        self::$data = $data;
        self::open();
        self::$conn->set_charset("utf8");
        self::prepare();
        self::setParams();
        self::$stmt->execute();
        //pr(self::$conn);
        if($fields) {           
            self::getData($fields);
            return self::$results;
        } 
        else {
            if(strpos(self::$sql, strtolower('INSERT')) === 0) {
                return self::$conn->insert_id;
            }
        }
        self::close();       
    }
}
?>