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
                        <div class="card-body">
                        <?php foreach ($datas as $value) {?>
                            <!-- <h6 class="card-subtitle">Just add <code>floating-labels</code> class to the form and <code>has-warning, has-success, has-danger & has-error</code> for various inputs. For input with icon add <code>has-feedback</code> class.</h6> -->
                            <form  method="POST" action="/poll/poll/edit/<?php echo $value->id ?>">
                                <!-- <div class="form-group m-b-40">
                                    <input type="text" class="form-control input-lg" id="input8"  name="question"><span class="bar"></span>
                                    <label for="input8">Асуулт</label>
                                </div>
                                <div class="form-group m-b-40">
                                    <input type="text" class="form-control input-sm" id="input9"><span class="bar"></span>
                                    <label for="input9">Option 1</label>
                                </div>
                                <div class="form-group has-warning m-b-40">
                                    <input type="text" class="form-control" id="input10"><span class="bar"></span>
                                    <label for="input10">Option 2</label>
                                </div>
                                <div class="form-group has-success m-b-40">
                                    <input type="text" class="form-control" id="input11"><span class="bar"></span>
                                    <label for="input11">Option 3</label>
                                </div>
                                
                            </form> -->
                            
                                <div class="form-group">
                                    <label>Санал асуулга</label>
                                    <textarea class="form-control" name="question" rows="5"><?php echo $value->question; ?></textarea>
                                </div>
                                <div class="example">
                                    <h5 class="box-title m-t-5">Эхлэх болон дуусах огноог оруулна уу.<code>*</code></h5><br>
                                    <!-- <p class="text-muted m-b-20">just add id <code>#date-range</code> to create it.</p> -->
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text" class="form-control" name="start-date">
                                        <span class="input-group-addon bg-info b-0 text-white"> - </span>
                                        <input type="text" class="form-control" name="end-date">
                                    </div>
                                </div>
                                <!-- <div class="card-body">  -->
                                <div class="demo-checkbox m-t-30" onclick="can_add_option()" > 
                                    <input type="checkbox" id="basic_checkbox_1" checked="" name="can_add_option">
                                    <label style="margin-left:10px; padding-left:40px;" for="basic_checkbox_1">Хэрэглэгч сонголт нэмэж болно.</label>
                                </div>
                                <div class="demo-checkbox" onclick="has_multi_choise()"> 
                                    <input type="checkbox" id="basic_checkbox_2"  checked="" name="has_multi_choise">
                                    <label style="margin-left:10px; padding-left:40px;" for="basic_checkbox_2">Олон сонголт оруулж болно.</label>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <input type="text" id="option_input_1" class="form-control" placeholder="Сонголт нэмэх ...">
                                            <span class="input-group-btn"  onclick="add_option()">
                                                <span  class="btn btn-info"  id="option_plus" >+</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>

                                <div class="row">
                                    
                                    <button type="submit" style="margin-left:45%;" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Засах</button>
                                    <a href="/poll/poll"><span type="submit" class="btn btn-success waves-effect waves-light m-r-10">Гарах</span>
                                </div>
                            </form>
                        </div>
                    </div>
                        <?php } ?>

                </div>
            </div>
           
        </div>
        <footer class="footer">
            © 2017 Admin Press Admin by themedesigner.in
        </footer>
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
                // if(document.getElementById('option_plus').disabled == false){
                    let div = document.createElement("div")
                    div.className="row";
                    document.body.appendChild(div);
                    let div1 = document.createElement("div");
                    div1.className="col-lg-6"; 
                    document.body.appendChild(div1);
                    let div2 = document.createElement("div");
                    div2.className="input-group";
                    document.body.appendChild(div2);
                    let input = document.createElement("input");
                    input.type="text";
                    input.className="form-control";
                    input.placeholder="Сонголт оруулах ...";
                    document.body.appendChild(input);
                    let span1 = document.createElement("span");
                    span1.className="input-group-btn";
                    document.body.appendChild(span1);
                    let span2 = document.createElement("span");
                    span2.className = "btn btn-info";
                    document.body.appendChild(span2);
                    // let element = document.createElement("input");
                    // element.type="text";
                    // element.className="form-control";
                    // element.value = "value";
                    // document.body.appendChild(element);
                    // element.class = ""
                // }
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
