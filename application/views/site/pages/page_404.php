<?php
define('APP_NAME', $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->site_name);
define('APP_FAVICON', $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->web_favicon);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="">
<meta name="theme-color" content="#ff5252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> <?=(isset($current_page)) ? $current_page . ' | ' : '';?><?php echo APP_NAME; ?></title>
<link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/') . APP_FAVICON ?>" />

<link rel="stylesheet" href="<?= base_url('assets/site_assets/css/normalize.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/site_assets/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/site_assets/css/default.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/site_assets/css/style.min.css') ?>">
<style>
.error-item-dtl{
	width:50% !important;
}
.ptb-150{
	padding:170px 0;
}
@media (max-width:767px) {
	.error-item-dtl{
		width:100% !important;
	}
	.ptb-150{
		padding:120px 0;
	}
	.search-form-wrapper > h1 {
		letter-spacing: 0px;
	}
}
@media (max-width:479px) {
	.ptb-150{
		padding:150px 0;
	}	
	.search-form-wrapper > h1 {
		font-size: 120px;
		font-weight: 700;
		color: #ff5252;
		line-height: 70px;
		margin: 0 0 30px;
		letter-spacing: 0;
	}
}
</style>
</head>
<body>
  <section class="error-404-area">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="search-form-wrapper ptb-150">
            <h1>404</h1>
            <h2><?=$this->lang->line('page_not_found_lbl')?></h2>
            <div class="error-message">
              <p class="error-item-dtl"><?=$this->lang->line('page_not_found_desc_lbl')?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>