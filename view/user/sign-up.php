<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <title>Бүртгүүлэх</title>
    <!-- Bootstrap Core CSS -->
    <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../../assets/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../../assets/css/colors/blue.css" id="theme" rel="stylesheet">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
     <?php
    // session_start();

        // if(isset($_POST['insert'])){
        //     $conn=mysqli_connect('localhost', 'root', '', 'eschool');
            
        //     $query="INSERT INTO users (first_name, last_name, email_phone, password,) VALUES
        //     ('".$_POST['first_name']."', '".$_POST['last_name']."', '".$_POST['email_phone']."', '".$_POST['password']."')";
        //     mysqli_query($conn, $query);
        //     echo '<p style="color:green;">Амжилттай бүртгэгдлээ.</p>';
        // }
        ?>
        <form method="post" enctype="multipart/form-data">
    <section id="wrapper">
        <div class="login-register" style="background-image:url(http://localhost:8000/assets/login/images/background/login-register.jpg);">
            <div class="login-box card" style="margin-top:-50px;">
                <div class="card-body">
                    <form class="form-horizontal form-material" id="loginform" action="index.html">
                        <h3 class="box-title m-b-20">Бүртгэлийн хэсэг</h3>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="first_name"  value="" required="" placeholder="Овог">
                            </div>
                        </div>

                     <div class="form-group">
                        <div class="col-xs-12">
                                <input class="form-control" type="text" required="" name="last_name" value="" placeholder="Нэр">
                            </div>
                        </div>


                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" name="email_phone" required="" placeholder="И-мэйл эсвэл Утас">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="username" required="" placeholder="Хэрэглэгчийн нэр">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" required="" placeholder="Нууц үг">
                            </div>
                        </div>

                                             
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input name="re-pass" class="form-control" type="password" required="" placeholder="Нууц үгээ давтана уу"> <span style="color:red;"><?php if(isset($passequ)){echo $passequ;}?></span>
                            </div>
                        </div>
            
                        <div class="form-group row">
                            <label style="min-width: 190px !important;" for="example-month-input" class="col-md-2 col-form-label">Хэрэглэгчийн төрөл:</label>
                            <div class="col-md-6">
                                <select name="user_type" class="custom-select col-12" id="inlineFormCustomSelect">
                                    <?php foreach ($users_type as $key => $value) {
                                        echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" name="insert">Бүртгүүлэх</button>
                            </div>
                        </div>

                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                <div>Та бүртгэлтэй юу? <a href="/user/user/sign-in" class="text-info m-l-5"><b>Нэвтрэх</b></a></div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../../assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="../../assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../../assets/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../../assets/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
     </form>
        </body>

</html>
