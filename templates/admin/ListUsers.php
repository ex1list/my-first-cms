<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>
	  
    <h1>All Users</h1>

    <?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
    <?php } ?>

 
    <?php if ( isset( $results['statusMessage'] ) ) { ?>
            <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
    <?php } ?>

          <table>
            <tr>
              <th>Active</th>
              <th>Login</th>
              <th>Password</th>
               
            </tr>

   
    <?php  foreach ( $results['user'] as $b ) {  ?>
       
            <tr onclick="location='admin.php?action=EditUsers&amp;UserId=<?php echo $b->id?>'">
                
              <td> <?php echo $b->Active ?></td>
              <td>
              <?php echo $b->login ?>
              </td>
              <td>
                <?php echo $b->password ?>
              </td>
             
            </tr>
     
    <?php   } ?>
              
          </table>

        
 
          <p><a href="admin.php?action=newUsers">Add a New Users</a></p>

<?php include "templates/include/footer.php" ?>              