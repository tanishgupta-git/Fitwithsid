<?php require_once("INCLUDES/Sessions.php");  ?>
<?php 
$NameError="";
$EmailError="";
$MessageError="";
     if(isset($_POST['submit']))
     {
       if(empty($_POST["name"])){
        $NameError = "Name is Required *";
      }
    else
     {$Name = Test_user_input($_POST["name"]);
      if(!preg_match("/^[A-Za-z. ]*$/",$Name))
         {$NameError = "Only Letter and Whitespaces are allowed in name";}
      }
      if(empty($_POST["email"])){
    $EmailError = "Email is Required *";
          }
          else
      {
        $Email = Test_user_input($_POST["email"]);
         if(!preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/" , $Email))
         {
            $EmailError = "Invalid email format";
           }
       }
    if(empty($_POST["message"])){
      $MessageError = "Message is Required *";
    }
    else
    {
       $Message = Test_user_input($_POST["message"]);
       if(strlen($Message)>2000)
       {
        $MessageError = "Message  should be less than 2000 characters";
       }
    }
if(!empty($_POST["name"])&&!empty($_POST["email"])&&!empty($_POST["message"]))
{if((preg_match("/^[A-Za-z. ]*$/",$Name)==true)&&(preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/" , $Email)==true))
{if(strlen($Message)<2000)
  {
    $mailTo = "contactfitwithsid@gmail.com";
    $headers = "From: ". $Email;
    $txt = "You have recieved an email from".$name.".\n\n".$Message;
    mail($mailTo,$txt,$headers);
     $_SESSION["SuccessMessage"] = "All fields must be fiiled out";
  }
  else{
    $MessageError = "Message should be less than 2000 characters";
  }
          
}
else
{
  $_SESSION["ErrorMessage"] = "Please fill the correct information";
}
}

    }
function Test_User_Input($Data)
{return $Data; }
?>
<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
	   <meta name="viewport" content="width=device-width , initial-scale=1.0">
	     <meta http-equiv="X-UA-Compatible" content="IE=edge">
	        <script src="https://kit.fontawesome.com/9dd2d32fa7.js" crossorigin="anonymous"></script>
	        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap" rel="stylesheet">
          <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed&display=swap" rel="stylesheet">
          <!-- linking css files-->
	        <link rel="stylesheet" type="text/css" href="css/publicbasicdesign.css">
	         <link rel="stylesheet" type="text/css" href="css/fitaboutandcontactus.css">
	<title>ContactUs</title>
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
<div class="info-container">
	   <div class="info">
	      <p class="jumpers">GOT A QUESTION?</p>
	        <p>We’re here to help and answer any question you might have. We look forward to hearing from you.</p>
	     <span><i class="fas fa-envelope-open-text fa-3x"></i><span>
      </div>
  </div>
   <div class="parent-container">
       <div class="clip-container"></div>
         <div class="form-container faders">
   	       <h1 class="display-head">Contact Us</h1>

             <form action="ContactUs.php" method="post">
              <span class="error"><?php echo $NameError;?></span>
  	          <div class="parent-input">
                 <input type="text" class="animated-input" name="name" id="name" autocomplete="off">
                  <label for="name" class="text">Name</label>
                    <span class="animated-line"></span>
                  </div>
                      <span class="error"><?php echo $EmailError; ?></span>
  <div class="parent-input">
           <input type="email" class="animated-input" name="email" id="email" autocomplete="off">
              <label for="email" class="text">Email</label>
                <span class="animated-line"></span>
              </div>
              <span class="error"><?php echo $MessageError; ?></span>
    <textarea name="message" rows="3" id="message" placeholder="message"></textarea>

        <input type="submit" name="submit" value="Submit">
          <span class="assurence-msg">*Anonymity of message is guaranteed</span>.
      </form>
     </div>
     <div class="aside-message faders">
     	    <h3>How Can We Help ?</h3>
            <p>Consistent exercise and proper nutrition will ensure that your quality of life is maintained. It seems difficult to do all this in right direction by yourself but don't worry we are here to help you, fill the form and send a Message. we will get back to you soon.</p>
             <h3>Be the Content writer</h3>
              <p>If you are a fitness expert and want to be the part of our team you just have to fill the form and send it to us.</p>   
      </div>
    </div>
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