<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="left"></div>
    <div class="right"></div>
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $text_send; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
            <table class="form">
              <tr>
                <td><?php echo $entry_email; ?></td>
                <td><?php echo $email; ?>
                <input type="hidden" name="email" value="<?php echo $email; ?>" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_customer; ?></td>
                <td><?php echo $customer; ?>
                <input type="hidden" name="customer" value="<?php echo $customer; ?>" /></td>
              </tr>
              <tr>
                <td> <?php echo $entry_title; ?></td>
                <td><div style="word-wrap: break-word; width: 600px;"><?php echo $title; ?></div>
                <input type="hidden" name="title" value="<?php echo $title; ?>" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_content; ?></td>
                <td><div style="word-wrap: break-word; width: 600px;"><?php echo $content; ?></div>
                <input type="hidden" name="content" value="<?php echo $content; ?>" /></td>
              </tr>
              <tr>
              	<td><?php echo $entry_reply; ?></td>
              	<td><?php echo $entry_title; ?><br /><input type="text" name="reply_title" style="width: 500px;" value="<?php echo $reply_title; ?>" />
              	<?php if ($error_title) { ?>
                <span class="error"><?php echo $error_title; ?></span>
              	<?php } ?><br /><br />
              	
              	<?php echo $entry_content; ?><textarea name="reply_content" id="reply_content"><?php echo $reply_content; ?></textarea>
              	<?php if ($error_content) { ?>
                <span class="error"><?php echo $error_content; ?></span>
              	<?php } ?></td>
              </tr>
            </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
CKEDITOR.replace('reply_content', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
//--></script> 
<script type="text/javascript"><!--
$('.htabs a').tabs();
$('.vtabs a').tabs();
//--></script>
<script type="text/javascript"><!--
$('form input[type=radio]').live('click', function () {
	$('form input[type=radio]').attr('checked', false);
	$(this).attr('checked', true);
});
//--></script> 
<?php echo $footer; ?>