<?php echo $header; ?>
<div class="my-breadcrumb out-content">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <div class="breadcrumb-box">
          <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
      </div>
      <div class="breadcrumb-arrow"></div>
  <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
  <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
<?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
<?php } ?>
  <?php echo $content_top; ?>  
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <h2 class='ac-title'><?php echo $text_your_details; ?></h2>
    <div class="content">
      <div class="fl">
          <div id="checkimage" style="position: relative; margin-bottom: 20px;">
          <div style="width: 210px; height: 210px; overflow: hidden; opacity: 0; position: absolute; z-index: 100;">
          <input name="user_thumb" type="file" onchange="readURL(this);" style="font-size: 480px; z-index: 100; width: 210px; height: 210px;" />
          </div>
          <div class="user_avatar">
            <img id="user_thumb" src="<?php echo $thumb_url; ?>" class="img-polaroid" style="width: 200px; height: 200px; border: none; padding: 2px;">
          </div>
          </div>
          <div id="upload_message"><?php echo $text_choose_thumb; ?></div>
        </div>
        <script type="text/javascript"><!--//
          function readURL(input) {
            var formData = new FormData();

            if (input.files && input.files[0]) {
              var reader = new FileReader();

              reader.onload = function (e) {
                $('#user_thumb')
                .attr('src', e.target.result)
                .width(200)
                .height(200);
              };

              reader.readAsDataURL(input.files[0]);

              formData.append('thumb', input.files[0]);
            }

            $.ajax({
              type: "POST",
              url: "<?php echo $changeThumb; ?>",
              enctype: 'multipart/form-data',
              data: formData,
              processData: false,  
              contentType: false, 
              dataType: 'json',
              success: function ( json ) {
                $('#upload-message').remove();
                if (json.status == 'failed') {
                  $('#upload_message').after('<div style="margin-top: 10px;" id="upload-message" ><span class="error">' + json.message + '</span></div>');
                }else {
                  $('#upload_message').after('<div style="margin-top: 10px;" id="upload-message" ><span class="success">' + json.message + '</span></div>');
                }
              }
            });
          }
        //--></script>
        <div class="fl" style="margin-left: 20px;">
          <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
            <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
              <?php if ($error_firstname) { ?>
              <span class="error"><?php echo $error_firstname; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
            <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" />
              <?php if ($error_lastname) { ?>
              <span class="error"><?php echo $error_lastname; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_email; ?></td>
            <td><input type="text" name="email" value="<?php echo $email; ?>" />
              <?php if ($error_email) { ?>
              <span class="error"><?php echo $error_email; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_telephone; ?></td>
            <td><input type="text" name="telephone" value="<?php if (isset($telephone)) echo $telephone; ?>" />
          </tr>
          </table>
        </div>  
    </div>
    <div class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
      <div class="right">
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
  </form>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>