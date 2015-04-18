<div class="slideshow">
      <!--
	<div id="slideshow<?php echo $module; ?>" class="nivoSlider" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;">
        
	</div> -->
	<div id="slideshow-home">  
		<div class="nivoSlider">
			<?php foreach ($banners as $banner) { ?>
        	<?php if ($banner['link']) { ?>
        	<a href="<?php echo $banner['link']; ?>">
        		<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
        	</a>
        	<?php } else { ?>
        	<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
        	<?php } ?>
        	<?php } ?>
			<!--<a href="#">
				<img src="<?php echo HTTP_IMAGE; ?>data/slideshow/sl0.jpg" alt="Supporting your technology"  />
			</a>     
			<a href="#">
				<img src="<?php echo HTTP_IMAGE; ?>data/slideshow/sl1.jpg" alt="Supporting your technology"  />
			</a>
			<a href="#">
				<img src="<?php echo HTTP_IMAGE; ?>data/slideshow/sl2.jpg" alt="Supporting your technology"  />
			</a>
			<a href="#">
				<img src="<?php echo HTTP_IMAGE; ?>data/slideshow/sl3.jpg" alt="Supporting your technology"  />
			</a>//-->
		</div>
	</div>
</div>
<div class="line-shadown"></div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#slideshow-home .nivoSlider').nivoSlider();
});
--></script>