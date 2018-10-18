<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: dbConnection.class.php
/////////////////////////////////////////////

//This class is one of the biggest classes for this page, it's basically a database wrapper.
//We will use PDO connect to a mysql database.

//We start by defining the class.
//We will be working with the singleton pattern: http://www.phptherightway.com/pages/Design-Patterns.html
//We will use a main static method called getInstance, with this method we'll be able to get an instance
//of the database if it has been already instantiated, so we don't have to connect to the database many 
//times making everything to work more efficient.

class dbConnection {
    //Here we declare our variables with the underscore so we know that they
    //are private variables later when we work with them.
    private static $db_instance = null;
    private  $db_pdo, //Here we'll store the pdo object.
             $db_query, //This will be the last query that was excecuted.
             $db_error = false, //For errors, is there an error or not? 
             $db_results, //This will store the result set.
             $db_count = 0; //For counting results.

    //Next we create the constructor.
    //This will run everytime the class is instantiated.
    private function __construct() {
      //Next we will try the PDO connection.
      try {
          //Here we set the private pdo property to a new pdo connection.
          //We use the config class to hadle this connection.
          $this->db_pdo = new PDO('mysql:host=' . config::getPath('mysql/host')
           . ';dbname=' .config::getPath('mysql/db') 
           ,config::getPath('mysql/username'), config::getPath('mysql/password'));
      //Here we'll catch any possible errors inside the try block.
      } catch(PDOException $e){
         die($e->getMessage());
      }
    }
    
    //Next we'll create the getInstance method.
    //What this will do is to check if the object has been instanciated. If the 
    //object is not been instantiated, it'll create and instanciate one, if the object
    //has been created it'll return an instance of it.
    public static function getInstance() {
       if(!isset (self::$db_instance)){
         self::$db_instance =new dbConnection();
       }
       //Here will return the instance so we can start using all the functionality
       //of the object.
      return self::$db_instance;
    }

    //Next we create the method to query the database either from outside the
    //clase of from the class itself.
    public function dbQuery($sql, $dbParameters = array()) {
       //Here we reset the query back to false so we know are not returning an error
       //from a previous query.
       $this->db_error = false;
       //Next using an if statement we check if the query 
       //has been prepared properly. If the query has been 
       //prepared successfully then bind the poparameters together. 
       if ($this->db_query = $this->db_pdo->prepare($sql)) {      
       $i=1;
       //Here we check if the parameters exists.      
       if(count($dbParameters)){
        foreach ($dbParameters as $dbParameter) {
           //Here we bind the value position with the parameter.
           $this->db_query->bindValue($i, $dbParameter);
           $i++;         
        }
       }
       //Next we excecute the query even if there are no parameters, or the prvious
       //count doesn't work we still want to excecute the query.
       if($this->db_query->execute()) {
          //If the query was excecuted successfully, then we store the result set.
          $this->db_results = $this->db_query->fetchAll(PDO::FETCH_OBJ);
          $this->db_count = $this ->db_query->rowCount();
          //Otherwise we set errors to true.
          } else {
           $this->db_error = true;
          }
          //This returns the current object and allow us to work
          //together with the error method created below.
          return $this;  
       } 
     }

    //Next we create the method dbTasks this method will allow us to make speciphic tasks
    //like delete or select.
    public function dbTasks($task, $table, $where = array(),$sortorder) {
           //First we check if the count is equal to 3 
           //(field, value and operator.)
           if (count($where === 3)) {
             $operators = array('=','>','<','>=','<=');
             $field     =  $where [0];
             $operator  =  $where [1];
             $value     =  $where [2];
             //Next we check if the operator is inside the array... (operators array)
             if (in_array($operator, $operators)) {
             //If its inside then we contruct the query. In the next query 
             //we say SELECT * FROM users WHERE username = value
             if($sortorder == "") {
                $sql = "{$task} FROM {$table} WHERE {$field} {$operator} ?";
             } else {
                $sql = "{$task} FROM {$table}  WHERE {$field} {$operator} ? {$sortorder}";
             }
             //$sql = "{$task} FROM {$table} $sortorder WHERE {$field} {$operator} ?";
             //Then if not errors return this.
             if(!$this->dbQuery($sql, array($value))->dbError()) {
                return $this;
             }
           }
         }
         //Otherwise we return false.
         return false;
       }
       //Here we create this function to be able to get
       //data from the table in the database.
       public function getData($table, $where, $sortorder=""){
        return $this->dbTasks('SELECT *',$table , $where, $sortorder);
       }

       //Next this function delete will allow us to delete
       //data from the table.
       public function deleteData($table,$where){
        return $this->action('DELETE *',$table , $where);
       }
       

    //Next we create the inserData method so we can be able to 
    //insert data in the database.
    //First we define the method and pass the table and fields,
    //this will be an array of data.
    public function insertData($table, $fields = array()) {
          //Next we define some variables for the companents
          //we will need.
          $keys   = array_keys($fields);
          $values = '';
          $i      = 1;
          //Next we create a foreach loop to go through the fields
          //defined in this method.
          foreach ($fields as $field) {
              $values .= '?';
              //Next we check with this if statement if we are at the end
              //of the fields defined?
              if ($i < count($fields)) {
                  //If not, we add a comma to these values.
                  $values .= ', ';
              }
              $i++;
          }
          //Next we create the query in the following way
          $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
          //If there is not errors in the query
          if (!$this->dbQuery($sql, $fields)->dbError()) {
              // Return true.
              return true;
            }
            //Otherwise return false.
            return false;
          }
          
 
    //This public function will return the results from the
    //database and will make them available for us to use.
    public function dbResults(){
     return $this->db_results;
    }

    //This public function will return the first result from the table
    //and will make it available for us to use.
    public function firstResult(){
     return $this->db_results[0];
    }

    //This public function is created just to return any errors.
    public function dbError(){
     return $this->db_error;
    }

    //This public function will return the users count from the
    //database and will make them available for us to use.
    public function dbCount(){
     return $this->db_count;
    }
}
