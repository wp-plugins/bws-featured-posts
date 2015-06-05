<?php
/*
Plugin Name: Featured Posts by BestWebSoft
Plugin URI: http://bestwebsoft.com/plugin/
Description: Displays featured posts randomly on any website page.
Author: BestWebSoft
Version: 0.4
Author URI: http://bestwebsoft.com/
License: GPLv3 or later
*/

/*  @ Copyright 2015  BestWebSoft  ( http://support.bestwebsoft.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
* Add option page in admin menu 
*/
if ( ! function_exists( 'ftrdpsts_admin_menu' ) ) {
	function ftrdpsts_admin_menu() {
		bws_add_general_menu( plugin_basename( __FILE__ ) );
		add_submenu_page( 'bws_plugins', __( 'Featured Posts Settings', 'featured_posts' ), __( 'Featured Posts', 'featured_posts' ), 'manage_options', 'featured-posts.php', 'ftrdpsts_settings_page' );
	}
}

/**
* Plugin initialization
*/
if ( ! function_exists( 'ftrdpsts_init' ) ) {
	function ftrdpsts_init() {
		global $ftrdpsts_plugin_info;
		load_plugin_textdomain( 'featured_posts', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 

		require_once( dirname( __FILE__ ) . '/bws_menu/bws_functions.php' );

		if ( empty( $ftrdpsts_plugin_info ) ) {
			if ( ! function_exists( 'get_plugin_data' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$ftrdpsts_plugin_info = get_plugin_data( __FILE__ );
		}

		/* Function check if plugin is compatible with current WP version */
		bws_wp_version_check( plugin_basename( __FILE__ ), $ftrdpsts_plugin_info, "3.5" );
	}
}

if ( ! function_exists( 'ftrdpsts_admin_init' ) ) {
	function ftrdpsts_admin_init() {
		global $bws_plugin_info, $ftrdpsts_plugin_info;
		/* Add variable for bws_menu */
		if ( ! isset( $bws_plugin_info ) || empty( $bws_plugin_info ) )
			$bws_plugin_info = array( 'id' => '179', 'version' => $ftrdpsts_plugin_info["Version"] );

		/* Call register settings function */
		if ( isset( $_REQUEST['page'] ) && ( 'featured-posts.php' == $_REQUEST['page'] ) )
			ftrdpsts_settings();
	}
}

/**
* Register settings for plugin 
*/
if ( ! function_exists( 'ftrdpsts_settings' ) ) {
	function ftrdpsts_settings() {
		global $ftrdpsts_options, $ftrdpsts_plugin_info;

		$ftrdpsts_option_defaults = array(
			'plugin_option_version' 	=> $ftrdpsts_plugin_info["Version"],
			'display_before_content'	=> 0,
			'display_after_content'		=> 1,
			'block_width'				=> '100%',
			'text_block_width'			=> '960px',
			'theme_style'				=> 1,
			'background_color_block'	=> '#f3f3f3',
			'background_color_text'		=> '#f3f3f3',
			'color_text'				=> '#777b7e',
			'color_header'				=> '#777b7e',
			'color_link'				=> '#777b7e',
		);

		/* Install the option defaults */
		if ( ! get_option( 'ftrdpsts_options' ) )
			add_option( 'ftrdpsts_options', $ftrdpsts_option_defaults );

		$ftrdpsts_options = get_option( 'ftrdpsts_options' );

		if ( ! isset( $ftrdpsts_options['plugin_option_version'] ) || $ftrdpsts_options['plugin_option_version'] != $ftrdpsts_plugin_info["Version"] ) {
			$ftrdpsts_options = array_merge( $ftrdpsts_option_defaults, $ftrdpsts_options );
			$ftrdpsts_options['plugin_option_version'] = $ftrdpsts_plugin_info["Version"];
			update_option( 'ftrdpsts_options', $ftrdpsts_options );
		}		
	}
}

/**
	* Add settings page in admin area
	*/
if ( ! function_exists( 'ftrdpsts_settings_page' ) ) {
	function ftrdpsts_settings_page(){ 
		global $title, $ftrdpsts_options, $ftrdpsts_plugin_info;
		$message = $error = ''; 
		
		if ( isset( $_POST['ftrdpsts_form_submit'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'ftrdpsts_check_field' ) ) {
			$ftrdpsts_options['display_before_content'] = ( isset( $_POST['ftrdpsts_display_before_content'] ) ) ? 1 : 0;
			$ftrdpsts_options['display_after_content'] = ( isset( $_POST['ftrdpsts_display_after_content'] ) ) ? 1 : 0;
			$block_width = trim( stripslashes( esc_html( $_POST['ftrdpsts_block_width'] ) ) );
			if ( preg_match( '/^\d{1,4}(px|%)$/', $block_width ) )
				$ftrdpsts_options['block_width'] = $block_width;
			else
				$error = __( "Invalid value for 'Block width'", 'featured_posts' );

			$text_block_width = trim( stripslashes( esc_html( $_POST['ftrdpsts_text_block_width'] ) ) );
			if ( preg_match( '/^\d{1,4}(px|%)$/', $text_block_width ) )
				$ftrdpsts_options['text_block_width'] = $text_block_width;
			else
				$error = __( "Invalid value for 'Content block width'", 'featured_posts' );
			
			$ftrdpsts_options['theme_style'] = ( isset( $_POST['ftrdpsts_theme_style'] ) ) ? 1 : 0;
			$ftrdpsts_options['background_color_block'] = stripslashes( esc_html( $_POST['ftrdpsts_background_color_block'] ) );
			$ftrdpsts_options['background_color_text'] = stripslashes( esc_html( $_POST['ftrdpsts_background_color_text'] ) );
			$ftrdpsts_options['color_text'] = stripslashes( esc_html( $_POST['ftrdpsts_color_text'] ) );
			$ftrdpsts_options['color_header'] = stripslashes( esc_html( $_POST['ftrdpsts_color_header'] ) );
			$ftrdpsts_options['color_link'] = stripslashes( esc_html( $_POST['ftrdpsts_color_link'] ) );

			update_option( 'ftrdpsts_options', $ftrdpsts_options ); 
			$message = __( 'Changes saved', 'featured_posts' );
		}
		$theme_style_class = $ftrdpsts_options['theme_style'] == 1 ? 'hidden-field' : ''; ?>
		<div class="wrap">
			<div class="icon32 icon32-bws" id="icon-options-general"></div>
			<h2><?php echo $title; ?></h2>
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab nav-tab-active" href="admin.php?page=featured-posts.php"><?php _e( 'Settings', 'featured_posts' ); ?></a>
				<a class="nav-tab" href="http://bestwebsoft.com/products/featured-posts/faq/" target="_blank"><?php _e( 'FAQ', 'featured_posts' ); ?></a>
			</h2>
			<div id="ftrdpsts_settings_notice" class="updated fade" style="display:none"><p><strong><?php _e( "Notice:", 'featured_posts' ); ?></strong> <?php _e( "The plugin's settings have been changed. In order to save them please don't forget to click the 'Save Changes' button.", 'featured_posts' ); ?></p></div>
			<div class="updated fade" <?php if ( ! isset( $_REQUEST['ftrdpsts_submit'] ) || $error != "" ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
			<div class="error" <?php if ( "" == $error ) echo "style=\"display:none\""; ?>><p><?php echo $error; ?></p></div>
			<p><?php _e( "If you would like to add Featured Posts to your page or post, select posts to be displayed (on the page/post editing page, in Featured Post block, please mark 'Display this post in the Featured Post block?').", 'featured_posts' ); ?></p>
			<p>
				<?php _e( "If you would like to add Featured Posts to your website, just copy and paste this shortcode into your post or page:", 'featured_posts' ); ?> <span class="ftrdpsts_code">[bws_featured_post]</span>.
			</p>
			<p>
				<?php _e( "Also, you can paste the following strings into the template source code", 'featured_posts' ); ?> 
				<code>
					&lt;?php if( has_action( 'ftrdpsts_featured_posts' ) ) {
						do_action( 'ftrdpsts_featured_posts' );
					} ?&gt;
				</code>
			</p>
			<form id="ftrdpsts_settings_form" method='post' action='admin.php?page=featured-posts.php'>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e( 'Display the block with Featured Posts', 'featured_posts' ); ?></th>
							<td>
								<label>
									<input type="checkbox" value="1" name="ftrdpsts_display_before_content" <?php if ( $ftrdpsts_options['display_before_content'] == 1 ) echo 'checked="checked"'; ?> /> 
									<?php _e( 'Before the Post', 'featured_posts' ); ?>
								</label><br />
								<label>
									<input type="checkbox" value="1" name="ftrdpsts_display_after_content" <?php if ( $ftrdpsts_options['display_after_content'] == 1 ) echo 'checked="checked"'; ?> /> 
									<?php _e( 'After the Post', 'featured_posts' ); ?>
								</label>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e( 'Block width', 'featured_posts' ); ?></th>
							<td>
								<input maxlength="6" type="text" class="regular-text" value="<?php echo $ftrdpsts_options['block_width']; ?>" name="ftrdpsts_block_width">
								<p class="description"><?php _e( 'Please, enter the value in &#37; or px, for instance, 100&#37; or 960px', 'featured_posts' ); ?></p>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e( 'Content block width', 'featured_posts' ); ?></th>
							<td>
								<input maxlength="6" type="text" class="regular-text" value="<?php echo $ftrdpsts_options['text_block_width']; ?>" name="ftrdpsts_text_block_width" />
								<p class="description"><?php _e( 'Please, enter the value in &#37; or px, for instance, 100&#37; or 960px', 'featured_posts' ); ?></p>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e( 'Style', 'featured_posts' ); ?></th>
							<td>
								<label>
									<input id="ftrdpsts_theme_style" type="checkbox" value="1" name="ftrdpsts_theme_style" <?php if ( $ftrdpsts_options['theme_style'] == 1 ) echo 'checked="checked"'; ?> /> 
									<?php _e( 'Use theme styles for Featured Posts block', 'featured_posts' ); ?>
								</label>
							</td>
						</tr>
						<tr class="ftrdpsts_theme_style <?php echo $theme_style_class; ?>">
							<th scope="row"><?php _e( 'Background Color for block', 'featured_posts' ); ?></th>
							<td>
								<input type="text" value="<?php echo $ftrdpsts_options['background_color_block']; ?>" name="ftrdpsts_background_color_block" maxlength="7" class="wp-color-picker" />
							</td>
						</tr>
						<tr class="ftrdpsts_theme_style <?php echo $theme_style_class; ?>">
							<th scope="row"><?php _e( 'Background Color for text', 'featured_posts' ); ?></th>
							<td>
								<input type="text" value="<?php echo $ftrdpsts_options['background_color_text']; ?>" name="ftrdpsts_background_color_text" maxlength="7" class="wp-color-picker" />
							</td>
						</tr>
						<tr class="ftrdpsts_theme_style <?php echo $theme_style_class; ?>">
							<th scope="row"><?php _e( 'Title Color', 'featured_posts' ); ?></th>
							<td>
								<input type="text" value="<?php echo $ftrdpsts_options['color_header']; ?>" name="ftrdpsts_color_header" maxlength="7" class="wp-color-picker" />
							</td>
						</tr>
						<tr class="ftrdpsts_theme_style <?php echo $theme_style_class; ?>">
							<th scope="row"><?php _e( 'Text Color', 'featured_posts' ); ?></th>
							<td>
								<input type="text" value="<?php echo $ftrdpsts_options['color_text']; ?>" name="ftrdpsts_color_text" maxlength="7" class="wp-color-picker" />
							</td>
						</tr>
						<tr class="ftrdpsts_theme_style <?php echo $theme_style_class; ?>">
							<th scope="row"><?php _e( '"Learn more" Link Color', 'featured_posts' ); ?></th>
							<td>
								<input type="text" value="<?php echo $ftrdpsts_options['color_link']; ?>" name="ftrdpsts_color_link" maxlength="7" class="wp-color-picker" />
							</td>
						</tr>
					</tbody>
				</table>
				<p class="submit">
					<input type="submit" value="<?php _e( 'Save Changes', 'featured_posts' ); ?>" class="button button-primary" id="submit" name="ftrdpsts_submit">
					<input type="hidden" name="ftrdpsts_form_submit" value="submit" />
					<?php wp_nonce_field( plugin_basename( __FILE__ ), 'ftrdpsts_check_field' ) ?>
				</p>
			</form>
			<?php bws_plugin_reviews_block( $ftrdpsts_plugin_info['Name'], 'bws-featured-posts' ); ?>
		</div>
	<?php }
}

/**
 * Display Block with Featured Post
 * @return echo Featured Post block
 */
if ( ! function_exists( 'ftrdpsts_display_block' ) ) {
	function ftrdpsts_display_block( $content ) {
		global $ftrdpsts_options;
 
		if ( is_single() || is_page() ) {
			if ( empty( $ftrdpsts_options ) )
				$ftrdpsts_options = get_option( 'ftrdpsts_options' );

			$ftrdpsts_block = ftrdpsts_featured_posts( true );
			/* Indication where show Facebook Button depending on selected item in admin page. */
			if ( 1 == $ftrdpsts_options['display_before_content'] && 1 == $ftrdpsts_options['display_after_content'] )
				return $ftrdpsts_block . $content . $ftrdpsts_block;
			elseif ( 1 == $ftrdpsts_options['display_before_content'] )
				return $ftrdpsts_block . $content;
			else if ( 1 == $ftrdpsts_options['display_after_content'] )
				return $content . $ftrdpsts_block;		
			else
				return $content;
		} else {
			return $content;
		}
	}
}

if ( ! function_exists( 'ftrdpsts_get_the_excerpt' ) ) {
	function ftrdpsts_get_the_excerpt( $content ) {
		$charlength = 100;
		$content = wp_strip_all_tags( $content );
		if ( strlen( $content ) > $charlength ) {
			$subex = substr( $content, 0, $charlength-5 );
			$exwords = explode( " ", $subex );
			$excut = - ( strlen( $exwords [ count( $exwords ) - 1 ] ) );
			$new_content = ( $excut < 0 ) ? substr( $subex, 0, $excut ) : $subex;
			$new_content .= "...";
			return $new_content;
		} else {
			return $content;
		}
	}
}

/**
 * Display Featured Post
 * @return echo Featured Post block
 */
if ( ! function_exists( 'ftrdpsts_featured_posts' ) ) {
	function ftrdpsts_featured_posts( $return = false ) {
		$result = '';
		$the_query = new WP_Query( array(
			'post_type'				=> array( 'post', 'page' ),
			'meta_key'				=> '_ftrdpsts_add_to_featured_post',
			'meta_value'			=> '1',
			'posts_per_page'		=> '1',
			'orderby'				=> 'rand',
			'ignore_sticky_posts' 	=> 1
		) );
		/* The Loop */
		if ( $the_query->have_posts() ) {
			$the_query->the_post();
			global $post;
			$result .= '<div id="ftrdpsts_heading_featured_post">
				<div class="widget_content">
					<h2>
						<a href="' . get_permalink( $post->ID ) . '">' . get_the_title( $post->ID ) . '</a>
					</h2>' . 
					'<p>' . ftrdpsts_get_the_excerpt( $post->post_content ) . '</p>' . 
					'<a href="' . get_permalink( $post->ID ) . '" class="more">' . __( 'Learn more', 'featured_posts' ) . '</a>
				</div><!-- .widget_content -->
			</div><!-- .ftrdpsts_heading_featured_post -->';
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		wp_reset_query();
		if ( false == $return )
			echo $result;
		else
			return $result;
	}
}

/*
 * Add a box to the main column on the Post and Page edit screens.
 */
if ( ! function_exists( 'ftrdpsts_featured_posts_add_custom_box' ) ) {
	function ftrdpsts_featured_posts_add_custom_box() {
		$screens = array( 'post', 'page' );
		foreach ( $screens as $screen ) {
			add_meta_box(
				'showonfeaturedpost',
				__( 'Featured Post', 'featured_posts' ),
				'ftrdpsts_featured_post_inner_custom_box',
				$screen
			);
		}
	}
}

/**
 * Prints the meta box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
if ( ! function_exists( 'ftrdpsts_featured_post_inner_custom_box' ) ) {
	function ftrdpsts_featured_post_inner_custom_box( $post ) {
		/* Add an nonce field so we can check for it later. */
		wp_nonce_field( 'ftrdpsts_featured_post_inner_custom_box', 'ftrdpsts_featured_post_inner_custom_box_nonce' );
		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$is_check = get_post_meta( $post->ID, '_ftrdpsts_add_to_featured_post', true ); ?>
		<div class="check-to-display">
			<input type="checkbox" name="ftrdpsts_featured_post_checkbox" <?php if ( $is_check == true ) echo 'checked="checked"'; ?> value="1" /> 
			<label>
				<?php _e( "Display this post in the Featured Post block?", 'featured_posts' ); ?>
			</label>
		</div>
	<?php }
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
if ( ! function_exists( 'ftrdpsts_featured_posts_save_postdata' ) ) {
	function ftrdpsts_featured_posts_save_postdata( $post_id ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */
		/* If this is an autosave, our form has not been submitted, so we don't want to do anything. */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;
		/* Check if our nonce is set. */
		if ( ! isset( $_POST[ 'ftrdpsts_featured_post_inner_custom_box_nonce' ] ) )
			return $post_id;
		else {
			$nonce = $_POST[ 'ftrdpsts_featured_post_inner_custom_box_nonce' ];
			/* Verify that the nonce is valid. */
			if ( ! wp_verify_nonce( $nonce, 'ftrdpsts_featured_post_inner_custom_box' ) )
				return $post_id;	
		}
		if ( isset( $_POST[ 'ftrdpsts_featured_post_inner_custom_box_nonce' ] ) ) {
			$ftrdpsts_featured_post_checkbox = isset( $_POST[ 'ftrdpsts_featured_post_checkbox' ] ) ? 1 : 0;
			/* Update the meta field in the database. */
			update_post_meta( $post_id, '_ftrdpsts_add_to_featured_post', $ftrdpsts_featured_post_checkbox );
		}
	}
}

/**
	* Add style for featured posts block 
	*/
if ( ! function_exists( 'ftrdpsts_wp_head' ) ) {
	function ftrdpsts_wp_head() {
		global $ftrdpsts_options;
		wp_enqueue_style( 'ftrdpsts_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
		if ( empty( $ftrdpsts_options ) )
			$ftrdpsts_options = get_option( 'ftrdpsts_options' ); ?>
		<style type="text/css">
			#ftrdpsts_heading_featured_post {
				width: <?php echo $ftrdpsts_options['block_width']; ?>;
			}
			#ftrdpsts_heading_featured_post .widget_content {
				width: <?php echo $ftrdpsts_options['text_block_width']; ?>;
			}
			<?php if ( $ftrdpsts_options['theme_style'] != 1 ) { ?>			
				#ftrdpsts_heading_featured_post {
					background-color: <?php echo $ftrdpsts_options['background_color_block']; ?> !important;
				}
				#ftrdpsts_heading_featured_post .widget_content {
					background-color: <?php echo $ftrdpsts_options['background_color_text']; ?> !important;
				}
				#ftrdpsts_heading_featured_post .widget_content h2 a {
					color: <?php echo $ftrdpsts_options['color_header']; ?> !important;
				}
				#ftrdpsts_heading_featured_post .widget_content p {
					color: <?php echo $ftrdpsts_options['color_text']; ?> !important;
				}
				#ftrdpsts_heading_featured_post .widget_content > a {
					color: <?php echo $ftrdpsts_options['color_link']; ?> !important;
				}
			<?php } ?>
		</style>
	<?php }
}

/**
* Add style for admin page
*/
if ( ! function_exists( 'ftrdpsts_admin_head' ) ) {
	function ftrdpsts_admin_head() {		
		if ( isset( $_REQUEST['page'] ) && 'featured-posts.php' == $_REQUEST['page'] ) {
			wp_enqueue_style( 'ftrdpsts_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' ); 
			wp_enqueue_script( 'ftrdpsts_script', plugins_url( '/js/script.js', __FILE__ ) , array( 'jquery' ) );
		}
	}
}

/**
 * Function to handle action links
 */
if ( ! function_exists( 'ftrdpsts_plugin_action_links' ) ) {
	function ftrdpsts_plugin_action_links( $links, $file ) {
		if ( ! is_network_admin() ) {
			/* Static so we don't call plugin_basename on every plugin row. */
			static $this_plugin;
			if ( ! $this_plugin )
				$this_plugin = plugin_basename(__FILE__);

			if ( $file == $this_plugin ) {
				$settings_link = '<a href="admin.php?page=featured-posts.php">' . __( 'Settings', 'featured_posts' ) . '</a>';
				array_unshift( $links, $settings_link );
			}
		}
		return $links;
	}
}

/**
* Additional links on the plugin page
*/
if ( ! function_exists( 'ftrdpsts_register_plugin_links' ) ) {
	function ftrdpsts_register_plugin_links( $links, $file ) {
		$base = plugin_basename(__FILE__);
		if ( $file == $base ) {
			if ( ! is_network_admin() )
				$links[] = '<a href="admin.php?page=featured-posts.php">' . __( 'Settings','featured_posts' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/plugins/bws-featured-posts/faq/" target="_blank">' . __( 'FAQ','featured_posts' ) . '</a>';
			$links[] = '<a href="http://support.bestwebsoft.com">' . __( 'Support','featured_posts' ) . '</a>';
		}
		return $links;
	}
}

/**
 * Delete plugin options
 */
if ( ! function_exists( 'ftrdpsts_plugin_uninstall' ) ) {
	function ftrdpsts_plugin_uninstall() {
		delete_option( 'ftrdpsts_options' );
	}
}

/* Add option page in admin menu */
add_action( 'admin_menu', 'ftrdpsts_admin_menu' );	

/* Plugin initialization */
add_action( 'init', 'ftrdpsts_init' );

/* Plugin initialization for admin page */
add_action( 'admin_init', 'ftrdpsts_admin_init' );

/* Adds a box to the main column on the Post and Page edit screens. */
add_action( 'add_meta_boxes', 'ftrdpsts_featured_posts_add_custom_box' );

/* When the post is saved, saves our custom data. */
add_action( 'save_post', 'ftrdpsts_featured_posts_save_postdata' );

/* Additional links on the plugin page */
add_filter( 'plugin_action_links', 'ftrdpsts_plugin_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'ftrdpsts_register_plugin_links', 10, 2 );

/* Add style for Featured Posts block */
add_action( 'wp_enqueue_scripts', 'ftrdpsts_wp_head' );
/* Add style for admin page */
add_action( 'admin_enqueue_scripts', 'ftrdpsts_admin_head' );

/* Display Featured Post */
add_action( 'ftrdpsts_featured_posts', 'ftrdpsts_featured_posts' );

/* Add shortcode and plugin block */
add_shortcode( 'bws_featured_post', 'ftrdpsts_featured_posts' );
add_filter( 'the_content', 'ftrdpsts_display_block' );

register_uninstall_hook( __FILE__, 'ftrdpsts_plugin_uninstall' );