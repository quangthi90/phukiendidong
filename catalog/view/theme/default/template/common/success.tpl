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
  <?php echo $text_message; ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>