<?php
namespace App\Libraries;

class Database {

    protected static $instance;
  
    protected function __construct() {}
  
    public static function getInstance() {
  
      if(empty(self::$instance)) {
  
        $db_config = get_config("Database");
        $db = $db_config['dbname'];
        $host = $db_config['host'];
        $user = $db_config["user"];
        $pass = $db_config["password"];
        $port = $db_config["port"];

        try {
          self::$instance = new \PDO(
            "mysql:host=$host;port=$port;dbname=$db",
            $user,
            $pass
          );
  
        } catch(PDOException $error) {
          echo $error->getMessage();
        }
  
      }
  
      return self::$instance;
    }
}