 <style type="text/css">
    	.modal-content {
    -webkit-border-radius: 0;
    -webkit-background-clip: padding-box;
    -moz-border-radius: 0;
    -moz-background-clip: padding;
    border-radius: 6px;
    background-clip: padding-box;
    -webkit-box-shadow: 0 0 40px rgba(0,0,0,.5);
    -moz-box-shadow: 0 0 40px rgba(0,0,0,.5);
    box-shadow: 0 0 40px rgba(0,0,0,.5);
    color: #000;
    background-color: #fff;
    border: rgba(0,0,0,0);
}
.modal-message .modal-dialog {
    width: 300px;
}
.modal-message .modal-body, .modal-message .modal-footer, .modal-message .modal-header, .modal-message .modal-title {
    background: 0 0;
    border: none;
    margin: 0;
    padding: 0 20px;
    text-align: center!important;
}

.modal-message .modal-title {
    font-size: 17px;
    color: #737373;
    margin-bottom: 3px;
}

.modal-message .modal-body {
    color: #737373;
}

.modal-message .modal-header {
    color: #fff;
    margin-bottom: 10px;
    padding: 15px 0 8px;
}
.modal-warning .modal-header, .modal-warning .modal-footer {
    background-color: #ffffff!important;
}
.modal-danger .modal-header, .modal-danger .modal-footer {
    background-color: #ffffff!important;
}
.modal-info .modal-header, .modal-info .modal-footer {
    background-color: #ffffff!important;
}
.modal-success .modal-header, .modal-success .modal-footer {
    background-color: #ffffff!important;
}
.modal-message .modal-header .fa, 
.modal-message .modal-header 
.glyphicon, .modal-message 
.modal-header .typcn, .modal-message .modal-header .wi {
    font-size: 30px;
}

.modal-message .modal-footer {
    margin: 25px 0 20px;
    padding-bottom: 10px;
}

.modal-backdrop.in {
    zoom: 1;
    filter: alpha(opacity=75);
    -webkit-opacity: .75;
    -moz-opacity: .75;
    opacity: .75;
}
.modal-backdrop {
    background-color: #fff;
}
.modal-message.modal-success .modal-header {
    color: #53a93f;
    border-bottom: 3px solid #a0d468;
}

.modal-message.modal-info .modal-header {
    color: #57b5e3;
    border-bottom: 3px solid #57b5e3;
}

.modal-message.modal-danger .modal-header {
    color: #d73d32;
    border-bottom: 3px solid #e46f61;
}

.modal-message.modal-warning .modal-header {
    color: #f4b400;
    border-bottom: 3px solid #ffce55;
}


    </style>
<div class="buttons-preview">
    <button id="fah1" class="btn btn-success" >Success</button>
    <button id="fah2" class="btn btn-info">Info</button>
    <button id="fah3" class="btn btn-danger">Danger</button>
    <button id="fah4" class="btn btn-warning" >Warning</button>
    <form method="post"> <button type="submit" id="fah5" class="btn btn-warning">Warning</button></form>
</div> 
    <div id="fl_alert_container"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#fah1').click(function(){ fl_fl_alert('info','success','This is test message'); })
		$('#fah2').click(function(){ fl_fl_alert('info','info','This is test message'); })
		$('#fah3').click(function(){ fl_fl_alert('info','danger','This is test message'); })
		$('#fah4').click(function(){ fl_fl_alert('info','warning','This is test message'); })
		$('#fah5').click(function(){ fl_confirm('This is test message'); })
        
	});
        function fl_fl_alert('info',type='',message=''){
            
                var icon = '';
                switch(type){
                    case 'success': 
                        icon='glyphicon glyphicon-check';
                        break;
                    case 'info': 
                        icon='fa fa-envelope';
                        break;
                    case 'danger': 
                        icon='glyphicon glyphicon-fire';
                        break;
                    case 'warning': 
                        icon='fa fa-warning';
                        break;
                    default :
                        icon='glyphicon glyphicon-check';
                        break;
                }
            
                var mdl_body = '<div id="fl_alert_'+type+'" class="modal modal-message modal-'+type+' fade" style="display: none;" aria-hidden="true">'+
                                    '<div class="modal-dialog">'+
                                       ' <div class="modal-content">'+
                                            '<div class="modal-header">'+
                                                '<i class="'+icon+' text-'+type+'"></i>'+
                                           ' </div>'+
                                            '<div class="modal-title">'+type+'</div>'+
                                            '<div class="center-block fl_message" style="text-align: center; color: #444">'+message+'</div>'+
                                           ' <div class="modal-footer">'+
                                               ' <button type="button" class="btn btn-'+type+'" data-dismiss="modal">OK</button>'+
                                            '</div>'+
                                       ' </div> '+
                                    '</div> '+
                                '</div>';
//            fl_alert('info',);
                $('#fl_alert_container').html(mdl_body);
                $('#fl_alert_'+type+' .fl_message').text(message);
                $('#fl_alert_'+type).modal('toggle'); 
        }
        function fl_confirm(message=''){
                var type = 'warning';
                var icon = 'fa fa-question-circle'; 
            
                var mdl_body = '<div id="fl_alert_'+type+'" class="modal modal-message modal-'+type+' fade" style="display: none;" aria-hidden="true">'+
                                    '<div class="modal-dialog">'+
                                       ' <div class="modal-content">'+
                                            '<div class="modal-header">'+
                                                '<i class="'+icon+' text-'+type+'"></i>'+
                                           ' </div>'+
                                            '<div class="modal-title">'+type+'</div>'+
                                            '<div class="center-block fl_message" style="text-align: center; color: #444">'+message+'</div>'+
                                           ' <div class="modal-footer">'+
                                               ' <button style="width:72px;" id="fl_confirm_ok" type="button" class="btn btn-success">OK</button>'+
                                               ' <button id="fl_confirm_cancel" type="button" class="btn btn-'+type+'" data-dismiss="modal">CANCEL</button>'+
                                            '</div>'+
                                       ' </div> '+
                                    '</div> '+
                                '</div>';
//            fl_alert('info',);
                $('#fl_alert_container').html(mdl_body);
                $('#fl_alert_'+type+' .fl_message').text(message);
                $('#fl_alert_'+type).modal('toggle'); 
                
                var modalConfirm = function(callback){
  

                $("#fl_confirm_ok").on("click", function(){
                  callback(true);
                  $('#fl_alert_'+type).modal('hide');
                });

                $("#fl_confirm_cancel").on("click", function(){
                  callback(false);
                  $('#fl_alert_'+type).modal('hide');
                });
              };

              modalConfirm(function(confirm){
                if(confirm){
                  //Acciones si el usuario confirma
                  fl_alert('info','kk')
                }else{
                  //Acciones si el usuario no confirma
                  fl_alert('info','as')
                }
              });
        }
</script>