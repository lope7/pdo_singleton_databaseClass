<?php


class Database {


    private $dbHost     = "" ;
    private $dbUser     = "" ;
    private $dbPass     = "" ;
    private $dbName     = "" ;

    
    private static $prp ;
    private static $pdo ;
    private static $instance = null ;


    public static function getInstance():Database {
        if(self::$instance == null) self::$instance = new Database();
        return self::$instance;
    }

    private function __clone(){}
    
    private function __construct() {
    $this->connect() ;
    }

    
    public function __destruct(){
        $this->close() ;
    }


    private function connect() { 
        try {

            self::$pdo = new PDO("mysql:dbname={$this->dbName};host={$this->dbHost};charset=utf8",
                                    $this->dbUser, 
                                    $this->dbPass);

          
            self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0) ;
            
        } catch (Exception $e) {
            die("**Error connection") ;
        }
    }

   
    public function query($sql, $params=[]) {

        self::$prp = self::$pdo->prepare($sql);


        self::$prp->execute($params);

    }



    public function getRow($class="stdclass") {
        return self::$prp->fetchObject($class);
    }

   
    public function close() {
        self::$pdo = [] ;
    }

    
}
