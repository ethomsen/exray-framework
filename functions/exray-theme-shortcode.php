<?php
/*
	Plugin Name: Exray Shortcode
	Plugin URI: http://seotemplates.net/plugins/exray-shortcode
	Description: Easily add more functionalities to your WordPress website with Shortcodes.
	Version: 0.0.1
	Author: Septian Ahmad Fujianto
	Author URI: http://seotemplates.net
	License: GPLv2 or later
*/

/*
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

	add_shortcode( 'button', 'custom_button' );
	add_shortcode('video_embed', 'embed_video');

	function custom_button($atts, $content = null){
		$pairs = array(
					'color' => 'blue',
					'to' => ''
				);

		extract(shortcode_atts( $pairs, $atts ));

		return '<a href="' .$to. '" class="button '.$color.' ">'. $content .'</a>';
	}

	function embed_video($atts){
		$pairs = array(
				'src' => ''
			);

		extract(shortcode_atts( $pairs, $atts ));

		return '<div class="video-container">'.
			   '<iframe width="500" height="280" src="' .$src. '" frameborder="0" allowfullscreen></iframe>'.
			   '</div>' ;
	}
?>