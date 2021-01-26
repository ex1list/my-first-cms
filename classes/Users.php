<?php


/**
 * Класс для обработки статей
 */
class Users
{
    // Свойства
    /**
    * @var int ID статей из базы данны
    */
     public $id = null;

    /**
    * @var string логин пользователя
    */
    public $login = null;

    /**
    * @var string пароль пользователя
    */
    public $password = null;

   
     /**
    * @var string Активность статьи
    */
    public $Active = null;

   
    
    /**
     * Создать объект пользователь
     * 
     * @param array $data массив значений (столбцов) строки таблицы пользователей
     */
    public function __construct($data=array())
    {
        
      if (isset( $data['id'])) {
          $this->id = (int) $data['id'];     
      }
  
      if (isset( $data['login'])) {
          $this->login = (string) $data['login'];     
      }
      //die(print_r($this->publicationDate));
      
      if (isset($data['password'])) {
          $this->password = $data['password'];        
      }
      
       if (isset($data['Active'])) {
          $this->Active = $data['Active']; 
          //echo $this->Active; die();
      }      

    }


    /**
    * Устанавливаем свойства с помощью значений формы редактирования записи в заданном массиве
    *
    * @param assoc Значения записи формы
    */
    public function storeFormValues_user ( $params ) {
      // Сохраняем все параметры
      //print_r($params); die(); 
     
      $this-> __construct( $params ); 
   //  var_dump( $this-> __construct); die();
      //$data=array();
      //$data=$params;
    //  var_dump( $data);die();
      // echo $data['articleId'];
     // echo $data['Active'];
        //      die();
    }
   

        public static function getById_user($id) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM users WHERE id=:id";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();       
        $row = $st->fetch();   
         $conn = null;
    
        if ($row) { 
            return new Users($row);
        }
    }
     
    
    public static function getList_user ($numRows=1000000) 
    {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $st = $conn->prepare ( "SELECT SQL_CALC_FOUND_ROWS * FROM users" );
        // $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
        $st->execute();
        $list = array();
         while ($row = $st->fetch()) {
            $users = new Users ($row);
            $list[] = $users;           
             }
     // var_dump( $list );  die();     
            return ($list);    
            
        }
        
        
  


    public function insert_user() {
        // Вставляем статью
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO users ( id, login, password, Active) VALUES ( :id, :login, :password, :Active)";
        $st = $conn->prepare ($sql);
        $st->bindValue( ":id", $this->id, PDO::PARAM_INT);
        $st->bindValue( ":login", $this->login, PDO::PARAM_STR );
        $st->bindValue( ":password", $this->password, PDO::PARAM_STR );
        $st->bindValue( ":Active", $this->Active, PDO::PARAM_INT );
        $st->execute();
        // var_dump($conn->lastInsertId());die();
        $this->id = $conn->lastInsertId();
        $conn = null;
        
         
        
      
      
       
        
        
        
    }

    public function update_user() {
      // Обновляем данные о пользователе
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "UPDATE users SET  login=:login, password=:password,"
              . "Active=:Active WHERE id =:id";
      $st = $conn->prepare ($sql);
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT);
      $st->bindValue( ":login", $this->login, PDO::PARAM_STR );
      $st->bindValue( ":password", $this->password, PDO::PARAM_STR );
      $st->bindValue( ":Active", $this->Active, PDO::PARAM_INT );
      $st->execute();
      $conn = null;
    }

    public function delete_user() {   
      // Удаляем данные о пользователе
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $st = $conn->prepare ( "DELETE FROM users WHERE id = :id LIMIT 1" );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $st->execute();
      $conn = null;
    }

}
