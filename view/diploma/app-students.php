<?php include('header.php') ?>
<?php include('aside.php'); ?>

<div id="main-wrapper">
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
        <!-- <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Bordered Table</h4>
                                <h6 class="card-subtitle">Add<code>.table-bordered</code>for borders on all sides of the table and cells.</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Task</th>
                                                <th>Progress</th>
                                                <th>Deadline</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Lunar probe project</td>
                                                <td>
                                                    <div class="progress progress-xs margin-vertical-10 ">
                                                        <div class="progress-bar bg-danger" style="width: 35%; height:6px;"></div>
                                                    </div>
                                                </td>
                                                <td>May 15, 2015</td>
                                                <td class="text-nowrap">
                                                    <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Dream successful plan</td>
                                                <td>
                                                    <div class="progress progress-xs margin-vertical-10 ">
                                                        <div class="progress-bar bg-warning" style="width: 50%; height:6px;"></div>
                                                    </div>
                                                </td>
                                                <td>July 1, 2015</td>
                                                <td class="text-nowrap">
                                                    <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Office automatization</td>
                                                <td>
                                                    <div class="progress progress-xs margin-vertical-10 ">
                                                        <div class="progress-bar bg-success" style="width: 100%; height:6px;"></div>
                                                    </div>
                                                </td>
                                                <td>Apr 12, 2015</td>
                                                <td class="text-nowrap">
                                                    <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>The sun climbing plan</td>
                                                <td>
                                                    <div class="progress progress-xs margin-vertical-10 ">
                                                        <div class="progress-bar bg-primary" style="width: 70%; height:6px;"></div>
                                                    </div>
                                                </td>
                                                <td>Aug 9, 2015</td>
                                                <td class="text-nowrap">
                                                    <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Open strategy</td>
                                                <td>
                                                    <div class="progress progress-xs margin-vertical-10 ">
                                                        <div class="progress-bar bg-info" style="width: 85%; height:6px;"></div>
                                                    </div>
                                                </td>
                                                <td>Apr 2, 2015</td>
                                                <td class="text-nowrap">
                                                    <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tantas earum numeris</td>
                                                <td>
                                                    <div class="progress progress-xs margin-vertical-10 ">
                                                        <div class="progress-bar bg-inverse" style="width: 50%; height:6px;"></div>
                                                    </div>
                                                </td>
                                                <td>July 11, 2015</td>
                                                <td class="text-nowrap">
                                                    <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                     -->
        <!-- MYCODE -->
        <div class="container-fluid">

        <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">2018 оны дипломын оюутан.</h4>
                            <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                            <div class="table-responsive m-t-40">
                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Оюутны код</th>
                                            <th>Овог,Нэр</th>
                                            <th>Утас</th>
                                            <th>Явц</th>
                                            <th>Үйлдэл</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $index = 0; 
                                            foreach ($page as $value) {?>
                                            <tr>
                                                <td><?php echo $value->id; ?> </td>
                                                <td><?php echo $value->student_code; ?> </td>
                                                <td><?php $str = ucwords($value->first_name); echo substr($str, 0,1).".".ucwords($value->last_name); ?> </td>
                                                <td><?php echo $value->last_name; ?> </td>
                                                <td><?php echo $value->first_name; ?> </td>
                                                <td style="padding-left:30px;">
                                                    <a href="/diploma/students/edit/<?php echo $value->id; ?>"><i class="fa fa-edit"></i> </a> | 
                                                    <a href="/diploma/students/delete/<?php echo $value->id?>"><i class="fa fa-times"></i></a> |
                                                    <a href="/diploma/students/studentDetail/<?php echo $value->id;?>"><i class="fa fa-eye"></i>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div id="myModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <p>Some text in the Modal..</p>
                        </div>
                    </div>
                    <!-- End Modal -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Data Table</h4>
                            <h6 class="card-subtitle">Data table example</h6>
                            <div class="table-responsive m-t-40">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Row grouping </h4>
                            <h6 class="card-subtitle">Data table example</h6>
                            <div class="table-responsive m-t-40">
                                <table id="example" class="table display table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>63</td>
                                            <td>2011/07/25</td>
                                            <td>$170,750</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
        <footer class="footer">
            © 2017 Admin Press Admin by themedesigner.in
        </footer>
    </div>    
</div>
<?php include('foother.php'); ?>
