<?php
include_once "global/connect.php"; 
$path = "nft/payments/razorpay/";
include_once $path."credentials.php";
$id = $_REQUEST['asset'];
$asset = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM assets WHERE assetid='$id'"));
$authorRow = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `authors` WHERE `authorid` = '".$asset['authorid']."'"));
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
  <body onload="executeNode()">
    <input type="hidden" id="assetid" value="<?php echo $_REQUEST['asset'];?>" placeholder="Enter Asset ID">
    <input type="hidden" id="amount" value="<?php echo $asset['price'];?>" placeholder="Enter Amount">
    <input type="hidden" id="currency" value="<?php echo $asset['currency'];?>" placeholder="Enter Currency">
    <input type="hidden" id="author-title" value="<?php echo $authorRow['name'];?>" placeholder="Enter Asset Title">
    <input type="hidden" id="asset-title" value="<?php echo $asset['title'];?>" placeholder="Enter Asset Title">
    


      
    <!-- END header -->

    <?php include 'global/top.php'; ?>
      <!-- Container-fluid starts-->
      <div class="container main-container-2">
        <div class="row" style="text-align:center">
          <div class="col-md-12 col-sm-12 col-xl-12" style="margin-top: 70px;">
              <span class="head-title">
                <font style="font-weight:400;">Kickstart Your Journey Into the world of<br><font style="font-weight:600">NFTs & Concerts</font>
                <br><a href="/interest" class="social-but">Get your artisteverse?</a><Br><span style="font-size: 16px;">Already on our platform? <a href="/login">Log in</a></span>
              </span>
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
        padding: 10px 30px;
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
      function buyNow(){
          var walletAddress = document.getElementById("walletAddress").value;
          if (walletAddress.length == 42 && walletAddress.slice(0, 2) == "0x") {
            document.getElementById("buynow-button").disabled = true;
            var assetid = document.getElementById("assetid").value;
            var url = "<?php echo $path;?>init.php?asset="+assetid+"&walletAddress="+walletAddress;
            $.get(url, function(data) {
                var j = JSON.parse(data);
                if (j.status == 200){
                    initRazorpay(j.msg);   
                } else {
                    alert(j.msg);
                }
            });
          } else {
            alert("Invalid Wallet Address");
          }
      }
      function insertRow(orderid, res){
          var assetid = "<?php echo $_REQUEST['asset'];?>";
          var payload = [assetid, orderid, res];
          var url = "<?php echo $path;?>create.php?data="+JSON.stringify(payload);
          showOverlay();
          $.post(url, function(data) {
              var j = JSON.parse(data);
              if (j.status == 200){
                initiateTransfer(orderid);
              } else {
                alert(j.msg);
              }
          });
      }
      function initiateTransfer(orderid){
        var url = "<?php echo $path; ?>redirect.php?orderid="+orderid;
        console.log(url);
        $.get(url, function(data) { 
          executeNode();
          document.getElementById("text").innerHTML = '<font style="font-size: 20px">If you haven\'t received the NFT, please wait up to 30 mins, or contact us on shekhar@nocapmeta.in thereafter</font>';
            // setTimeout(function(){
            //     window.location.reload();
            // }, 15000);
        });
        document.getElementById("buynow-button").disabled = false;
      }
      function executeNode(){
        $.get("nft/test.php", function(data) {
        });
      }
      function initRazorpay(orderid){
          var options = {
              "key": "<?php echo $api_key;?>", // Enter the Key ID generated from the Dashboard
              "amount": document.getElementById("walletAddress").value, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
              "currency": document.getElementById("currency").value,
              "name": document.getElementById("asset-title").value,
              "description": document.getElementById("author-title").value,
              "image": "<?php echo $thumbnail;?>",
              "order_id": orderid, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
              "handler": function (response){
                  var res = {};
                  res["Payment ID"] = response.razorpay_payment_id;
                  res["Order ID"] = response.razorpay_order_id;
                  res["Signature"] = response.razorpay_signature;
                  console.log(res);
                  insertRow(orderid, res)
              },
              "notes": {
                  "walletAddress": document.getElementById("walletAddress").value
              },
              "theme": {
                  "color": "#3399cc"
              }
          };
          var rzp1 = new Razorpay(options);
          rzp1.on('payment.failed', function (response){
                  var res = {};
                  res["Error Code"] = response.error.code;
                  res["Error Description"] = response.error.description;
                  res["Error Source"] = response.error.source;
                  res["Error Step"] = response.error.step;
                  res["Error Reason"] = response.error.reason;
                  res["Error Order ID"] = response.error.metadata.order_id;
                  res["Error Payment ID"] = response.error.metadata.payment_id;
                  console.log(res);
                  insertRow(orderid, res)
          });
          rzp1.open();
        }
    </script>
    <script>
			/* To connect using MetaMask */
			async function connectWallet() {
			 if (window.ethereum) {
				await window.ethereum.request({ method: "eth_requestAccounts" });
				window.web3 = new Web3(window.ethereum);
				const account = web3.eth.accounts;
				console.log("Metamask present");
				//Get the current MetaMask selected/active wallet
				const walletAddress = account.givenProvider.selectedAddress;
				document.getElementById("walletAddress").value = walletAddress;
        document.getElementById("walletAddress").readOnly = true;
			 } else {
				alert("No wallet available");
			 }
			}
		</script>
  </body>
</html>
