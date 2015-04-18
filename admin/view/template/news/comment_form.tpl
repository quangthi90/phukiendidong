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
    <div class="heading">
      <h1><img src="view/image/review.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <input type="hidden" name="review" value="1" />
        <table class="form">
          <tr>
            <td><?php echo $entry_customer; ?></td>
            <td>
              <select name="customer_id">
              <?php foreach ($customers as $customer) { ?>
                <?php if ($customer['customer_id'] == $customer_id) { ?>
                <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['name']; ?></option>
                <?php }else { ?>
                <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['name']; ?></option>
                <?php } ?>
              <?php } ?>
              </select>
               <?php if ($error_customer) { ?>
              <span class="error"><?php echo $error_customer; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_news; ?></td>
            <td>
              <select name="news_id">
              <?php foreach ($news as $new) { ?>
                <?php if ($new['news_id'] == $news_id) { ?>
                <option value="<?php echo $new['news_id']; ?>" selected="selected"><?php echo $new['title']; ?></option>
                <?php }else { ?>
                <option value="<?php echo $new['news_id']; ?>"><?php echo $new['title']; ?></option>
                <?php } ?>
              <?php } ?>
              </select>
              <?php if ($error_news) { ?>
              <span class="error"><?php echo $error_news; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_content; ?></td>
            <td><textarea name="content" cols="60" rows="8"><?php echo $content; ?></textarea>
              <?php if ($error_content) { ?>
              <span class="error"><?php echo $error_content; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="status">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
  delay: 0,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.product_id
          }
        }));
      }
    });
  },
  select: function(event, ui) {
    $('input[name=\'product\']').val(ui.item.label);
    $('input[name=\'product_id\']').val(ui.item.value);
    
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});
//--></script> 
<?php echo $footer; ?>