<?php
include_once 'session.php';
$authorid = $_REQUEST['id'];
$row = mysqli_query($con, "SELECT * FROM authors WHERE authorid='$authorid'");
if (mysqli_num_rows($row) > 0){
    $row = mysqli_fetch_assoc($row);
} else {
    header("location: /");
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
                <h4>Artist Accounts (<?php echo $row['name'];?>)</h4>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 wallet-but">
            <button class="btn btn-warning"  data-toggle="modal" data-target="#mapModal" style="width:200px"><i class="fa fa-plus"></i> Map Account</button>
            <button class="btn btn-primary"  data-toggle="modal" data-target="#exampleModal" style="width:200px"><i class="fa fa-plus"></i> Create an Account</button>
            </div>
        </div><br><Br>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Asset Name</th>
                                <th>Account Email</th>
                                <th>Account Name</th>
                                <th>Reset Password</th>
                                <th>Map/Unmap</th>
                                <th>Created On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $rows = mysqli_query($con, "SELECT * FROM asset_mapping WHERE assetid IN (SELECT assetid FROM assets WHERE authorid='$authorid')");

                            while ($r = mysqli_fetch_assoc($rows)) {
                                $asset = $r['assetid'];
                                $asset = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM assets WHERE assetid='$asset'"));
                                $userid = $r['userid'];
                                $suspendButton = '<button class="btn btn-danger" onclick="action(\''.$r['mappingid'].'\', \'status\', 0)">Suspend</button>';
                                $activateButton = '<button class="btn btn-success" onclick="action(\''.$r['mappingid'].'\', \'status\', 1)">Activate</button>';
                                $account = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM accounts WHERE userid='$userid'"));
                            ?>
                            <tr>
                                <td><?php echo $asset['title']; ?></td>
                                <td><?php echo $account['email']; ?></td>
                                <td><?php echo $account['name']; ?></td>
                                <td><button class="btn btn-primary" onclick="refreshkey('<?php echo $r['mappingid'];?>')"><i class="fa fa-refresh"></i></button></td>
                                <td><?php echo ($r['status'] == 1) ? $suspendButton : $activateButton; ?></td>
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
                <div class="form-group">
                    <label for="artistName">Artist Name</label>
                    <input type="text" class="form-control" id="artistName" placeholder="Enter Artist Name">
                </div>
                <div class="form-group">
                    <label for="artistEmail">Email address</label>
                    <input type="email" class="form-control" id="artistEmail" placeholder="Enter Artist Email">
                </div>
                <div class="form-group">
                    <label for="artistPass1">Enter Password</label>
                    <input type="password" class="form-control" id="artistPass1" placeholder="Enter Artist Password">
                </div>
                <div class="form-group">
                    <label for="artistPass2">Repeat Password</label>
                    <input type="password" class="form-control" id="artistPass2" placeholder="Repeat Artist Password">
                </div>
                <div class="alert alert-warning alert-dismissible fade show">You cannot delete the artist account once created</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="newAccount()">Save changes</button>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Map Artist to Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="artistName">Select User</label>
                    <select class="form-control" id="mapUser">
                        <option value="">-- Email Address --</option>
                        <?php
                        $artists = mysqli_query($con, "SELECT * FROM accounts");
                        while ($r = mysqli_fetch_assoc($artists)){ ?>
                        <option value="<?php echo $r['userid'];?>"><?php echo $r['email'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="artistName">Select Asset</label>
                    <select class="form-control" id="mapAsset">
                        <option value="">-- Asset --</option>
                        <?php
                        $assets = mysqli_query($con, "SELECT * FROM assets WHERE authorid='$authorid'");
                        while ($r = mysqli_fetch_assoc($assets)){ ?>
                        <option value="<?php echo $r['assetid'];?>"><?php echo $r['title'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="alert alert-warning alert-dismissible fade show">You cannot delete the artist account once created</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="mapArtist()">Save changes</button>
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
        function mapArtist() {
            var mapUser = document.getElementById("mapUser").value;
            var mapAsset = document.getElementById("mapAsset").value;
            var payload = [mapUser, mapAsset];
            if (mapUser!="" && mapAsset!=""){
                var url = "/ajax/artists/map?data="+JSON.stringify(payload);
                // console.log(url);
                $.get(url, function(data) {
                    var j = JSON.parse(data);
                    if (j.status == 200) {
                        window.location.reload();
                    } else {
                        // alert(j.msg);
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
        function newAccount() {
            var artistName = document.getElementById("artistName").value;
            var artistEmail = document.getElementById("artistEmail").value;
            var artistPass1 = document.getElementById("artistPass1").value;
            var artistPass2 = document.getElementById("artistPass2").value;
            var payload = [artistName, artistEmail, artistPass1, artistPass2];
            if (artistEmail != ""){
                if (artistPass1 == artistPass2){
                    var url = "/ajax/accounts/new?data="+JSON.stringify(payload);
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
                } else {
                Swal.fire({
                    title: 'Error',
                    text: "Passwords do not match",
                    icon: 'error',
                    confirmButtonText: 'Cool'
                })
            }
            } else {
                Swal.fire({
                    title: 'Error',
                    text: "Email cannot be empty",
                    icon: 'error',
                    confirmButtonText: 'Cool'
                })
            }
        }
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
        function action(mappingid, field, value) {
            var payload = [mappingid, field, value];
            var url = "/ajax/artists/changeStatus?data="+JSON.stringify(payload);
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
        function refreshkey(mappingid) {

            Swal.fire({
                title: 'New password',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
            showCancelButton: true,
            confirmButtonText: 'Change Password',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
                return fetch(`/ajax/accounts/resetpass?password=${login}&mappingid=${mappingid}`)
                .then(response => {
                    console.log(response);
                    if (!response.ok) {
                    throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                    `Request failed: ${error}`
                    )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Password changed',
                        imageUrl: result.value.avatar_url
                    })
                }
            })
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
        .form-group label {
            color: #000;
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