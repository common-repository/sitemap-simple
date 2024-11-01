<?php
/*
Plugin Name: Sitemap Simple
Plugin URI:  https://wordpress.org/plugins/sitemap-simple/
Description: This plugin will create a Sitemap for pages. Use the shortcode "[sitemap_simple]".
Version:     1.3
Author:      Abhay Yadav
Author URI:  http://abhayyadav.com
License:     GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

function sitemap_simple_shortcode( $args, $content = null )
{
	if( is_feed() )
		return '';
	
	$class_name = '';
	if( isset($args['class']) ) {
		if( !empty($args['class']) )
			$class_name = $args['class'];
		unset($args['class']);
	}
	
	$id_name = '';
	if( isset($args['id']) ) {
		if( !empty($args['id']) )
			$id_name = $args['id'];
		unset($args['id']);
	}
	
	
	$args['echo'] = 0;
	$args['title_li'] = '';
	unset($args['link_before']);
	unset($args['link_after']);
	if( isset($args['child_of']) && $args['child_of'] == 'CURRENT' ) {
		$args['child_of'] = get_the_ID();
	} else if( isset($args['child_of']) && $args['child_of'] == 'PARENT' ) {
		$post = &get_post( get_the_ID() );
		if( $post->post_parent )
			$args['child_of'] = $post->post_parent;
		else
			unset( $args['child_of'] );
	}
	
	$html = wp_list_pages($args);

	// Remove the classes added by WordPress
	$html = preg_replace('/( class="[^"]+")/is', '', $html);
	$prefix = '<ul';
	
	if( !empty($id_name) ) {
		$prefix .= ' id="'. esc_attr($id_name) .'"';
	}
	
	if( !empty($class_name) ) {
		$prefix .= ' class="'. esc_attr($id_name) .'"';
	}
	$prefix .= '>';
	
	return $prefix . $html .'</ul>';
}

add_shortcode('sitemap_simple', 'sitemap_simple_shortcode'); 

