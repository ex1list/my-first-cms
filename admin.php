<?php
 
// var_dump($_GET); die();
require("config.php");
session_start();
$action = isset($_GET['action']) ? $_GET['action'] : "";
  // var_dump($action);die();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
//var_dump($username);die();
if ($action != "login" && $action != "logout" && !$username) {
    login();
    exit;
}

switch ($action) {
    case 'login':
        login();
        break;
    case 'logout':
        logout();
        break;
    case 'newArticle':
        newArticle();
        break;
    case 'editArticle':
        editArticle();
        break;
    case 'deleteArticle':
        deleteArticle();
        break;
    case 'listCategories':
        listCategories();
        break;
    case 'newCategory':
        newCategory();
        break;
    case 'editCategory':
        editCategory();
        break;
    case 'deleteCategory':
        deleteCategory();
        break;
      case 'newUsers':
        newUsers();
        break;
    case 'EditUsers':
        EditUsers();
        break;
   case 'deleteUser':   
     deleteUsers();
    break; 
     case 'ListUsers':
        ListUsers();
        break;
   case 'listSubCategories':
        listSubCategories();
        break;
    case 'newSubCategory':
        newSubCategory();
        break;
    case 'editSubCategories':
        editSubCategories();  
        break;
    case 'deleteSubCategory':
        deleteSubCategory();
        break;
    default:
        listArticles();
} 
    
/**
 * Авторизация пользователя (админа) -- установка значения в сессию
 */
function login() {
    $results = array();
    $results['pageTitle'] = "Admin Login | Widget News";
    if (isset($_POST['login'])) {
        // Пользователь получает форму входа: попытка авторизировать пользователя
        if ($_POST['username'] == ADMIN_USERNAME 
                && $_POST['password'] == ADMIN_PASSWORD) {
          // Вход прошел успешно: создаем сессию и перенаправляем на страницу администратора
          $_SESSION['username'] = ADMIN_USERNAME;
          header( "Location:admin.php");}    
         // Пользователь получает форму входа: попытка авторизировать пользователя
            if (isset($_POST['username'])  && isset($_POST['password'] )) {  
                
                
                
            $sql_f="SELECT COUNT(*) FROM users WHERE login=:login AND password=:password";
              
            function user_autorize ($username,$password,$sql) {
            $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $st = $conn->prepare ($sql);
            $st->bindValue(":login",$username, PDO::PARAM_STR);
            $st->bindValue(":password",$password, PDO::PARAM_STR);
            $st->execute();
            return $row = $st->fetch(PDO::FETCH_ASSOC);
    
            }
            
            $user_f = user_autorize ($_POST['username'],$_POST['password'],$sql_f);
           // echo($user_f['COUNT(*)']); die();
            
           
           // var_dump($user_s); die();
            // var_dump(user_autorize ($_POST['username'],$_POST['password'],$sql_s)); die(); 
           // var_dump($row); die();
            //var_dump($_POST['username']); var_dump($_POST['password']);var_dump($row = $st->fetch()); die();               
            if ($user_f['COUNT(*)'] <> '0') { 
                $sql_s="SELECT * FROM users WHERE login=:login AND password=:password AND Active<>0";
                 $user_s = user_autorize ($_POST['username'],$_POST['password'],$sql_s);
                if ($user_s != false) { 
                    // Вход прошел успешно: создаем сессию и перенаправляем на страницу администратора
                    $_SESSION['username'] = $_POST['username']; // или константу "user"
                    // var_dump($_SESSION); die();
                    header( "Location: admin.php");  
                }  else {
                    // Ошибка входа: выводим сообщение об ошибке для пользователя
                    $results['errorMessage'] = "Извините, в ваш аккаунт нельзя войти обратитесь к администратору по телефону: 8798798798989";
                    require( TEMPLATE_PATH . "/admin/loginForm.php" );
                 }
        }  else {             
                // Ошибка входа: выводим сообщение об ошибке для пользователя
                $results['errorMessage'] = "Неправильный пароль, попробуйте ещё раз.";
                require( TEMPLATE_PATH . "/admin/loginForm.php" );
                }
                $conn = null;
            }   
  //var_dump( $list );  die();     
    } else {
      // Пользователь еще не получил форму: выводим форму
      require(TEMPLATE_PATH . "/admin/loginForm.php");
    }
}
function logout() {
    unset( $_SESSION['username'] );
    header( "Location: admin.php" );
}


function newUsers () {
    $results = array();
    $results['pageTitle'] = "New User";
    $results['formAction'] = "newUsers";
   
    if ( isset( $_POST['saveChanges'] ) ) {
        $user = new Users();
        //var_dump($_POST); die();
        $user->storeFormValues_user ( $_POST );
        $user->insert_user ();
        header( "Location: admin.php?action=ListUsers&status=changesSaved" ); 
        } elseif ( isset( $_POST['cancel'] ) ) {
            // Пользователь сбросил результаты редактирования: возвращаемся к списку статей
            header( "Location: admin.php?action=ListUsers" );
          } else { 
            // Пользователь еще не получил форму редактирования: выводим форму
            $results['user'] = new Users;
            require( TEMPLATE_PATH."/admin/EditUsers.php" );
            }
           
}  
            
            
            
   
 
function EditUsers() {
    $results = array();
    $results['pageTitle'] = "Edit User";
    $results['formAction'] = "EditUsers";
    //var_dump($_POST); die();
    if (isset($_POST['saveChanges'])) {
    // Пользователь получил форму редактирования статьи: сохраняем изменения
        if ( !$user = Users::getById_user( (int)$_POST['UserId'] ) ) {
         //var_dump($_POST['UserId']); die();
            header( "Location: admin.php?error=NotFound" );
            return;       
        }       
        
       // var_dump($_POST['UserId']); die();
        $user->storeFormValues_user( $_POST );
        $user->update_user();  
        header( "Location: admin.php?action=ListUsers&status=changesSaved" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        // Пользователь отказался от результатов редактирования: возвращаемся к списку пользователей
        header( "Location:admin.php?action=newUsers" );
      } else {
           // Пользвоатель еще не получил форму редактирования: выводим форму
    
             $results['user'] = Users::getById_user((int)$_GET['UserId']);  
            
            require(TEMPLATE_PATH . "/admin/EditUsers.php");      
         }   
    
  
         
         
         
        
         
}
    

    
           
   
   

    
    
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
    
   
 function deleteUsers() {
    
      if ( !$user = Users::getById_user( (int)$_GET['UserId']  ) ) {
        header( "Location: admin.php?error=NotFound" );
        return;
    }
    $user->delete_user() ;
    header( "Location: admin.php?status=UserDeleted" ); 
 }
 
    

   
    
 
 
 
 
 function listUsers() {
    $results = array(); 
    $results['user'] = Users::getList_user();
    // var_dump($results['user']); die();  
    $results['pageTitle'] = "Все юзеры";
 
    if (isset($_GET['status'])) { // вывод сообщения (если есть)
        if ($_GET['status'] == "changesSaved") {
            $results['statusMessage'] = "Your changes have been saved.";
        } if ($_GET['status'] == "UserDeleted")  {
            $results['statusMessage'] = "User deleted.";
          }
    } 
    require(TEMPLATE_PATH . "/admin/ListUsers.php" );   
}
 
 
 
 
 
 
 

function newArticle() {
   // var_dump($_POST);  die();
    $results = array();
    $results['pageTitle'] = "New Article";
    $results['formAction'] = "newArticle";
    
    if ( isset( $_POST['saveChanges'] ) ) {
//            echo "<pre>";
//            print_r($results);
//            print_r($_POST);
//            echo "<pre>";
//            В $_POST данные о статье сохраняются корректно
        // Пользователь получает форму редактирования статьи: сохраняем новую статью
         
        $article = new Article();
          
      // var_dump($article); die();
        $article->storeFormValues( $_POST );
//            echo "<pre>";
//            print_r($article);
//            echo "<pre>";
//            А здесь данные массива $article уже неполные(есть только Число от даты, категория и полный текст статьи)          
        $article->insert();
        header( "Location: admin.php?status=changesSaved" );

    } elseif ( isset( $_POST['cancel'] ) ) {

        // Пользователь сбросил результаты редактирования: возвращаемся к списку статей
        header( "Location: admin.php" );
    } else {

        // Пользователь еще не получил форму редактирования: выводим форму
        $results['article'] = new Article;
        $data = Category::getList();
        $results['categories'] = $data['results'];
        $subdata = Subcategory::SubgetList(); 
        $results['subcategories'] = $subdata['results'];
        require( TEMPLATE_PATH . "/admin/editArticle.php" );
     
    }
}


/**
 * Редактирование статьи
 * 
 * @return null
 */
function editArticle() {
  // var_dump($_POST);  die();
/*
array (size=10)
  'articleId' => string '2' (length=1)
  'title' => string 'Title Article_2' (length=15)
  'summary' => string 'Summary Article_2' (length=17)
  'content' => string 'Content Article_2' (length=17)
  'categoryId' => string '1' (length=1)
  'SubcategoryId' => string '1' (length=1)
  'groups' => 
    array (size=3)
      0 => string '1' (length=1)
      1 => string '2' (length=1)
      2 => string '3' (length=1)
  'publicationDate' => string '2021-01-29' (length=10)
  'Active' => string '0' (length=1)
  'saveChanges' => string 'Save Changes' (length=12)
*/





    $results = array();
    $results['pageTitle'] = "Edit Article";
    $results['formAction'] = "editArticle";

 //var_dump($_POST);  die();
    if (isset($_POST['saveChanges'])) {

        $subdata = Subcategory::SubgetList();  
        $results['subcategories'] = $subdata['results'];


/*

/var/www/my-first-cms/admin.php:352:
array (size=11)
  'articleId' => string '3' (length=1)
  'title' => string 'Title Article_3' (length=15)
  'summary' => string 'Summary Article_3' (length=17)
  'content' => string 'Content Article_3' (length=17)
  'categoryId' => string '2' (length=1)
  'SubcategoryId' => string '1' (length=1)
  'category_id' => string ' Subcategory Object

(

    [id] => 1

    [category_id] => 3

    [Subname] => Name Subcategory_1

    [Subdescription] => Description Subcategory_1

)

  ' (length=156)
  'groups' => 
    array (size=1)
      0 => string '6' (length=1)
  'publicationDate' => string '2021-01-25' (length=10)
  'Active' => string '0' (length=1)
  'saveChanges' => string 'Save Changes' (length=12)



*/




      
    if ($_POST['categoryId'] ==   $results['subcategories'][$_POST['SubcategoryId']-1]->category_id) {  
       //var_dump( $_POST['groups']); die();
        // Пользователь получил форму редактирования статьи: сохраняем изменения
        if ( !$article = Article::getById( (int)$_POST['articleId'] ) ) {
            header( "Location: admin.php?error=articleNotFound" );
            return;
        }
   
        // print_r($_POST);  die() ; 
       //var_dump($_POST);  die();
        $article->storeFormValues( $_POST );
        $article->update();
        $article->insert_author_articles();
       //var_dump($article->author_articles()); die();   
        
        header( "Location: admin.php?status=changesSaved" );
} else {
        
             
        $results['errorMessage']="Ошибка: Выбранная категория не соответствует подкатегории!";

        // Пользвоатель еще не получил форму редактирования: выводим форму
        $results['article'] = Article::getById((int)$_POST['articleId']);
         
        // var_dump($results['article'] );die();
        $data = Category::getList(); 
        $results['categories'] = $data['results'];

        // var_dump($results['categories']); die();
        





       
        $subdata = Subcategory::SubgetList();  
        $results['subcategories'] = $subdata['results'];
        require(TEMPLATE_PATH . "/admin/editArticle.php");
       //  var_dump($results['article']); die();
        
      
    }




    } elseif ( isset( $_POST['cancel'] ) ) {
        // Пользователь отказался от результатов редактирования: возвращаемся к списку статей
        header( "Location: admin.php" );
    } else {
    
          
        // Пользвоатель еще не получил форму редактирования: выводим форму
        $results['article'] = Article::getById((int)$_GET['articleId']);
        
       // var_dump($results['article'] );die();
        $data = Category::getList(); 
        $results['categories'] = $data['results'];
       // var_dump($results['categories']); die();
        $subdata = Subcategory::SubgetList();  
        $results['subcategories'] = $subdata['results'];
    
      // var_dump($results['subcategories']); die();


      $resultsz = array(); 
        $resultsz['user_result'] = Users::getList_user();
       // var_dump($resultsz); die();
 

        require(TEMPLATE_PATH . "/admin/editArticle.php");

     


       //  var_dump($results['article']); die();
    }
    
     

}


function deleteArticle() {

    if ( !$article = Article::getById( (int)$_GET['articleId'] ) ) {
        header( "Location: admin.php?error=articleNotFound" );
        return;
    }

    $article->delete();
    header( "Location: admin.php?status=articleDeleted" );
}


function listArticles() {
    $results = array();
    
    $data = Article::getList();
    //var_dump($data); die();
    $results['articles'] = $data['results']; // этот массив отправляется на view страницу
   // var_dump($results['articles']); die();
    $results['totalRows'] = $data['totalRows'];
    
    $data = Category::getList();
   //  var_dump($data); die();
    $results['categories'] = array();
    foreach ($data['results'] as $category) { 
    $results['categories'][$category->id] = $category;
  // var_dump($results['categories'][$category->id]);
    }
   // die();
    
   
     $subdata = SubCategory::SubgetList();
    
     $results['subcategories'] = array();   
    foreach ($subdata['results'] as $subcategory) { 
        $results['subcategories'][$subcategory->id] = $subcategory;
     //  var_dump($subcategory);
    }
    

        $resultsz = array(); 
        $resultsz['user_result'] = Users::getList_user();

         $data = Article::getlist_author_articles();
         $authors = $data;
      //var_dump($authors);  
     

   
 


     // die();
    
    $results['pageTitle'] = "Все статьи";

    if (isset($_GET['error'])) { // вывод сообщения об ошибке (если есть)
        if ($_GET['error'] == "articleNotFound") 
            $results['errorMessage'] = "Error: Article not found.";
    }
 // var_dump($_GET['status']); die(); 

    if (isset($_GET['status'])) { // вывод сообщения (если есть)
        if ($_GET['status'] == "changesSaved") {
            $results['statusMessage'] = "Your changes have been saved.";
        }
        if ($_GET['status'] == "articleDeleted")  {
            $results['statusMessage'] = "Article deleted.";
        }
    }

    require(TEMPLATE_PATH . "/admin/listArticles.php" );
}

function listCategories() {
    $results = array();
    $data = Category::getList();
    //var_dump($data['results']); die();
    $results['categories'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Article Categories";

    if ( isset( $_GET['error'] ) ) {
        if ( $_GET['error'] == "categoryNotFound" ) $results['errorMessage'] = "Error: Category not found.";
        if ( $_GET['error'] == "categoryContainsArticles" ) $results['errorMessage'] = "Error: Category contains articles. Delete the articles, or assign them to another category, before deleting this category.";
    }

    if ( isset( $_GET['status'] ) ) {
        if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
        if ( $_GET['status'] == "categoryDeleted" ) $results['statusMessage'] = "SubCategory deleted.";
    }

    require( TEMPLATE_PATH . "/admin/listCategories.php" );
}
	  
	  
function newCategory() {
    
    $results = array();
    $results['pageTitle'] = "New Article Category";
    $results['formAction'] = "newCategory";

    if ( isset( $_POST['saveChanges'] ) ) {
     // var_dump ($_POST); die();
     /*
     array (size=4)
    'categoryId' => string '' (length=0)
    'name' => string 'Second_category' (length=15)
    'description' => string 'rthrt' (length=5)
    'saveChanges' => string 'Save Changes' (length=12)
    */


        // User has posted the category edit form: save the new category
        $category = new Category;
    
         // var_dump($_POST);die();
        $category->storeFormValues( $_POST );
        // var_dump($_POST);die();
        $category->insert();
        header( "Location: admin.php?action=listCategories&status=changesSaved" );
    } elseif ( isset( $_POST['cancel'] ) ) {   
        // User has cancelled their edits: return to the category list
        header( "Location: admin.php?action=listCategories" );
    } else {
        // User has not posted the category edit form yet: display the form
        $results['category'] = new Category;
      //var_dump($results['category']); die();
        require( TEMPLATE_PATH . "/admin/editCategory.php" );
    }
}


function editCategory() {

    $results = array();
    $results['pageTitle'] = "Edit Article Category";
    $results['formAction'] = "editCategory";

    if ( isset( $_POST['saveChanges'] ) ) {
 //var_dump("МЫ ЗАШЛИ В ПОСТ");die();
        // User has posted the category edit form: save the category changes
 //var_dump(Category::getById( (int)$_POST['categoryId']));die();
        if (!$category = Category::getById( (int)$_POST['categoryId'] ) ) {
          header( "Location: admin.php?action=listCategories&error=categoryNotFound" );
          return;
        }
 //var_dump( $_POST );die();
        $category->storeFormValues( $_POST );
        $category->update();
        header( "Location: admin.php?action=listCategories&status=changesSaved" );

    } elseif ( isset( $_POST['cancel'] ) ) {

        // User has cancelled their edits: return to the category list
        header( "Location: admin.php?action=listCategories" );
    } else {
   // var_dump($_GET);die();
        // User has not posted the category edit form yet: display the form
        $results['category'] = Category::getById( (int)$_GET['categoryId'] );
        require( TEMPLATE_PATH . "/admin/editCategory.php" );
    }

}


function deleteCategory() {
    if ( !$category = Category::getById( (int)$_GET['categoryId'] ) ) {
        header( "Location: admin.php?action=listCategories&error=categoryNotFound" );
        return;
    }
    $articles = Article::getList( 1000000, $category->id );
    if ( $articles['totalRows'] > 0 ) {
        header( "Location: admin.php?action=listCategories&error=categoryContainsArticles" );
        return;
    }
    $category->delete();
    header( "Location: admin.php?action=listCategories&status=SubcategoryDeleted" );
}

function listSubCategories() {
    $results = array();
    $data = SubCategory::SubgetList();
    
    // var_dump($data); die();
    $results['subcategories'] = $data['results'];
     // var_dump($results['subcategories'][1]->id ); die();
  //  var_dump($results['subcategories']); die();
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Article SubCategories";
    if ( isset( $_GET['error'] ) ) {
        if ( $_GET['error'] == "SubcategoryNotFound" ) $results['errorMessage'] = "Error: Subcategory not found.";
        if ( $_GET['error'] == "categoryContainsArticles" ) $results['errorMessage'] = "Error: Category contains articles. Delete the articles, or assign them to another category, before deleting this category.";
    }
    if ( isset( $_GET['status'] ) ) {
        if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
        if ( $_GET['status'] == "categoryDeleted" ) $results['statusMessage'] = "SubCategory deleted.";
    }  
    require( TEMPLATE_PATH . "/admin/listSubCategories.php" );
}	  	  
function newSubCategory() {
    //var_dump("Privet"); die();
    $results = array();
    $results['pageTitle'] = "New Article SubCategory";
    $results['formAction'] = "newSubCategory";
   
    if ( isset( $_POST['saveChanges'] ) ) {
      //  var_dump ($_POST); die();
        // User has posted the category edit form: save the new category
     
       /* 
  'id' => string '' (length=0)
  'Subname' => string 'STRING' (length=6)
  'Subdescription' => string 'STRING_W' (length=8)
  'saveChanges' => string 'Save Changes' (length=12)
        */  
      $category = new SubCategory;      
     //  var_dump ( $category); 
      //  var_dump($_POST);die();


/*
/var/www/my-first-cms/admin.php:672:
object(Subcategory)[1]
  public 'id' => null
  public 'category_id' => null
  public 'Subname' => null
  public 'Subdescription' => null

/var/www/my-first-cms/admin.php:673:
array (size=5)
  'Subid' => string '' (length=0)
  'Subname' => string 'ytjtyjytjytj' (length=12)
  'category_id' => string '1' (length=1)
  'Subdescription' => string 'hgrthrtyjytj' (length=12)
  'saveChanges' => string 'Save Changes' (length=12)
*/

        $category->SubstoreFormValues($_POST);
        $category->Subinsert();
        header( "Location: admin.php?action=listSubCategories&status=changesSaved" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        // User has cancelled their edits: return to the category list
        header( "Location: admin.php?action=listSubCategories" );
    } else {
        // User has not posted the category edit form yet: display the form
       $results['subcategories']= new SubCategory;
        $data = Category::getList(); 
        $results['categories'] = $data['results'];



        //  var_dump($results['subcategories']); die();
        require( TEMPLATE_PATH . "/admin/EditSubCategories.php" );
    }
}

function editSubCategories() {
    $results = array();
    $results['pageTitle'] = "Edit Article SubCategory";
    $results['formAction'] = "editSubCategories"; 
    // var_dump($_POST); die();
    if ( isset( $_POST['saveChanges'] ) ) {
    
        // User has posted the category edit form: save the category changes
        if (!$subcategory = SubCategory::SubgetById( (int)$_POST['Subid']) ) {
          header( "Location: admin.php?action=listSubCategories&error=SubcategoryNotFound" );
          return;
           
        }
        // var_dump($_POST); die();
        $subcategory->SubstoreFormValues( $_POST );
        $subcategory->Subupdate();
        header( "Location: admin.php?action=listSubCategories&status=changesSaved" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        // User has cancelled their edits: return to the category list
        header( "Location: admin.php?action=listSubCategories" );
    } else { 
        // User has not posted the category edit form yet: display the form
    
       $results['subcategories'] = SubCategory::SubgetById( (int)$_GET['SubcategoryId']);
    //   var_dump($results['subcategories']); die();
       
        $data = Category::getList(); 
        $results['categories'] = $data['results'];

        // var_dump($results['categories']); die();
/*
  public 'id' => int 2
  public 'Subname' => string 'h' (length=1)
  public 'Subdescription' => string 'ws' (length=2)
 */    
       
    
        require( TEMPLATE_PATH . "/admin/EditSubCategories.php" );
    }

}
function deleteSubCategory() {
  // var_dump($_GET['Subid']); die();
    if ( !$subcategory = SubCategory::SubgetById( (int)$_GET['Subid'] ) ) {
        header( "Location: admin.php?action=listSubCategories&error=SubcategoryNotFound" );
        return;
    }
  //var_dump($subcategory->id);die();
  $articles = Article::getList( 1000000, $subcategory->id);
    if ( $articles['totalRows'] > 0 ) {
        header( "Location: admin.php?action=listCategories&error=categoryContainsArticles" );
        return;
    }


   $subcategory->Subdelete();
   header("Location: admin.php?action=listSubCategories&status=categoryDeleted");
}

    





