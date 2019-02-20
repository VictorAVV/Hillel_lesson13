<?php
/**
 * 2. Создайте класс User с полями id (должно содержать только число) 
 * и password (длина поля должна быть не более 8 символов) 
 * и методом getUserData, который возвращает id и password. 
 * Обработайте исключения, 
 * когда id содержит не число и password содержит более 8 символов, 
 * при этом выведите сообщение исключения, файл в котором данное исключение возникло и номер строки.
 */

class User
{
    /**
     * @var id - должно содержать только число
     */
    private $id;
    /**
     * @var password - длина поля должна быть не более 8 символов
     */
    private $password;

    public function __construct($id, $password)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException('ERROR: Invalid argument, ID must be only number!');
        }
        $this->id = $id;

        if (strlen($password) > 8) {
            throw new InvalidArgumentException('ERROR: Invalid argument, Length of PASSWORD must be less then 8 symbols!');
        }
        $this->password = $password;
    }
    public function getUserData()
    {
        return array(
            'id' => $this->id,
            'password' => $this->password
        );
    }
}

try {
    $user1 = new User(12, 'wsadfa');
    //next code throws an exception
    //$user1 = new User(12, 'wsadfafasdsadsd');
    //$user1 = new User('12sad', 'wsadfaf');
    print_r($user1->getUserData());
} catch (InvalidArgumentException $err) {
    echo $err->getMessage();
    echo ' in file: ' . $err->getFile();
    echo ' on line: ' . $err->getLine();
}
