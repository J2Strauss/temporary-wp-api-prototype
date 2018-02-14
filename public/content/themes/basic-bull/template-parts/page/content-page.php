<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package basic-bull
 */

?>

<div class="content">
	
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>

</div>

<?php get_template_part( 'template-parts/components/accordions/accordion', 'container' ); ?>

<?php get_template_part( 'template-parts/components/tabs/tabs', 'container' ); ?>

<?php get_template_part( 'template-parts/components/tabs/tabs', 'container' ); ?>

<?php get_template_part( 'template-parts/components/tables/table', 'container' ); ?>

