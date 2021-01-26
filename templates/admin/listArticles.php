<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>
	  
    <h1>All Articles</h1>

    <?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
    <?php } ?>


    <?php if ( isset( $results['statusMessage'] ) ) { ?>
            <div class="statusMessage"><?php echo $results['statusMessage'] ?> </div>
    <?php } ?>

          <table>
            <tr>
              <th>Publication Date</th>
              <th>Article</th>
              <th>Category</th>
               <th>SubCategory</th>
              <th>Active Article</th>
              <th>Author/s</th>
            </tr>
 
<!--<?php echo "<pre>"; print_r ($results['articles'][2]->publicationDate); echo "</pre>"; ?> Обращаемся к дате массива $results. Дата = 0 -->
           <!--  <?php print_r($results)?> -->
    <?php foreach ( $results['articles'] as $article ) { ?>

            <tr onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $article->id?>'">
              <td><?php echo date('j M Y', $article->publicationDate)?></td>
              <td>
                <?php echo $article->title?>
             
              
              
              <td>
                  
             <!--   <?php echo $results['categories'][$article->categoryId]->name?> Эта строка была скопирована с сайта-->
             <!-- <?php echo "<pre>"; print_r ($article); echo "</pre>"; ?> Здесь объект $article содержит в себе только ID категории. А надо по ID достать название категории-->
            <!--<?php echo "<pre>"; print_r ($results); echo "</pre>"; ?> Здесь есть доступ к полному объекту $results -->
             
                <?php 
               
                if(isset ($article->categoryId)) {
                    echo $results['categories'][$article->categoryId]->name;                        
                }   
                else {
                echo "Без категории";
                }?>
              </td>
              
               </td>
               <td>
                  <?php 
                // var_dump($article->categoryId); 
                  
                  
          /* $results['articles'] -> articles
           * 
           * public 'id' => int 1
          public 'publicationDate' => string '1497992400' (length=10)
          public 'title' => string 'Первопроходцы ' (length=27)
          public 'categoryId' => int 12
          public 'summary' => string 'Это статья - первопроходец' (length=48)
          public 'Active' => string '0' (length=1)
          public 'SubcategoryId' => null
          public 'content' => string 'Первопроходец - человек(или статья), проложивший новые пути, открывший новые земли' (length=150)
             */     
               // var_dump($results);die();
                if(isset ($article->SubcategoryId)) {
                echo  $results['subcategories'][(int) $article->SubcategoryId]->Subname; 
                } 
                else {
                echo "Без субкатегории";
                }?>
              </td>
              
              <td>
                <?php 
                 if ( $article->Active == 1 ) {
                    echo "Active";         
                } else {
                    echo "NoActive"; 
                }  
             //   print_r ($article->Active);
                ?>
              </td>

              <td>
      
<?php 

if(isset ($authors)) {


foreach (  $authors as $authors_view  )  { 



   if ($authors_view['article_id'] == $article->id) {
    // var_dump((int) $authors_view['users_id'])  ;
    //var_dump($resultsz['user_result']);
  //  var_dump($resultsz['user_result'][(int) $article->id-1]->login)  ;

  foreach ( $resultsz['user_result'] as $a  )  { 
    if ((int) $authors_view['users_id'] == $a->id) {
  // var_dump($resultsz['user_result'][$a->id-1]->login) ;
    echo $a->login ;
 }
}


   }

 
 
   

 
             
    /*    /var/www/my-first-cms/admin.php:520:
array (size=2)
  0 => 
    array (size=2)
      'users_id' => string '1' (length=1)
      'article_id' => string '2' (length=1)
  1 => 
    array (size=2)
      'users_id' => string '2' (length=1)
      'article_id' => string '2' (length=1)
    */
  

} 

} else {
  echo "No authors";
 


  }?>
              </td>


            </tr>



    <?php } ?>

          </table>

          <p><?php echo $results['totalRows']?> article<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>

          <p><a href="admin.php?action=newArticle">Add a New Article</a></p>

<?php include "templates/include/footer.php" ?>              