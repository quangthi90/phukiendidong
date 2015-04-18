<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
<div class="my-breadcrumb">
	<div class="span7">
		<div class="breadcrumb-box">
			<a><?php echo $text_home; ?></a>
		</div>
		<div class="breadcrumb-arrow"></div>
	</div>
	
	<div class="span4" style="float: right; text-align: right; padding-right: 10px;">
		<form class="form-search" action-"GET">
			<div class="input-append" style="padding-top: 2px;">
				<input type="hidden" name="route" value="product/search"/>
				<?php if ($filter_name) { ?>
				    <input name="filter_name" type="text" class="span2 search-query" style="width: 150px;" value="<?php echo $filter_name; ?>" />
				    <?php } else { ?>
				    <input name="filter_name" type="text" class="span2 search-query" style="width: 150px;" value="<?php echo $filter_name; ?>" />
				<?php } ?>
				<button type="submit" class="btn button-search" style=" border-radius: 0 14px 14px 0; margin-left: -4px;"><i class="icon-search" style="font-size: 18px;"></i></button>
			</div>
		</form>
	</div>
</div>
<div class="cleaner"></div>
<?php if ($error_warning) { ?>
<div class="warning" style="margin-top: 10px; margin-bottom: 10px;"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success" style="margin-top: 10px; margin-bottom: 10px;"><?php echo $success; ?></div>
<?php } ?>
<div class="cleaner"></div>
<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>