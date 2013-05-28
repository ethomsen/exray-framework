<?php
require 'html.php';

class Exray extends HTML{
	public $content_width;
	public $custom_scripts;
	public $symbol;
	public $lang_dir, $domain;

	public function __construct(){ }

	public static function validate_var($var, $default = ''){
		if(isset($var) ){
			return $var;
		}

		return $default;
	}

	/**
	 * Set default menu fallback.
	 * @return callback default fallbacl to wp_list_page/
	 */
	public static function default_menu_fallback(){
	    echo '<ul>';
	       wp_list_pages( array('depth' => 3,'title_li' => '') ); 
	    echo '</ul>';
	} 

	/**
     * Set scripts to be loaded. Call load_custom_scripts() afterward to enqueue scripts.
     * @param array $custom_scripts <i>wp_enqueue_script()</i> array value. Place it inside array.
     * e.g: <code>array(
     * array(
     *  'handle' => 'custom_scripts',
     *  'src' => 'scripts.js',
     *  'deps' => array('jquery'),
     *  'ver' => false,
     *  'in_footer' => true
     * ))
     * </code>
     */
	public function load_custom_scripts($custom_scripts){
		 $this->custom_scripts = $custom_scripts;

		 add_action( 'wp_enqueue_scripts', function(){
			$scripts = $this->custom_scripts;
			foreach ($scripts as $script) {
				wp_enqueue_script( $script['handle'] , $script['src'],  $script['deps'], $script['ver'], $script['in_footer']);
			}
		});
	}

	/**
	 * Set content maximum width. 
	 * @param int $content_width maximum content width.
	 */
	public function set_max_content_width($content_width){
		$this->content_width = $content_width;     
	}

	/**
	 * Apply maximum content width to all WordPress media.
	 * @return int maximum content width.
	 */
	public function get_max_content_width(){
		global $content_width;
		return (!isset($content_width) ) ? $content_width = $this->content_width : $content_width;
	}

	/**
	 * Give aside post format special symbol on the readmore link.
	 * @param boolean $apply_aside_symbol give aside post format or not.
	 * @param string $symbol aside post format symbol.
	 */
	public function set_aside_symbol($apply_aside_symbol, $symbol){
		$this->symbol = $symbol;

		if($apply_aside_symbol === true){			
			add_filter( 'the_content', function($content){
				if ( has_post_format( 'aside' ) && !is_singular() )
					$content .= self::link( get_permalink(), $this->symbol, get_the_title());

				return $content;
			}, 9 ); 
		}
	}

	/**
	 * Load translation file to WordPress.  
	 * @param  string $lang_dir Directory where translation file placed.
	 * @param  string $domain   Unique theme text domain.
	 * @return callback         Hook callback to after_theme_setup.
	 */
	public function load_theme_localization($lang_dir, $domain){
		$this->$lang_dir = $lang_dir;
		$this->$domain = $domain;

		add_action('after_theme_setup', function(){
			$lang_dir = $this->$lang_dir;
			load_theme_textdomain($this->$domain, $lang_dir);
		});
	}

	/**
	 * Get the first image on Post if Post Thumbnail not set 
	 * @return string The first image found on post.
	 * http://www.wprecipes.com/how-to-get-the-first-image-from-the-post-and-display-it
	 */
	public static function catch_that_image(){
		global $post, $posts;

		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if(count($matches [1]))$first_img = $matches [1] [0];
		
		return $first_img;
	}

	/**
	 * Load post thumbnail image, if the_post_thumbnail() empty, grab the first image on post.
	 * @return string displayed image on post thumbnail 
	 */
	public static function load_post_thumbnail(){
		global $post, $posts;
		$post_thumbnail = wp_get_attachment_thumb_url( get_post_thumbnail_id( $post->ID ) );
		$thumb_id = get_post_thumbnail_id( $post->ID );

		/* Check if the_post_thumbnail() != '' */
		if($post_thumbnail){
			the_post_thumbnail();
		}
		/* Get the first image if post thumbnail fail to retrieve image */
		else{
			echo '<img src="'. Exray::catch_that_image() .'" alt="featured image" />';
		}
	}

	/**
	 * Load yoast breadcrumb if WordPress SEO breadcrumb checked.
	 * @return string Breadcrumb navigation.
	 */
	public static function load_breadcrumb(){
		if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb('<p id="breadcrumbs">','</p>');
		}
	}

}

$exray = new Exray;
?>