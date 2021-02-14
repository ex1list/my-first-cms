<?php


/**
 * Класс для обработки статей
 */
class Article
{
    // Свойства
    /**
    * @var int ID статей из базы данны
    */
    public $id = null;

    /**
    * @var int Дата первой публикации статьи
    */
    public $publicationDate = null;

    /**
    * @var string Полное название статьи
    */
    public $title = null;

      /**
    * @var string Полное название статьи
    */
    public $users_articles = null;

     /**
    * @var int ID категории статьи
    */
    public $categoryId = null;

    /**
    * @var string Краткое описание статьи
    */
    public $summary = null;
    
     /**
    * @var string Активность статьи
    */
    public $Active = null;
    
    /**
    * @var string Cубкатегория  статьи
    */
    public $SubcategoryId = null;

    /**
    * @var string HTML содержание статьи
    */
    public $content = null;
    /**
    * Устанавливаем свойства с помощью значений в заданном массиве
    *
    * @param assoc Значения свойств
    */

    /*
    public function __construct( $data=array() ) {
      if ( isset( $data['id'] ) ) {$this->id = (int) $data['id'];}
      if ( isset( $data['publicationDate'] ) ) {$this->publicationDate = (int) $data['publicationDate'];}
      if ( isset( $data['title'] ) ) {$this->title = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title'] );}
      if ( isset( $data['categoryId'] ) ) {$this->categoryId = (int) $data['categoryId'];}
      if ( isset( $data['summary'] ) ) {$this->summary = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['summary'] );}
      if ( isset( $data['content'] ) ) {$this->content = $data['content'];}
    }*/
    
    /**
     * Создаст объект статьи
     * 
     * @param array $data массив значений (столбцов) строки таблицы статей
     */
    public function __construct($data=array())
    {
        
      if (isset($data['id'])) {
          $this->id = (int) $data['id'];
      }
      
      if (isset( $data['publicationDate'])) {
          $this->publicationDate = (string) $data['publicationDate'];     
      }

      //die(print_r($this->publicationDate));

      if (isset($data['title'])) {
          $this->title = $data['title'];        
      }
      
      if (isset($data['categoryId'])) {
          $this->categoryId = (int) $data['categoryId'];      
      }
      
        if (isset($data['SubcategoryId'])) {
          $this->SubcategoryId  = (int) $data['SubcategoryId'];      
      }
      
      
      if (isset($data['summary'])) {
          $this->summary = $data['summary'];         
      }
      
      if (isset($data['content'])) {
          $this->content = $data['content'];  
      }
       if (isset($data['Active'])) {
          $this->Active = $data['Active']; 
          //echo $this->Active; die();
      }
         if (isset($data['groups'])) {
          $this->users_articles = $data['groups']; 
          //echo $this->Active; die();
      }            
      
    }


    /**
    * Устанавливаем свойства с помощью значений формы редактирования записи в заданном массиве
    *
    * @param assoc Значения записи формы
    */
    public function storeFormValues ( $params ) {
   //var_dump( $params); die();
      // Сохраняем все параметры
      $this->__construct( $params );
      
      //$data=array();
      //$data=$params;
      // var_dump( $data);
      // echo $data['articleId'];
      // var_dump($params );
       //     die();

      // Разбираем и сохраняем дату публикации
      if ( isset($params['publicationDate']) ) {
        $publicationDate = explode ( '-', $params['publicationDate'] );

        if ( count($publicationDate) == 3 ) {
          list ( $y, $m, $d ) = $publicationDate;
          $this->publicationDate = mktime ( 0, 0, 0, $m, $d, $y );
        }
      }
    }


    /**
    * Возвращаем объект статьи соответствующий заданному ID статьи
    *
    * @param int ID статьи
    * @return Article|false Объект статьи или false, если запись не найдена или возникли проблемы
    */
    public static function getById($id) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) "
                . "AS publicationDate FROM articles WHERE id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
           
        $row = $st->fetch();
   // var_dump($row); die();
      $conn = null;
         
        if ($row) { 
            return new Article($row);
        }
    } 


    /**
    * Возвращает все (или диапазон) объекты Article из базы данных
    *
    * @param int $numRows Количество возвращаемых строк (по умолчанию = 1000000)
    * @param int $categoryId Вернуть статьи только из категории с указанным ID
    * @param string $order Столбец, по которому выполняется сортировка статей (по умолчанию = "publicationDate DESC")
    * @return Array|false Двух элементный массив: results => массив объектов Article; totalRows => общее количество строк
    */
    public static function getList($numRows=1000000, 
            $categoryId=null, $order="publicationDate DESC") 
    {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $categoryClause = $categoryId ? "WHERE categoryId = :categoryId" : "";
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) 
                AS publicationDate
                FROM articles $categoryClause
                ORDER BY  $order  LIMIT :numRows";
        
        $st = $conn->prepare($sql);
//                        echo "<pre>";
//                        print_r($st);
//                        echo "</pre>";
//                        Здесь $st - текст предполагаемого SQL-запроса, причём переменные не отображаются
        $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
        
        if ($categoryId) 
            $st->bindValue( ":categoryId", $categoryId, PDO::PARAM_INT);
        
        $st->execute(); // выполняем запрос к базе данных
//                        echo "<pre>";
//                        print_r($st);
//                        echo "</pre>";
//                        Здесь $st - текст предполагаемого SQL-запроса, причём переменные не отображаются
        $list = array();

        while ($row = $st->fetch()) {
            $article = new Article($row);
            $list[] = $article;
        }
      // var_dump($list);die();

        // Получаем общее количество статей, которые соответствуют критерию
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query($sql)->fetch();
        $conn = null;
        
        return (array(
            "results" => $list, 
            "totalRows" => $totalRows[0]
            ) 
        );
    }


public static function subgetList($numRows=1000000, 
            $subcategoryId=null, $order="publicationDate DESC") 
    {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $categoryClause = $subcategoryId ? "WHERE SubcategoryId = :SubcategoryId" : "";
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) 
                AS publicationDate
                FROM articles $categoryClause
                ORDER BY  $order  LIMIT :numRows";
        
        $st = $conn->prepare($sql);
//                        echo "<pre>";
//                        print_r($st);
//                        echo "</pre>";
//                        Здесь $st - текст предполагаемого SQL-запроса, причём переменные не отображаются
        $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
        
        if ($subcategoryId) 
            $st->bindValue( ":SubcategoryId", $subcategoryId, PDO::PARAM_INT);
        
        $st->execute(); // выполняем запрос к базе данных
//                        echo "<pre>";
//                        print_r($st);
//                        echo "</pre>";
//                        Здесь $st - текст предполагаемого SQL-запроса, причём переменные не отображаются
        $list = array();

        while ($row = $st->fetch()) {
            $article = new Article($row);
            $list[] = $article;
        }
      // var_dump($list);die();

        // Получаем общее количество статей, которые соответствуют критерию
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query($sql)->fetch();
        $conn = null;
        
        return (array(
            "results" => $list, 
            "totalRows" => $totalRows[0]
            ) 
        );
    }

    /**
    * Вставляем текущий объект статьи в базу данных, устанавливаем его свойства.
    */


    /**
    * Вставляем текущий объек Article в базу данных, устанавливаем его ID.
    */
    public function insert() {

        // Есть уже у объекта Article ID?
        if ( !is_null( $this->id ) ) trigger_error ( "Article::insert(): Attempt to insert an Article object that already has its ID property set (to $this->id).", E_USER_ERROR );

        // Вставляем статью
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO articles ( publicationDate, categoryId, SubcategoryId ,title, summary, content, Active) VALUES ( FROM_UNIXTIME(:publicationDate), :categoryId, :SubcategoryId ,:title, :summary, :content, :Active)";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
        $st->bindValue( ":categoryId", $this->categoryId, PDO::PARAM_INT );
        $st->bindValue( ":SubcategoryId", $this->SubcategoryId, PDO::PARAM_INT );
        $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
        $st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
        $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
        $st->bindValue( ":Active", $this->Active, PDO::PARAM_INT );
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    /**
    * Обновляем текущий объект статьи в базе данных
    */
    public function update() {

      // Есть ли у объекта статьи ID?
      if ( is_null( $this->id ) ) trigger_error ( "Article::update(): "
              . "Attempt to update an Article object "
              . "that does not have its ID property set.", E_USER_ERROR );

      // Обновляем статью
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate),"
              . " categoryId=:categoryId, SubcategoryId=:SubcategoryId, title=:title, summary=:summary,"
              . "Active=:Active,"
              . " content=:content WHERE id = :id";
      
      $st = $conn->prepare ( $sql );
      
      
      
      $st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
      $st->bindValue( ":categoryId", $this->categoryId, PDO::PARAM_INT );
      $st->bindValue( ":SubcategoryId", $this->SubcategoryId, PDO::PARAM_INT );
      $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
      $st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
      $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
      $st->bindValue( ":Active", $this->Active, PDO::PARAM_INT );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $st->execute();
      $conn = null;
    }

      public function insert_author_articles() {    
      //var_dump($_POST['groups']);   die(); 
     // foreach ($_POST['groups'] as $author) { 
       // var_dump($this->users_articles);   die();
        //   echo ($this->id);   
          
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );  
        $sql = "DELETE FROM `users_articles` WHERE article_id = :article_id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":article_id", $this->id, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
             
        foreach ( $this->users_articles as $user_id ) {

          // var_dump($user_id);die();
             /* $user_id  вывод id пользователя который является автором статьи
                $this->id номер статьи
                users_articles таблица которая содержит авторов и статьи
              */
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO users_articles(users_id, article_id) VALUES (  :user_id, :article_id)";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":user_id", $user_id, PDO::PARAM_INT );
        $st->bindValue( ":article_id", $this->id, PDO::PARAM_INT );
        $st->execute();
        // $this->id = $conn->lastInsertId();
        $conn = null;
      }

     }

public static function getlist_author_articles() {  
           $array =null;
           $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
           $sql = "SELECT * FROM `users_articles`";
           $st = $conn->prepare ( $sql );
           $st->execute();
           $array = $st->fetchAll(PDO::FETCH_ASSOC);
           $conn = null; 
            // var_dump($array); die();
            foreach ( $array as $category ) {
               return  $array;  
            }
           }













    




    /**
    * Удаляем текущий объект статьи из базы данных
    */
    public function delete() {

      // Есть ли у объекта статьи ID?
      if ( is_null( $this->id ) ) trigger_error ( "Article::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR );

      // Удаляем статью
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $st = $conn->prepare ( "DELETE FROM articles WHERE id = :id LIMIT 1" );
      $st->bindValue(":id", $this->id, PDO::PARAM_INT);
      $st->execute();
      $conn = null;
    }

}
