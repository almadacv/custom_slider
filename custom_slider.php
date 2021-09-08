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

	$Content = "";

	// WP_Query arguments
	$args = array(
		//'post_type'              => array('radios'),
		'post_type'              => $atts['tipo'],
		'post_status'            => array('Publish'),
		//'category_name'          => 'Patrocinado',
		//		'category_name'          => 'Não Patrocinado',
		'category_name'          => $atts['cate'],
		'nopaging'               => false,
		//'posts_per_page'         => '4',
		'ignore_sticky_posts'    => true,
		'order'                  => 'ASC',
		'orderby'                => 'title',

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
					$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
			?>
					<div class="slider_elemento">
						<a href="<?php the_permalink() ?> ">
							<div class="slider_img"><?php the_post_thumbnail('post-thumbnail', array('class' => '.card-img-top, .lazyloaded')) ?> </div>
							<div class="slider_texto"> <?php the_title('<p class="elementor-post__title"">', '</p>') ?></div>
						</a>
					</div>
				<?php } ?>
		</div>
	</div>

	<script>
		var $jq = jQuery.noConflict();

		$jq('.slider_gera').slick({
			infinite: true,
			slidesToShow: 4,
			slidesToScroll: 3,
			/*adaptiveHeight: true,
			variableWidth:true,
			autoplay: true,
			autoplayspeed: 2000, */
			arrows: true,
			dots: true,
			// Add FontAwesome Class
			appendArrows: '.container_slider',
			prevArrow: '<div class="slider-prev fa fa-chevron-left"></div>',
			nextArrow: '<div class="slider-next fa fa-chevron-right"></div>',
			//			prevArrow: '<div class="slider-prev fa fa-angle-left"></div>',
			//			nextArrow: '<div class="slider-next fa fa-angle-right"></div>',
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
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			]

		});
	</script>

<?php
				ob_end_flush();
			} else {
				echo 'no posts found';
			}


			// Restore original Post Data
			wp_reset_postdata();

			return $Content;
		}

		add_shortcode('custom-slider-teste', 'custom_slider');
?>