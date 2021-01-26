<?php

//phpinfo(); die();

require("config.php");
   
try {
    initApplication();
} catch (Exception $e) { 
    $results['errorMessage'] = $e->getMessage();
    require(TEMPLATE_PATH . "/viewErrorPage.php");
}
 

function initApplication()
{
    $action = isset($_GET['action']) ? $_GET['action'] : "";

    switch ($action) {
        case 'archive':
          archive();
          break;
        case 'subarchive':
          subarchive();
          break;
        case 'viewArticle':
          viewArticle();
          break;
        
        default:
          homepage();      
    }
}

       
            
            
            
            
            
        
           
  
function archive() 
{
 
    $results = [];   
 //***********Poluchenie nomera categorii iz $_GET parzmetrov 
    $categoryId = (isset( $_GET['categoryId'] ) && $_GET['categoryId'] ) ? (int)$_GET['categoryId']: null;   
//***********Zapis v massiv obecta kategorii iz funkcii getById 
    $results['category'] = Category::getById( $categoryId );
    // var_dump($results); die();
//***********Vivod tolko teh statei gde categoryId ravno result['category']
    $data = Article::getList( 100000, $results['category'] ? $results['category']->id : null );  
   //  var_dump($data); die();
//***********Zapis' v massiv vsech statei s operedelennim categoryId
    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
 //***********Vivod imeni vsech kategorii  
    $data = Category::getList();
  //  var_dump($data); die();
    $results['categories'] = array();
    foreach ( $data['results'] as $category ) {
        $results['categories'][$category->id] = $category;
    }  

    $results['pageHeading'] = $results['category'] ?  $results['category']->name : "Article Archive";
    $results['pageTitle'] = $results['pageHeading'] . " | Widget News"; 
  
    require( TEMPLATE_PATH . "/archive.php" );
}

function subarchive() 
{
    $results = [];      
    $subcategoryId = ( isset( $_GET['subcategoryId'] ) && $_GET['subcategoryId'] ) ? (int)$_GET['subcategoryId'] : null;   
    $results['subcategory'] = Subcategory::SubgetById( $subcategoryId );
    // var_dump($results); die();
    // var_dump($results['subcategory']);die();
    $data = Article::subgetList( 100000, $results['subcategory'] ? $results['subcategory']->id : null );  
     //var_dump($data); die();
    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $data = Subcategory::SubgetList();
    $results['subcategories'] = array();
    foreach ( $data['results'] as $subcategory ) {
        $results['subcategories'][$subcategory->id] = $subcategory;
    }   
    $results['pageHeading'] = $results['subcategory'] ?  $results['subcategory']->Subname : "Article Archive";
    $results['pageTitle'] = $results['pageHeading'] . " | Widget News"; 
    require( TEMPLATE_PATH . "/subarchive.php" );
 }
    
    
    
    
  












/**
 * Загрузка страницы с конкретной статьёй
 * 
 * @return null
 */
function viewArticle() 
{   
    if ( !isset($_GET["articleId"]) || !$_GET["articleId"] ) {
      homepage();
      return;
    }

    $results = array();
    $articleId = (int)$_GET["articleId"];
    $results['article'] = Article::getById($articleId);
    
    if (!$results['article']) {
        throw new Exception("Статья с id = $articleId не найдена");
    }
    
    $results['category'] = Category::getById($results['article']->categoryId);
    $results['pageTitle'] = $results['article']->title . " | Простая CMS";
    
    
    require(TEMPLATE_PATH . "/viewArticle.php");
}

/**
 * Вывод домашней ("главной") страницы сайта
 */
function homepage() 
{
    $results = array();
    $data = Article::getList(HOMEPAGE_NUM_ARTICLES);    
 // echo  $data['results'][0]->Active ; 
 // echo  $data['results'][0]->title;
  // die();
    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    //var_dump ($results['articles']);die();
    $data = Category::getList();
    $results['categories'] = array();
    foreach ( $data['results'] as $category ) { 
        $results['categories'][$category->id] = $category;
    } 
    
     $data = Subcategory::SubgetList();
      // var_dump($data); die();
     $results['subcategories']= array();
     foreach ( $data['results'] as $subcategory ) { 
        $results['subcategories'][$subcategory->id] = $subcategory;
        // var_dump($results['subcategories'][$subcategory->id] ); 
        //  echo "______________________________________________"; 
       //  var_dump($subcategory); die();
    } 
        
    
    
    $results['pageTitle'] = "Простая CMS на PHP";
    
//    echo "<pre>";
//    print_r($data);
//    echo "</pre>";
//    die();
    
    require(TEMPLATE_PATH . "/homepage.php");
    
}