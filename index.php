<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
} else {
    header('location:admin/');
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Vehicle Service Management System</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aclonica">
  <!-- Plugin CSS -->
  <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template -->
  <link href="css/freelancer.min.css" rel="stylesheet">
</head>
<body id="page-top" onload="onld();">
  <!-- Navigation 
  <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top"><h1 class="text-center" style="font-size: 40px;font-family: Aclonica, sans-serif;"><strong><em>SULALITHA SERVICE CENTRE (SSC)</em></strong></h1></a>
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Vehicle Service Management System (VSMS)</a>
      <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
    
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="user/">User</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="admin/">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

   Header 
  <header class="masthead bg-primary text-white text-center">
    <div class="container">
        <img class="img-fluid mb-5 d-block mx-auto" src="img/profile.png"  height="350" width="350">
      <h1 class="text-uppercase mb-0"></h1>
      <hr class="star-light">
      <h2 class="font-weight-light mb-0">Developed using PHP & MySQL</h2>
    </div>
  </header>


  <div class="copyright m-t-40 py-4 text-center text-white">
    <div class="container">
      <small>2021 © Vehicle Service Management System</small>
    </div>
  </div>

   Scroll to Top Button (Only visible on small and extra-small screen sizes) 
  <div class="scroll-to-top d-lg-none position-fixed ">
    <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
      <i class="fa fa-chevron-up"></i>
    </a>
  </div> -->

 
  <script type="text/javascript">
      function onld(){
          document.location.href="admin/";
      }
      </script>
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
  <!-- Contact Form JavaScript -->
  <script src="js/jqBootstrapValidation.js"></script>
  <script src="js/contact_me.js"></script>
  <!-- Custom scripts for this template -->
  <script src="js/freelancer.min.js"></script>

</body>

</html>
