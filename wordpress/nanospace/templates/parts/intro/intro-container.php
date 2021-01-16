<?php
/**
 * Page intro container
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */


$class = ( is_singular() ) ? ( 'entry-header' ) : ( 'page-header' );
?>

<section id="intro-container" class="<?php echo esc_attr( $class ); ?> intro-container" role="complementary">

	<?php do_action( 'nanospace_intro_before' ); ?>

	<div id="intro" class="intro">
		<div class="intro-inner">

			<?php do_action( 'nanospace_intro' ); ?>

		</div>
	</div>

	<?php do_action( 'nanospace_intro_after' ); ?>

</section>
