<?php include('header.php') ?>
<div id="main-wrapper">
    <?php include('aside.php'); ?>
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Санал асуулга</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Inbox</li>
                    <li class="breadcrumb-item active">Санал асуулга</li>
                </ol>
            </div>
            <div class="">
                <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
            </div>
        </div>
        <!-- MYCODE -->
        <!-- <div class="container-fluid"> -->
            <div class="container-fluid">
            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><a href="/poll/poll/create" style="color:white;">Create Poll</a></button>
                <br><br>
                <div class="row">
                    <div class="col-8">
                        <!-- Column -->
                        <?php foreach ($datas as $data) { ?>
                        <div class="card">
                            <div class="row">
                                <div class="card-body coll-10" style="margin-left:2%;" >
                                    <h4 class="card-title"><?php  echo $data->question;?></h4>
                                    <h6 class="card-title" style="margin-left:10px;"><?php $date=date_create($data->start_date); echo date_format($date,"Y/m/d");?></h6>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Checkbox for following text input">
                                        </span>
                                        <input type="text" class="form-control" aria-label="Text input with checkbox">   
                                    </div>
                                    
                                    <div class="input-group" style="margin-top:5px;">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Checkbox for following text input">
                                        </span>
                                        <input type="text" class="form-control" aria-label="Text input with checkbox">
                                    </div>
                                </div>
                                <div class="card-body coll-2"  style="margin-left:25%">
                                <!-- <td class="text-nowrap"> -->
                                    <a href="/poll/poll/edit/<?php echo $data->id; ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <a href="/poll/poll/delete/<?php echo $data->id;?>" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                <!-- </td> -->
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Polls</h4>
                            <div class="table-responsive">
                                <table class="table color-table success-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Асуулт</th>
                                            <th>Хэрэглэгч</th>
                                            <th>Үүсгэсэн огноо</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                            <div class="form-group">
                                                <label>Text area</label>
                                                <textarea class="form-control" rows="5"></textarea>
                                            </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --> 
            
            <!-- <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Poll үүсгэх</h4>
                            <h6 class="card-subtitle">Just add <code>floating-labels</code> class to the form and <code>has-warning, has-success, has-danger & has-error</code> for various inputs. For input with icon add <code>has-feedback</code> class.</h6>
                            <form class="floating-labels m-t-40">
                                <div class="form-group m-b-40">
                                    <input type="text" class="form-control input-lg" id="input8"><span class="bar"></span>
                                    <label for="input8">Large Input</label>
                                </div>
                                <div class="form-group m-b-40">
                                    <input type="text" class="form-control input-sm" id="input9"><span class="bar"></span>
                                    <label for="input9">Small Input</label>
                                </div>
                                <div class="form-group has-warning m-b-40">
                                    <input type="text" class="form-control" id="input10"><span class="bar"></span>
                                    <label for="input10">Warning State</label>
                                </div>
                                <div class="form-group has-success m-b-40">
                                    <input type="text" class="form-control" id="input11"><span class="bar"></span>
                                    <label for="input11">Success State</label>
                                </div>
                                <div class="form-group has-error has-danger m-b-40">
                                    <input type="text" class="form-control" id="input12"><span class="bar"></span>
                                    <label for="input12">Error State</label>
                                </div>
                                <div class="form-group has-warning has-feedback m-b-40">
                                    <input type="text" class="form-control form-control-warning" id="input13"><span class="bar"></span>
                                    <label for="input13">Warning State With Feedback</label>
                                </div>
                                <div class="form-group has-success has-feedback m-b-40">
                                    <input type="text" class="form-control form-control-success" id="input14"><span class="bar"></span>
                                    <label for="input14">Success State With Feedback</label>
                                </div>
                                <div class="form-group has-danger has-error has-feedback m-b-5">
                                    <input type="text" class="form-control form-control-danger" id="input15"><span class="bar"></span>
                                    <label for="input15">Error State With Feedback</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> -->
           
        <!-- </div> -->
        <footer class="footer">
            © 2017 Admin Press Admin by themedesigner.in
        </footer>
    </div>    
</div>
<?php include('foother.php'); ?>
