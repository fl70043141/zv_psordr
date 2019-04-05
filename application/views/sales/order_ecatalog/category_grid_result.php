<style>
    
@media only screen and (max-width: 600px) {
    .caption a{
    font-size: 10px;
}
</style>
<div class="row">        
    <?php
    
//    echo form_hidden('page_count', $res_page_count); 
    if(!empty($categories_res)){
        foreach ($categories_res as $search){
//            echo '<pre>';        print_r($categories_res); die;
            echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div  id="'.$search['id'].'" class="thumbnail cat_click">

                        <div class="caption">
                            <div class="mailbox-attachment-info"  style="text-align:center;">
                            <a href="'. base_url($this->router->fetch_class().'/item_list/'.$search['id'].'_'.$order_id.'/1').'" class="mailbox-attachment-name center">'.$search['category_name'].'</a> 
                          </div>
                        </div>
                          <a href="'. base_url($this->router->fetch_class().'/item_list/'.$search['id'].'_'.$order_id.'/1').'"> <img src="'. base_url(CAT_IMAGES.(($search['cat_image']!='')?$search['id'].'/'.$search['cat_image']:'../default/default.jpg')).'" alt="'.$search['category_name'].'" style="width:100%;overflow: hidden"></a>
                    </div>
                  </div>';
        }
    }else{
        echo '<p><span class="fa fa-warning"></span> No results found for this Category!</p>';
    }
    ?>
    <input hidden type="text" id="page_count_str" value="1">
</div>