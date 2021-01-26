
<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>

        <h1><?php echo $results['pageTitle']?></h1>

        <form action="admin.php?action=<?php echo $results['formAction']?>" method="post"> 
          <!-- Обработка формы будет направлена файлу admin.php ф-ции newSubCategory либо editSubCategory в зависимости от formAction, сохранённого в result-е -->
     
          
         <?php //  var_dump((int) $results['subcategories']->id); die();   ?>  
          
          <input type="hidden" name="Subid" value="<?php echo $results['subcategories']->id ?>"/>
 
    <?php if ( isset( $results['errorMessage'] ) ) { ?>  
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
    <?php } ?>

        <ul>
          <li>
            <label for="Subname">SubCategory Name</label>
            <input type="text" name="Subname" id="name" placeholder="Name of the category" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['subcategories']->Subname )?>" />
          </li>
          
       


              <li>
                <label for="categoryId"> Category</label>
                <select name="category_id">
                
                <?php   foreach ( $results['categories'] as $category ) { ?>
                  <option value="<?php echo $category->id?>"  ><?php echo htmlspecialchars($category->name)?></option>
                <?php } ?>
                </select>
              </li>

          <li>
            <label for="Subdescription">SubDescription</label>
            <textarea name="Subdescription" id="description" placeholder="Brief description of the category" required maxlength="1000" style="height: 5em;"><?php echo htmlspecialchars( $results['subcategories']->Subdescription )?></textarea>
          </li>

        </ul>
        <div class="buttons">
          <input type="submit" name="saveChanges" value="Save Changes" />
          <input type="submit" formnovalidate name="cancel" value="Cancel" />
        </div>
      </form>
    <?php  if ( $results['subcategories']->id ) { ?>
          <p><a href="admin.php?action=deleteSubCategory&amp;Subid=<?php echo $results['subcategories']->id ?>" onclick="return confirm('Delete This SubCategory?')">Delete This SubCategory</a></p>
    <?php } ?>
<?php include "templates/include/footer.php" ?>

