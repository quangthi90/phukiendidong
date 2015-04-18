<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  	</div>
  	<?php if ($success) { ?>
  	<div class="success"><?php echo $success; ?></div>
  	<?php } ?>
  	<?php if ($error) { ?>
  	<div class="warning"><?php echo $error; ?></div>
  	<?php } ?>
  	<div class="box">
  		<div class="heading">
      		<h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    	    <div class="buttons"><a onclick="$('form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
      </div>
    	<div class="content">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    		<table class="list">
    			<thead>
    				<tr>
    					<td><?php echo $text_module_name; ?></td>
              <td><?php echo $text_layout; ?></td>
              <td><?php echo $text_position; ?></td>
              <td><?php echo $text_limit; ?></td>
    				</tr>
    			</thead>
    			<tbody>
    				<?php if ($extensions) { ?>
          	<?php foreach ($extensions as $modules) { ?>
            <?php foreach ($modules as $key => $module) { ?>   
            <tr>
            	<td class="left"><?php echo $module['name']; ?></td>
            	<td class="left"><?php echo $module['layout']; ?></td>
              <td class="left"><?php echo $module['position']; ?></td>
              <td class="left">
                <input type="text" name="module[<?php echo $module['code']; ?>][<?php echo $key; ?>][limit]" value="<?php echo $module['limit']; ?>" />
              </td> 
          	</tr>
          	<?php } ?>
            <?php } ?>
          	<?php } else { ?>
          		<tr>
            		<td class="center" colspan="4"><?php echo $text_no_results; ?></td>
          		</tr>
          	<?php } ?>
            <?php foreach ($setting as $key => $value) { ?>
              <tr>
                <td class="left"><?php echo $value['layout']; ?></td>
                <td class="left"><?php echo $value['layout']; ?></td>
                <td class="left"></td>
                <td class="left"><input type="text" name="setting[<?php echo $key; ?>]" value="<?php echo $value['limit']; ?>" /></td>
              </tr>
            <?php } ?>
    			</tbody>
    		</table>
        </form>
    	</div>
  	</div>
</div>
<?php echo $footer; ?>