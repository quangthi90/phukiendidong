<?php if ( count($categories) > 0 ){ ?>
<?php foreach ( $categories as $category ){ ?>
<?php // if ( count($newses[$category['id']]) == 7 ){ ?>
<?php if (isset($newses[$category['id']])) { ?> 
<div class="box">
  <div class="box-hl"></div>
  <div class="box-hr"></div>
  <div class="box-heading"><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></div>
  <div class="box-content">
  	<?php foreach ( $newses[$category['id']] as $i => $news ){ ?>  	
  	<div class="box-news fl">
    	<div class="news_title">
        	<a href="<?php echo $news['href']; ?>"><?php echo $news['title']; ?></a> 
        </div>	
        <div class="news_image">
        	<a href="<?php echo $news['href']; ?>" title="<?php echo $news['title']; ?>"><img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>" /></a>
        </div>
        <div class="overlay"></div>
	   </div>
    <?php } ?>
    <div class="cb"></div>
  </div>
</div>
<?php } ?>
<?php } ?>
<?php } ?>

