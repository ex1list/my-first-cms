
<?php include "templates/include/header.php" ?>
    <ul id="headlines">  

 

    <?php foreach ($results['articles'] as $article)   
    { if ( ! $article->Active == 1 ) {continue;}  ?>
        <li class='<?php echo $article->id?>'>
            
           
            
            <h2>
               
                <span class="pubDate">
                    <?php echo date('j F', $article->publicationDate)?>
                </span>
                
                
               <!-- NAME OF ARTICLE -->
                <a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>">
                    <?php echo htmlspecialchars( $article->title )?>
                </a>
                
                
                <!-- NAME OF CATEGORY "IN CATEGORY" -->
                <?php if (isset($article->categoryId)) { ?>
                <span class="category">
                        in category:
                        <a href=".?action=archive&amp;categoryId=<?php echo $article->categoryId?>">
                            <?php echo htmlspecialchars($results['categories'][$article->categoryId]->name )?>
                        </a>     
                    </span>
               <?php } 
                else { ?>
                    <span class="category">
                        <?php echo "Без категории"?>
                    </span>
                <?php } ?>
                
               
                <!-- NAME OF SUBCATEGORY "IN SUBCATEGORY" -->
                <?php if (isset($article->SubcategoryId)) { ?>
                <span class="category"> 
                   in SubCategory:
                    <a href=".?action=subarchive&amp;subcategoryId=<?php echo $article->SubcategoryId?>">
                    <?php echo htmlspecialchars($results['subcategories'][$article->SubcategoryId]->Subname) ?>
                </span>                         
                  <?php }  
                else { ?>
                    <span class="category">
                        <?php echo "Без cубкатегории"?>
                    </span>
                <?php } ?>
                    
            </h2>
            
             <!-- NAME OF SUMMARY -->
            <p class="summary"><?php echo htmlspecialchars($article->summary)?></p>
            
            
            <!--  идентификатор загрузки (анимация) - ожидания выполнения-->
            <img id="loader-identity" src="JS/ajax-loader.gif" alt="gif">                 
       <ul class="ajax-load">
                <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="ajaxArticleBodyByPost" data-contentId="<?php echo $article->id?>">Показать продолжение (POST)</a></li>
                <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="ajaxArticleBodyByGet" data-contentId="<?php echo $article->id?>">Показать продолжение (GET)</a></li>
                <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="ajaxPOSTnew" data-contentId="<?php echo $article->id?>">(POST) -- NEW</a></li> 
                <li><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="ajaxGETnew" data-contentId="<?php echo $article->id?>">(GET)  -- NEW</a></li> 
            </ul>    
            
            
            
              <!-- VIEW ARTICLES -->
            <a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="showContent" data-contentId="<?php echo $article->id?>">Показать полностью</a>
        
        
        
        
        </li>
    <?php } ?>
    </ul>
    <p><a href="./?action=archive">Article Archive</a></p>
<?php include "templates/include/footer.php" ?>

    
