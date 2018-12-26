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
  
          <div class="container-fluid">
            <div class="row">
                  <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Сэдэв сонголтын явц</h4>
                                <div class="collapse m-t-15" id="pgr2"> <pre class="line-numbers language-javascript"><code>&lt;div class="progress"&gt;<br/>&lt;div class="progress-bar bg-success" role="progressbar" style="width: 75%;height:15px;" role="progressbar""&gt; 75% &lt;/div&gt;<br/>&lt;/div&gt;</code></pre> </div>
                                <div class="progress m-t-20">
                                    <div class="progress-bar bg-success" style="width: 75%; height:15px;" role="progressbar">75%</div>
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
