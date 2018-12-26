<?php include('header.php'); ?>
<div id="main-wrapper">
        <?php include('aside.php'); ?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                  
                    <hr>
                    <div class="sl-item">
                    <div class="sl-right">
  <style type="text/css">
table {
    border-collapse: collapse;
    width: 50%
}
table, th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
th, td {
    padding: 10px;
}
th {
    {background-color:#f5f5f5;}
}
table {
    border-spacing: 5px;
    border-radius: 12px;
}

</style>
 <body>
                            
    <a href="/comment/comment2/add">Сэтгэгдэл бичих</a>
            <table style="border:none;">
             <?php 
            //  var_dump($commenTs);
            foreach($commenTs as $soyloo){  ?>
            <tr>
                <td><?php echo $soyloo->id; ?>
                <?php echo $soyloo->comment; ?>  
               
                <button type="button" class="btn btn-secondary btn-outline" data-toggle="button" aria-pressed="true">
                                            <i class="fa fa-heart-o text" aria-hidden="true"></i>
                                            <i class="fa fa-heart text-active text-danger" aria-hidden="true"></i></button>
                                            <a href="/comment/comment2/add" > хариулах </a>
                    <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="/comment/comment2/edit/<?php echo $soyloo->id; ?>">Засах</a>
                    
                    <form action="/comment/comment2/remove/<?php echo $soyloo->id; ?>" method="POST"><input type="submit" value="устгах"  class="btn m-t-10 btn-info btn-block waves-effect waves-light"></form>
                    
                </td>
                <td>  </td>
                
           </tr>

           <?php 
            //  var_dump($commenTs);
            foreach($commenTs as $comment){  
            if($soyloo->id==$comment->parent_id){?>
            <tr>
                <td><?php echo $comment->id; ?>
                <?php echo $comment->comment; ?>  
               
                <button type="button" class="btn btn-secondary btn-outline" data-toggle="button" aria-pressed="true">
                                            <i class="fa fa-heart-o text" aria-hidden="true"></i>
                                            <i class="fa fa-heart text-active text-danger" aria-hidden="true"></i></button>
                    <div class="btn-group">
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu">
                    
                    <a class="dropdown-item" href="/comment/comment2/edit/<?php echo $comment->id; ?>">Засах</a>
                    <a href="#" data-toggle="modal" data-target="#addreply<?php echo $comment->id; ?>" ><i class="ti-plus"></i> reply </a>
                    <form action="/comment/comment2/remove/<?php echo $comment->id; ?>" method="POST"><input type="submit" value="устгах"  class="btn m-t-10 btn-info btn-block waves-effect waves-light"></form>
                </td>
  

           </tr>
           <?php }}} ?>
       </div>
    </div>
         
   </table>
</body>
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
    <div class="modal fade none-border" id="addreply">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>хариу</strong> сэтгэгдэл бичих</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form role="form" action="/comment/comment2/addreply/<?php echo $comment->id; ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">comment</label>
                                <br><textarea  placeholder="Та сэтгэгдлээ бичнэ үү" cols="30" rows="5" name="comment"></textarea><br>
                            </div>
                            
                        </div>
                        <input type="submit" value="хадгалах">
                    </form>
                </div>
            </div>
        <div class="modal-footer">
    <div class="container pb-cmnt-container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="btn-group">
                            <button class="btn" type="button"><span class="fa fa-picture-o fa-lg"></span></button>
                            <button class="btn" type="button"><span class="fa fa-video-camera fa-lg"></span></button>
                            <button class="btn" type="button"><span class="fa fa-microphone fa-lg"></span></button>
                            <button class="btn" type="button"><span class="fa fa-music fa-lg"></span></button>
                            <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                           
                         </div>
                    </form>
                 </div>
            </div>
        </div>
    </div>    
                        </div>
                     </div>
                 </div>
             </div>
 <?php include('foother.php');?>






               
              