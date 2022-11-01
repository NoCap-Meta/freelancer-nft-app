<?php
include_once "global/connect.php"; 
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title><?php echo $asset['title'];?></title>
    
  </head>
  <body>
    <input type="hidden" id="assetid" value="<?php echo $_REQUEST['asset'];?>" placeholder="Enter Asset ID">
    <input type="hidden" id="amount" value="<?php echo $asset['price'];?>" placeholder="Enter Amount">
    <input type="hidden" id="currency" value="<?php echo $asset['currency'];?>" placeholder="Enter Currency">
    <input type="hidden" id="author-title" value="<?php echo $authorRow['name'];?>" placeholder="Enter Asset Title">
    <input type="hidden" id="asset-title" value="<?php echo $asset['title'];?>" placeholder="Enter Asset Title">
    


      
    <!-- END header -->

    <div class="page-body">
      <header role="banner">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark  navbar-fixed-top">
          <div class="container">
            <a class="navbar-brand" href="https://www.metastarmedia.io/" target="_blank"><img src="images/logo.png" class="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <?php include 'global/nav.php'; ?>
          </div>
        </nav>
      </header><br>
    </div>
      <!-- Container-fluid starts-->
      <div class="container main-container-2">
        <div class="row" style="text-align:center">
          <div class="col-md-12 col-sm-12 col-xl-12" style="margin-top: 0px;">
              <span class="head-title">
                <font style="font-weight:400;">Welcome back! Sign in below
                </span><br>
                <div class="form-fields">
                    <input type="email" id="email" placeholder="Email Address" class="future-field"><br>
                    <input type="email" id="password" placeholder="Account Password" class="future-field"><br>
                </div>
                <!-- <br><a href="/interest" class="social-but">Get your artisteverse?</a><Br><span style="font-size: 16px;">Already on our platform? <a href="/login">Log in</a></span> -->
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xl-6 col-lg-6 custom-style" style="margin-top: 0px; text-align:right;">
                        <!-- <i class="fa fa-arrow-left"></i> Get Started</i> -->
                    </div>
                    <div class="col-md-6 col-sm-12 col-xl-6 col-lg-6" style="margin-top: 0px; text-align:left">
                        <button class="social-but" onclick="login(this.id)" id="login_button">Log In</i></button>
                    </div>
                </div>
          </div>
        </div>
        
      </div>
                
      <?php //include 'global/footer.php'; ?>
      
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.7.4-rc.1/web3.min.js"></script>
    <style>
      .custom-style {
        vertical-align: middle;
      }
      .form-fields {
        margin-top: 40px;
      }
      .future-field {
        margin-bottom: 20px;
        width: 350px !important;
        padding: 10px 20px;
      }
      #text{
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 50px;
        color: white;
        transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
      }
    </style>

    <div id="overlay">
      <div id="text" style="text-align:center">Do not navigate away.<br>Please wait.</div>
    </div>
    <script>
      function showOverlay() {
        document.getElementById("overlay").style.display = "block";
      }
      function hideOverlay() {
        document.getElementById("overlay").style.display = "none";
      }
    </script>
    <style>
      nft-card-front, .card, .card-inner {
        background-color: #fff; 
      }
      .sale-tag {
        /* border-radius: 0.3em; */
        padding: 10px 10px;
        background-color: #1f1f1f;
        margin-bottom: 15px;
        padding-bottom: 20px;
      }
      .tags {
        font-size: 18px;
      }
      .card, .card-header, .card-body {
        color: #fff;
        background-color: #000;
        padding-left: 0px;
      }
      .card-header {
        border-bottom: 1px solid #fff;
        margin-top: 20px;
      }
      .description {
        font-size: 15px;
      }
      .tags a {
        border: 1px solid blue;
        padding: 5px;
        font-size: 14px;
        color: #fff;
        margin-right: 0px;
        text-transform: uppercase;
      }
      .home-services {
        width: 100%;
        height: auto;
      }
      .main-container-2 {
        /* margin-top: 200px; */
        /* padding-top: 100px; */
      }
      .content-block {
        /* vertical-align:middle !important; */
        /* padding-top: 100px!important; */
        padding-bottom: 100px!important;
      }
      @media only screen and (max-width: 600px) {
        .main-container-2 {
          margin-top: 100px;
        }
        .flex-column-reverse {
          display: flex !important;
          flex-direction: column-reverse !important;
        }
      }
      .social-but {
        background-color: #fff;
        color: #000;
        text-transform: uppercase;
        font-size: 14px;
        font-weight: bold;
        padding: 10px 50px;
        letter-spacing: 2px;
        margin-top: 10px;
        margin-bottom: 10px;
      }
      .form-control, .form-control:active {
        color: #fff !important;
        background-color: #000 !important;
        border-radius: 0px !important;
        /* letter-spacing: 1px; */
        /* text-transform: uppercase; */
        padding: 5px 10px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-left: 0px !important;
      }
      .social-but2 {
        background-color: #fff;
        color: #000;
        text-transform: uppercase;
        font-size: 14px;
        font-weight: bold;
        padding: 5px 15px;
        letter-spacing: 5px;
      }
      #overlay {
        position: fixed; /* Sit on top of the page content */
        display: none; /* Hidden by default */
        width: 100%; /* Full width (cover the whole page) */
        height: 100%; /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.9); /* Black background with opacity */
        z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
        cursor: pointer; /* Add a pointer on hover */
      }
    </style>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
      function login(id){
            var email_field = document.getElementById("email");
            var password_field = document.getElementById("password");
            var email = email_field.value;
            var password = password_field.value;
            var button_id = document.getElementById(id);
            button_id.disabled = true;
            email_field.disabled = true;
            password_field.disabled = true;
            var payload = [email, password];
            var url = "auth.php?data="+JSON.stringify(payload);
            console.log(url);
            $.get(url, function(data) {
                var j = JSON.parse(data);
                if (j.status == 200) {
                    var redirectURL = document.getElementById("redirectURL").value;
                    if (redirectURL != ""){
                        window.location.href = redirectURL;
                    } else {
                        window.location.href = "wallets";
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: j.msg,
                        icon: 'error',
                        confirmButtonText: 'Cool'
                    });
                    button_id.disabled = false;
                    email_field.disabled = false;
                    password_field.disabled = false;
                }
            });
        }
    </script>
    <script>
			/* To connect using MetaMask */
			
		</script>
  </body>
</html>
