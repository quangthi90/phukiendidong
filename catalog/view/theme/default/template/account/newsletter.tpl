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
<div id="content"><?php echo $content_top; ?>  
  <h2 class='ac-title'><?php echo $heading_title; ?></h2>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_newsletter; ?></td>
          <td style= "width: 67%;">
            <?php if ($newsletter) { ?>
                <span class="radio_field">
                    <input id="newsletter_yes" type="radio" name="newsletter" value="1" checked="checked" />
                    <label for="newsletter_yes" class=="label_newsletter"><?php echo $text_yes; ?></label>
                </span>
                <span class="radio_field">
                    <input id="newsletter_no" type="radio" name="newsletter" value="0" />
                    <label for="newsletter_no" class=="label_newsletter"><?php echo $text_no; ?></label>
                </span>            
            <?php } else { ?>
                <span class="radio_field">
                    <input id="newsletter_yes" type="radio" name="newsletter" value="1" />
                    <label for="newsletter_yes" class=="label_newsletter"><?php echo $text_yes; ?></label>
                </span>
                <span class="radio_field">
                    <input id="newsletter_no" type="radio" name="newsletter" value="0" checked="checked" />
                    <label for="newsletter_no" class=="label_newsletter"><?php echo $text_no; ?></label>
                </span>  
            <?php } ?>
          </td>
        </tr>
      </table>
    </div>
    <div class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
      <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
    </div>
  </form>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>