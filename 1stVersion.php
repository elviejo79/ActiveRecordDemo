<?php

class DB {
    private static $conn = null;

    private function __construct(){}

    public static function Conn() {
        if (self::$conn == null){
            self::$conn = new PDO('sqlite:activerecord.sq3');            
        }
        return self::$conn;
    }
}

class Person {
    private $numNomina = 0;
    public $lastName = "";
    public $firstName = "";
    public $numberOfDependents = 0;

    public function __construct($nomina, $first, $last, $dependents = 0){
        $this->numNomina = $nomina;
        $this->lastName = $last;
        $this->firstName = $first;
        $this->numberOfDependents = $dependents;
    }

    public static function findById($id){
        $select = "select * from Person where numNomina=$id";
        $results = DB::Conn()->query($select); //nunuca hagan esto!!!
        $res = $results->fetch(PDO::FETCH_ASSOC);
        return new Person($res['numNomina'],$res['lastName'],$res['firstName'],$res['numberOfDependents']);
    }
    public function update(){
        $file_db = DB::Conn();
        // Create table messages
        $file_db->exec("CREATE TABLE IF NOT EXISTS Person (numNomina INTEGER PRIMARY KEY, lastName TEXT, firstName TEXT, numberOfDependents)");

        // Prepare INSERT statement to SQLite3 file db
        // NO HACER ESTO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $insert = "INSERT OR REPLACE INTO Person (numNomina, lastName, firstName, numberOfDependents) 
                   VALUES ({$this->numNomina}, '{$this->lastName}', '{$this->firstName}', {$this->numberOfDependents})";

  
        $results = $file_db->exec($insert);
      }
}


$viejo = new Person(361157, 'Alejandro', 'Garcia',2);
$viejo->update();

$chairez = new Person(158,'Manuel A.','Chairez',0);
$chairez->update();

$chairez->numberOfDependents = 10;
$chairez->update();

$otraPersona = Person::findById(158);
print_r($otraPersona);
