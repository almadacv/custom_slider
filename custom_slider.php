<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              EmersonAlmada.info
 * @since             1.0.0
 * @package           Custom_slider
 *
 * @wordpress-plugin
 * Plugin Name:       custom post slider
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Emerson Almada
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom_slider
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('CUSTOM_SLIDER_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom_slider-activator.php
 */
function activate_custom_slider()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-custom_slider-activator.php';
	Custom_slider_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom_slider-deactivator.php
 */
function deactivate_custom_slider()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-custom_slider-deactivator.php';
	Custom_slider_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_custom_slider');
register_deactivation_hook(__FILE__, 'deactivate_custom_slider');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-custom_slider.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custom_slider()
{

	$plugin = new Custom_slider();
	$plugin->run();
}
run_custom_slider();

/*-----------------------------------*/


function custom_slider($atts)
{
	//echo 'agagga';

	// Attributes
	$atts = shortcode_atts(
		array(
			'tipo' => 'post',
			'cate' => '',
		),
		$atts
	);

	global $post;

	// WP_Query arguments
	$args = array(
		//'post_type'              => array('radios'),
		'post_type'              => $atts['tipo'],
		'post_status'            => array('Publish'),
		'category_name'          => $atts['cate'],
		'nopaging'               => false,
		//'posts_per_page'         => '4',
		'ignore_sticky_posts'    => true,
		'order'                  => 'ASC',
		'orderby'                => 'title',
		'post__not_in' => array($post->ID),
	);

	// The Query
	$query = new WP_Query($args);

	// The Loop
	ob_start();
?>
	<div class="container_slider">
		<div class="slider_gera">
			<?php if ($query->have_posts()) {
				while ($query->have_posts()) {
					$query->the_post();
					// do something
			?>
					<div class="slider_elemento">
						<a href="<?php the_permalink() ?> ">
							<div class="slider_img"><?php the_post_thumbnail('post-thumbnail', array('class' => 'elementor-post__thumbnail lazyloaded elementor-fit-height')) ?> </div>
							<div class="slider_texto"> <?php the_title('<p class="elementor-post__title"">', '</p>') ?></div>
						</a>
					</div>
				<?php } ?>
		</div>
	</div>

	<script>
		var $jq = jQuery.noConflict();
		$jq('.slider_gera').each(function(index) {
			$jq(this).attr('data-slider', index);
			$jq(this).not('.slick-initialized').slick({
				infinite: true,
				slidesToShow: 4,
				slidesToScroll: 3,
				arrows: true,
				dots: true,
				appendArrows: this.closest('.container_slider'),
				prevArrow: '<div class="slider-prev fa fa-chevron-left fa-2x"></div>',
				nextArrow: '<div class="slider-next fa fa-chevron-right fa-2x"></div>',
				responsive: [{
						breakpoint: 1024,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 3,
							infinite: true,
							dots: true
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					},
				]
			});
		});
	</script>

	<style>
		.slider_texto p {
			overflow: hidden;
			text-overflow: ellipsis;
			line-height: 1.3em;
			height: 2.6em;
			font-family: "Poppins", poppins;
			font-size: 15px;
			font-weight: 600;
			color: #28303d;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp: 2;
		}

		.slider_elemento {
			margin: 5px;
		}

		.slider_img img {
			/* background-color: green; */
			/*border: 1px #888 solid;*/
			box-shadow: 0px 0px 2px 0px rgb(0 0 0 / 50%);
			border-radius: 8px;
			margin-bottom: 20px;
		}

		.slider-prev,
		.slider-next {
			/* background-color: red; */
		}

		.slick-dots {
			/* background-color: cyan; */
		}

		.container_slider {
			/* background-color: pink; */
		}

		.slick-slide {
			/* background-color: #4899dd; */
		}

		.slider_elemento {
			/* border: 1px #888 solid;
			border-radius: 8px; */
			margin: 5px;
		}
	</style>

<?php
				ob_end_flush();
			} else {
				echo 'no posts found';
			}
			// Restore original Post Data
			wp_reset_postdata();
		}
		add_shortcode('custom-slider-teste', 'custom_slider');
?>