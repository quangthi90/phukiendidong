<div class="box out-content box-shadown">
  <div class="box-title"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <ul>
      <li class="title">Tài khoản</li>
      <?php if (!$logged) { ?>
        <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a> / <a href="<?php echo $register; ?>">
          <?php echo $text_register; ?></a></li>
        <li><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></li>
      <?php } ?>
      <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
      <?php if ($logged) { ?>
      <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
      <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
      <?php } ?>
      <?php if ($logged) { ?>
      <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
      <?php } ?>
      <li class="title">Đơn hàng</li>
      <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
      <li class="title">Nhận tin</li>
      <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>      
    </ul>
  </div>
</div>
