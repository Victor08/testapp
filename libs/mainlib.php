<?php

// for database operations
class DB {

    static public $mysqli = array();
    static public $connect = array();

    //the function for setting up a database connection 
    static public function _($key = 0) {
        if (!isset(self::$mysqli['$key'])) {
            if (!isset(self::$connect['server'])) {
                self::$connect['server'] = Core::$DB_SERVER;
            }
            if (!isset(self::$connect['user'])) {
                self::$connect['user'] = Core::$DB_LOGIN;
            }
            if (!isset(self::$connect['pass'])) {
                self::$connect['pass'] = Core::$DB_PASS;
            }
            if (!isset(self::$connect['db'])) {
                self::$connect['db'] = Core::$DB_NAME;
            }
            self::$mysqli[$key] = @new mysqli (self::$connect['server'], self::$connect['user'], self::$connect['pass'], self::$connect['db']);

            if (mysqli_connect_errno()) {
                echo 'Не удалось подключиться к базе данных';
                exit;
            }
            if (!self::$mysqli[$key]->set_charset("utf8")) {
                echo "Ошибка при загрузке символов utf-8 " . self::$mysqli[$key]->error;
                exit;
            }
        }
        return self::$mysqli[$key];
    }

    //the function for closing a database connection
    static public function close($key = 0) {
        self::$mysqli[$key]->close();
        unset(self::$mysqli[$key]);
    }
    
    //the function for creating a database query
    static public function q($query, $key = 0) {
        $result = self::_($key)->query($query);
        if ($result === false) {
            $info = debug_backtrace();
            $error_arg_string = "";
            foreach ($info[0]['args'] as $v) {
                $error_arg_string .= $v . "\n";
            }
            $error_message = "ошибка в функции " . $info[0]['function'] . "\n"
                    . "на строке " . $info[0]['line'] . "\n"
                    . "в файле " . $info[0]['file'] . "\n"
                    . "в аргументах:" . $error_arg_string . "время ошибки: " . date("Y-m-d H:i:s") . "\n"
                    . "страница, на которой был сделан запрос:" . $_SERVER['REQUEST_URI'] . "\n"
                    . "=============================================";
            file_put_contents('/logs/mysql.log', $error_message, FILE_APPEND);
            echo $error_message;
            return false;
            exit();
        } else {
            return $result;
        }
    }
    
    static public function mres($element, $key=0) {
        return self::_($key)->real_escape_string($element);
    }

}

class router {
    static public function set_route_params () {
        if (isset($_GET['route'])) {
            $route = explode('/', $_GET['route']);
            for ($i=0; $i<count($route); $i++){
                if ($i==0) {
                    $_GET['module'] = hschAll($route[$i]);
                } elseif ($i==1) {
                    $_GET['page'] = hschAll($route[$i]);
                } elseif ( $i>1 ){
                    if (!isset($_GET['extra'])) {
                        $_GET['extra'] = array();
                    }
                    array_push ($_GET['extra'], hschAll($route[$i]));
                }
            }
        }
    }
}

