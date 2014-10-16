<?php ob_start();
/*
Template Name: Logout
*/
get_header();

if ( array_key_exists('ref', $_GET) ) { $ref = sanitize_text_field($_GET['ref']); } else { $ref = WHATIF_BLOGURL; }

wp_logout();

	wp_redirect($ref);
	exit;

get_footer(); ob_end_flush(); ?>
