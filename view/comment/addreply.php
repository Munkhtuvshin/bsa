<?php include('header.php'); ?>
<div id="main-wrapper">
        <?php include('aside.php'); ?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                  
                    <hr>
                    <div class="sl-item">
                    <div class="sl-right">
        
                   


    <form method="POST" action="/comment/comment2/addreply">
          
             <div class="container pb-cmnt-container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-body">
                <form method = "POST" id="comment_form">
               <label> Comment: <br><textarea  placeholder="Та сэтгэгдлээ бичнэ үү" cols="30" rows="5" name="comment"></textarea></label><br>
              
          
                    <form class="form-inline">
                        <div class="btn-group">
                            <button class="btn" type="button"><span class="fa fa-picture-o fa-lg"></span></button>
                            <button class="btn" type="button"><span class="fa fa-video-camera fa-lg"></span></button>
                            <button class="btn" type="button"><span class="fa fa-microphone fa-lg"></span></button>
                            <button class="btn" type="button"><span class="fa fa-music fa-lg"></span></button>
                            <input type="submit" value="хадгалах">
                            <a href="/comment/comment2">Буцах</a>
                        
                        </div>
                        </form>
                        
                      
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .pb-cmnt-container {
        font-family: Lato;
        margin-top: 50px;
    }


</style>
    </form>
        <div class="sl-item">
                        <div class="sl-right">
                                                   
                                  <div class="like-comm m-t-20"> <a href="javascript:void(0)" class="link m-r-10">2 comment</a> <a href="javascript:void(0)" class="link m-r-10"><i class="fa fa-heart text-danger"></i> 5 Love</a> </div>
                          </div>
                  </div>
                               
                </div>
              
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
        <!-- MYCODE -->
        



        </div>
    </div>
    <?php include('foother.php');?>