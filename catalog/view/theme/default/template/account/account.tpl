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
<?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
<?php } ?>
  <?php echo $content_top; ?>  
  <h2 class='ac-title'><?php echo $text_my_account; ?></h2>
  <div class="content">
    <ul>
      <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
      <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
      <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
    </ul>
  </div>
  <h2 class='ac-title'><?php echo $text_my_orders; ?></h2>
  <div class="content">
    <ul>
      <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
      <?php if ($reward) { ?>
      <!--li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li-->
      <?php } ?>
      <!--li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li-->
      <!--li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li-->
    </ul>
  </div>
  <h2 class='ac-title'><?php echo $text_my_newsletter; ?></h2>
  <div class="content">
    <ul>
      <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
    </ul>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 