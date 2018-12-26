<?php include('header.php') ?>
<div id="main-wrapper">
    <?php include('aside.php'); ?>
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Knob</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Inbox</li>
                    <li class="breadcrumb-item active">Knob</li>
                </ol>
            </div>
            <div class="">
                <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
            </div>
        </div>
        <!-- MYCODE -->
        <div class="container-fluid">
            <div class="row">
            <div class="col-xlg-10 col-lg-9 col-md-8 bg-light-part b-l">
                    <div class="card-body">
                        <h3 class="card-title">Сэтгэгдэл бичих</h3>
                        <form action="/comment/comment2/add" method="POST">
                            <div class="form-group">
                                <textarea name="comment" class="textarea_editor form-control" rows="15" placeholder="Enter text ..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success m-t-20"><i class="fa fa-envelope-o"></i> Илгээх </button>
                            <button type="submit" class="btn btn-inverse m-t-20"><i class="fa fa-times"></i> Цуцлах</button>
                        </form>
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
