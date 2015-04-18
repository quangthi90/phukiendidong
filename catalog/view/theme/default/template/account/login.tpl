<?php echo $header; ?>
<?php echo $column_right; ?>
<div id="content">
    <?php echo $content_top; ?>
   <div class="my-breadcrumb">
        <div class="span7">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <div class="breadcrumb-box">
                    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                </div>
                <div class="breadcrumb-arrow"></div>
            <?php } ?>
        </div>
  </div>
  <h3 class="heading-title"><?php echo $heading_title; ?></h3>
  <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
  <div class="login-content">
    <div class="left">
      <h4 class="heading-title-l2"><?php echo $text_new_customer; ?></h4>
      <div class="content">
        <p><b><?php echo $text_register; ?></b></p>
        <p><?php echo $text_register_account; ?></p> 
        <button onclick="location.href='<?php echo $register; ?>';" class="btn btn-primary" style="height: 30px; padding: 1px 14px;" type="button">
            <?php echo $button_continue; ?>
        </button>
      </div>
    </div>
    <div class="right">
      <h4 class="heading-title-l2"><?php echo $text_returning_customer; ?></h4>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class="content">
          <p><?php echo $text_i_am_returning_customer; ?></p>
          <b><?php echo $entry_email; ?></b><br />
          <input type="text" name="email" value="<?php echo $email; ?>" />
          <br />
          <br />
          <b><?php echo $entry_password; ?></b><br />
          <input type="password" name="password" value="<?php echo $password; ?>" />
          <br />
          <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a><br />
          <br />
          <input type="submit" value="<?php echo $button_login; ?>" class="btn btn-primary" style="height: 30px; padding: 1px 14px;" />
          <?php if ($redirect) { ?>
          <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
          <?php } ?>
        </div>
      </form>
    </div>
  </div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});
//--></script> 
<?php echo $footer; ?>