<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ExtraMile_Theme_2023
 */

get_header();

$notFoundPage = get_field('404_page', 'option');

$post = get_post($notFoundPage); 
$content = apply_filters('the_content', $post->post_content); 
echo $content;  

get_footer();
