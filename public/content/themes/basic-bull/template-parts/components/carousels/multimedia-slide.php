<?php
	
	$src = "";
	$poster = "";
	$class = "";
	$dataUrl = "";
	$dataId = "";
	$url = "";
	$closeButton = "";

	$mediaType = get_sub_field('slide_type');
	$image = get_sub_field('slide_image');

	// iframe TBD
	$iframe = get_sub_field('slide_content_iframe');
	

	if ( $mediaType == 'youtube' || $mediaType == 'vimeo' ) {

		// Get HTML for oEmbed
		$embed = get_sub_field('slide_content_oembed');
		$url = get_sub_field('slide_content_oembed', false, false);

		$class = "video";

		if ( $embed ) {
		
			if ( preg_match('/youtu\.be/i', $url) || preg_match('/youtube\.com\/watch/i', $url) ) {

				// Gse preg_match to find embed src
				preg_match('/src="(.+?)"/', $embed, $matches);
				$src = $matches[1];
				
				$pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
				
				preg_match($pattern, $url, $match);
				
				if ( $match !== "" && strlen($match[7]) == 11) {

					$id = $match[7];

					$thumbnail = "http://i3.ytimg.com/vi/$id/mqdefault.jpg";

					$poster = "http://i3.ytimg.com/vi/$id/maxresdefault.jpg";

				}

			} elseif ( preg_match('/vimeo\.com/i', $url) ) {

				// Gse preg_match to find embed src
				preg_match('/src="(.+?)"/', $embed, $matches);
				$src = $matches[1];

				$pattern = '/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/';

				preg_match($pattern, $url, $match);
				
				if ($match !== "") {

					$id = $match[2];

					$data = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));
					
					$thumbnail =$data[0]['thumbnail_medium']; 

					$poster = (explode("_640",$data[0]['thumbnail_large'])); //remove size restriction

					$poster = $poster[0];

				}

			} 

		}

		// Extra information (not mandatory)
		$dataUrl = 'data-url="'.$url.'"';
		$dataId = 'data-id="'.$id.'"';

	} elseif ( $mediaType == 'matterport' ) {

		$closeButton = '<a href="#" class="close-button"><span class="bars"></span></a>';

		// Get url to place into a iframe
		$link = get_sub_field('slide_content_url');

		$class = "iframe";

		if ( $link ) {

			$src = $link;

		}

	} else {

		$class = "image";
	}

	if ( $image ) {

		$imageUrl = $image['url'];
		$thumbnail = $image['sizes'][ 'small-horizontal' ];
		$poster = $image['sizes'][ 'large-horizontal' ];
		$caption = $image['caption'];

	}

?>

<?php if ( $poster !== "" ): ?>

	<div class="slide-poster" style="background-image: url('<?php echo $thumbnail; ?>');">

		<?php // To trigger load on click and supply link to source should javascript be disabled ?>

		<?php if ( $url ): ?>

			<a href="<?php echo $url; ?>" id="play-button" class="play-button">

				<?php if( get_sub_field('slide_button') ): ?>

					<span class="button button-gray"><?php the_sub_field('slide_button'); ?></span>

				<?php else: ?>
				
					<i class="icon play-icon"></i>

					<span class="srt-only">Play</span>

				<?php endif; ?>

			</a>
			
		<?php elseif ( $src !== ""): ?>

			<a href="<?php echo $src; ?>" id="play-button" class="play-button">
				
				<?php if( get_sub_field('slide_button') ): ?>

					<span class="button button-gray"><?php the_sub_field('slide_button'); ?></span>

				<?php else: ?>
				
					<i class="icon play-icon"></i>
					
					<span class="srt-only">Play</span>

				<?php endif; ?>

			</a>

		<?php endif; ?>

		<img data-lazy="<?php echo $poster; ?>">

		<?php if ($caption): ?>
		
			<div class="image-caption">
				
				<p><?php echo $caption; ?></p>

			</div>

		<?php endif; ?>

	</div>

<?php endif; ?>

<?php echo $closeButton; ?>

<?php if ($class != "image"): ?>
	
	<div class="slide-object <?php echo $class; ?>" data-embed="<?php echo $src; ?>" <?php echo $dataUrl; ?> <?php echo $dataId; ?>></div>

<?php endif; ?>
