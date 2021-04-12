<?php 
  $this->load->view('site/layout/breadcrumb'); 
  // print_r($contact_subjects);

  // print_r($settings_row);

  $ci =& get_instance();
?>
<section class="about-us-area"> 
  <div class="container">
    <div class="row"> 
      <div class="col-md-12">
        <?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->about_content?>
      </div>
    </div>
  </div>
</section>
    