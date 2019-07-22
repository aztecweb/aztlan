<?php
/**
 * Theme starter header
 *
 * @package Aztec
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div>
		<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/aztec.png" alt="<?php echo esc_attr( get_bloginfo( 'sitename' ) ); ?>" />
	</div>
	<?php esc_html_e( 'Hello World', 'env-theme' ); ?>
