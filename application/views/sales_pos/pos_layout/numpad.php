<div style=" position:relative;z-index:2000;" id="num_pad_btns">
                                                <div class="col-md-12">  
                                                    <hr style="margin-top:15px;margin-bottom:15px;">

                                                    <a id="key_7" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-default">
                                                       <i  class="fa-4x">7</i><br/> 
                                                   </a>   
                                                   <a id="key_8" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-default">
                                                       <i  class="fa-4x">8</i><br/> 
                                                   </a>   
                                                   <a id="key_9" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-default">
                                                       <i  class="fa-4x">9</i><br/> 
                                                   </a> 
                                               </div>
                                               <div style="margin-top: 3px;" class="col-md-12">   

                                                   <a id="key_4" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-default">
                                                       <i  class="fa-4x">4</i><br/> 
                                                   </a>    
                                                   <a id="key_5" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-default">
                                                       <i  class="fa-4x">5</i><br/> 
                                                   </a>    
                                                   <a id="key_6" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-default">
                                                       <i  class="fa-4x">6</i><br/> 
                                                   </a>       
                                               </div>  
                                               <div style="margin-top: 3px;"  class="col-md-12 ">    

                                                   <a id="key_1" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-default">
                                                       <i  class="fa-4x">1</i><br/> 
                                                   </a>    
                                                   <a id="key_2" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-default">
                                                       <i  class="fa-4x">2</i><br/> 
                                                   </a>    
                                                   <a id="key_3" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-default">
                                                       <i  class="fa-4x">3</i><br/> 
                                                   </a>       
                                               </div> 
                                               <div style="margin-top: 3px;"  class="col-md-12 ">     
                                                   <a id="key_0" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-default">
                                                       <i  class="fa-4x">0</i><br/> 
                                                   </a>       
                                                   <a id="key_dot" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-default">
                                                       <i  class="fa-4x">.</i><br/> 
                                                   </a>    
                                                   <a id="key_del" style="width:80px; height: 80px; background-color: #f73e3ede; color: white;" href="#" class="btn btn-sq-lg btn-danger">
                                                       <i  class="fa-4x"><span class="glyphicon glyphicon-arrow-left"></span></i><br/> 
                                                   </a>    
                                               </div> 
 
                                        </div>


<script>
    
$(document).ready(function() {
    
    $('#num_pad_btns').sortable();
    $('#key_0,#key_1,#key_2,#key_3,#key_4,#key_5,#key_6,#key_7,#key_8,#key_9,#key_del,#key_dot').click(function(){ set_numpad_press(this.id) });
     
    
function set_numpad_press(id,add_var=''){ 
        var selected_string = document.activeElement;
        var exist_str = selected_string.value; 
//        fl_alert('info',exist_str)
        
        var start = selected_string.selectionStart;
        var end = selected_string.selectionEnd;
        
        var add_str = (id).split("_")[1]; 
            switch (add_str) {
                case 'dot':
                    add_str = '.';
                    break;
                case 'del':
                    add_str = '';
                    start = start-1;
                    break; 
                default:
                   break;
            } 
        var ret_str = exist_str.substring(0,start) + add_str + exist_str.substring(end); 

        document.activeElement.value = ret_str;
}
});
//$('.modal').on('shown', function () {
//    $("#num_pad_btns").
//});
</script>