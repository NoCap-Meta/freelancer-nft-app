<?php
include_once 'session.php'; 
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
                <h4>Artists</h4>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 wallet-but">
                <button class="btn btn-primary"  data-toggle="modal" data-target="#exampleModal" style="width:200px"><i class="fa fa-plus"></i> Create an Artist</button>
            </div>
        </div><br><Br>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade show">You cannot delete the artist profile once created</div>
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Artist ID</th>
                                <th>Artist Name</th>
                                <th>Asset Count</th>
                                <th>Total Visits</th>
                                <th>Access</th>
                                <th>Assets</th>
                                <th>Transactions</th>
                                <th>Created On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $rows = mysqli_query($con, "SELECT * FROM authors");
                            while ($r = mysqli_fetch_assoc($rows)) {
                                $suspendButton = '<button class="btn btn-danger" onclick="action(\''.$r['authorid'].'\', \'active\', 0)">Suspend</button>';
                                $activateButton = '<button class="btn btn-success" onclick="action(\''.$r['authorid'].'\', \'active\', 1)">Activate</button>';
                                $assets = mysqli_num_rows(mysqli_query($con, "SELECT * FROM assets WHERE authorid='".$r['authorid']."'"));
                                $visits = mysqli_fetch_assoc(mysqli_query($con, "SELECT visits FROM visits WHERE authorid='".$r['authorid']."'"))['visits'];
                            ?>
                            <tr>
                                <td><?php echo $r['authorid']; ?></td>
                                <td><?php echo $r['name']; ?></td>
                                <td><?php echo $assets;?></td>                                
                                <!-- <button class="btn btn-primary" onclick="refreshkey('<?php echo $r['partnerid'];?>')"><i class="fa fa-refresh"></i></button><br><?php echo $r['secret']; ?> -->
                                <td><?php if($visits==""){echo "0";}else{echo $visits;} ?></td>
                                <td><a class="btn my-button" href="access?id=<?php echo $r['authorid']; ?>">Control</a></td>
                                <td><a class="btn my-button" href="listings?id=<?php echo $r['authorid']; ?>">View</a></td>
                                <td><a class="btn my-button" href="transactions?id=<?php echo $r['authorid']; ?>">View</a></td>
                                <td><?php echo $r['created']; ?></td>
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
        function newArtist(name) {
            var name = document.getElementById("artistName").value;
            if (name != ""){
                var url = "/ajax/artists/create?data="+JSON.stringify([name]);
                $.get(url, function(data) {
                    var j = JSON.parse(data);
                    if (j.status == 200) {
                        window.location.reload();
                    } else {
                        alert(j.msg);
                        Swal.fire({
                            title: 'Error',
                            text: j.msg,
                            icon: 'error',
                            confirmButtonText: 'Cool'
                        })
                    }
                });
            }
        }
        function action(partnerid, field, value) {
            var payload = [partnerid, field, value];
            var url = "/ajax/partners/changeStatus?data="+JSON.stringify(payload);
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
        .my-button {
            background-color: grey;
            border-radius: 0px;
            color: #000 !important;
        }
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