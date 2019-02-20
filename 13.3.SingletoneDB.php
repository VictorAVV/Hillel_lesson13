<?php
/**
 * 3. Напишите свою реализацию шаблона Одиночка 
 * на примере класса DB (DataBase). 
 * Доступ к БД осуществляется по хосту, имени пользователя и паролю.
 */

final class DataBase
{
    private static $instance;
    
    private $host;
    private $user;
    private $password;
    private $db;
    /**
     * @var ссылка на БД
     */
    private $mysqli;

    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function connect($host, $user, $password, $db)
    {
        $this->mysqli = @new mysqli($host, $user, $password, $db);
        if ($this->mysqli->connect_errno != 0) {
            //output of the error message
            //echo '<hr>' . $this->mysqli->connect_error . '<hr>';
            if ($this->mysqli->connect_errno == 2002) {
                throw new Exception("ERROR: HOST not found"); 
            } elseif ($this->mysqli->connect_errno == 1044) {
                throw new Exception("ERROR: Authentification failed");
            } else {
                throw new Exception('ERROR: Connection failed. Error No ' . $this->mysqli->connect_errno);
            }
        }
    }

    public function getUserById($id) 
    {
        $selectQuery = "SELECT * FROM `users` WHERE `id` = $id"; 
        $resultQuery = $this->mysqli->query($selectQuery)->fetch_assoc();
        if ($resultQuery === NULL) { 
            return false;
        }
        return $resultQuery;
    }
    public function saveNewUser($name, $password, $email = "") 
    {
        //$query = "INSERT INTO `users` (`name`, `password`, `email`) VALUES ('$name', '$password', '$email')"; 
        //$resultQuery = $this->mysqli->query($query); 
        
        $query = $this->mysqli->prepare("INSERT INTO `users` (`name`, `password`, `email`) VALUES (?, ?, ?)"); 
        $query->bind_param('sss', $name, $password, $email);
        $query->execute();
        $last_id = $query->insert_id;
        $errorNum = $query->errno;
        $query->close();
        if ($errorNum !== 0) { 
            throw new Exception('ERROR: Wrong SQL-query! Can\'t save user. Error No ' . $errorNum); 
        }
        return $last_id;
    }

    private function __construct()
    {
    }
    private function __clone()
    {
    }
    private function __sleep()
    {
    }
    private function __wakeup()
    {
    }
    public function __destruct()
    {
        unset($this->mysqli);
    }
}

try {
    $database1 = DataBase::getInstance();
    $database1->connect('localhost', 'root', '', 'users_db');
    echo "Connected successfully<br>";
    $userId = $database1->saveNewUser('Ivan', 'qwerty');

    $database2 = DataBase::getInstance();
    print_r($database2->getUserById($userId));
} catch (Exception $err) {
    echo $err->getMessage();
}
