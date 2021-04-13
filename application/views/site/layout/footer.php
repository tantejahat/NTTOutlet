  <footer>
    <div class="footer-container white-bg"> 
      <div class="footer-top-area ptb-50">
        <div class="container">
          <div class="row"> 
            <div class="col-md-4 col-sm-6">
              <div class="single-footer"> 
                <div class="footer-logo"> <a href="<?=base_url('/')?>"><img src="<?=base_url('assets/images/').APP_LOGO_2?>" alt=""></a> </div>
                <div class="footer-content">
                  <p>
                    <?php

                    $about_content=strip_tags($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->about_content);
                    if(strlen($about_content) > 150){
                      echo substr($about_content,0,150).'...';
                    }
                    else{
                      echo $about_content;
                    }
                    ?>
                  </p>
                  <div class="contact">
                    <p>
                      <label><?=$this->lang->line('address_sort_lbl')?>:</label>
                      <?php 
                      $address=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->address;
                      if(strlen($address) > 33){
                        echo substr($address,0,33).'...';
                      }
                      else{
                        echo $address;
                      }
                      ?>
                    </p>
                    <p>
                      <label><?=$this->lang->line('phone_sort_lbl')?>:</label>
                      <a href="tel: <?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->contact_number?>"><?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->contact_number?></a>
                    </p>
                    <p>
                      <label><?=$this->lang->line('email_sort_lbl')?>:</label>
                      <a href="mailto:<?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->contact_email?>"><?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->contact_email?></a></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2 col-sm-6">
                <div class="single-footer mt-10">
                  <div class="footer-title">
                    <h3><?=$this->lang->line('about_section_lbl')?></h3>
                  </div>
                  <ul class="footer-info">
                    <?php 
                    if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->about_status=='true')
                    {
                      ?>
                      <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('about-us'); ?>"><?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->about_page_title?></a></li>
                    <?php } ?>
                    
                    <?php 
                    if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->terms_of_use_page_status=='true')
                    {
                      ?>
                      <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('terms-of-use'); ?>"><?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->terms_of_use_page_title?></a></li>
                    <?php } ?>
                    <?php 
                    if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->privacy_page_status=='true')
                    {
                      ?>
                      <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('privacy'); ?>"><?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->privacy_page_title?></a></li>
                    <?php } ?>
                    <?php 
                    if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->refund_return_policy_status=='true')
                    {
                      ?>
                      <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('refund-return-policy'); ?>"><?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->refund_return_policy_page_title?></a></li>
                    <?php } ?>
                    <?php 
                    if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->cancellation_page_status=='true')
                    {
                      ?>
                      <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('cancellation'); ?>"><?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->cancellation_page_title?></a></li>
                    <?php } ?>

                    <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('payments'); ?>"><?=$this->lang->line('payment_lbl')?></a></li>
                  </ul>
                </div>
              </div>
              <div class="col-md-2 col-sm-6">
                <div class="single-footer mt-10">
                  <div class="footer-title">
                    <h3><?=$this->lang->line('myaccount_section_lbl')?></h3>
                  </div>
                  <ul class="footer-info">
                    <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('my-account'); ?>"><?=$this->lang->line('myaccount_lbl')?></a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('my-orders'); ?>"><?=$this->lang->line('myorders_lbl')?></a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('my-cart'); ?>"><?=$this->lang->line('shoppingcart_lbl')?></a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('wishlist'); ?>"><?=$this->lang->line('mywishlist_lbl')?></a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('my-reviews'); ?>"><?=$this->lang->line('myreviewrating_lbl')?></a></li>
                    <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('faq'); ?>"><?=$this->lang->line('faq_lbl')?></a></li>
                  </ul>
                </div>
              </div>
              <div class="col-md-4 col-sm-6">
                <div class="single-footer mt-10">
                  <?php 
                  if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->facebook_url!='' || $this->db->get_where('tbl_settings', array('id' => '1'))->row()->twitter_url!='' || $this->db->get_where('tbl_settings', array('id' => '1'))->row()->instagram_url!='' || $this->db->get_where('tbl_settings', array('id' => '1'))->row()->youtube_url!='')
                  {
                    ?>
                    <div class="footer-title">
                      <h3><?=$this->lang->line('followus_section_lbl')?></h3>
                    </div>
                    <ul class="socil-icon mb-40">
                      <?php 
                      if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->facebook_url!='')
                      {
                        ?>
                        <li><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->facebook_url?>" data-toggle="tooltip" title="Facebook" target="_blank"><i class="ion-social-facebook"></i></a></li>
                      <?php } ?>
                      <?php 
                      if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->twitter_url!='')
                      {
                        ?>
                        <li><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->twitter_url?>" data-toggle="tooltip" title="Twitter" target="_blank"><i class="ion-social-twitter"></i></a></li>
                      <?php } ?>

                      <?php 
                      if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->instagram_url!='')
                      {
                        ?>
                        <li><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->instagram_url?>" data-toggle="tooltip" title="Instagram" target="_blank"><i class="ion-social-instagram"></i></a></li>
                      <?php } ?>

                      <?php 
                      if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->youtube_url!='')
                      {
                        ?>
                        <li><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->youtube_url?>" data-toggle="tooltip" title="Youtube" target="_blank"><i class="ion-social-youtube"></i></a></li>
                      <?php } ?>
                      
                    </ul>
                  <?php } ?>
                  <div class="footer-title">
                    <h3><?=$this->lang->line('downloadapps_section_lbl')?></h3>
                  </div>
                  <div class="footer-content"> 
                    <?php 
                    if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->android_app_url!='')
                    {
                      ?>
                      <a href="<?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->android_app_url?>" target="_blank"><img src="<?=base_url('assets/images/google-play.png')?>" alt=""></a> 
                    <?php } ?>
                    <?php 
                    if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->ios_app_url!='')
                    {
                      ?>
                      <a href="<?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->ios_app_url?>" target="_blank"><img src="<?=base_url('assets/images/app-store.png')?>" alt=""></a> </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-bottom-area">
          <div class="container">
            <div class="row"> 
              <div class="col-md-6 col-sm-6">
                <div class="copyright-text">
                  <p><?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->copyright_text?></p>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="payment-img text-right"> <a href="javascript:void(0)"><img src="<?=base_url('assets/site_assets/img/payment/payment.png')?>" alt=""></a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Product Quick Preview -->
      <div id="productQuickView" class="modal fade" role="dialog" style="z-index: 9999999">
        <div class="modal-dialog"> 
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body"></div>
          </div>
        </div>
      </div>

      <div id="size_chart" class="modal" style="z-index: 9999999;background: rgba(0,0,0,0.5);overflow-y: auto;">
        <div class="modal-dialog modal-confirm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="font-weight: 600"><?=$this->lang->line('size_chart')?></h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:0px;padding-top:15px;">
              <img src="" class="size_chart_img">
              <h3 class="no_data"><?=$this->lang->line('no_data')?></h3>
            </div>
          </div>
        </div>
      </div>

    </footer>
    
    <style type="text/css">
      .radio-group{
        position: relative;
      }
      .radio_btn{
        display: inline-block;
        width: auto;
        height: auto;
        background-color: #eee;
        border: 2px solid #ddd;
        cursor: pointer;
        margin: 2px 1px;
        text-align: center;
        padding: 5px 15px;
      }
      .radio_btn.selected{
        border-color: #ff5252;
      }
    </style>

    <div id="cartModal" class="modal fade" role="dialog" style="z-index: 9999999">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body"></div>
        </div>
      </div>
    </div>
    <?php
    if($this->session->flashdata('cart_msg')) {
      $message = $this->session->flashdata('cart_msg');
      ?>
      <script type="text/javascript">
        var _msg='<?=$message['message']?>';
        var _class='<?=$message['class']?>';

        $('.notifyjs-corner').empty();
        $.notify(
          _msg, 
          { position:"top right",className: _class }
          ); 
        </script>
        <?php
      }
      ?>

      <?php
      if($this->session->flashdata('response_msg')) {
        $message = $this->session->flashdata('response_msg');
        ?>
        <script type="text/javascript">
          var _msg='<?=$message['message']?>';
          var _class='<?=$message['class']?>';

          _msg=_msg.replace(/(<([^>]+)>)/ig,"");

          $('.notifyjs-corner').empty();
          $.notify(_msg, { position:"top right",className: _class}); 
        </script>
        <?php
      }
      ?>

      <?php 
      if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='local'){
        ?>

        <script src="<?=base_url('assets/site_assets/js/bootstrap.min.js')?>"></script>

        <script type="text/javascript" src="<?=base_url('assets/site_assets/js/jquery.scrollUp.min.js')?>"></script>

        <script type="text/javascript" src="<?=base_url('assets/site_assets/js/jquery.meanmenu.min.js')?>"></script>

        <script type="text/javascript" src="<?=base_url('assets/site_assets/js/owl.carousel.min.js')?>"></script>

      <?php }else if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='cdn'){ ?>
        <!-- Include CDN Files -->

        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/scrollup/2.4.1/jquery.scrollUp.min.js"></script>

        <script type="text/javascript" src="<?=base_url('assets/site_assets/js/jquery.meanmenu.min.js')?>"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
      <?php } ?>

      <?php 
      // for dynamic js files
      echo put_cdn_footers();
      echo put_footers();
      ?>

      <script type="text/javascript" src="<?=base_url('assets/site_assets/js/jquery-ui.min.js')?>"></script>

      <script type="text/javascript" src="<?=base_url('assets/sweetalert/sweetalert.min.js')?>"></script>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

      <script type="text/javascript" src="<?=base_url('assets/site_assets/js/plugins.js')?>"></script>

      <script type="text/javascript" src="<?=base_url('assets/site_assets/js/custom_jquery.js')?>"></script>

      <script src="<?=base_url('assets/site_assets/js/cust_javascript.js')?>"></script>

      <?=html_entity_decode($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->footer_code)?>

    </body>
    </html>