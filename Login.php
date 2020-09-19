<?php require_once("INCLUDES/DB.php");?>
<?php require_once("INCLUDES/Functions.php");  ?>
<?php require_once("INCLUDES/Sessions.php");   ?>
<?php 
  if(isset($_SESSION["FitUSER_Id"])){
	  Redirect_to("Dashboard.php");
      }
   if(isset($_POST["Submit"])){
      $Username = $_POST["Username"];
       $Password = $_POST["Password"];
      if(empty($Username)||empty($Password))
      {
       $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("Login.php");
      }
  else
    {
  	  $Found_Account =Login_Attempt($Username,$Password);
  	   if($Found_Account){
  		  $_SESSION["FitUSER_Id"] = $Found_Account["id"];
  		   $_SESSION["FitUsername"] = $Found_Account["username"];
            $_SESSION["FitAdminName"] = $Found_Account["aname"];
            $_SESSION["SuccessMessage"] = "Wellcome ".$_SESSION["FitAdminName"];
  		     if (isset($_SESSION["TrackingURL"])) {
         Redirect_to($_SESSION["TrackingURL"]);
        }else{
        Redirect_to("Dashboard.php");
      }
  	 }else
  		 {
  			$_SESSION["ErrorMessage"] = "Incorrect Username/Password";
            Redirect_to("Login.php");
  		}
 
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
	   <meta name="viewport" content="width=device-width , initial-scale=1.0">
	      <meta http-equiv="X-UA-Compatible" content="IE=edge">
	       <script src="https://kit.fontawesome.com/9dd2d32fa7.js" crossorigin="anonymous"></script>
           <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&family=Poppins:wght@700&display=swap" rel="stylesheet">
     <!--responsive login page design-->
	       <link rel="stylesheet" type="text/css" href="css/Login.css">
	          <title>Login</title>
</head>
<body>
<!-- NAVBAR -->
   <nav>
      <a href="Blog.php"><img class="logo" src="logoandproimage/logosmall.png"></a>
         <a href="Blog.php" class="home-link">Home</a>
   </nav>
<!----- end of navbar -->
<!-- Main Area Start -->
   <section>
       <div class="wrapper">
           <?php 
            echo ErrorMessage();
               echo SuccessMessage();
          ?>
        <!-- two absolute design div -->
         <div class="back-form divleft"></div>
            <div class="back-form divright"></div>
         <!-- from container start -->
	  	    <div class="form-container">
               <div>
                  <div class="form-wrapper">
                       <div class="icon-container">
	  				             <div class="large-device-iconcircle" >
                           <span class="user-icon"><i class="fas fa-2x fa-user"></i></span>
                          </div>
                         </div>
                     <h3>Admin Login</h3>
	  			     <div class="center-form">
	  			 	      <form class="" action="Login.php" method="post">
	  			 		        <div class="user-input">
                         <span><i class="fas fa-user inside"></i></span>	  			
                           <input type="text" class="form-control" name="Username" id="username" placeholder="username" value="" autocomplete="off">
	  			 				         <span class="animated-line"></span>
	  			 		          </div>
	  			 		    <div class="user-input">
	  			          <span><i class="fas fa-lock inside"></i></span>	  			 			
	  			            <input type="password" name="Password" id="password" placeholder="password" value="">
	  			 	          <span class="animated-line"></span>
	  			 	     </div>
	  			 	<input type="submit" name="Submit" value="Login">
	  			 	</form>
	  			 </div>
	  	</div>
    </div>
      <div class="public-message">Only admins are allowed to logged in</div>
	  	</div>
    </div>
    </section>
<!-- main area end -->

<script>
	var input = document.querySelectorAll("input");
	var line= document.querySelectorAll(".animated-line");
	for(let i=0;i<2;i++)
	{
      input[i].addEventListener("focus",function(){
	line[i].classList.add("move");
	});
      input[i].addEventListener("blur", function(){
		if(input[i].value==="")
		{
       line[i].classList.remove("move");
		}
	});
	}
	</script>
</body>
</html>