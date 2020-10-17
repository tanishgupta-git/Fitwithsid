<?php require_once("INCLUDES/DB.php");?>
<?php require_once("INCLUDES/Functions.php");  ?>
<?php require_once("INCLUDES/Sessions.php");   ?>

<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); 
?>
<!DOCTYPE html>
<html>
 <head>
	<meta charset="utf-8">
	  <meta name="viewport" content="width=device-width , initial-scale=1.0">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+HK&display=swap" rel="stylesheet">
	     <script src="https://kit.fontawesome.com/9dd2d32fa7.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" type="text/css" href="css/basicadmindesign.css">
              <link rel="stylesheet" type="text/css" href="css/privateonlyadmin.css">
	         <title>Dashboard</title>
    </head>
<body>
  <!-- navbar for small screen only -->
    <div class="mobile-screen-only">
        <a href="#"><img class="logo" src="logoandproimage/logosmall.png"></a>
          <button class="click-show"><i class="fas fa-bars fa-2x"></i></button>
    </div>
    <!-- end of navbar for small screen only -->
    <div class="wrapper">
    <!-- NAVBAR -->
      <div class="nav-parent">
        <nav>
         <a href="#"><img class="logo" src="logoandproimage/logosmall.png"></a>
          <button class="click-hide"><i class="fas fa-times fa-2x"></i></button><br>
       <p class="li-clone">Features</p> 
       <ul>  
            <li>
        		<a href="Dashboard.php"><i class="fas fa-cog"></i> Dashboard</a>
        	</li>
        	<li>
        		<a href="Posts.php"><i class="fab fa-readme"></i> Posts</a>
        	</li>
        	<li>
        		<a href="Categories.php"><i class="fas fa-folder"></i> Categories</a>
        	</li>
        	<li>
        		<a href="Admins.php"><i class="fas fa-users"></i> Manage Admins</a>
        	</li>
        	<li>
        		<a href="Comments.php"><i class="fas fa-comments"></i> Comments</a>
        	</li>
        	<li>
        		<a href="Blog.php?page=1"><i class="fas fa-blog"></i> Live Blog</a>
        	</li>
            <li>
               <a href="Logout.php" ><i class="fas fa-user-times"></i> Logout</a>
           </li>
       </ul>   	
     </nav>
  </div>
<!----- end of navbar -->

<!-- header start -->
<div class="main-area">
    <header>
	   	 	<div>
              <p class="page-define"><i class="fas fa-cog"></i> Dashboard</p>
            </div>
             <div class="edit-buttongroup">
          <div>
                <a href="AddNewPost.php"><i class="fas fa-edit"></i> Add New Post
                </a>
             </div>
              <div>
                <a href="Categories.php"><i class="fas fa-folder-plus"></i> Add New Category
                </a>
             </div>
             <div>
                <a href="Admins.php"><i class="fas fa-user-plus"></i>  Add New Admin
                </a>
             </div>
             <div>
                <a href="Comments.php"><i class="fas fa-check"></i> Approve Comments
                </a>
             </div>
          </div>
       </header>

<!-- end of header -->
<!-- Main area -->
     <section>
      <?php 
            echo ErrorMessage();
       echo SuccessMessage();
       ?>
       <div class="sub-all-area">
       <!-- left side area start -->
         <div class="statistics-sum">
             
                <div class="total-count">
                    <p>Posts</p>
                    <h4>
                        <i class="fab fa-readme"></i>
                        <?php TotalPosts(); ?>
                    </h4>  
                 </div>
                 
                  <div class="total-count">
                    <p>Categories</p>
                    <h4>
                        <i class="fas fa-folder"></i>
                        <?php TotalCategories(); ?>
                    </h4>  
                 </div>
                 
                <div class="total-count">
                    <p>Admins</p>
                    <h4>
                        <i class="fas fa-users"></i>
                        <?php TotalAdmins(); ?>
                    </h4>  
                 </div>
                 
                <div class="total-count">
                    <p>Comments</p>
                    <h4>
                        <i class="fas fa-comments"></i>
                        <?php TotalComments(); ?>
                    </h4>  
                 </div>
                 
         </div>
          <!-- left side area end -->

          <!-- right side area -->
           <div class="table-container">
               <p>Top Posts</p>
               <div class="responsive-table">
               <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Date&Time</th>
                        <th>Author</th>
                        <th>Comments</th>
                        <th>Details</th>
                    </tr>
                </thead>
                  <?php 
                  $SrNo =0;
                  global $ConnectingDB;
            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
            $stmt = $ConnectingDB->query($sql);
            while($DataRows=$stmt->fetch())
            {
            $PostId = $DataRows["id"];
            $DateTime = $DataRows["datetime"];
            $Author = $DataRows["author"];
            $Title = $DataRows["title"];
            $SrNo++;         
            ?>
            <tbody>
                <tr>
                    <td><?php echo $SrNo; ?></td>
                    <td><?php echo $Title; ?></td>
                    <td><?php echo $DateTime ?></td>
                    <td><?php echo $Author ?></td>
                    <td>
                        <?php
                        $Total=ApproveCommentsAccordingtoPost($PostId);
                        if($Total>0)
                        { ?>
                         <span class="badge approve">   
                          <?php  echo $Total;?>
                      </span>
                     <?php }
                        ?>
                        <?php
                        $Total=DisapproveCommentsAccordingtoPost($PostId);
                        if($Total>0)
                        { ?>
                         <span class="badge disapprove">   
                          <?php  echo $Total;?>
                      </span>
                     <?php }
                        ?>
                        </td>
                    <td><a target="_blank" href="FullPost.php?id=<?php echo $PostId; ?>"><span class=" btn preview">Preview</span></a></td>
                </tr>
            </tbody>
        <?php } ?>
               </table>
           </div>
           </div>
          <!-- end right side area -->
        </div>
       </section>
<!-- end of main area -->
</div>
</div>

<script src="slidemenu.js"></script>
</body>
</html>