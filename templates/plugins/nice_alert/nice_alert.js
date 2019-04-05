/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

        function fl_alert(type='',message=''){
                if(($(".fl_alert_modal").data('bs.modal') || {}).isShown ){ 
                    return false;
                }
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
            
                var mdl_body = '<div class="fl_alert_'+type+' fl_alert_modal modal modal-message modal-'+type+' fade" style="display: none;" aria-hidden="true">'+
                                    '<div class="modal-dialog">'+
                                       ' <div class="modal-content">'+
                                            '<div class="modal-header">'+
                                                '<i class="'+icon+' text-'+type+'"></i>'+
                                           ' </div>'+
                                            '<div class="modal-title"></div>'+
                                            '<div class="center-block fl_message" style="text-align: center; color: #444">'+message+'</div>'+
                                           ' <div class="modal-footer">'+
                                               ' <button type="button" class="btn btn-'+type+'" data-dismiss="modal">OK</button>'+
                                            '</div>'+
                                       ' </div> '+
                                    '</div> '+
                                '</div>';
                        
//            alert(mdl_body)
//            alert();
                $('#fl_alert_container').html(mdl_body);
                $('.fl_alert_'+type+' .fl_message').text(message);
                $('.fl_alert_'+type).modal('toggle'); 
                
        }
        function fl_confirm(type='warning',message=''){
            
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
                                            '<div class="modal-title"></div>'+
                                            '<div class="center-block fl_message" style="text-align: center; color: #444">'+message+'</div>'+
                                           ' <div class="modal-footer">'+
                                               ' <button style="width:72px;" id="fl_confirm_ok" type="button" class="btn btn-success">OK</button>'+
                                               ' <button id="fl_confirm_cancel" type="button" class="btn btn-'+type+'" data-dismiss="modal">CANCEL</button>'+
                                            '</div>'+
                                       ' </div> '+
                                    '</div> '+
                                '</div>';
//            alert();
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
                  
                    $('#formfield').submit();
                  return true;
                }else{
                  //Acciones si el usuario no confirma 
                  return false;
                }
              });
              
                  return false;
        }