<?php
	
	// Disabled until criteria is met in checks below
	$backgroundContent = false;
	
	// Empty variables set with criteria below
	$backgroundModifier = "";
	$dataUrl = "";
	$dataId = "";
	$dataImage = "";
	$dataColor = "";
	$dataOverlay = "";
	$dataFile = "";
	$dataPoster = "";
	$dataThumbnail = "";

	// Background fields
	$backgroundType = get_field('background_type');
	$backgroundVideoSource = get_field('background_video_source');
	$backgroundVideoEmbed = get_field('background_video_embed');
	$backgroundVideoFile = get_field('background_video_file');
	$backgroundImage = get_field('background_image');
	$backgroundColor = get_field('background_color');
	$backgroundOverlay = get_field('background_overlay');


	// Background videos
	if ( $backgroundType == 'background-video' ) {
	
		// YouTube or Vimeo
		if ( $backgroundVideoSource == 'youtube' || $backgroundVideoSource == 'vimeo' ) {			

			if ( $backgroundVideoEmbed ) {

				$backgroundContent = true;

				$backgroundModifier = " embed-background";
				
				$backgroundVideoEmbedUrl = get_field('background_video_embed', false, false);
			
				if ( preg_match('/youtu\.be/i', $backgroundVideoEmbedUrl) || preg_match('/youtube\.com\/watch/i', $backgroundVideoEmbedUrl) ) {

					// Gse preg_match to find embed src
					preg_match('/src="(.+?)"/', $backgroundVideoEmbed, $matches);
					
					// $src = $matches[1];
					
					$pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
					
					preg_match($pattern, $backgroundVideoEmbedUrl, $match);
					
					if ( $match !== "" && strlen($match[7]) == 11) {

						$id = $match[7];

						$dataThumbnail = "http://i3.ytimg.com/vi/$id/mqdefault.jpg";

						$dataPoster = "http://i3.ytimg.com/vi/$id/maxresdefault.jpg";

						$dataImage = 'style="background-image: url('.$dataPoster.');"';

					}

				} elseif ( preg_match('/vimeo\.com/i', $backgroundVideoEmbedUrl) ) {

					// Gse preg_match to find embed src
					preg_match('/src="(.+?)"/', $backgroundVideoEmbed, $matches);
					
					//$src = $matches[1];

					$pattern = '/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/';

					preg_match($pattern, $backgroundVideoEmbedUrl, $match);
					
					if ($match !== "") {

						$id = $match[2];

						$data = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));
						
						$dataThumbnail =$data[0]['thumbnail_medium']; 

						$dataPoster = (explode("_640",$data[0]['thumbnail_large'])); //remove size restriction

						$dataPoster = $dataPoster[0];

						$dataImage = 'style="background-image: url('.$dataPoster.');"';

					}

				}

				// Video URL and ID
				$dataUrl = 'data-url="'.$backgroundVideoEmbedUrl.'"';
				$dataId = 'data-id="'.$id.'"';

				if ( $backgroundOverlay && $backgroundColor ) {

					$dataOverlay = '<div class="background-overlay" style="background-color: '.$backgroundColor.'"></div>';
				}

			}
			
		// Video file
		} else {

			if ( $backgroundVideoFile ) {

				$backgroundContent = true;

				if ( $backgroundImage ) {
					
					$dataPoster = 'poster="'.$backgroundImage['sizes']['large-horizontal'].'"';

				}

				$dataFile = '<video class="video video-js" autoplay preload="auto" '.$dataPoster.' data-setup="{}"><source src="'.$backgroundVideoFile.'" type="video/mp4"></video>';

			}

			if ( $backgroundOverlay && $backgroundColor ) {

				$dataOverlay = '<div class="background-overlay" style="background-color: '.$backgroundColor.'"></div>';
			}

		}

	// Background image
	} elseif ( $backgroundType == 'background-image' ) {

		if ( $backgroundImage ) {

			$backgroundContent = true;
				
			$dataImage = 'style="background-image: url('.$backgroundImage['sizes'][ 'large-horizontal' ].');"';

			if ( $backgroundOverlay && $backgroundColor ) {

				$dataOverlay = '<div class="background-overlay" style="background-color: '.$backgroundColor.'"></div>';
			}

		}

	// Background color
	} elseif ( $backgroundType == 'background-color' ) {

		if ( $backgroundColor ) {

			$backgroundContent = true;
				
			$dataColor = 'style="background-color: '.$backgroundColor.'"';

		}

	} 

?>

<?php if ( $backgroundType !== "background-none" && $backgroundContent == true ): ?>
	
	<div class="background-component<?php echo $backgroundModifier; ?>">
		
		<div class="<?php echo $backgroundType; ?>" <?php echo $dataUrl; ?> <?php echo $dataId; ?> <?php echo $dataImage; ?> <?php echo $dataColor; ?>><?php echo $dataFile; ?></div>

		<?php echo $dataOverlay; ?>

	</div>

<?php endif; ?>
