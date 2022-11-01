<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include_once 'session.php';
include_once 's3.php';

$admin = 1;
$assetid = $_REQUEST['id'];
$row = mysqli_query($con, "SELECT * FROM assets WHERE assetid='$assetid'");

if ($admin == 1) {
  if ($_REQUEST['mapAsset']==1){
    if ($_REQUEST['val']==1){
      mysqli_query($con, "UPDATE assets SET audiopath=attachment WHERE assetid='$assetid'");
      header("location: edit?id=".$_REQUEST['id']);
    }
  }
  if ($_REQUEST['changeState']==1){
    $state = $_REQUEST['val'];
    if ($state != 5) {
      mysqli_query($con, "UPDATE assets SET state='$state' WHERE assetid='$assetid'");
      header("location: edit?id=".$_REQUEST['id']);
    } else {
      if (mysqli_fetch_assoc($row)['opensea']==""){
        header("location: edit?error=pending&id=".$_REQUEST['id']);
      }
    }
  }
}
$row = mysqli_query($con, "SELECT * FROM assets WHERE assetid='$assetid'");
if (mysqli_num_rows($row) > 0){
    $row = mysqli_fetch_assoc($row);
    $asset = $row;
    $authorid = $row['authorid'];
    $author = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM authors WHERE authorid='$authorid'"));
} else {
    header("location: /");
}
if ($_SESSION['admin'] != 1) {
    // header("location: /");
}

$fieldVal = $row['image'];
$imgpath = $fieldVal;
$tags = json_decode($asset['tags']);
$tags = implode(', ', $tags);
// $tags = '"'.implode('", "', $tags).'"';
function openseaParser($con, $assetid){
  $row = mysqli_query($con, "SELECT * FROM assets WHERE opensea!='' AND assetid='$assetid'");
  while($r = mysqli_fetch_assoc($row)){
      $assetid = $r['assetid'];
      $full_url = $r['opensea'];
      $url = explode("/", $full_url);
      $contract = $url[5];
      $token = $url[6]; 
      $updateSql = "UPDATE assets SET contractAddress='$contract', tokenId='$token' WHERE assetid='$assetid'";
      mysqli_query($con, $updateSql);
  }
}
openseaParser($con, $assetid);
$progress = 20*($asset['state']);
if($progress==0){
  $progress = 5;
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
    

    <title><?php echo $row['title']; ?></title>
    
  </head>
  <body onload="onload()">



      
    <!-- END header -->

    <?php include 'global/top.php'; ?>
      <!-- Container-fluid starts-->
    <div class="container main-container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <h4><?php echo $row['title']; ?></h4>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 wallet-but">
                <a class="btn btn-primary" href="/create"><i class="fa fa-plus"></i> Create a Listing</a>
            </div>
        </div><br>
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="progress">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress; ?>%"><?php echo $progress; ?>%</div>
            </div>
          </div>
        </div>
<Br>
        <div class="row flex-lg-row">
            <div class="col-md-12 col-lg-5 col-xl-5">
              
              <div class="col-sm-12 imgUp">
                <div class="imagePreview"></div>
                <form action="" method="post" id="imgUpload" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
                  <label class="btn btn-primary" style="width: 87%; cursor:pointer" id="imgUploadLabel">
                    <i class="fa fa-arrow-up"></i> Reupload<input type="file" name="fileToUpload" id="fileToUpload" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                  </label>
                  <button class="btn btn-success" id="saveButton" type="submit" name="submit" style="width: 87%; cursor:pointer">
                    <i class="fa fa-save"></i> Save
                  </label>
                </form>
              </div>
              <?php
              if($asset['audiopath']!=""){ ?>
              <div class="col-sm-12">
                <audio autoplay="" class="AssetMedia--audio" style="width: 87%" controls="" controlslist="nodownload" data-testid="AssetMedia--audio" loop="" preload="none" src="<?php echo $asset['audiopath'];?>"></audio>
              </div>
              <?php }
              if ($asset['audiopath']=="" && $asset['attachment']!="") { ?>
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Is the <a href="<?php echo $row['attachment']; ?>" target="_blank">attachment</a> an audio file?</label><br>
                  <small>You cannot undo this option</small><br><Br>
                  <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
                    <select class="form-control" name="val" style="width: 75%; display: inline">
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                    </select>
                    <button class="btn btn-primary" type="submit" name="mapAsset" value="1"><i class="fa fa-save"></i></button>
                  </form>
                </div>
              </div>
              <?php } ?>
              <?php
              if ($admin == 1){ ?>
              <div class="col-sm-12">
                <div class="form-group"><br><Br>
                  <label>Current Stage: <?php echo $asset['state']; ?></label><br>
                  <?php if($_REQUEST['error']=="pending"){
                    echo '<div class="alert alert-warning">You need to map Opensea Listing first</div>';
                  }?>
                  <?php if($asset['state']!=5) { ?>
                  <form action="" method="get">
                    <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
                    <select class="form-control" name="val" style="width: 75%; display: inline">
                      <option value="0" <?php if($asset['state']==0){echo "selected";}?>>0: Request Created</option>
                      <option value="1" <?php if($asset['state']==1){echo "selected";}?>>1: Discussion</option>
                      <option value="2" <?php if($asset['state']==2){echo "selected";}?>>2: Commercials</option>
                      <option value="3" <?php if($asset['state']==3){echo "selected";}?>>3: In Progress</option>
                      <option value="4" <?php if($asset['state']==4){echo "selected";}?>>4: Review</option>
                      <option value="5" <?php if($asset['state']==5){echo "selected";}?>>5: Complete</option>
                    </select>
                    <button class="btn btn-primary" type="submit" name="changeState" value="1"><i class="fa fa-save"></i></button>
                  </form>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="col-md-12 col-lg-7 col-xl-7">
              <h4><input type="text" class="form-control" id="assetTitle" value="<?php echo $asset['title'];?>"></h4><br>
                Sale Price: <input type="number" step="0.01" id="assetPrice" class="form-control" value="<?php echo $asset['price'];?>" style="width: 100px; display:inline"> <?php echo $asset['currency'];?><br>
                
                Quantity: <input type="text" readonly="true" class="form-control" value="<?php echo $asset['qty'];?>" style="width: 100px; display:inline"> NFTs<br><br>
                
              <span class="tags">Tags: <span class="margin-right: 20px;"></span>              
              <input type="text" class="form-control" value='<?php echo $tags;?>'  data-role="tagsinput" id="tags" style="display:inline;">
              </span><Br><Br>
              
              <textarea id="assetBody" class="form-control description" rows="5"><?php echo $asset['body'];?></textarea><br>
              <?php if($admin == 1){ ?>
                Image, Video, Audio, or 3D Model<br>
                <small>File types supported: JPG, PNG, GIF, SVG, MP4, WEBM, MP3, WAV, OGG, GLB, GLTF. Max size: 80 MB</small><br><br>
                <?php if($row['attachment']==""){ ?>
                  <form action="" method="post" id="imgUpload2" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
                  <input type="hidden" name="page" value="edit">
                  <input type="hidden" name="imageOnly" value="0">
                  <div class="file-drop-area" id="file-upload-area">
                    <span class="choose-file-button">Choose files</span>
                    <span class="file-message" id="file-message">or drag and drop files here</span>
                    <input type="file" name="fileToUpload" id="fileToUpload1" class="file-input" onchange="uploadAttachment()">
                    </div>
                  <input type="submit" style="margin-left: 5px;" name="submit" value="submit" id="attachmentUploadButton" value="Upload" class="btn btn-primary">
                  </form>
                <?php } else { ?>
                  File Uploaded: <a target="_blank" href="<?php echo $row['attachment'];?>">Click here</a><br><br>
                <?php } ?><br>
                <div class="form-group">
                  <label for="openseaURL">Enter OpenSea URL</label><br>
                  <small>This will help the system autofetch the contract address and the token ID from the listing</small><br><br>
                <input type="url" placeholder="Enter Opensea Listing URL" value="<?php echo $asset['opensea'];?>" class="form-control"><br>
              <?php } ?>
              
              <button class="social-but" id="submit-but" onclick="savechanges()">save changes</button>
              <div class="card card-default">
                <div class="card-header">
                  About Creator
                </div>
                <div class="card-body">
                  <textarea id="authorAbout" class="form-control description" rows="6"><?php echo $author['about'];?></textarea><br>
                </div>
              </div>
              <button class="social-but" id="submit-bio" onclick="savebio()">save artist bio</button>
              
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
        $(document).ready(function () {
            // $('.file-upload').file_upload();
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
            var assetid = "<?php echo $_REQUEST['id'];?>";
            var assetTitle = document.getElementById("assetTitle").value;
            var assetPrice = document.getElementById("assetPrice").value;
            var assetBody = document.getElementById("assetBody").value;
            var tags = $("#tags").tagsinput('items');
            var payload = [assetid, assetTitle, assetPrice, assetBody, tags];
            var url = "/ajax/assets/update?data="+JSON.stringify(payload);
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
            document.getElementById("submit-but").disabled = false;
        }
        function uploadAttachment(){
          var filename = document.getElementById('fileToUpload1').files[0].name;
          document.getElementById("file-message").innerHTML = filename;
          document.getElementById("attachmentUploadButton").style.display = "block";
        }
        function onload(){
          document.getElementById("saveButton").style.display = "none";
          document.getElementById("attachmentUploadButton").style.display = "none";
          <?php if($asset['state']==5){ ?>
            document.getElementById("imgUploadLabel").style.display = "none";
            document.getElementById("submit-but").style.display = "none";
            <?php if($admin==1){ ?>
              document.getElementById("fileToUpload1").disabled = true;
              <?php } ?>    
          <?php } ?>
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
        function showPassbase(id){
            Swal.fire({
                title: 'Passbase ID',
                text: id,
                icon: 'info',
                confirmButtonText: 'Cool'
            });
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
      .file-drop-area {
        position: relative;
        display: flex;
        align-items: center;
        width: 450px;
        max-width: 100%;
        padding: 25px;
        border: 1px dashed rgba(255, 255, 255, 0.4);
        border-radius: 3px;
        transition: 0.2s;
      
      }

      .choose-file-button {
        flex-shrink: 0;
        background-color: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 3px;
        padding: 8px 15px;
        margin-right: 10px;
        font-size: 12px;
        text-transform: uppercase;
      }

      .file-message {
        font-size: small;
        font-weight: 300;
        line-height: 1.4;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .file-input {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        cursor: pointer;
        opacity: 0;
        
      }
    </style>
  </body>
</html>