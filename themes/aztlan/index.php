<?php
/**
 * Theme start file
 *
 * @package Aztec
 */

declare(strict_types = 1);

get_header();
?>

<div class="welcome">
	<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/aztec.png" alt="<?php echo esc_attr( get_bloginfo( 'sitename' ) ); ?>" width="350">
	<h1 class="welcome__title"><?php esc_html_e( 'Welcome to Aztlan', 'aztlan' ); ?></h1>
	<ul class="welcome__links">
		<li><a href="https://aztlan.aztecweb.net">Docs</a></li>
		<li><a href="https://aztecweb.net">Aztec</a></li>
	</ul>
</div>

<?php get_footer(); ?>
