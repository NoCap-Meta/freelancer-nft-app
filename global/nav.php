<div class="collapse navbar-collapse" id="navbarsExample05">
                        <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
                            <?php if($_SESSION['userid']!="") { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/artists">Artists</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/listings">Listings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/drafts">Drafts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/transactions">Transactions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/logout">Logout</a>
                            </li>
                            <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/faq">FAQs</a>
                            </li>
                            <!--<li class="nav-item">-->
                            <!--    <a class="nav-link" href="/privacy.php" target="_blank">Privacy Policy</a>-->
                            <!--</li>-->
                            <li class="nav-item">
                                <a class="nav-link" href="/terms">Terms of Use</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Login</a>
                            </li>
                            
                            <?php } ?>
                        </ul>
                        
                        
                        
                    </div>
                    <style>
                        .logo {
                            height: 60px;
                        }
                    </style>
                    <script>
                        function showBalance(balance) {
                            Swal.fire({
                                title: 'Balance',
                                text: balance+" credit(s)",
                                icon: 'info',
                                confirmButtonText: 'Cool'
                            })
                        }
                    </script>