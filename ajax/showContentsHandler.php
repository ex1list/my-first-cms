<?php



require ('../config.php');
 //var_dump( $_GET['articleId']); die();
if (isset($_GET['articleId'])) {
	 //var_dump("A: "); die();
    $article = Article::getById((int)$_GET['articleId']);
    echo $article->content;
}

  
 
 // var_dump($article) ;
/*
/var/www/my-first-cms/ajax/showContentsHandler.php:10:
object(Article)[3]
  public 'id' => int 9
  public 'publicationDate' => string '1608325200' (length=10)
  public 'title' => string 'j' (length=1)
  public 'categoryId' => int 2
  public 'summary' => string 'j' (length=1)
  public 'Active' => string '1' (length=1)
  public 'SubcategoryId' => int 2
  public 'content' => string 'j' (length=1)
*/

if (isset ($_POST['articleId'])) {
	// var_dump($_POST); die();
    //die("Привет)");
    $article = Article::getById((int)$_POST['articleId']);
   // var_dump(Privet);die();
   // echo json_encode($article);
    echo $article->content;
//        die("Привет)");
//    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
//    
//        if (isset($conn)) {
//            die("Соединенте установлено");
//        }
//        else {
//            die("Соединение не установлено");
//        }
//    $article = "WHERE Id=". (int)$_POST[articleId];
//    echo $article;
//    $sql = "SELECT content FROM articles". $article;
//    $contentFromDb = $conn->prepare( $sql );
//    $contentFromDb->execute();
//    $result = $contentFromDb->fetch();
//    $conn = null;
//    echo json_encode($result);
}

