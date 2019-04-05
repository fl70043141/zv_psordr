
<script src="<?php echo base_url('templates/plugins/multyselect_leftright/multyselect_leftright.js');?>"></script>
<?php // echo '<pre>'; print_r($grouped_invoices); die;?>
<div class="row">
    <?php echo  form_open("", 'id="form_selctions" class="form-horizontal"');?>
            <div class="col-xs-5">
                <?php echo form_hidden('multiselect_group_id',0);?>
                <?php
                     $not_grouped_total =0; 
                     $group_option_list = '';
                     if(isset($grouped_invoices[0])){
                        foreach ($grouped_invoices[0] as $key1=>$not_grouped){
                            $group_option_list .= '<option value="'.$key1.'">'.$not_grouped['invoice_no'].'  [ '.$not_grouped['currency_code'].'  '.number_format($not_grouped['net_total'],2).']</option>';
                            $not_grouped_total += $not_grouped['net_total'];
                        echo '<input hidden id="invinpt_'.$key1.'" type="text" value="'.$not_grouped['net_total'].'" class="not_grouped_tot grp_tot_cls">';
                        }
                     }
                    ?>
                <select name="from[]" id="multiselect" class="form-control" size="8" multiple="multiple">
                    <?php echo $group_option_list;?>

                </select>
                <blockquote class="pull-right">
                    <p>Total : <span id="not_group_tot_text"><?php echo number_format($not_grouped_total,2);?></span></p> 
              </blockquote>
            </div>

            <div class="col-xs-2 actn_btn">
              <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
              <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
              <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
              <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
            </div>

            <div class="col-xs-5">
                <?php echo form_hidden('multiselect_to_group_id',1);?>
                <?php
                     $grouped_total =0;
                     $group_option_list = '';
                     if(isset($grouped_invoices[1])){
                        foreach ($grouped_invoices[1] as $key2=>$grouped){
                            $group_option_list .= '<option value="'.$key2.'">'.$grouped['invoice_no'].'  [ '.$grouped['currency_code'].'  '.number_format($grouped['net_total'],2).']</option>';
                            $grouped_total += $grouped['net_total'];
                        echo '<input hidden type="text" id="invinpt_'.$key2.'" value="'.$grouped['net_total'].'" class="grouped_tot grp_tot_cls">';
                        }
                     }
                    ?>
                <select name="to[]" id="multiselect_to" class="form-control" size="8" multiple="multiple">
                    <?php echo $group_option_list;?>
                </select>
                <blockquote class="pull-right">
                    <p>Total : <span id="group_tot_text"><?php echo number_format($grouped_total,2);?></span></p> 
              </blockquote>
            </div>
    <?php echo form_close();?>
        </div>
    <hr>
     
<script>
    $(document).ready(function(){
        $('.actn_btn').click(function(){
            var grouped_tot = 0;
            $("#multiselect_to option").each(function(){
                var amount1 = $('#invinpt_'+this.value).val();
                grouped_tot += parseFloat(amount1);
            });
//            alert(grouped_tot);
            $('#group_tot_text').text(addCommas(grouped_tot.toFixed(2)))
            
            var not_grouped_tot = 0;
            $("#multiselect option").each(function(){
                var amount2 = $('#invinpt_'+this.value).val();
                not_grouped_tot += parseFloat(amount2);
            });
            $('#not_group_tot_text').text(addCommas(not_grouped_tot.toFixed(2)))
            
        });
    });
    
        $('#multiselect option, #multiselect_to option').dblclick(function(){
             return false;
        });
    
     function addCommas(nStr){
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
    }
</script>