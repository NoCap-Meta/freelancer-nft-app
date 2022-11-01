<?php
include_once 'session.php';
$authorid = $_REQUEST['id'];
$filter = true;
if ($authorid == "") {
    $filter = false;
    $name = "Platform";
}
if ($filter) {
    $row = mysqli_query($con, "SELECT * FROM authors WHERE authorid='$authorid'");
    if (mysqli_num_rows($row) > 0){
        $row = mysqli_fetch_assoc($row);
    } if ($authorid == "") {
        $filter = false;
    } else {
        // header("location: /");
    }
    $name = $row['name'];
} else {

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

    <title>Artist and Creators</title>
    
  </head>
  <body>



      
    <!-- END header -->

    <?php include 'global/top.php'; ?>
      <!-- Container-fluid starts-->
    <div class="container main-container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <h4><?php echo $name; ?>'s Listings</h4>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 wallet-but">
                <button onclick="location.href='create'" class="btn btn-primary" style="width:200px"><i class="fa fa-plus"></i> Create a Listing</button>
            </div>
        </div><br><Br>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Asset ID</th>
                                <th>Artist</th>
                                <th>Asset Title</th>
                                <th>Asset Price</th>
                                <th>Attachment</th>
                                <th>Qty</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($filter){
                                $rows = mysqli_query($con, "SELECT * FROM assets WHERE authorid='$authorid' AND state!=5 ");
                            } else {
                                $rows = mysqli_query($con, "SELECT * FROM assets WHERE state!=5");
                            }
                            while ($r = mysqli_fetch_assoc($rows)) {
                                $assetid = $r['assetid'];
                               
                                $visits = mysqli_fetch_assoc(mysqli_query($con, "SELECT visits FROM visits WHERE assetid='".$assetid."'"))['visits'];
                                
                                $authorid = $r['authorid'];
                                $authorname = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM authors WHERE authorid='$authorid'"))['name'];
                            ?>
                            <tr>
                                <td><?php echo $r['assetid']; ?></td>
                                <td><a href="listings?id=<?php echo $authorid;?>"><?php echo $authorname; ?></a></td>
                                <td><?php echo $r['title']; ?></td>
                                <td><?php echo $r['price']." ".$r['currency']; ?></td>
                                <td><?php if($r['attachment']){echo "Yes";}else{echo "No";}?></td>
                                <td><?php echo $r['qty']; ?></td>
                                
                                <td><a href="edit?id=<?php echo $r['assetid'];?>" class="btn btn-primary"><i class="fa fa-pen"></i></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Artist/Creator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="artistName" placeholder="Enter Artist Name">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="newArtist()">Save changes</button>
            </div>
            </div>
        </div>
    </div>
    <?php include 'global/footer.php'; ?>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>
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
  </body>
</html>