<?php

    	 // ################ Configurations ######################
		/* Your SQL Database server */
		define('DBHOST','localhost');
		/* Your SQL Database Username */
		define('DBUSER','root');
		/* Your SQL Database Password */
		define('DBPASS','');
		/* Your SQL Database Name */
        define('DBNAME','cms');
        // Your Site Domain
        define('DIR','localhost');
        // Your Site Email
        define('SITEEMAIL','noreply@domain.com');

class DB {
    
        private $con;
        private $error;
        private $qError;
        
        private $stmt;
        
        public function connect(){
            $dbs = "mysql:host=".DBHOST.";dbname=".DBNAME;
            $options = array(
                PDO::ATTR_PERSISTENT    => true,
                PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
                );
            
            try{
                $this->con = new PDO($dbs, DBUSER, DBPASS, $options);
            }
            //catch any errors
            catch (PDOException $e){
                $this->error = $e->getMessage();
                exit;
            }
            
        }

        public function query($query){
            $this->stmt = $this->con->prepare($query);
        }

        public function bind($param, $value, $type = null){
            if(is_null($type)){
                switch (true){
                    case is_int($value):
                      $type = PDO::PARAM_INT;
                      break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
          $this->stmt->bindValue($param, $value, $type);
        }

        public function execute(){
            return $this->stmt->execute();
            $this->qError = $this->con->errorInfo();
              if(!is_null($this->qError[2])){
                  echo $this->qError[2];
              }
        }

        public function results(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function result(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function rowCount(){
            return $this->stmt->rowCount();
        }

        public function queryError(){
            $this->qError = $this->con->errorInfo();
            if(!is_null($qError[2])){
                echo $qError[2];
            }
        }

        public function close(){
            $this->con = null;
        }
}


?>