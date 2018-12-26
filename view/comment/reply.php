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
                    <?php foreach($result as $reply){?>
                    <div class="card">
                        <div class="card-header">
                            <?php echo $reply->username ?>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <?php echo $reply->comment ; ?>
                            </p>
                            <a href="/comment/comment/reply/<?php echo $reply->commentId; ?>">
                                <button class="btn btn-primary btn-sm" id="btn" type="button">reply</button>
                            </a>
                            <a href="/comment/comment/remove/<?php echo $reply->commentId; ?>">
                                <button class="btn btn-primary btn-sm" id="btn" type="button">delete</button>
                            </a>
                            <button href="#" class="btn btn-danger btn-sm">like</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <div class="card" style="height:200px;">
                                <div class="card-body">
                                    <form action="/comment/comment/reply/<?php echo $reply->commentId; ?>" method="POST">
                                        <input type="hidden" name="parent_id" value="<?php echo $reply->commentId;?>">
                                        <div class="form-group">
                                            <label>Хариулт бичих</label>
                                            <textarea class="form-control" name="comment" style="height:50px;" rows="5"></textarea>
                                        </div>
                                        <div class="form-group d-flex flex-row-reverse">
                                            <input class="p-2 btn btn-primary btn-sm" type="submit" value="Бичих">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php foreach ($getReplys as $key => $value) {?>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <div class="card" style="height:200px;">
                                <div class="card-header">
                                    <?php echo $value->username ?>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <?php echo $value->comment ; ?>
                                    </p>
                                    <a href="/comment/comment/reply/<?php echo $value->commentId; ?>">
                                        <button class="btn btn-primary btn-sm" id="btn" type="button">reply</button>
                                    </a>
                                    <a href="/comment/comment/remove/<?php echo $value->commentId; ?>">
                                        <button class="btn btn-primary btn-sm" id="btn" type="button">delete</button>
                                    </a>
                                    <button href="#" class="btn btn-danger btn-sm">like</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <div>
                        <footer class="footer">
                            © 2017 Admin Press Admin by themedesigner.in
                        </footer>
                    </div>
                </div>
            </div>
        </div>
                <?php include('foother.php'); ?>