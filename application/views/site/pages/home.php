<?php 
  
  if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='local')
  {
    add_css(array('assets/site_assets/css/nivo-slider.css', 'assets/site_assets/css/slick.min.css'));

    add_footer_js(array('assets/site_assets/js/jquery.nivo.slider.js','assets/site_assets/js/jquery.countdown.min.js','assets/site_assets/js/slick.min.js'));
  }
  else if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='cdn')
  {
    add_cdn_css(array('https://cdnjs.cloudflare.com/ajax/libs/jquery-nivoslider/3.2/nivo-slider.min.css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css'));

    add_footer_cdn_js(array('https://cdnjs.cloudflare.com/ajax/libs/jquery-nivoslider/3.2/jquery.nivo.slider.min.js','https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js'));
  }

  add_footer_js(array('assets/site_assets/js/nivo.slider.init.js', 'assets/site_assets/js/slick.init.js'));

  $ci =& get_instance();
?>

<style type="text/css">
  .nivo-controlNav{
    z-index: 16 !important; 
  }
  .nivoSlider a.nivo-imageLink{
    z-index: 15 !important; 
  }
</style>

   <?php
  // for hide/show slider 
   if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->home_slider_opt=='true')
   {
    ?>

    <!-- start slider container -->
    <section class="slider-area mb-50">
      <div class="slider-wrapper theme-default"> 
        <div id="slider" class="nivoSlider"> 
          <?php 
          $i=0;
          foreach ($banner_list as $key => $row) 
          {
            $img_file=base_url('assets/images/banner/'.$row->banner_image);

            /*$thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->banner_image);

            $img_file=base_url().$ci->_create_thumbnail('assets/images/banner/',$thumb_img_nm,$row->banner_image,1350,422);*/
            ?>
            <a href="<?=base_url('banners/'.$row->banner_slug)?>" class="pjax">
              <img src="<?=$img_file?>" class="banner_img" alt="" height="100%" title="#<?=$row->id?>"/>
            </a>
            <?php 
          }
          ?>
        </div>
      </div>
    </section>
    <!-- end slider container -->

  <?php }else{ echo '<br/>';} ?>

  <?php
  // for hide/show brands 
  if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->home_brand_opt=='true' AND !empty($brands_list))
  {
    ?>

    <!-- categories container -->
    <section class="brand-slider mb-0">
      <div class="container">
        <div class="row">
          <div class="col-md-12"> 
            <div class="section-title1-border">
              <div class="section-title1">
                <h3><?=$this->lang->line('brands_lbl')?></h3>
              </div>
              <?php 
              if(count($brands_list) > 8){
                echo '<div class="category_view_all" style="right: 100px"><a href="'.base_url('/brand').'" class="pjax">'.$this->lang->line('view_all_lbl').'</a></div>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="brand-active mb-30 owl-carousel" style="border-top: 0px;">
            <?php 
            $i=0;

            foreach ($brands_list as $key => $row) 
            {

              if($row->brand_image!='')
              {

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->brand_image);

                $img_file=base_url().$ci->_create_thumbnail('assets/images/brand/',$thumb_img_nm,$row->brand_image,117,70);
              }
              else{
                $img_file='https://via.placeholder.com/300x180?text=No image';
              }


              $url=base_url('brand/'.$row->brand_slug);
              ?>
              <div class="col-md-12 item-col">
                <div class="single-offer">
                  <div class="all_categori_list img-full"> 
                    <a href="<?=$url?>" title="<?=$row->brand_name?>" class="pjax"> 
                      <img src="<?=$img_file?>" alt="" style="height: 100%">  
                      <span>
                        <?php 
                        if(strlen($row->brand_name) > 10){
                          echo substr(stripslashes($row->brand_name), 0, 10).'...';  
                        }else{
                          echo $row->brand_name;
                        }
                        ?>
                      </span>
                    </a>
                  </div>
                </div>
              </div>   
            <?php } ?>  
          </div> 
        </div>
      </div>
    </section>
    <!-- end categories container -->

  <?php } ?>

  <?php
  // for hide/show categories
  if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->home_category_opt=='true' AND !empty($category_list))
  {
    ?>
    <!-- categories container -->
    <section class="mb-0">
      <div class="container">
        <div class="row">
          <div class="col-md-12"> 
            <div class="section-title1-border">
              <div class="section-title1">
                <h3><?=$this->lang->line('category_lbl')?></h3>
              </div>
              <?php 
              if(count($category_list) > 4){
                echo '<div class="category_view_all" style="right: 100px"><a href="'.base_url('/category').'" class="pjax">'.$this->lang->line('view_all_lbl').'</a></div>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="category-slider mb-30 owl-carousel">
            <?php 
            $i=0;

            foreach ($category_list as $key => $row) 
            {

              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->category_image);

              $img_file=base_url().$ci->_create_thumbnail('assets/images/category/',$thumb_img_nm,$row->category_image,204,122);

              $counts=$ci->getCount('tbl_sub_category', array('category_id' => $row->id, 'status' => '1'));

              if($counts > 0)
              {
                $url=base_url('category/'.$row->category_slug);  
              }
              else{
                $url=base_url('category/products/'.$row->id);
              }
              ?>
              <div class="col-md-12 item-col">
                <div class="single-offer">
                  <div class="all_categori_list img-full"> 
                    <a href="<?=$url?>" class="pjax"> 
                      <img src="<?=$img_file?>" alt="" style="height: auto">  
                      <span>
                        <?php 
                        if(strlen($row->category_name) > 30){
                          echo substr(stripslashes($row->category_name), 0, 30).'...';  
                        }else{
                          echo $row->category_name;
                        }
                        ?>
                      </span>
                    </a>
                  </div>
                </div>
              </div>   
            <?php } ?>  
          </div> 
        </div>
      </div>
    </section>
    <!-- end categories container -->

  <?php } ?>

  <?php
  // for hide/show offers
  if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->home_offer_opt=='true' AND !empty($offers_list))
  {
    ?>

    <!-- offer container -->
    <div class="offer-area mb-30">
      <div class="container">
        <div class="row">
          <div class="col-md-12"> 
            <div class="section-title1-border">
              <div class="section-title1">
                <h3><?=$this->lang->line('offers_lbl')?></h3>
              </div>
              <?php 
              if(count($offers_list) > 4){
                echo '<div class="category_view_all" style="right: 100px"><a href="'.base_url('/offers').'" class="pjax">'.$this->lang->line('view_all_lbl').'</a></div>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="product-offers mb-30 owl-carousel">
            <?php 
            $i=0;
            foreach ($offers_list as $key => $row) 
            {
              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->offer_image);

              $img_offer=base_url().$ci->_create_thumbnail('assets/images/offers/',$thumb_img_nm,$row->offer_image,224,127);
            ?>
            <div class="col-md-12 item-col">
              <div class="single-offer">
                <div class="offer-img img-full"> <a href="<?=base_url('offers/'.$row->offer_slug)?>" class="pjax"> <img src="<?=$img_offer?>" alt="" style="height: auto"> </a> </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

<?php } ?>

<?php
  // for hide/show todays deal
if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->home_flase_opt=='true')
{
  ?>

  <?php 
  if(!empty($todays_deal))
  {
    ?>
    <section class="hot-deal-product-of-the-day mb-30">
      <div class="container">
        <div class="row">
          <div class="col-md-12"> 
            <div class="section-title1-border">
              <div class="section-title1">
                <h3><?=$this->lang->line('hot_deal_lbl')?></h3>
              </div>
              <?php 
              if(count($todays_deal) > 2){
                echo '<div class="category_view_all" style="right: 100px"><a href="'.base_url('/todays-deals').'" class="pjax">'.$this->lang->line('view_all_lbl').'</a></div>';
              }
              ?>

            </div>
          </div>
        </div>
        <div class="row">
          <div class="hot-deal-of-product owl-carousel">
            <?php   

            foreach ($todays_deal as $key => $row) 
            {

              $db_date=date('Y-m-d H:i:s',$row->today_deal_date);

              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->featured_image);

              $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$row->featured_image,250,250);

              if($row->featured_image2=='')
              { 
                $img_file2=$img_file;
              }
              else{
                $img_file2=$ci->_create_thumbnail('assets/images/products/',$row->product_slug,$row->featured_image2,251,251);
              }

              $is_avail=true;

              if($row->status==0)
              {
                $is_avail=false;
              }

              $next_day=date('Y/m/d H:i:s', strtotime($db_date .' +1 day'));

              ?> 
              <div class="col-md-12">
                <div class="single-product hot-deal-list">
                  <?php 
                  if(!$is_avail)
                  {
                    ?>
                    <div class="unavailable_override">
                      <p><?=$this->lang->line('unavailable_lbl')?></p>
                    </div> 
                  <?php } ?>
                  <div class="product-img"> 
                    <?php 
                    if($row->you_save_per!='0'){
                      echo '<span class="sicker" style="right:auto;left:10px">'.$row->you_save_per.$this->lang->line('per_off_lbl').'</span>';
                    }
                    ?>
                    <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>"> <img class="first-img" src="<?=base_url().$img_file?>" alt="" style="height: 250px;width: 250px"> <img class="hover-img" src="<?=base_url().$img_file2?>" alt="" style="height: 250px;width: 250px"> </a> </div>

                    <div class="product-content">
                      <h2 class="pro-title">
                        <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>">
                          <?php 
                          if(strlen($row->product_title) > 30){
                            echo substr(stripslashes($row->product_title), 0, 30).'...';  
                          }else{
                            echo $row->product_title;
                          }
                          ?>
                        </a>
                      </h2>
                      <div class="pro-rating-price">

                        <div class="product-price">
                          <div class="price_holder"> 
                            <?php 
                            if($row->you_save_amt!='0'){
                              ?>
                              <span class="new-price"><?=CURRENCY_CODE.' '.number_format($row->selling_price, 2)?></span> 
                              <span class="old-price"><?=CURRENCY_CODE.' '.number_format($row->product_mrp, 2);?></span>
                              <?php
                            }
                            else{
                              ?>
                              <span class="new-price"><?=CURRENCY_CODE.' '.number_format($row->product_mrp, 2);?></span>
                              <?php

                            }
                            ?>
                          </div>
                        </div>
                        <div class="rating">
                          <?php 
                          for ($x = 0; $x < 5; $x++) { 
                            if($x < $row->rate_avg){
                              ?>
                              <i class="fa fa-star" style="color: #F9BA48"></i>
                              <?php  
                            }
                            else{
                              ?>
                              <i class="fa fa-star"></i>
                              <?php
                            }

                          }
                          ?>
                        </div>
                        <div class="hot-deal-product-des">
                          <p>
                            <?php
                            if(strlen($row->product_desc) > 100){
                              echo substr(stripslashes($row->product_desc), 0, 100);  
                            }else{
                              echo $row->product_desc;
                            }
                            ?>
                          </p>
                        </div>
                        <div class="count-down-box">
                          <div class="count-box">
                            <div class="pro-countdown" data-countdown="<?=$next_day?>"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </section>
<?php }   // end for hot deal set or not
}   // end for its hide/show opt
?>

<?php
  // for home page ads 
if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->home_ad=='true')
{
  ?>
  <div class="offer-area mb-60">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="single-offer">
            <div class="offer-img img-full">
              <?php 
              echo html_entity_decode($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->home_banner_ad);
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php
  // for hide/show latest products
if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->home_latest_opt=='true')
{
  ?>

  <?php 
  // show latest products
  if(!empty($latest_products))
  {
    ?>
    <section class="bestseller-product mb-30">
      <div class="container">
        <div class="row">
          <div class="col-md-12"> 
            <div class="section-title1-border">
              <div class="section-title1">
                <h3><?=$this->lang->line('latest_product_lbl')?></h3>
                <?php 
                if(count($latest_products) > 5){
                  echo '<div class="category_view_all" style="right: 100px"><a href="'.base_url('/latest-products').'" class="pjax">'.$this->lang->line('view_all_lbl').'</a></div>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="latest-products mb-30 owl-carousel"> 
            <?php 

            foreach ($latest_products as $key => $product_row) 
            {
              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $product_row->featured_image);

              $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$product_row->featured_image,205,205);

              $img_file2=$ci->_create_thumbnail('assets/images/products/',$product_row->product_id,$product_row->featured_image2,205,205);

              $is_avail=true;

              if($product_row->status==0)
              {
                $is_avail=false;
              }

              ?>
              <div class="col-md-12 item-col">    
                <div class="single-product3">
                  <?php 
                  if(!$is_avail)
                  {
                    ?>
                    <div class="unavailable_override">
                      <p><?=$this->lang->line('unavailable_lbl')?></p>
                    </div> 
                  <?php } ?>
                  <div class="product-img"><a href="<?php echo site_url('product/'.$product_row->product_slug); ?>" title="<?=$product_row->product_title?>"> <img class="first-img" src="<?=base_url().$img_file?>"> <img class="hover-img" src="<?=base_url().$img_file2?>"> </a>
                    <?php 
                    if($product_row->you_save_per!='0'){
                      echo '<span class="sicker">'.$product_row->you_save_per.$this->lang->line('per_off_lbl').'</span>';
                    }
                    ?>
                    <ul class="product-action">
                      <?php 
                      if(check_user_login() && $ci->is_favorite($this->session->userdata('user_id'), $product_row->product_id)){
                        ?>
                        <li><a href="javascript:void(0)" class="btn_wishlist" data-id="<?=$product_row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('remove_wishlist_lbl')?>" style="background-color: #ff5252"><i class="ion-android-favorite-outline"></i></a></li>
                        <?php
                      }
                      else if($ci->check_cart($product_row->product_id,$this->session->userdata('user_id'))){
                        ?>
                        <li><a href="javascript:void(0)" data-toggle="tooltip" title="<?=$this->lang->line('already_cart_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                        <?php
                      } 
                      else{
                        ?>
                        <li><a href="javascript:void(0)" class="btn_wishlist" data-id="<?=$product_row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('add_wishlist_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                        <?php
                      } 
                      ?>

                      <li><a href="" class="btn_quick_view" data-id="<?=$product_row->product_id?>" title="<?=$this->lang->line('quick_view_lbl')?>"><i class="ion-android-expand"></i></a></li>

                    </ul>
                  </div>
                  <div class="product-content">
                    <h2>
                      <a href="<?php echo site_url('product/'.$product_row->product_slug); ?>">
                        <?php 
                        if(strlen($product_row->product_title) > 20){
                          echo substr(stripslashes($product_row->product_title), 0, 20).'...';  
                        }else{
                          echo $product_row->product_title;
                        }
                        ?>
                      </a>
                    </h2>
                    <div class="product-price"> 
                      <?php 
                      if($product_row->you_save_amt!='0'){
                        ?>
                        <span class="new-price"><?=CURRENCY_CODE.' '.number_format($product_row->selling_price, 2)?></span> 
                        <span class="old-price"><?=CURRENCY_CODE.' '.number_format($product_row->product_mrp, 2);?></span>
                        <?php
                      }
                      else{
                        ?>
                        <span class="new-price"><?=CURRENCY_CODE.' '.number_format($product_row->product_mrp, 2);?></span>
                        <?php

                      }
                      ?>
                      <div class="rating">
                        <?php 
                        for ($x = 0; $x < 5; $x++) { 
                          if($x < $product_row->rate_avg){
                            ?>
                            <i class="fa fa-star" style="color: #F9BA48"></i>
                            <?php  
                          }
                          else{
                            ?>
                            <i class="fa fa-star"></i>
                            <?php
                          }
                        }
                        ?>
                      </div>
                      <?php
                      $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0'; 
                      if(!$ci->check_cart($product_row->product_id,$user_id)){
                        ?>
                        <a href="javascript:void(0)" class="button add-btn btn_cart <?=(!$is_avail) ? 'disabled' : ''?>" data-id="<?=$product_row->product_id?>" data-maxunit="<?=$product_row->max_unit_buy?>" data-toggle="tooltip" title="<?=$this->lang->line('add_cart_lbl')?>"><?=$this->lang->line('add_cart_lbl')?></a>
                        <?php
                      }
                      else{
                        $cart_id=$ci->get_single_info(array('product_id' => $product_row->product_id, 'user_id' => $user_id),'id','tbl_cart');
                        ?>
                        <a href="<?php echo site_url('remove-to-cart/'.$cart_id); ?>" class="button add-btn btn_remove_cart" style="" data-toggle="tooltip" title="<?=$this->lang->line('remove_cart_lbl')?>"><?=$this->lang->line('remove_cart_lbl')?></a>
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>
<?php }   // end inner if condition
}   // end outer if condition
?>

<?php
  // for hide/show top rated products
if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->home_top_rated_opt=='true')
{
  ?>

  <?php 
  // show top rated products
  if(!empty($top_rated_products))
  {
    ?>
    <section class="bestseller-product mb-30">
      <div class="container">
        <div class="row">
          <div class="col-md-12"> 
            <div class="section-title1-border">
              <div class="section-title1">
                <h3><?=$this->lang->line('top_rated_product_lbl')?></h3>
                <?php 
                if(count($top_rated_products) > 5){
                  echo '<div class="category_view_all" style="right: 100px"><a href="'.base_url('/top-rated-products').'" class="pjax">'.$this->lang->line('view_all_lbl').'</a></div>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="top-rated-products mb-30 owl-carousel"> 

            <?php 

            foreach ($top_rated_products as $key => $product_row)
            {

              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $product_row->featured_image);

              $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$product_row->featured_image,205,205);

              $img_file2=$ci->_create_thumbnail('assets/images/products/',$product_row->product_id,$product_row->featured_image2,205,205);

              $is_avail=true;

              if($product_row->status==0)
              {
                $is_avail=false;
              }

              ?>
              <div class="col-md-12 item-col">     
                <div class="single-product3">
                  <?php 
                  if(!$is_avail)
                  {
                    ?>
                    <div class="unavailable_override">
                      <p><?=$this->lang->line('unavailable_lbl')?></p>
                    </div> 
                  <?php } ?>
                  <div class="product-img"> <a href="<?php echo site_url('product/'.$product_row->product_slug); ?>" title="<?=$product_row->product_title?>"> <img class="first-img" src="<?=base_url().$img_file?>"> <img class="hover-img" src="<?=base_url().$img_file2?>"> </a>
                    <?php 
                    if($product_row->you_save_per!='0'){
                      echo '<span class="sicker">'.$product_row->you_save_per.$this->lang->line('per_off_lbl').'</span>';
                    }
                    ?>
                    <ul class="product-action">

                      <?php 
                      if(check_user_login() && $ci->is_favorite($this->session->userdata('user_id'), $product_row->product_id)){
                        ?>
                        <li><a href="javascript:void(0)" class="btn_wishlist" data-id="<?=$product_row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('remove_wishlist_lbl')?>" style="background-color: #ff5252"><i class="ion-android-favorite-outline"></i></a></li>
                        <?php
                      }
                      else if($ci->check_cart($product_row->product_id,$this->session->userdata('user_id'))){
                        ?>
                        <li><a href="javascript:void(0)" data-toggle="tooltip" title="<?=$this->lang->line('already_cart_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                        <?php
                      } 
                      else{
                        ?>
                        <li><a href="javascript:void(0)" class="btn_wishlist" data-id="<?=$product_row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('add_wishlist_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                        <?php
                      } 
                      ?>

                      <li><a href="javascript:void(0)" class="btn_quick_view" data-id="<?=$product_row->product_id?>" title="<?=$this->lang->line('quick_view_lbl')?>"><i class="ion-android-expand"></i></a></li>

                    </ul>
                  </div>
                  <div class="product-content">
                    <h2>
                      <a href="<?php echo site_url('product/'.$product_row->product_slug); ?>">
                        <?php 
                        if(strlen($product_row->product_title) > 20){
                          echo substr(stripslashes($product_row->product_title), 0, 20).'...';  
                        }else{
                          echo $product_row->product_title;
                        }
                        ?>
                      </a>
                    </h2>
                    <div class="product-price"> 
                      <?php 
                      if($product_row->you_save_amt!='0'){
                        ?>
                        <span class="new-price"><?=CURRENCY_CODE.' '.number_format($product_row->selling_price, 2)?></span> 
                        <span class="old-price"><?=CURRENCY_CODE.' '.number_format($product_row->product_mrp, 2);?></span>
                        <?php
                      }
                      else{
                        ?>
                        <span class="new-price"><?=CURRENCY_CODE.' '.number_format($product_row->product_mrp, 2);?></span>
                        <?php

                      }
                      ?>
                      <div class="rating">
                        <?php 
                        for ($x = 0; $x < 5; $x++) { 
                          if($x < $product_row->rate_avg){
                            ?>
                            <i class="fa fa-star" style="color: #F9BA48"></i>
                            <?php  
                          }
                          else{
                            ?>
                            <i class="fa fa-star"></i>
                            <?php
                          }
                        }
                        ?>
                      </div>
                      <?php
                      $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0'; 
                      if(!$ci->check_cart($product_row->product_id,$user_id)){
                        ?>
                        <a href="javascript:void(0)" class="button add-btn btn_cart <?=(!$is_avail) ? 'disabled' : ''?>" data-id="<?=$product_row->product_id?>" data-maxunit="<?=$product_row->max_unit_buy?>" data-toggle="tooltip" title="<?=$this->lang->line('add_cart_lbl')?>"><?=$this->lang->line('add_cart_lbl')?></a>
                        <?php
                      }
                      else{
                        $cart_id=$ci->get_single_info(array('product_id' => $product_row->product_id, 'user_id' => $user_id),'id','tbl_cart');
                        ?>
                        <a href="<?php echo site_url('remove-to-cart/'.$cart_id); ?>" class="button add-btn btn_remove_cart" data-toggle="tooltip" title="<?=$this->lang->line('remove_cart_lbl')?>"><?=$this->lang->line('remove_cart_lbl')?></a>
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>
<?php }   // end inner if condition
}   // end outer if condition
?>

<?php
  // for hide/show home categories
if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->home_cat_wise_opt=='true')
{
  ?>

  <?php
  // show home categories 
  if(!empty($home_categories))
  {
    foreach ($home_categories as $key_cat => $row) {

      $limit=3;
      $sub_categories=$ci->get_home_sub_category($row->id, $limit);

      ?>
      <section class="bestseller-product mb-30">
        <div class="container">
          <div class="row">
            <div class="col-md-12"> 
              <div class="section-title1-border">
                <div class="section-title1">
                  <h3><?=$row->category_name?></h3>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12"> 
              <div class="product-tab-menu-area">
                <div class="product-tab">
                  <ul>
                    <?php
                    $is_active=true;
                    $i=1;

                    foreach ($sub_categories as $key => $value) {

                      if($is_active){
                        $is_active=false;
                        echo '<li class="active"><a data-toggle="tab" href="#'.$value->sub_category_slug.'">'.$value->sub_category_name.'</a></li>';
                      }
                      else{
                        echo '<li><a data-toggle="tab" href="#'.$value->sub_category_slug.'">'.$value->sub_category_name.'</a></li>';
                      }
                    }

                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-content">
            <?php
            $is_active=true;
            $limit=10;

            foreach ($sub_categories as $key => $value) {

              $class='';

              if($is_active){
                $is_active=false;
                $class=' active in';
              }

              ?>
              <div id="<?=$value->sub_category_slug?>" class="tab-pane fade<?=$class?>">
                <div class="row">
                  <div class="bestseller-product3 mb-30 owl-carousel"> 

                    <?php 
                    $products=$ci->get_cat_sub_product($row->id, $value->id);
                    ?>

                    <?php 
                    foreach ($products as $key => $product_row)
                    {

                      $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $product_row->featured_image);

                      $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$product_row->featured_image,205,205);

                      $img_file2=$ci->_create_thumbnail('assets/images/products/',$product_row->product_id,$product_row->featured_image2,205,205);

                      $is_avail=true;

                      if($product_row->status==0)
                      {
                        $is_avail=false;
                      }

                      ?>
                      <div class="col-md-12 item-col">     
                        <?php 
                        if(!$is_avail)
                        {
                          ?>
                          <div class="unavailable_override">
                            <p><?=$this->lang->line('unavailable_lbl')?></p>
                          </div> 
                        <?php } ?>
                        <div class="single-product3">
                          <div class="product-img"> <a href="<?php echo site_url('product/'.$product_row->product_slug); ?>" title="<?=$product_row->product_title?>"> <img class="first-img" src="<?=base_url().$img_file?>"> <img class="hover-img" src="<?=base_url().$img_file2?>"> </a>
                            <?php 
                            if($product_row->you_save_per!='0'){
                              echo '<span class="sicker">'.$product_row->you_save_per.$this->lang->line('per_off_lbl').'</span>';
                            }
                            ?>
                            <ul class="product-action">
                              <?php 
                              if(check_user_login() && $ci->is_favorite($this->session->userdata('user_id'), $product_row->product_id)){
                                ?>
                                <li><a href="javascript:void(0)" class="btn_wishlist" data-id="<?=$product_row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('remove_wishlist_lbl')?>" style="background-color: #ff5252"><i class="ion-android-favorite-outline"></i></a></li>
                                <?php
                              }
                              else if($ci->check_cart($product_row->product_id,$this->session->userdata('user_id'))){
                                ?>
                                <li><a href="javascript:void(0)" data-toggle="tooltip" title="<?=$this->lang->line('already_cart_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                                <?php
                              } 
                              else{
                                ?>
                                <li><a href="javascript:void(0)" class="btn_wishlist" data-id="<?=$product_row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('add_wishlist_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                                <?php
                              } 
                              ?>

                              <li><a href="javascript:void(0)" class="btn_quick_view" data-id="<?=$product_row->product_id?>" title="<?=$this->lang->line('quick_view_lbl')?>"><i class="ion-android-expand"></i></a></li>

                            </ul>
                          </div>
                          <div class="product-content">
                            <h2>
                              <a href="<?php echo site_url('product/'.$product_row->product_slug); ?>">
                                <?php 
                                if(strlen($product_row->product_title) > 14){
                                  echo substr(stripslashes($product_row->product_title), 0, 14).'...';  
                                }else{
                                  echo $product_row->product_title;
                                }
                                ?>
                              </a>
                            </h2>
                            <div class="product-price">
                              <div class="price_holder">
                                <?php 
                                if($product_row->you_save_amt!='0'){
                                  ?>
                                  <span class="new-price"><?=CURRENCY_CODE.' '.number_format($product_row->selling_price, 2)?></span> 
                                  <span class="old-price"><?=CURRENCY_CODE.' '.number_format($product_row->product_mrp, 2);?></span>
                                  <?php
                                }
                                else{
                                  ?>
                                  <span class="new-price"><?=CURRENCY_CODE.' '.number_format($product_row->product_mrp, 2);?></span>
                                  <?php

                                }
                                ?>
                              </div>
                              <div class="rating">
                                <?php 
                                for ($x = 0; $x < 5; $x++) { 
                                  if($x < $product_row->rate_avg){
                                    ?>
                                    <i class="fa fa-star" style="color: #F9BA48"></i>
                                    <?php  
                                  }
                                  else{
                                    ?>
                                    <i class="fa fa-star"></i>
                                    <?php
                                  }
                                }
                                ?>
                              </div>

                              <?php
                              $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0'; 
                              if(!$ci->check_cart($product_row->product_id,$user_id)){
                                ?>
                                <a href="javascript:void(0)" class="button add-btn btn_cart <?=(!$is_avail) ? 'disabled' : ''?>" data-id="<?=$product_row->product_id?>" data-maxunit="<?=$product_row->max_unit_buy?>" data-toggle="tooltip" title="<?=$this->lang->line('add_cart_lbl')?>"><?=$this->lang->line('add_cart_lbl')?></a>
                                <?php
                              }
                              else{
                                $cart_id=$ci->get_single_info(array('product_id' => $product_row->product_id, 'user_id' => $user_id),'id','tbl_cart');
                                ?>
                                <a href="<?php echo site_url('remove-to-cart/'.$cart_id); ?>" class="button add-btn btn_remove_cart" data-toggle="tooltip" title="<?=$this->lang->line('remove_cart_lbl')?>"><?=$this->lang->line('remove_cart_lbl')?></a>
                                <?php
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
      </section>
      <?php
    }
  }
} // end outer if condition
?>

<?php
  // for hide/show recently viewed products
if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->home_recent_opt=='true')
{
  ?>

  <?php
  // show recently viewed items
  if(!empty($recent_viewed_products))
  {
    ?>
    <section class="bestseller-product mb-30">
      <div class="container">
        <div class="row">
          <div class="col-md-12"> 
            <div class="section-title1-border">
              <div class="section-title1">
                <h3><?=$this->lang->line('recent_view_lbl')?></h3>
                <?php 
                if(count($recent_viewed_products) > 5){
                  echo '<div class="category_view_all" style="right: 100px"><a href="'.base_url('/recently-viewed-products').'" class="pjax">'.$this->lang->line('view_all_lbl').'</a></div>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="recently-products mb-30 owl-carousel"> 

            <?php 

            foreach ($recent_viewed_products as $key => $product_row) 
            {

              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $product_row->featured_image);

              $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$product_row->featured_image,205,205);

              $img_file2=$ci->_create_thumbnail('assets/images/products/',$product_row->product_id,$product_row->featured_image2,205,205);

              $is_avail=true;

              if($product_row->status==0)
              {
                $is_avail=false;
              }

              ?>
              <div class="col-md-12 item-col">
                <?php 
                if(!$is_avail)
                {
                  ?>
                  <div class="unavailable_override">
                    <p><?=$this->lang->line('unavailable_lbl')?></p>
                  </div> 
                <?php } ?>     
                <div class="single-product3">
                  <div class="product-img"> <a href="<?php echo site_url('product/'.$product_row->product_slug); ?>" title="<?=$product_row->product_title?>"> <img class="first-img" src="<?=base_url().$img_file?>"> <img class="hover-img" src="<?=base_url().$img_file2?>"> </a>
                    <?php 
                    if($product_row->you_save_per!='0'){
                      echo '<span class="sicker">'.$product_row->you_save_per.$this->lang->line('per_off_lbl').'</span>';
                    }
                    ?>
                    <ul class="product-action">

                      <?php 
                      if(check_user_login() && $ci->is_favorite($this->session->userdata('user_id'), $product_row->product_id)){
                        ?>
                        <li><a href="javascript:void(0)" class="btn_wishlist" data-id="<?=$product_row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('remove_wishlist_lbl')?>" style="background-color: #ff5252"><i class="ion-android-favorite-outline"></i></a></li>
                        <?php
                      }
                      else if($ci->check_cart($product_row->product_id,$this->session->userdata('user_id'))){
                        ?>
                        <li><a href="javascript:void(0)" data-toggle="tooltip" title="<?=$this->lang->line('already_cart_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                        <?php
                      } 
                      else{
                        ?>
                        <li><a href="javascript:void(0)" class="btn_wishlist" data-id="<?=$product_row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('add_wishlist_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                        <?php
                      } 
                      ?>

                      <li><a href="javascript:void(0)" class="btn_quick_view" data-id="<?=$product_row->product_id?>" title="<?=$this->lang->line('quick_view_lbl')?>"><i class="ion-android-expand"></i></a></li>

                    </ul>
                  </div>
                  <div class="product-content">
                    <h2>
                      <a href="<?php echo site_url('product/'.$product_row->product_slug); ?>">
                        <?php 
                        if(strlen($product_row->product_title) > 20){
                          echo substr(stripslashes($product_row->product_title), 0, 20).'...';  
                        }else{
                          echo $product_row->product_title;
                        }
                        ?>
                      </a>
                    </h2>
                    <div class="product-price"> 
                      <div class="price_holder">
                        <?php 
                        if($product_row->you_save_amt!='0'){
                          ?>
                          <span class="new-price"><?=CURRENCY_CODE.' '.number_format($product_row->selling_price, 2)?></span> 
                          <span class="old-price"><?=CURRENCY_CODE.' '.number_format($product_row->product_mrp, 2);?></span>
                          <?php
                        }
                        else{
                          ?>
                          <span class="new-price"><?=CURRENCY_CODE.' '.number_format($product_row->product_mrp, 2);?></span>
                          <?php

                        }
                        ?>
                      </div>
                      <div class="rating">
                        <?php 
                        for ($x = 0; $x < 5; $x++) { 
                          if($x < $product_row->rate_avg){
                            ?>
                            <i class="fa fa-star" style="color: #F9BA48"></i>
                            <?php  
                          }
                          else{
                            ?>
                            <i class="fa fa-star"></i>
                            <?php
                          }
                        }
                        ?>
                      </div>
                      <?php
                      $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0'; 
                      if(!$ci->check_cart($product_row->product_id,$user_id)){
                        ?>
                        <a href="javascript:void(0)" class="button add-btn btn_cart <?=(!$is_avail) ? 'disabled' : ''?>" data-id="<?=$product_row->product_id?>" data-maxunit="<?=$product_row->max_unit_buy?>" data-toggle="tooltip" title="<?=$this->lang->line('add_cart_lbl')?>"><?=$this->lang->line('add_cart_lbl')?></a>
                        <?php
                      }
                      else{
                        $cart_id=$ci->get_single_info(array('product_id' => $product_row->product_id, 'user_id' => $user_id),'id','tbl_cart');
                        ?>
                        <a href="<?php echo site_url('remove-to-cart/'.$cart_id); ?>" class="button add-btn btn_remove_cart" data-toggle="tooltip" title="<?=$this->lang->line('remove_cart_lbl')?>"><?=$this->lang->line('remove_cart_lbl')?></a>
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>
  <?php } 
} // end outer if condition
?>