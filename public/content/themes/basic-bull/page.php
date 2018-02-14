<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cohere-foundation
 */

	get_header();
 ?>

<div id="primary" class="content-area">

	<div id="main" class="section section-main" role="main">

		<h1><?php the_title(); ?></h1>

		

		<?php
			
			$request = wp_remote_get( 'http://staging.j2made.com/json/posts.json' );
			
			if( is_wp_error( $request ) ) {

				return false; // Bail early

			}

			$response = wp_remote_retrieve_body( $request );
			$data = json_decode( $response );

			//print_r($data);


			if( ! empty( $data ) ) :
				
				foreach( $data->posts as $post ) : 

					$postId = $post->id;
					$postDate = $post->date;
					$postStatus = $post->status;
					$postType = $post->type;
					$postTitle = $post->title->rendered;
					$postCategories = array_merge($post->music_program, $post->instrument, $post->location, $post->skill_level, $post->age_range);
					$postDescription = $post->acf->description_long_form;
					$postExcerpt = $post->acf->description_short_form;
					$postFinancialAid = $post->acf->financial_aid;
					$postAgeStart = $post->acf->age_range->age_range_start;
					$postAgeEnd = $post->acf->age_range->age_range_end;

		?>

			<?php 

				if ( get_post_status ( $postId ) ) :

					echo 'This post exists';

					// $courseStatus = strtotime($coursePublishDate) > strtotime('today') ? 'future' : 'publish';

					$updateArgs = array(
						'ID' 				=> $postId,
						'post_date' 		=> $postDate,
						'post_status' 		=> $postStatus,
						'post_title' 		=> $postTitle, //Title of post
						'post_type' 		=> $postType, //could be any custom post type
						'post_content' 		=> $postDescription,
						//'edit_date' 		=> true,
						// 'post_date_gmt' 	=> gmdate( 'Y-m-d H:i:s', strtotime($coursePublishDate) )
					);

					// Updates standard post content

					wp_update_post( $updateArgs );
					
					// Updates custom taxonomies

					wp_set_post_terms( $postId, $postCategories, 'music_program', false);
					wp_set_post_terms( $postId, $postCategories, 'instrument', false);
					wp_set_post_terms( $postId, $postCategories, 'location', false);
					wp_set_post_terms( $postId, $postCategories, 'skill_level', false);
					wp_set_post_terms( $postId, $postCategories, 'age_range', false);


					// Updates ACF fields

					// Course description long form
					$field_key = "field_5a834c4b1a5ab";
					$value = $postDescription;
					update_field( $field_key, $value, $postId );

					// Course description short form (excerpt)
					$field_key = "field_5a834c891a5ac";
					$value = $postExcerpt;
					update_field( $field_key, $value, $postId );


					// Course financial aid
					$field_key = "field_5a834e2356e38";
					$value = $postFinancialAid;
					update_field( $field_key, $value, $postId );

					// Age range start
				 	$field_key = "age_range_age_start";
				 	$value = $postAgeStart;
					update_field( $field_key, $value, $postId );

					// Age range end
					$field_key = "age_range_age_end";
				 	$value = $postAgeEnd;
					update_field( $field_key, $value, $postId );

			?>
				

				<div>

					<h5><?php echo $post->title->rendered; ?> - <?php echo $post->id; ?></h5>

				</div>

			<?php  

				else :

					echo $postId;

					echo 'These dont exist';

					$createArg = array(
						'import_id'			=> $postId,
						'post_date' 		=> $postDate,
						'post_title' 		=> $postTitle, //Title of post
						'post_type' 		=> $postType, //could be any custom post type
						'post_content' 		=> $postDescription,
						
					);

					wp_insert_post($createArg, true); 

					wp_set_post_terms( $postId, $postCategories, 'music_program', false);
					wp_set_post_terms( $postId, $postCategories, 'instrument', false);
					wp_set_post_terms( $postId, $postCategories, 'location', false);
					wp_set_post_terms( $postId, $postCategories, 'skill_level', false);
					wp_set_post_terms( $postId, $postCategories, 'age_range', false);

					update_field( 'age_range_age_start', 'Yes', $postId);

				endif;

			?>

			<?php endforeach; ?>



		<?php endif; ?>

		

	</div><!-- #main -->

	<?php edit_post_link('Edit', '', '','','admin-link button edit-button'); ?>

	

</div><!-- #primary -->

<?php get_footer(); ?>


