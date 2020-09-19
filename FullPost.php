<?php require_once("INCLUDES/DB.php");?>
<?php require_once("INCLUDES/Functions.php"); ?>
<?php require_once("INCLUDES/Sessions.php");  ?>
<?php $SearchQueryParameter =$_GET["id"]; ?>
<?php
  if(isset($_POST["submit"])){
     $Name=$_POST["CommenterName"];
     $Email=$_POST["CommenterEmail"];
     $Comment=$_POST["CommenterThoughts"];
     date_default_timezone_set("Asia/Kolkata");
      $CurrentTime=time();
       $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);


     if(empty($Name)||empty($Email)||empty($Comment)){
      $_SESSION["ErrorMessage"] = "All fields must be fiiled out";
        Redirect_to("FullPost.php?id={$SearchQueryParameter}");
       
       }elseif (strlen($Comment)>500) {  
         $_SESSION["ErrorMessage"] = "Comment should be less tha 500 characters";
        Redirect_to("FullPost.php?id={SearchQueryParameter}");
       }else{
        // Query to insert comment in db when everyting is fineg
        global $ConnectingDB;
        $sql="INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
        $sql .="VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
        $stmt= $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':name',$Name);
        $stmt->bindValue(':email',$Email);
        $stmt->bindValue(':comment',$Comment);
        $stmt->bindValue(':postIdFromURL',$SearchQueryParameter);
        $Execute=$stmt->execute();
        if($Execute)
        {
          $_SESSION["SuccessMessage"]="Comment submited,it will show on the page if approved by the admin";
          Redirect_to("FullPost.php?id={$SearchQueryParameter}");
        }else{
          $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
         Redirect_to("FullPost.php?id={$SearchQueryParameter}");
        }

       }
} //Ending of Submit Button if-condition

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	  <meta name="viewport" content="width=device-width , initial-scale=1.0">
	     <meta http-equiv="X-UA-Compatible" content="IE=edge">
	       <script src="https://kit.fontawesome.com/9dd2d32fa7.js" crossorigin="anonymous"></script>
	          <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&family=Roboto&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&display=swap" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="css/publicbasicdesign.css">
            <link rel="stylesheet" type="text/css" href="css/fitaboutandcontactus.css">
	<title>Full Post Page</title>
</head>
<body>
   <!-- only for obile and tablet users -->
<div class="side-nav-bar">
  <button class="hide"><i class="fas fa-times fa-2x"></i></button><br>
   <ul class="screen-ul">
      <li class="screen-li"><a href="Blog.php">Home</a></li>
      <li class="screen-li"><a href="ContactUs.php">Contact Us</a></li>
      <li class="screen-li"><a href="AboutUs.php">About Us</a></li>
        <li class="screen-li"><a href="Gallery.html">Gallery</a></li>   
   </ul>
</div>
<!-- end of screen readers -->
<!-- Navbar start -->
<nav>



  <a href="Blog.php"><img class="logo" src="logoandproimage/logosmall.png"></a>
  <button class="click-show"><i class="fas fa-bars fa-2x"></i></button>
      <ul class="desktop-ul">
      <a href="Blog.php" class="desktopmenu-link"><li>Home</li></a>
      <a href="ContactUs.php" class="desktopmenu-link"><li>Contact Us</li></a>
    <a href="AboutUs.php" class="desktopmenu-link"><li>About Us</li></a>
       <a href="Gallery.html" class="desktopmenu-link"><li>Gallery</li></a>  
   </ul>
</nav>
<!----- end of navbar -->

<!-- header start -->
      <div class="post-container-parent">
      <?php 
       echo ErrorMessage();
       echo SuccessMessage();
        ?>
    <div class="post-container">
       <div class="grid-container">
     <div class="main-postcontent">
  	 	 <?php
  	 	 global $ConnectingDB;
  	 	 if(isset($_GET["SearchButton"])){
  	 	 	$Search = $_GET["Search"];
             $sql = "SELECT * FROM posts WHERE datetime LIKE :search
             OR title LIKE :search
             OR category LIKE :search
             OR post LIKE :search";
             $stmt = $ConnectingDB->prepare($sql);
             $stmt->bindValue(':search','%'.$Search.'%');
             $stmt->execute();
  	 	 }else
  	 	 	{
          $PostIdFromURL=$_GET["id"];
          if(!isset($PostIdFromURL)){
            $_SESSION["ErrorMessage"] = "Bad Request !";
            Redirect_to("Blog.php");
          }
  	 	 $sql = "SELECT * FROM posts WHERE id='$PostIdFromURL'";
  	 	 $stmt = $ConnectingDB->query($sql);
       $Result =$stmt->rowcount();
       if($Result!=1){
        $_SESSION["ErrorMessage"]="Bad Request";
        Redirect_to("Blog.php?page=1");
       }
  	 	}
  	 	// default sql query
  	 	 while($DataRows = $stmt->fetch()){
  	 	 	        $PostId  =     $DataRows["id"];
                    $DateTime =    $DataRows["datetime"];
                    $PostTitle =   $DataRows["title"];
                    $Category =    $DataRows["category"]; 
                    $Admin =       $DataRows["author"];
                    $Image =       $DataRows["image"];
                    $PostText =    $DataRows["post"];
  	 	 ?>
  	 	  <div class="post faders">
        <h1><?php echo htmlentities($PostTitle); ?></h1>
        <img src="UPLOAD/<?php echo htmlentities($Image);?>">
          <div class="post-summary">Category: 
            <a class="anchor-underline" href="Blog.php?category=<?php echo htmlentities($Category);?>"><?php echo htmlentities($Category);?></a>  & Written by <span><?php echo htmlentities($Admin); ?></span> On <span><?php echo htmlentities($DateTime); ?></span> 
           </div>
          <p><?php echo nl2br($PostText); ?></p>
     </div>
  	<?php } ?>
<!-- Comment Part Start -->
<div class="comment-section">

      <div class="user-comment-area faders">
          <form action="FullPost.php?id=<?php echo $SearchQueryParameter;?>" method="post">
            <div class="comment-container">
              <p>Your email address will not be published. Required fields are marked * .</p>
              <h5 class="name">Leave a reply</h5>
              <div class="comment-content">
                  <div class="input-group">
                      <span><i class="fas fa-user"></i></span>
                  <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="" autocomplete="off">
                </div>
                  <div class="input-group">
                  <span><i class="fas fa-envelope"></i></span>
                  <input class="form-control" type="text" name="CommenterEmail" placeholder="email" value="" autocomplete="off">
                </div>
                <br>
                 <textarea name="CommenterThoughts" class="form-control" placeholder="comment"></textarea> 
                 <input type="submit" name="submit" value="post comment">
              </div>

           </div>

          </form>

        </div>
  	<!-- Comment Part End -->
    <!-- Fetching existing comment start -->
<?php if(ApproveCommentsAccordingtoPost($SearchQueryParameter)>0) { ?>
<div class="already-existcomment-container faders">
<h2 class="name">Comments</h2>
<?php
global $ConnectingDB;
$sql = "SELECT * FROM comments 
WHERE post_id='$SearchQueryParameter' AND status='ON'";
$stmt = $ConnectingDB->query($sql);
while($DataRows = $stmt->fetch()){
  $CommentDate = $DataRows['datetime'];
 $CommenterName = $DataRows['name'];
 $CommentContent =$DataRows['comment']; 
  
 ?>
    <div class="already-existcomment">
      <img class="img-fluid" src="IMAGES/comment.png">
       <div class="comment">
          <h3><?php  echo $CommenterName; ?></h3>
            <p><span>#</span> <?php  echo $CommentDate; ?></p>
              <p><?php echo $CommentContent; ?></p>
         </div>
    </div>
<?php } ?>
</div>
<?php } ?>
<!-- --------------- -->
     </div>
    </div>
  	 <!-- Main area End -->
      <!-- side area start -->
     <div class="aside-parent">
      <div class="aside-content">
         <div class="creative-container faders">
            <div class="creative-backcont"></div>
          <div>
          <div class="article">
            <h1 class="lead-head">Fitness</h1>
            <p>Fitness as a term is contextual. It would describe as being fit for taking on challenges set in front of you.One should always be mentally fit and physically fit.Being mentally fit is important for critical thinking in daily operations. Being physically fit is important so you are able to handle the physical challenges life puts in front of you.</p></div>          
      </div>
      </div>
      <br>
               <div class="aside_cate_postcont sliders from-right">
            <div class="Categories-list">
               <h2 class="lead-head">Categories</h2>             
                <?php 
                  global $ConnectingDB;
                  $sql = "SELECT  * FROM category ORDER BY id desc";
             $stmt=$ConnectingDB->query($sql);
             while ($DataRows=$stmt->fetch()) {
               $CategoryId=$DataRows["id"];
               $CategoryName=$DataRows["title"];  
               
            ?>
            <a href="Blog.php?category=<?php echo $CategoryName; ?>"><div class="anchor-underline"><?php echo $CategoryName; ?></div></a><br>
          <?php } ?>
          
        </div>
        <div class="recent-container">
            <h2 class="lead-head">Recent Posts</h2>
            <div class="recent-post">
              <?php global $ConnectingDB;
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
               $stmt=$ConnectingDB->query($sql);
              while($DataRows=$stmt->fetch()){
                $Id =      $DataRows["id"];
                $Title =   $DataRows["title"];
                $DateTime =$DataRows["datetime"];
                $Image =   $DataRows["image"];
                 ?>
              <div class="media">
                <img src="UPLOAD/<?php echo htmlentities($Image);?>"alt="">
                <div class="recent-post-text">
                  <a class="anchor-underline" href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank"><?php echo htmlentities($Title); ?></a>
                  <p><?php echo htmlentities($DateTime); ?></p>
                </div>
              </div>
            <?php } ?>
            </div>  
            </div>
          </div>       
      </div>

       </div>
     </div>
   <!-- side area end -->

</div>
</div>
<!-- end of header -->

  <!-- footer start -->
   <footer>
    <div class="footer-wrapper">
    <h1>All progress takes place outside the comfort zone</h1>
    <div class="footer-flex">
      <div class="fit-explore-li">
        <h3 class="footer-heading">Explore</h3>
        <ul>
          <li><a href="Blog.php">Home</a></li>
          <li><a href="AboutUs.php">About Us</a></li>
          <li><a href="ContactUs.php">Contact Us</a></li>
          <li><a href="Gallery.html">Gallery</a></li>
        </ul>
      </div>
      <div class="fit-latestupdate">
        <h3 class="footer-heading">Latest Update</h3>
       <p>We soon gonna update a fitness course where you will get tutorials on yoga , martial-arts , meditation and lot more.</p>
       <br>
       <p>Contact - contactfitwithsid@gmail.com</p>
      </div>
      <div class="fit-follow">
        <h3 class="footer-heading">Follow Us</h3>
        <ul>
          <li><a href="https://www.facebook.com/Siddharth-MartialArts-481309835637621/"><div class="fitsocial-links"><i class="fab fa-facebook-f fa-2x"></i></div></a></li>
          <li><a href="https://www.instagram.com/siddharth_martial_arts"><div class="fitsocial-links"><i class="fab fa-instagram fa-2x"></i></div></a></li>
          <li><a href="https://mobile.twitter.com/sharmas11751840"><div class="fitsocial-links"><i class="fab fa-twitter fa-2x"></i></div></a></li>
          <li><a href="https://www.youtube.com/channel/UCCl7msUpsMXu46N-GMyveCg"><div class="fitsocial-links"><i class="fab fa-youtube fa-2x"></i></div></a></li>
        </ul>
     </div>
    </div>
    <div class="admin-login-terms">
      <a href="Login.php">Admin Login</a>
      <a href="policy.html">Privacy Policy</a>
    </div>
    <div class="copyright-para">
    <p>Copyright &copy <span id="date"></span> fitwithsid | All Rights Reserved.</p>
  </div>
       </div>
      </footer>
<!-- end of footer -->


 <script src="publicnav.js"></script>
</body>
</html>