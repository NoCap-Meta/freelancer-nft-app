<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include_once 'session.php';
include_once 's3.php';
if(isset($_REQUEST)){
  $imgpath = $_REQUEST['imgpath'];  
  $fieldVal = $imgpath;
}
if(!isset($imgpath) || $imgpath == ""){
  $fieldVal = "";
  $imgpath = "https://t3.ftcdn.net/jpg/03/45/05/92/360_F_345059232_CPieT8RIWOUk4JqBkkWkIETYAkmz2b75.jpg";
}
if ($_SESSION['admin'] != 1) {
  // header("location: /");
}
?>
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="/fonts/icomoon/style.css">

<link rel="stylesheet" href="/css/owl.carousel.min.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="/css/bootstrap.min.css">

<!-- Style -->
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/index.css">
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300&display=swap" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="js/bootstrap-tagsinput-main/dist/bootstrap-tagsinput.css">
<link rel="stylesheet" href="js/bootstrap-tagsinput-main/examples/assets/app.css">


<title>New Listing</title>

</head>
<body onload="onload()">




<!-- END header -->

<?php include 'global/top.php'; ?>
<!-- Container-fluid starts-->
<div class="container main-container">
<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
<h4>Create a Listing</h4>
</div>
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 wallet-but">
<a class="btn btn-warning" href="/create"><i class="fa fa-refresh"></i> Start all over</a> <a class="btn btn-primary" href="/listings"><i class="fa fa-eye"></i> All Listings</a>
</div>
</div><br><Br>
<div class="row flex-lg-row">
<div class="col-md-12 col-lg-5 col-xl-5">
<img src="" class="home-services"><br>
<div class="col-sm-12 imgUp">
<div class="imagePreview"></div>
<form action="" method="post" id="imgUpload" enctype="multipart/form-data">
<input type="hidden" name="page" value="create">
<input type="hidden" name="imageOnly" value="1">
<label class="btn btn-primary" style="width: 87%; cursor:pointer">
<i class="fa fa-arrow-up"></i> Upload<input type="file" name="fileToUpload" id="fileToUpload" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
</label>
<button class="btn btn-success" id="saveButton" type="submit" name="submit" style="width: 87%; cursor:pointer">
<i class="fa fa-save"></i> Save
</label>
</form>
</div><!-- col-2 -->
<?php
if($asset['audiopath']!=""){ ?>
  <audio autoplay="" class="AssetMedia--audio" style="width: 100%" controls="" controlslist="nodownload" data-testid="AssetMedia--audio" loop="" preload="none" src="<?php echo $asset['audiopath'];?>"></audio>
  <?php } ?>
  </div>
  <div class="col-md-12 col-lg-7 col-xl-7">
  <input type="hidden" id="assetImg" value="<?php echo $fieldVal;?>">
  <h4><input type="text" class="form-control" id="assetTitle" value="<?php echo $asset['title'];?>" placeholder="Enter Asset Title"></h4><br>
  Sale Price: <input type="number" step="0.01" id="assetPrice" class="form-control" value="<?php echo $asset['price'];?>" placeholder="0.00" style="width: 100px; display:inline"> INR<br>
  
  Quantity: <input id="assetQty" type="text" class="form-control" placeholder="1" step="1" min="1" value="<?php echo $asset['qty'];?>" style="width: 100px; display:inline"> NFTs<br><br>
  
  <span class="tags">Tags: <span class="margin-right: 20px;"></span>              
  <input type="text" class="form-control" value='<?php echo $tags;?>'  data-role="tagsinput" id="tags" style="display:inline;">
  </span><Br><Br>
  
  <textarea id="assetBody" class="form-control description" rows="5"><?php echo $asset['body'];?></textarea><br>
  <select class="form-control" id="author">
  <option value="">Select Artist</option>
  <?php
  $artists = mysqli_query($con, "SELECT * FROM authors");
  while($r = mysqli_fetch_assoc($artists)){ ?>
  <option value="<?php echo $r['authorid'];?>"><?php echo $r['name'];?></option>
  <?php } ?>
  </select>
  <button class="social-but" id="submit-but" onclick="savechanges()">save changes</button>
  
  
  </div>
  </div>
  
  </div>
  
  
  <?php include 'global/footer.php'; ?>
  
  
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/main.js"></script>
  <script src="js/bootstrap-tagsinput-main/dist/bootstrap-tagsinput.min.js"></script>
  <script src="js/bootstrap-tagsinput-main/dist/bootstrap-tagsinput/bootstrap-tagsinput-angular.min.js"></script>
  <script src="js/web3-modal.js?v=010"></script>
  <script src="js/web3-login.js?v=010"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script>
  $(document).ready(function () {
    $('#example').DataTable({
      autoWidth: true,
      columnDefs: [
        {
          targets: ['_all'],
          className: 'mdc-data-table__cell',
        },
      ],
    });
  });
  function savebio(){
    document.getElementById("submit-bio").disabled = true;
    var assetid = "<?php echo $_REQUEST['id'];?>";
    var authorAbout = document.getElementById("authorAbout").value;
    var payload = [assetid, authorAbout];
    var url = "/ajax/artists/update?data="+JSON.stringify(payload);
    console.log(url);
    $.get(url, function(data) {
      var j = JSON.parse(data);
      if (j.status == 200) {
        window.location.reload();
      } else {
        Swal.fire({
          title: 'Error',
          text: j.msg,
          icon: 'error',
          confirmButtonText: 'Cool'
        })
      }
    });
    document.getElementById("submit-bio").disabled = false;
  }
  function savechanges(){
    document.getElementById("submit-but").disabled = true;
    var assetImg = document.getElementById("assetImg").value;
    var assetid = "<?php echo $_REQUEST['id'];?>";
    var assetTitle = document.getElementById("assetTitle").value;
    var assetPrice = document.getElementById("assetPrice").value;
    var assetQty = document.getElementById("assetQty").value;
    var assetBody = document.getElementById("assetBody").value;
    var artist = document.getElementById("author").value;
    var tags = $("#tags").tagsinput('items');
    if (assetImg != "" && assetTitle!="" && assetQty>=1 && assetPrice!="" && assetBody!="" && artist!=""){
      var payload = [assetImg, assetid, assetTitle, assetPrice, assetQty, assetBody, tags, artist];
      var url = "/ajax/assets/create?data="+JSON.stringify(payload);
      console.log(url);
      $.get(url, function(data) {
        var j = JSON.parse(data);
        if (j.status == 200) {
          window.location.href = "progress.php?id="+j.msg;
        } else {
          Swal.fire({
            title: 'Error',
            text: j.msg,
            icon: 'error',
            confirmButtonText: 'Cool'
          })
        }
      });
    } else {
      Swal.fire({
            title: 'Error',
            text: "Fields are mandatory",
            icon: 'error',
            confirmButtonText: 'Cool'
          })
    }
    document.getElementById("submit-but").disabled = false;
  }
  function action(assetid, field, value) {
    var payload = [assetid, field, value];
    var url = "/ajax/assets/changeStatus?data="+JSON.stringify(payload);
    $.get(url, function(data) {
      var j = JSON.parse(data);
      if (j.status == 200) {
        window.location.reload();
      } else {
        Swal.fire({
          title: 'Error',
          text: j.msg,
          icon: 'error',
          confirmButtonText: 'Cool'
        })
      }
    });
  }
  function refreshkey(partnerid) {
    var payload = [partnerid];
    var url = "/ajax/artists/refreshkey?data="+JSON.stringify(payload);
    $.get(url, function(data) {
      var j = JSON.parse(data);
      if (j.status == 200) {
        window.location.reload();
      } else {
        Swal.fire({
          title: 'Error',
          text: j.msg,
          icon: 'error',
          confirmButtonText: 'Cool'
        })
      }
    });
  }
  $(function() {
    $(document).on("change",".uploadFile", function()
    {
    		var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
              uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
              document.getElementById("saveButton").style.display = "block";
              document.getElementById("fileToUpload").value = this.result;
            }
        }      
    });
  });
  function onload(){
    document.getElementById("saveButton").style.display = "none";
  }
  function saveImage(){
    var localPath = document.getElementById("fileToUpload").value;
    $("#imgUpload").submit();
  }
  </script>
  <style>
  .modal-title {
    color: #000 !important;
  }
  #example *, #example_wrapper * {
    color: #fff !important;
  }
  #example div label {
    color: #fff !important;
  }
  .wallet-but {
    text-align:right;
  }
  body {
    padding-bottom: 0px !important;
    margin-bottom: 0px !important;
  }
  </style>
  <style>
  nft-card-front, .card, .card-inner {
    background-color: #fff; 
  }
  .bootstrap-tagsinput, .bootstrap-tagsinput .tag, .bootstrap-tagsinput .label {
    color: #fff !important;
  }
  .bootstrap-tagsinput {
    background-color: #000;
    padding: 10px 10px;
    border: 0px;
    border-bottom: 1px solid #fff;
  }
  .bootstrap-tagsinput .tag {
    font-size: 14px !important;
    border: 1px solid #fff;
    padding: 3px 7px;
    color: #fff;
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
    padding: 10px 15px;
    letter-spacing: 5px;
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
  .imagePreview {
    width: 360px;
    height: 360px;
    background-position: center center;
    background:url('<?php echo $imgpath;?>');
    background-color:#fff;
    background-size: contain;
    background-repeat:no-repeat;
    display: inline-block;
    box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
  }
  .btn-primary1
  {
    display:block;
    border-radius:0px;
    box-shadow:0px 4px 6px 2px rgba(0,0,0,0.2);
    margin-top:-5px;
  }
  .imgUp
  {
    margin-bottom:15px;
  }
  </style>
  
  </body>
  </html>