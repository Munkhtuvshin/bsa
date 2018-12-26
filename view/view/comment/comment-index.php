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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="/comment/comment/add" method="POST">
                                        <div class="form-group">
                                            <label>Сэтгэгдэл бичих</label>
                                            <textarea class="form-control" name="comment" rows="5"><?php  $res['comment']?> </textarea>
                                        </div>
                                        <div class="form-group d-flex flex-row-reverse">
                                            <input class="p-2 btn btn-primary" type="submit" value="Бичих">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php foreach ($comments as $value) {?>
                        <div class="card">
                            <div class="card-header">
                                <?php echo $value->username ?>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <?php echo $value->comment ?>
                                </p>
                                <a href="/comment/comment/reply/<?php echo $value->commentId; ?>">
                                    <button class="btn btn-primary btn-sm" id="btn" type="button">reply</button>
                                </a>
                                <a href="#">
                                    <button class="btn btn-danger btn-sm"><i class="fa fa-heart-o"></i></button>
                                </a>
                                <a href="/comment/comment/remove/<?php echo $value->commentId; ?>">
                                    <button class="btn btn-primary btn-sm" id="btn" type="button"><i class=" icon-like"></i></button>
                                </a>
                                <a href="/comment/comment/remove/<?php echo $value->commentId; ?>">
                                    <button class="btn btn-primary btn-sm" id="btn" type="button"><i class=" ti-face-smile"></i></button>
                                </a>
                                <a href="/comment/comment/remove/<?php echo $value->commentId; ?>">
                                    <button class="btn btn-primary btn-sm" id="btn" type="button"><i class=" ti-face-sad"></i></button>
                                </a>
                                <a href="/comment/comment/remove/<?php echo $value->commentId; ?>">
                                    <button class="btn btn-primary btn-sm" id="btn" type="button"><i class="  icon-dislike"></i></button>
                                </a>
                                <a href="/comment/comment/remove/<?php echo $value->commentId; ?>">
                                    <button class="btn btn-primary btn-sm" id="btn" type="button"><i class="fa fa-trash-o"></i></button>
                                </a>
                                <a href="/comment/comment/edit/<?php echo $value->commentId; ?>">
                                    <button class="btn btn-primary btn-sm" id="btn" type="button"><i class="fa fa-edit"></i></button>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                        <div id="modal" style="display:none">
                            <div class="card">
                                <div class="card-body collapse show">
                                    <h4 class="card-title">replied user name</h4>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    © 2017 Admin Press Admin by themedesigner.in
                </footer>
            </div>
            <script>
                var element = document.getElementById("modal");
                var btn = document.getElementById("btn");

                btn.onclick = function() {
                    element.style.display = block;
                }
            </script>
    </div>
    <?php include('foother.php'); ?>