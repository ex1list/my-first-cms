<?php

/**
 * Класс для обработки категорий статей
 */

class Subcategory
{
    // Свойства

    /**
    * @var int ID категории из базы данных
    */
    public $id = null;
    

    /**
    * @var int ID категории из базы данных
    */    
    public $category_id  = null;
    
    
    /**
    * @var string Название категории
    */
    public $Subname = null;

    /**
    * @var string Короткое описание категории
    */
    public $Subdescription = null;
    /**
    * Устанавливаем свойства объекта с использованием значений в передаваемом массиве
    *
    * @param assoc Значения свойств
    */
    /*public function __construct( $data=array() ) {
      if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
      if ( isset( $data['name'] ) ) $this->name = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['name'] );
      if ( isset( $data['description'] ) ) $this->description = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['description'] );
    }*/
    public function __construct( $data=array() ) {
              
      if ( isset( $data['id'] ) ) $this->id =  $data['id'];
      if ( isset( $data['Subname'] ) ) $this->Subname = $data['Subname'];
      if ( isset( $data['category_id'] ) ) $this->category_id = $data['category_id'];
      if ( isset( $data['Subdescription'] ) ) $this->Subdescription = $data['Subdescription'];
      // var_dump($this->id); 
    //  var_dump($this->Subname);
      //  var_dump($this->Subdescription);
     // var_dump($data); die();

       /*
/var/www/my-first-cms/classes/SubCategories.php:51:
array (size=8)
  'id' => string '1' (length=1)
  0 => string '1' (length=1)
  'category_id' => string '3' (length=1)
  1 => string '3' (length=1)
  'Subname' => string 'Name Subcategory_1' (length=18)
  2 => string 'Name Subcategory_1' (length=18)
  'Subdescription' => string 'Description Subcategory_1' (length=25)
  3 => string 'Description Subcategory_1' (length=25)


*/
   
    }
    /**
    * Устанавливаем свойства объекта с использованием значений из формы редактирования
    *
    * @param assoc Значения из формы редактирования
    */
  
    public function SubstoreFormValues ( $params ) {
      // Store all the parameters
      //  var_dump($params);die();

/*
/var/www/my-first-cms/classes/SubCategories.php:61:
array (size=5)
  'Subid' => string '' (length=0)
  'Subname' => string 'ytjtyjytjytj' (length=12)
  'category_id' => string '1' (length=1)
  'Subdescription' => string 'hgrthrtyjytj' (length=12)
  'saveChanges' => string 'Save Changes' (length=12)
*/




      $this-> __construct ($params);
     
    }


    /**
    * Возвращаем объект Category, соответствующий заданному ID
    *
    * @param int ID категории
    * @return Category|false Объект Category object или false, если запись не была найдена или в случае другой ошибки
    */

    public static function SubgetById( $id ) 
    {
        //var_dump($id); die();
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM Subcategories WHERE id = :id";
        $st = $conn->prepare( $sql );
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();      
        $conn = null;
       // var_dump($row); die();
        if ($row) 
            return new Subcategory($row);
    }
    
   

 

    /**
    * Возвращаем все (или диапазон) объектов Category из базы данных
    *
    * @param int Optional Количество возвращаемых строк (по умолчаниюt = all)
    * @param string Optional Столбец, по которому сортируются категории(по умолчанию = "name ASC")
    * @return Array|false Двух элементный массив: results => массив с объектами Category; totalRows => общее количество категорий
    */
    public static function SubgetList( $numRows=1000000, $order="Subname  ASC" ) 
    {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
    //	    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM categories
    //	            ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";

    //            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM categories
    //	            ORDER BY " .$conn->query($order) . " LIMIT :numRows";

    $sql = "SELECT * FROM Subcategories ORDER BY :order  LIMIT :numRows";

    $st = $conn->prepare($sql);
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->bindValue( ":order", $order, PDO::PARAM_STR );   
    $st->execute(); 
    $list = array();
 
    while ( $row = $st->fetch() ) {       
      $category = new Subcategory( $row );
      $list[] = $category;
      
    }
     
    // Получаем общее количество категорий, которые соответствуют критериям
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }

    
  

    /**
    * Вставляем текущий объект Category в базу данных и устанавливаем его свойство ID.
    */
/*
    public function Subinsert() {
   // У объекта Category уже есть ID?
       
       if ( !is_null($this->id) )   trigger_error ( "Subcategory::insert(): Attempt to insert a Category object that already has its ID property set (to $this->id).", E_USER_ERROR );
      
           $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      
      //var_dump($this->Subname); var_dump($this->Subdescription); die(); 
      $sql = "INSERT INTO Subcategories ( Subname, Subdescription ) VALUES ( :Subname, :Subdescription )";
      $st = $conn->prepare ( $sql );
      $st->bindValue( ":Subname", $this->Subname, PDO::PARAM_STR );
      $st->bindValue( ":Subdescription", $this->Subdescription, PDO::PARAM_STR );
      $st->execute();
     var_dump($conn->lastInsertid()); die();
      $this->id = $conn->lastInsertId();
      $conn = null;
    }
*/
    public function Subinsert() {
        // Вставляем статью
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO Subcategories ( id, category_id, Subname, Subdescription) VALUES ( :id, :category_id, :Subname, :Subdescription)";
        $st = $conn->prepare ($sql);
        $st->bindValue( ":id", $this->id, PDO::PARAM_INT);
        $st->bindValue( ":category_id", $this->category_id, PDO::PARAM_INT );
        $st->bindValue( ":Subname", $this->Subname, PDO::PARAM_STR );
        $st->bindValue( ":Subdescription", $this->Subdescription, PDO::PARAM_STR );
        $st->execute();
        // var_dump($conn->lastInsertId());die();
        //$this->id = 0;         
        //var_dump($conn->lastInsertId()); die();
        //var_dump($conn->lastInsertId()); die();
        
        $this->id = $conn->lastInsertId();
        $conn = null;
       // var_dump($conn->lastInsertId()); die();
         
    }

    /**
    * Обновляем текущий объект Category в базе данных.
    */

    public function Subupdate() {

      // У объекта Category  есть ID?
      if ( is_null( $this->id ) ) trigger_error ( "Category::update(): Attempt to update a Category object that does not have its ID property set.", E_USER_ERROR );
      //var_dump("Privet!");die();
      // Обновляем категорию
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "UPDATE Subcategories SET Subname=:name, Subdescription=:description, category_id= :category_id WHERE id = :id";
      $st = $conn->prepare ( $sql );
      $st->bindValue( ":name", $this->Subname, PDO::PARAM_STR );
      $st->bindValue( ":description", $this->Subdescription, PDO::PARAM_STR );
      $st->bindValue( ":category_id", $this->category_id, PDO::PARAM_INT );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $st->execute();
      $conn = null;
    }


    /**
    * Удаляем текущий объект Category из базы данных.
    */

    public function Subdelete() {

      // У объекта Category  есть ID?
      if ( is_null( $this->id ) ) trigger_error ( "Category::delete(): Attempt to delete a Category object that does not have its ID property set.", E_USER_ERROR );

      // Удаляем категорию
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $st = $conn->prepare ( "DELETE FROM Subcategories WHERE id = :id LIMIT 1" );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $st->execute();
      $conn = null;
    }

}
	  
	

