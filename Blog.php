<?php require_once("INCLUDES/DB.php");?>
<?php require_once("INCLUDES/Functions.php"); ?>
<?php require_once("INCLUDES/Sessions.php");  ?>

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
	    <title>Blog Page</title>
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
<!-- starting image area containing search container -->
   <div class="search-container">
      <div class="darken-image">  
        </div>
      <div class="search-parent">
         <div class="tagline-container">
           <h1>Action is the foundational key to all success.</h1>
            <h2>The best Fitness Blog Ever</h2>
           </div>
           <div class="search-form">
      <form action="Blog.php">
          <input type="text" name="Search" placeholder="Search" value="">
           <button type="submit" name="SearchButton"><i class="fas fa-2x fa-search"></i></button>
     </form>
     </div>
         <div class="end-punch-line"><h3>Fitness blog by siddharth martial arts</h3></div>
       </div>
        </div>
<!--end of starting image area-->

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
       $checkpost = 0;
  	 	 if(isset($_GET["SearchButton"])){
  	 	 	$Search = $_GET["Search"];
             $sql = "SELECT * FROM posts WHERE datetime LIKE :search
             OR title LIKE :search
             OR category LIKE :search
             OR post LIKE :search";
             $stmt = $ConnectingDB->prepare($sql);
             $stmt->bindValue(':search','%'.$Search.'%');
             $stmt->execute();
  	 	 }else if(isset($_GET["page"])){
            $Page = $_GET["page"];
            if($Page==0||$Page<1)
             {
              $ShowPostFrom=0;
             } 
             else
            {
            $ShowPostFrom=($Page*5)-5;
          }
            $sql  = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
            $stmt= $ConnectingDB->query($sql);                         
       }//query when Category is active in the tab 
       elseif (isset($_GET["category"])){
         $Category = $_GET["category"];
         $sql = "SELECT * FROM posts WHERE category=:categoryName";
         $stmt=$ConnectingDB->prepare($sql);
         $stmt->bindValue(':categoryName',$Category);
         $stmt->execute();

       }
        // default sql query
       else
  	 	 	{
  	 	 $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
  	 	 $stmt = $ConnectingDB->query($sql);
       $Page=0;
  	 	}
  	 	 while($DataRows = $stmt->fetch()){
  	 	 	            $PostId  =     $DataRows["id"];
                    $DateTime =    $DataRows["datetime"];
                    $PostTitle =   $DataRows["title"];
                    $Category =    $DataRows["category"]; 
                    $Admin =       $DataRows["author"];
                    $Image =       $DataRows["image"];
                    $PostText =    $DataRows["post"];
                    $checkpost++;
  	 	 ?>
  	 	 <div class="post faders">
        <h1><?php echo htmlentities($PostTitle); ?></h1>
  	 	 	<img src="UPLOAD/<?php echo htmlentities($Image);?>">
  	 	 		<div class="post-summary">Category: 
            <a class="anchor-underline" href="Blog.php?category=<?php echo htmlentities($Category);?>"><?php echo htmlentities($Category);?></a>  & Written by <span><?php echo htmlentities($Admin); ?></span> On <span><?php echo htmlentities($DateTime); ?></span> 
           </div>
  	 	 		<p><?php if(strlen($PostText)>150){$PostText = substr($PostText,0,150) ."...";} echo htmlentities($PostText); ?></p>
  	 	 		<a class="animatebtn" href="FullPost.php?id=<?php echo $PostId; ?>"><span></span>
            <span></span>
            <span></span>
            <span></span>Read More</a>
  	 </div>
  	<?php } ?>
    <?php if($checkpost == 0){?>
      <div class="not-found"><h1>We're sorry we couldn't find results for "<?php echo $Search ?>"</h1>
        <div>
        <h2>Here are few tips that might help</h2>
        <ul>
          <li>Check the spelling of your keyword</li>
          <li>Try alternate words or selections</li> 
          <li>Try entering a more generic keyword</li>
          <li>Try entering fewer keywords</li>
       </ul></div></div>
    <?php } ?>
    <!-- pagination start-->
      <?php if(TotalBlogPosts() > 3){ ?>
      <div class="pagination-parent">
        <ul>
        <!-- Backward button pagination -->
          <?php 
           if(isset($Page)){
            if($Page>1){
          ?>
         <li>
          <a href="Blog.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>
          </li>
          <?php } } ?>
          <!-- end of Backward button pagination -->
          <?php
          global $ConnectingDB;
          $sql = "SELECT COUNT(*) FROM posts";
          $stmt = $ConnectingDB->query($sql);
          $RowPagination = $stmt->fetch();
          $TotalPosts = array_shift($RowPagination); 
          $PostPagination=$TotalPosts/5;
          $PostPagination=ceil($PostPagination);
          for($i=1;$i <=$PostPagination;$i++){
            if(isset($Page)){
              if($i==$Page){
              ?>
              <li>
          <a href="Blog.php?page=<?php echo $i; ?>" class="page-link active"><?php echo $i; ?></a>
          </li>
          <?php }else
          {
            ?>
             <li>
          <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
          </li>

            <?php } } }
          ?>
          <!-- forward button pagination -->
          <?php 
           if(isset($Page)&&!empty($Page)){
            if($Page+1<=$PostPagination){
          ?>
         <li>
          <a href="Blog.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
          </li>
          <?php } } ?>
          <!-- end of forward button pagination -->        
        </ul>
      </div>
    <?php } ?>
    <!-- pagination end-->
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
           <p> Fitness as a term is contextual. It would describe as being fit for taking on challenges set in front of you.One should always be mentally fit and physically fit.Being mentally fit is important for critical thinking in daily operations. Being physically fit is important so you are able to handle the physical challenges life puts in front of you.</p></div>          
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

<div id="hideAll">
<div class="preloader-content">
<div class="preloadcirc two">
</div>
<div class="preloadcirc one">
</div>
<div id="content">Loading</div> 
</div>
</div>

 <!-- <script src="publicnav.js"></script> -->
<script src="publicnav.js"></script>
</body>
</html>