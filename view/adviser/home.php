<?php include('header.php') ?>
<div id="main-wrapper">
    <?php include('aside.php'); ?>
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Оюутны жагсаалт</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Inbox</li>
                    <li class="breadcrumb-item active">Оюутны жагсаалт</li>
                </ol>
            </div>
            <div class="">
                <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                               <div style="float: right; " class="btn waves-effect waves-light btn-rounded btn-primary " >
                                    <a href="/adviser/student/add" style="color: white">Оюутан нэмэх</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Овог</th>
                                                <th>Нэр</th>
                                                <th>Утас</th>
                                                <th>Е-Мэйл</th>
                                                <th>Үйлдэл</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach ($results as $key => $result){
                                            ?>
                                            <tr>
                                                <td><?php echo $key+1; ?></td>
                                                <td><?php echo $result->last_name ?></td>
                                                <td><?php echo $result->first_name ?></td>
                                                <td><?php echo $result->username ?></td>
                                                 <td>
                                                    <a href="/adviser/student/edit/<?php echo $result->id ?>" class=" label label-warning  font-weight-100">засах</a>
                                                </td>
                                                 <td>
                                                    <button class="label label-danger" type="button" name="delete">    
                                                        <a href="/adviser/student/delete/<?php echo $result->id ?>">устгах</a>
                                                    </button>
                                                 </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <!-- MYCODE -->
        <footer class="footer">
            © 2017 Admin Press Admin by themedesigner.in
        </footer>
    </div>    
</div>
<?php include('foother.php'); ?>
