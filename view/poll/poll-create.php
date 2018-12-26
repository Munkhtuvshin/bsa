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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="card-title" >Санал асуулга үүсгэх</h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body" id="card-body">
                            <form  method="POST" action="/poll/poll/create">
                                <div class="form-group">
                                    <label>Санал асуулга</label>
                                    <textarea class="form-control" name="question" rows="5"></textarea>
                                </div>
                                <div class="example">
                                    <h5 class="box-title m-t-5">Эхлэх болон дуусах огноог оруулна уу.<code>*</code></h5><br>
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text" class="form-control" name="start_date" placeholder="dd/mm/yyyy">
                                        <span class="input-group-addon bg-info b-0 text-white"> - </span>
                                        <input type="text" class="form-control" name="end_date" placeholder="dd/mm/yyyy">
                                    </div>
                                </div>
                                <div class="demo-checkbox m-t-30" onclick="can_add_option()" > 
                                    <input type="checkbox" id="basic_checkbox_1" checked="" name="can_add_option" value="1">
                                    <label style="margin-left:10px; padding-left:40px;" for="basic_checkbox_1" >Хэрэглэгч сонголт нэмэж болно.</label>
                                </div>
                                <div class="demo-checkbox" onclick="has_multi_choise()"> 
                                    <input type="checkbox" id="basic_checkbox_2"  checked="" name="has_multi_choise" value="1">
                                    <label style="margin-left:10px; padding-left:40px;" for="basic_checkbox_2" >Олон сонголт оруулж болно.</label>
                                </div>
                                <div id="div">
                                    <div class="row" id='options'>
                                        <div class="col-lg-6">
                                            <div class="input-group" id="option_group">
                                                <input type="text" name="options[1]" class="form-control" placeholder="Сонголт нэмэх ...">
                                                <span class="input-group-btn" id="option_plus"   >
                                                    <span  class="btn btn-info"  >+</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <button type="submit" style="margin-left:45%;" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Үүсгэх</button>
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Гарах</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            © 2017 Admin Press Admin by themedesigner.in
        </footer>
        <script>
          $(document).ready(function(){
              var count = 1;
            $("#option_plus").click(function(){
                $("#div").append(" <br> <div class='row' id='options'><div class='col-lg-6'><div class='input-group' ><input type='text' name='options["+(count +=1)+"]' class='form-control' placeholder='Сонголт нэмэх ...'><span class='input-group-btn id='option_plus'   ><span  class='btn btn-info'  >+</span></span></div></div></div>");
                console.log(count);
            });
            $("#btn2").click(function(){
                $("ol").append("<li>Appended item</li>");
            });
        });
        </script>
        <script>
            function can_add_option(){
                // var val = document.getElementById('basic_checkbox_1').value;
                if( document.getElementById('basic_checkbox_1').checked == true){
                    document.getElementById('basic_checkbox_1').value = 1;
                }
                else{
                    document.getElementById('basic_checkbox_1').value = 0;
                }
            console.log("val: "+document.getElementById('basic_checkbox_1').value);
            }
            function  has_multi_choise(){
                if( document.getElementById('basic_checkbox_2').checked == true  ){
                    document.getElementById('basic_checkbox_2').value = 1;
                    document.getElementById('option_input_1').disabled = false;
                    document.getElementById('option_plus').disabled = false;
                }
                else{
                    document.getElementById('basic_checkbox_2').value = 0;
                    document.getElementById('option_input_1').disabled = true;
                    document.getElementById('option_plus').disabled = true;

                }
            console.log("val: "+document.getElementById('option_plus').disabled );
            }
          
            function add_option(){
                var newElem = document.createElement ("div");
                newElem.innerHTML = "sample text";
                newElem.style.color = "red";

                var container = document.getElementById("card-body");
                container.appendChild (newElem);
            }
            
        </script>
    </div>    
    <script>
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    </script>
</div>
<?php include('foother.php'); ?>
