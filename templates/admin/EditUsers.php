<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>
<!--        <?php echo "<pre>";
            print_r($results);
            print_r($data);
        echo "<pre>"; ?> Данные о массиве $results и типе формы передаются корректно-->

        <h1><?php echo $results['pageTitle']?></h1>

        <form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
       <input    name="UserId" value="<?php echo $results['user']->id ?>">
    <?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
    <?php } ?>
  
          
             
            <ul>
              <li>
                <label for="title">Login</label>
                <input type="text" name="login" id="Login" placeholder="Login" required autofocus maxlength="255" value="<?php echo  htmlspecialchars($results['user']->login) ?>" />
              </li>

              <li>
                <label for="summary">Password</label>
                <textarea name="password" id="Password" placeholder="Password" required maxlength="20" style="height: 5em;"><?php echo htmlspecialchars($results['user']->password)  ?></textarea>
              </li>  
              
        
              <li>   
                <label for="Active">Active</label>
                 Текущая активность:  <?php echo htmlspecialchars($results['user']-> Active)  ?>
                <input type=hidden name="Active" value="0" >
                <input type=checkbox name="Active" value="1" >
              </li>

            </ul>

            <div class="buttons">
              <input type="submit" name="saveChanges" value="Save Changes" />
              <input type="submit" formnovalidate name="cancel" value="Cancel" />
            </div>

        </form>

    <?php if (1==1) { ?>
        
          <p><a href="admin.php?action=deleteUser&amp;UserId=<?php echo $results['user']->id ?>" onclick="return confirm('Delete This User?')">
                  Delete This User
              </a>
          </p>
    <?php } ?>
	  
<?php include "templates/include/footer.php" ?>

              