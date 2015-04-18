<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
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
  <div class="sitemap-info">
    <div class="left">
      <div class="sitemap-box">
        <h4>Sản phẩm</h4>
      <ul>
        <?php foreach ($categories as $category_1) { ?>
        <li><a href="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?></a>
          <?php if ($category_1['children']) { ?>
          <ul>
            <?php foreach ($category_1['children'] as $category_2) { ?>
            <li><a href="<?php echo $category_2['href']; ?>"><?php echo $category_2['name']; ?></a>              
            </li>
            <?php } ?>
          </ul>
          <?php } ?>
        </li>
        <?php } ?>
      </ul>
      </div>      
    </div>
    <div class="right">
      <div class="sitemap-box">
        <h4>Mua hàng</h4>
        <ul>
          <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
          <li><a href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a></li>
          <li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
          <li><a href="<?php echo $search; ?>"><?php echo $text_search; ?></a></li>
        </ul>
      </div>
      <div class="sitemap-box">
        <h4><?php echo $text_account; ?></h4>
        <ul>
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
          <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
          <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
          <li><a href="<?php echo $history; ?>"><?php echo $text_history; ?></a></li>
          <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
        </ul>
      </div>
      <div class="sitemap-box">
        <h4>Tin tức</h4>
        <ul>
          <li><a href="#">Tin công nghệ</a></li>
          <li><a href="#">Tin khoa học đời sống</a></li>
          <li><a href="#">Tin chứng khoán</a></li>
          <li><a href="#">Tin bất động sản</a></li>
          <li><a href="#">Tin xã hội</a></li>
          <li><a href="#">Tin thể thao</a></li>
        </ul>
      </div>
      <div class="sitemap-box">
        <h4><?php echo $text_information; ?></h4>
        <ul>
            <?php foreach ($informations as $information) { ?>
            <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
            <?php } ?>
            <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
          </ul>
      </div>      
    </div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>