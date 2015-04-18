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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
      	<a onclick="location = '<?php echo $insert; ?>'" class="button"><?php echo $button_insert; ?></a>
      	<a onclick="$('#form').attr('action', '<?php echo $recovery; ?>'); $('#form').submit();" class="button">
      		<?php echo $button_recovery; ?>
      	</a>
      	<a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="center"><?php echo $column_image; ?></td>
              <td class="left"><?php if ($sort == 'title') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'category_name') { ?>
                <a href="<?php echo $sort_category; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_category; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_category; ?>"><?php echo $column_category; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'news_status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
                <td><?php if ($sort == 'news_created_date') { ?>
                <a href="<?php echo $sort_created; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_created_date; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_created; ?>"><?php echo $column_created_date; ?></a>
                <?php } ?></td>
                <td><?php if ($sort == 'news_updated_date') { ?>
                <a href="<?php echo $sort_updated; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_updated_date; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_updated; ?>"><?php echo $column_updated_date; ?></a>
                <?php } ?></td>
                <td><?php if ($sort == 'special') { ?>
                <a href="<?php echo $sort_special; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_special; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_special; ?>"><?php echo $column_special; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td></td>
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
              <td><select name="filter_category">
                  <option value="*"><?php echo $text_none; ?></option>
                  <?php if ($all_categories) {
                  	foreach ($all_categories as $category){	
                  		if ($category['news_category_id'] == $filter_category){
                  ?>
                  <option value="<?php echo $category['news_category_id']; ?>" selected="selected"><?php echo $category['category_name']; ?></option>
                  <?php }else{?>
                  <option value="<?php echo $category['news_category_id']; ?>"><?php echo $category['category_name']; ?></option>
                  <?php
                  } 
                  	}
                  }?>
                </select></td>
              <td><select name="filter_status">
                  <option value="*"><?php echo $text_none; ?></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td><input type="text" name="filter_created" value="<?php echo $filter_created; ?>" size="12" class="date" /></td>
              <td><input type="text" name="filter_updated" value="<?php echo $filter_updated; ?>" size="12" class="date" /></td>
              <td></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($news) { ?>
            <?php foreach ($news as $new) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($new['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $new['news_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $new['news_id']; ?>" />
                <?php } ?></td>
              <td class="center"><img src="<?php echo $new['image']; ?>" alt="<?php echo $new['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
              <td class="left"><?php echo $new['name']; ?></td>
              <td class="left"><?php echo $new['category']; ?></td>
              <td class="left"><?php echo $new['status']; ?></td>
              <td class="left"><?php echo $new['created']; ?></td>
              <td class="left"><?php echo $new['updated']; ?></td>
              <td class="left"><?php echo $new['special']; ?></td>
              <td class="right"><?php foreach ($new['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=news/news&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_category = $('select[name=\'filter_category\']').attr('value');
	
	if (filter_category != '*') {
		url += '&filter_category=' + encodeURIComponent(filter_category);
	}
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	var filter_created = $('input[name=\'filter_created\']').attr('value');
	
	if (filter_created) {
		url += '&filter_created=' + encodeURIComponent(filter_created);
	}

	var filter_updated = $('input[name=\'filter_updated\']').attr('value');
	
	if (filter_updated) {
		url += '&filter_updated=' + encodeURIComponent(filter_updated);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=news/news/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.news_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_name\']').val(ui.item.label);

		return false;
	}
});
//--></script> 
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'dd-mm-yy'});
$('.datetime').datetimepicker({
	dateFormat: 'dd-mm-yy',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script> 
<?php echo $footer; ?>