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
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <?php foreach ($comment as $key => $value) { ?>
                    <div class="card-body">
                        <form action="/comment/comment/edit/<?php echo $value->commentId ?>" method="POST">
                            <div class="form-group">
                                <label>Сэтгэгдэл бичих</label>
                                <textarea class="form-control" name="comment" rows="5"><?php echo $value->comment ?></textarea>
                            </div>
                            <div class="d-flex flex-row-reverse">
                                <input class="p-2 btn btn-primary" type="submit" value="засах"><a class="p-2 btn btn-primary" href="/comment/comment"  >Буцах</a>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>
            </div>
        <div>
        <!--ENDMYCODE -->
        <footer class="footer">
            © 2017 Admin Press Admin by themedesigner.in
        </footer>
    </div>    
</div>
<?php include('foother.php'); ?>
