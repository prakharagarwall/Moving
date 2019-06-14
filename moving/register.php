<?php
	ob_start();
	session_start();
	/*
	if( isset($_SESSION['user'])!="" ){
		header("Location: home.php");
	}*/
	include_once 'dbconnect.php';

	$error = false;

	if ( isset($_POST['btn-signup']) ) {

	
		
		// clean user inputs to prevent sql injections
		$fname = trim($_POST['fname']);
		$fname = strip_tags($fname);
		$fname = htmlspecialchars($fname);
		
		echo "lname";
		$lname = trim($_POST['lname']);
		$lname = strip_tags($lname);
		$lname = htmlspecialchars($lname);
		
		echo "username";
		$username = trim($_POST['username']);
		$username = strip_tags($username);
		$username = htmlspecialchars($username);

		echo "email";
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);

		echo "password";
		$pass = trim($_POST['password']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);

		// basic name validation
		if (empty($fname)) {
			$error = true;
			$fnameError = "Please enter your first name.";
		}
		if (empty($lname)) {
			$error = true;
		$lnameError = "Last Name must have atleat 3 characters.";}
		if (strlen($fname) < 3) {
			$error = true;
			$fnameError = "First Name must have atleat 3 characters.";
			}
		if (strlen($lname) < 3) {
			$error = true;
			$lnameError = "Last Name must have atleat 3 characters.";
		} 
		if (!preg_match("/^[a-zA-Z ]+$/",$fname)) {
			$error = true;
			$fnameError = "First Name must contain alphabets and space.";
		}
		if (!preg_match("/^[a-zA-Z ]+$/",$lname)) {
			$error = true;
			$lnameError = "Last Name must contain alphabets and space.";
		}

		if (empty($username)) {
			$error = true;
			$usernameError = "Please enter User name.";
		}
		if (strlen($username) <5) {
			$error = true;
		$usernameError = "User Name must have atleat 5 characters.";}
		
		//basic email validation
		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) || !preg_match('/@.+\./',$email) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		} else {
			// check email exist or not
			$query = "SELECT email FROM users WHERE email='$email'";
			$result = mysqli_query($conn,$query);
			$count = mysqli_num_rows($result);
			if($count!=0){
				$error = true;
				$emailError = "Provided Email is already in use.";
			}
		}
		// password validation
		$uppercase = preg_match('@[A-Z]@', $pass);
		$lowercase = preg_match('@[a-z]@', $pass);
		$number    = preg_match('@[0-9]@', $pass);
		$special    = preg_match('@[\@\#\%\^\&\$\?\*\+\-]@', $pass);
		if (empty($pass)){
			$error = true;
			$passError = "Please enter password.";
		}
		if(strlen($pass) < 8) {
			$error = true;
			$passError = "Password must have atleast 6 characters.";
		}
		else if(!$uppercase) {
			$error = true;
			$passError = "Password must contain atleast one upper case letter";
		}
		else if(!$lowercase) {
			$error = true;
			$passError = "Password must contain atleast one lower case letter";
		}
		else if(!$number) {
			$error = true;
			$passError = "Password must contain atleast one number";
		}
		else if(!$special) {
			$error = true;
			$passError = "Password must contain atleast one special character";
		}

		// password encrypt using SHA256();
		$password = hash('sha256', $pass);
         echo "validated";

         echo $error;
		// if there's no error, continue to signup
		if( !$error ) {
        echo "inside";
			$query = "INSERT INTO users(userName,fname,lname,email,password) VALUES('$username','$fname','$lname','$email','$password')";
			$res = mysqli_query($conn,$query);
			echo "query inserted";
			if ($res) {
				$errTyp = "success";
				$errMSG = "Successfully registered, you may login now";
				unset($name);
				unset($email);
				unset($pass);
				header("Location: login.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
			}

		}
	}
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--=== Favicon ===-->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    <title>Moving Company</title>

    <!--=== Bootstrap CSS ===-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!--=== Slicknav CSS ===-->
    <link href="assets/css/plugins/slicknav.min.css" rel="stylesheet">
    <!--=== Magnific Popup CSS ===-->
    <link href="assets/css/plugins/magnific-popup.css" rel="stylesheet">
    <!--=== Owl Carousel CSS ===-->
    <link href="assets/css/plugins/owl.carousel.min.css" rel="stylesheet">
    <!--=== Gijgo CSS ===-->
    <link href="assets/css/plugins/gijgo.css" rel="stylesheet">
    <!--=== FontAwesome CSS ===-->
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <!--=== Theme Reset CSS ===-->
    <link href="assets/css/reset.css" rel="stylesheet">
    <!--=== Main Style CSS ===-->
    <link href="style.css" rel="stylesheet">
    <!--=== Responsive CSS ===-->
    <link href="assets/css/responsive.css" rel="stylesheet">


    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="loader-active">

    <!--== Preloader Area Start ==-->
    <div class="preloader">
        <div class="preloader-spinner">
            <div class="loader-content">
                <img src="assets/img/preloader.gif" alt="JSOFT">
            </div>
        </div>
    </div>
    <!--== Preloader Area End ==-->

    <!--== Header Area Start ==-->
    <header id="header-area" class="fixed-top">
        <!--== Header Top Start ==-->
        <div id="header-top" class="d-none d-xl-block">
            <div class="container">
                <div class="row">
                    <!--== Single HeaderTop Start ==-->
                    <div class="col-lg-3 text-left">
                        <i class="fa fa-map-marker"></i> Richardson, Texas
                    </div>
                    <!--== Single HeaderTop End ==-->

                    <!--== Single HeaderTop Start ==-->
                    <div class="col-lg-3 text-center">
                        <i class="fa fa-mobile"></i> +1 214 931 7441
                    </div>
                    <!--== Single HeaderTop End ==-->

                    <!--== Single HeaderTop Start ==-->
                    <div class="col-lg-3 text-center">
                        <i class="fa fa-clock-o"></i> Mon-Sun 09.00 - 21.00
                    </div>
                    <!--== Single HeaderTop End ==-->

                    <!--== Social Icons Start ==-->
                    <div class="col-lg-3 text-right">
                        <div class="header-social-icons">
                            <a href="#"><i class="fa fa-behance"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                    <!--== Social Icons End ==-->
                </div>
            </div>
        </div>
        <!--== Header Top End ==-->

        <!--== Header Bottom Start ==-->
        <div id="header-bottom">
            <div class="container">
                <div class="row">
                    <!--== Logo Start ==-->
                    <div class="col-lg-4">
                        <a href="index3.html" class="logo">
                            <img src="assets/img/logo.png" alt="JSOFT">
                        </a>
                    </div>
                    <!--== Logo End ==-->

                          <!--== Main Menu Start ==-->
                    <div class="col-lg-8 d-none d-xl-block">
                        <nav class="mainmenu alignright">
                            <ul>
                                <li class="active"><a href="index3.php">Home</a>
                                </li>
                                <li><a href="about.php">About</a></li>
                                <li><a href="services.php">services</a></li>
                                <li><a href="contact.php">Contact</a></li>
								<li><a href="faq.php">FAQ</a></li>
								<li><a href="login.php">Login/Signup</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!--== Main Menu End ==-->
                </div>
            </div>
        </div>
        <!--== Header Bottom End ==-->
    </header>
    <!--== Header Area End ==-->

    <!--== Page Title Area Start ==-->
    <section id="page-title-area" class="section-padding overlay">
        <div class="container">
            <div class="row">
                <!-- Page Title Start -->
                <div class="col-lg-12">
                    <div class="section-title  text-center">
                        <h2>Sign up</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                        <p>Sign Up to get more details about our services</p>
                    </div>
                </div>
                <!-- Page Title End -->
            </div>
        </div>
    </section>
    <!--== Page Title Area End ==-->

    <!--== Login Page Content Start ==-->
    <section id="lgoin-page-wrap" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-8 m-auto">
                	<div class="login-page-content">
                		<div class="login-form">
                			<h3>Sign Up</h3>
							<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
								<div class="name">
									<div class="row">
										<div class="col-md-6">
											<input type="text" name="fname" onfocus="this.placeholder = ''" required placeholder="First Name">
											<span><?php echo $fnameError; ?></span>
										</div>
										<div class="col-md-6">
											<input type="text" name="lname" onfocus="this.placeholder = ''" required placeholder="Last Name">
											<span><?php echo $lnameError; ?></span>
										</div>
									</div>
								</div>
								<div class="username">
									<input type="email" name="email" onfocus="this.placeholder = ''" required placeholder="Email">
									<span><?php echo $emailError; ?></span>
								</div>
								<div class="username">
									<input type="text" name="username" onfocus="this.placeholder = ''" required placeholder="Username">
									<span><?php echo $usernameError; ?></span>
								</div>
								<div class="password">
									<input type="password"name="password" onfocus="this.placeholder = ''" required placeholder="Password">
									
									<span><?php 
									if($passError)
									echo $passError; 
									else 
									echo "Password must contain 1 uppercase, 1 lowercase letter, 1 number and 1 special character atleast";
										?></span>
								</div>
								<div class="log-btn">
									<button type="submit" name="btn-signup"><i class="fa fa-check-square"></i> Sign Up</button>
								</div>
							</form>
                		</div>
                		<div class="login-other">
                			<span class="or">or</span>
                			<a href="#" class="login-with-btn facebook"><i class="fa fa-facebook"></i> Signup With Facebook</a>
                			<a href="#" class="login-with-btn google"><i class="fa fa-google"></i> Signup With Google</a>
                		</div>
                		<div class="create-ac">
                			<p>Have an account? <a href="login.php">Sign In</a></p>
                		</div>
                		<div class="login-menu">
                			<a href="about.php">About</a>
                			<span>|</span>
                			<a href="contact.php">Contact</a>
                		</div>
                	</div>
                </div>
        	</div>
        </div>
    </section>
    <!--== Login Page Content End ==-->

    <!--== Footer Area Start ==-->
    <section id="footer-area">
        <!-- Footer Widget Start -->
        <div class="footer-widget-area">
            <div class="container">
                <div class="row">
                    <!-- Single Footer Widget Start -->
                    <div class="col-lg-4 col-md-6">
                        <div class="single-footer-widget">
                            <h2>About Us</h2>
                            <div class="widget-body">
                                <img src="assets/img/logo.png" alt="JSOFT">
                                <p>Movingcompany helps people and businesses move their goods from one place to another. It offers all inclusive services for
								relocations like packing, loading, moving, unloading, unpacking, arranging of items to be shifted. 
								Additional services may include cleaning services for houses, offices or warehousing facilities.</p>

                                <div class="newsletter-area">
                                    <form action="index.html">
                                        <input type="email" placeholder="Subscribe Our Newsletter">
                                        <button type="submit" class="newsletter-btn"><i class="fa fa-send"></i></button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Single Footer Widget End -->
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- Single Footer Widget Start -->
                    <div class="col-lg-4 col-md-6">
                        <div class="single-footer-widget">
                            <h2>get touch</h2>
                            <div class="widget-body">
                                <p>We are available 24*7, Contact us below</p>

                                <ul class="get-touch">
                                    <li><i class="fa fa-map-marker"></i> Richardson Texas</li>
                                    <li><i class="fa fa-mobile"></i> +12149317441</li>
                                    <li><i class="fa fa-envelope"></i> MovingCompany@gmail.com</li>
                                </ul>
                                <a href="https://goo.gl/maps/M3grMfvRbJ82" class="map-show" target="_blank">Show Location</a>
                            </div>
                        </div>
                    </div>
                    <!-- Single Footer Widget End -->
                </div>
            </div>
        </div>
        <!-- Footer Widget End -->

        <!-- Footer Bottom Start -->
        <div class="footer-bottom-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p>
							Copyright &copy;<script>document.write(new Date().getFullYear());</script> </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Bottom End -->
    </section>
    <!--== Footer Area End ==-->
    <!--== Scroll Top Area Start ==-->
    <div class="scroll-top">
        <img src="assets/img/scroll-top.png" alt="JSOFT">
    </div>
    <!--== Scroll Top Area End ==-->

    <!--=======================Javascript============================-->
    <!--=== Jquery Min Js ===-->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <!--=== Jquery Migrate Min Js ===-->
    <script src="assets/js/jquery-migrate.min.js"></script>
    <!--=== Popper Min Js ===-->
    <script src="assets/js/popper.min.js"></script>
    <!--=== Bootstrap Min Js ===-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--=== Gijgo Min Js ===-->
    <script src="assets/js/plugins/gijgo.js"></script>
    <!--=== Vegas Min Js ===-->
    <script src="assets/js/plugins/vegas.min.js"></script>
    <!--=== Isotope Min Js ===-->
    <script src="assets/js/plugins/isotope.min.js"></script>
    <!--=== Owl Caousel Min Js ===-->
    <script src="assets/js/plugins/owl.carousel.min.js"></script>
    <!--=== Waypoint Min Js ===-->
    <script src="assets/js/plugins/waypoints.min.js"></script>
    <!--=== CounTotop Min Js ===-->
    <script src="assets/js/plugins/counterup.min.js"></script>
    <!--=== YtPlayer Min Js ===-->
    <script src="assets/js/plugins/mb.YTPlayer.js"></script>
    <!--=== Magnific Popup Min Js ===-->
    <script src="assets/js/plugins/magnific-popup.min.js"></script>
    <!--=== Slicknav Min Js ===-->
    <script src="assets/js/plugins/slicknav.min.js"></script>

    <!--=== Mian Js ===-->
    <script src="assets/js/main.js"></script>

</body>

</html>