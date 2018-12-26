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
        <div class="container-fluid">
        <!-- Row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <span>
                             <!-- <div> -->
                                <h4 class="m-b-0 text-white">Оюутны мэдээлэл бүртгэх</h4> 
                            <!-- </div>  -->
                            </span>
                            <span>
                                 <!-- <div> -->
                                <!-- <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Засах </button></span> -->
                            <!-- </div>   -->
                            </span>
                           
                        </div>
                        <div class="card-body">
                            <form action="/adviser/student/add" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data">

                                <div class="form-body">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Нэвтрэх нэр</label>
                                        <div class="col-md-9">
                                            <input type="text" name="username" class="form-control">
                                            <!-- <small class="form-control-feedback"> This is inline help </small>--> 
                                        </div> 
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"> Нууц үг</label>
                                        <div class="col-md-9">
                                            <input type="text"  name="password" class="form-control">
                                            <!-- <small class="form-control-feedback"> Нууц үг </small> -->
                                         </div>
                                    </div>
                                    <!-- <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Нууц үг давтах</label>
                                        <div class="col-md-9">
                                            <input type="text" name="password_again" class="form-control">
                                        </div>
                                    </div> -->
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Нэр</label>
                                        <div class="col-md-9">
                                            <input type="text" name="first_name" class="form-control">
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Дундын нэр</label>
                                        <div class="col-md-9">
                                            <input type="text" name="middle_name" class="form-control">
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Овог</label>
                                        <div class="col-md-9">
                                            <input type="text" name="last_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Төрөл</label>
                                        <div class="col-md-9">
                                            <select class="form-control custom-select" name="type">
                                                <option value="2" selected> Оюутан</option>
                                                <option value="1"> Багш</option>
                                                <option value="3"> Эцэг эх</option>
                                                <option value="4"> Нягтлан бодогч</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Сэргээх код </label>
                                        <div class="col-md-9">
                                            <input type="text" name="recovery_code" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Төрсөн өдөр, сар, жил</label>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control" name="birthday" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Гэр бүлийн байдал </label>
                                        <div class="col-md-9">
                                            <select class="form-control custom-select" name="family_type">
                                                <option value="гэрлэсэн">Гэрлэсэн</option>
                                                <option value="гэрлээгүй">Гэрлээгүй</option>
                                                <!-- <option value="">Салсан</option> -->
                                            </select>
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="control-label text-right col-md-3"> Утас </label>
                                        <div class="col-md-9">
                                            <input type="text" name="phone" class="form-control">
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Е-мэйл</label>
                                        <div class="col-md-9">
                                            <input type="text" name="email" class="form-control">
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Гэрийн хаяг </label>
                                        <div class="col-md-9">
                                            <input type="text" name="address" class="form-control">
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Шашин шүтлэг</label>
                                        <div class="col-md-9">
                                            <input type="text" name="worship" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Хэл</label>
                                        <div class="col-md-9">
                                            <select class="form-control custom-select" name="language">
                                                <option value="монгол">Монгол</option>
                                                <option value="англи">Англи</option>
                                                <option value="орос">Орос</option>
                                            </select>
                                        </div>
                                    </div>
                                      <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Хүйс</label>
                                        <div class="col-md-9">
                                            <select class="form-control custom-select" name="sex">
                                                <option value="эрэгтэй">Эрэгтэй</option>
                                                <option value="эмэгтэй">Эмэгтэй</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                         <div class="col-lg-6 col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title">Профайл зураг</h4>
                                                    <!-- <label for="input-file-now-custom-1">You can add a default value</label> -->
                                                    <input type="file" id="input-file-now-custom-1" name="profile_photo" class="dropify" data-default-file="../../../assets/images/logo-icon.png" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title">Ковер зураг</h4>
                                                    <!-- <label for="input-file-now">Your so fresh input file — Default version</label> -->
                                                    <input type="file" id="input-file-now" name="cover_photo" class="dropify" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group row">
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
                                    </div> -->
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

        </div>        
        <footer class="footer">
            © 2017 Admin Press Admin by themedesigner.in
        </footer>
    </div>    
</div>
<?php include('foother.php'); ?>
