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
  <?php if ($orders) { ?>
  <?php foreach ($orders as $order) { ?>
  <div class="order-list">
    <table width="100%" class='order_lst'>
      <tbody>
        <tr>
          <td colspan="3">
            <b><?php echo $text_order_id; ?></b> #<b><?php echo $order['order_id']; ?></b>
          </td>
          <td colspan="2" style= "text-align: right; width: 220px;">
            <b><?php echo $text_status; ?></b> <b><?php echo $order['status']; ?> </b>
          </td>
        </tr>
        <tr>
          <td class= "td_lb">
            <?php echo $text_date_added; ?>
          </td>
          <td class= "td_vl">
            <?php echo $order['date_added']; ?>
          </td>
          <td  class= "td_lb">
            <?php echo $text_customer; ?>
          </td>
          <td class= "td_vl">
            <?php echo $order['name']; ?>
          </td>
          <td rowspan="2" style= "text-align: center; vertical-align: middle;">
            <a href="<?php echo $order['href']; ?>">
              <img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" />
              </a>
              <a href="<?php echo $order['reorder']; ?>">
                <img src="catalog/view/theme/default/image/reorder.png" alt="<?php echo $button_reorder; ?>" title="<?php echo $button_reorder; ?>" />
              </a>
          </td>
        </tr>
        <tr>
          <td class= "td_lb">
            <?php echo $text_products; ?>
          </td>
          <td class= "td_vl">
            <?php echo $order['products']; ?>
          </td>
          <td class= "td_lb">
            <?php echo $text_total; ?>
          </td>
          <td class= "td_vl">
            <?php echo $order['total']; ?>
          </td>            
        </tr>
      </tbody>
    </table>      
  </div>
  <?php } ?>
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>