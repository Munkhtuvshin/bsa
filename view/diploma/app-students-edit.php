<?php include('header.php') ?>
<?php include('aside.php'); ?>
<div id="main-wrapper">
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><?php echo $title?></h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Inbox</li>
                    <li class="breadcrumb-item active"><?php echo $title?></li>
                </ol>
            </div>
            <div class="">
                <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
            </div>
        </div>
        <!-- MYCODE -->
        <?php foreach ($datas as $value) {
                                ?>
        <div class="container-fluid">
        <!-- Row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">With Border at Bottom (<small>Use class form-bordered</small>)</h4>
                        </div>
                        <div class="card-body">
                            <form action="/diploma/students/edit/<?php echo $value->id; ?>" method="POST" class="form-horizontal form-bordered">

                                <div class="form-body">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Нэвтрэх нэр</label>
                                        <div class="col-md-9">
                                            <input type="text" value="<?php echo $value->username; ?>" name="username" class="form-control">
                                            <small class="form-control-feedback"> This is inline help </small> </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"> Товч</label>
                                        <div class="col-md-9">
                                            <input type="text" value="<?php echo $value->middle_name;  ?>" name="middle_name" class="form-control">
                                            <small class="form-control-feedback"> Овог </small> </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Овог</label>
                                        <div class="col-md-9">
                                            <input type="text" value="<?php echo $value->last_name; ?>" name="last_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">нэр</label>
                                        <div class="col-md-9">
                                            <input type="text" value="<?php echo $value->first_name; ?>" name="first_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Gender</label>
                                        <div class="col-md-9">
                                            <select class="form-control custom-select">
                                                <option value="">Male</option>
                                                <option value="">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Date of Birth</label>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Category</label>
                                        <div class="col-md-9">
                                            <select class="form-control custom-select">
                                                <option value="Category 1">Category 1</option>
                                                <option value="Category 2">Category 2</option>
                                                <option value="Category 3">Category 5</option>
                                                <option value="Category 4">Category 4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Multi-Value Select</label>
                                        <div class="col-md-9">
                                            <select class="form-control" multiple="">
                                                <optgroup label="NFC EAST">
                                                    <option>Dallas Cowboys</option>
                                                    <option>New York Giants</option>
                                                    <option>Philadelphia Eagles</option>
                                                    <option>Washington Redskins</option>
                                                </optgroup>
                                                <optgroup label="NFC NORTH">
                                                    <option>Chicago Bears</option>
                                                    <option>Detroit Lions</option>
                                                    <option>Green Bay Packers</option>
                                                    <option>Minnesota Vikings</option>
                                                </optgroup>
                                                <optgroup label="NFC SOUTH">
                                                    <option>Atlanta Falcons</option>
                                                    <option>Carolina Panthers</option>
                                                    <option>New Orleans Saints</option>
                                                    <option>Tampa Bay Buccaneers</option>
                                                </optgroup>
                                                <optgroup label="NFC WEST">
                                                    <option>Arizona Cardinals</option>
                                                    <option>St. Louis Rams</option>
                                                    <option>San Francisco 49ers</option>
                                                    <option>Seattle Seahawks</option>
                                                </optgroup>
                                                <optgroup label="AFC EAST">
                                                    <option>Buffalo Bills</option>
                                                    <option>Miami Dolphins</option>
                                                    <option>New England Patriots</option>
                                                    <option>New York Jets</option>
                                                </optgroup>
                                                <optgroup label="AFC NORTH">
                                                    <option>Baltimore Ravens</option>
                                                    <option>Cincinnati Bengals</option>
                                                    <option>Cleveland Browns</option>
                                                    <option>Pittsburgh Steelers</option>
                                                </optgroup>
                                                <optgroup label="AFC SOUTH">
                                                    <option>Houston Texans</option>
                                                    <option>Indianapolis Colts</option>
                                                    <option>Jacksonville Jaguars</option>
                                                    <option>Tennessee Titans</option>
                                                </optgroup>
                                                <optgroup label="AFC WEST">
                                                    <option>Denver Broncos</option>
                                                    <option>Kansas City Chiefs</option>
                                                    <option>Oakland Raiders</option>
                                                    <option>San Diego Chargers</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Membership</label>
                                        <div class="col-md-9">
                                            <div class="radio-list">
                                                <label class="custom-control custom-radio">
                                                    <input id="radio3" name="radio" type="radio" checked="" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Free</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input id="radio4" name="radio" type="radio" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Paid</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">City</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">State</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Post Code</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row last">
                                        <label class="control-label text-right col-md-3">Country</label>
                                        <div class="col-md-9">
                                            <select class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="offset-sm-3 col-md-9">
                                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Засах </button>
                                                    <button type="button" class="btn btn-inverse"><a style="color:white;" href="/diploma/students">Буцах</a></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
        <?php } ?>
        </div>        
        <footer class="footer">
            © 2017 Admin Press Admin by themedesigner.in
        </footer>
    </div>    
</div>
<?php include('foother.php'); ?>
