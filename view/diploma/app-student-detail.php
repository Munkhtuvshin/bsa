<?php include('header.php') ?>
<div id="main-wrapper">
    <?php include('aside.php'); ?>
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><?php echo $title; ?></h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Inbox</li>
                    <li class="breadcrumb-item active"><?php echo $title; ?></li>
                </ol>
            </div>
            <div class="">
                <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
            </div>
        </div>
        <?php foreach ($datas as $value) {
            # code...
        } ?>
        <!-- MYCODE -->
        <div class="container-fluid">
            <!-- Row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Оюутны дэлгэрэнгүй</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" role="form" >
                                <div class="form-body">
                                    <h3 class="box-title"><?php echo ucwords($value->username); ?></h3>
                                    <hr class="m-t-0 m-b-40">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Овог :</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> <?php echo $value->last_name; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Нэр :</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> <?php echo $value->first_name; ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Товч нэр:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> <?php echo $value->middle_name; ?>  </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Date of Birth:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> 11/06/1987 </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Category:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> Category1 </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Membership:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> Free </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <h3 class="box-title">Address</h3>
                                    <hr class="m-t-0 m-b-40">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Address:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> E104, Dharti-2, Near silverstar mall </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">City:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> Bhavnagar </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">State:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> Gujarat </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Post Code:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> 457890 </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Country:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> India </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn btn-info"><a style="color:white;" href="/diploma/students/edit/<?php echo $value->id?>"><i class="fa fa-pencil"></i> Засах </a></button>
                                                    <button type="button" class="btn btn-inverse" > <a style="color:white;" href="/diploma/students"> Гарах </a></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
        </div>
        <footer class="footer">
            © 2017 Admin Press Admin by themedesigner.in
        </footer>
    </div>    
</div>
<?php include('foother.php'); ?>
