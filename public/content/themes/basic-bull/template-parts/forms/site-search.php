<form role="search" method="get" class="search-form" action="<?php echo get_home_url(); ?>">

	<div class="form-group">
	
		<label for="main-search" class="srt-only">Search: </label>

		<div class="input-wrapper">
			
			<input id="main-search" type="search" class="search-field" placeholder="Search" autocomplete="off" value="" name="s">
			
			<input type="submit" class="search-submit" value="">

			<i class="icon icon-search button-icon">

		        <svg>
		        	<use xlink:href="<?php echo get_template_directory_uri(); ?>/img/spritemap.svg#icon-ui-search"></use>
		        <svg>
		        	
		    </i>

		</div>

	</div>

</form>