<?php
/**
 * Plugin Name: Arrobo & Co Core
 * Description: MU-Plugin modular — Branding, seguridad y optimización WP by Arrobo & Co
 * Version:     2.0.1
 * Author:      Arrobo & Co
 * Author URI:  https://arrobo.ec
 *
 * Requires PHP: 7.4
 * Requires at least: 6.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ========================
// VERSION
// ========================

define( 'ARROBO_CO_VERSION', '2.0.1' );

// ========================
// MODULE SWITCHES
// ========================

if ( ! defined( 'ARROBO_CO_LOGIN_BRANDING' ) ) {
	define( 'ARROBO_CO_LOGIN_BRANDING', true );
}
if ( ! defined( 'ARROBO_CO_CLEAN_ADMIN_BAR' ) ) {
	define( 'ARROBO_CO_CLEAN_ADMIN_BAR', true );
}
if ( ! defined( 'ARROBO_CO_ADMIN_FOOTER' ) ) {
	define( 'ARROBO_CO_ADMIN_FOOTER', true );
}
if ( ! defined( 'ARROBO_CO_DYNAMIC_EMAIL' ) ) {
	define( 'ARROBO_CO_DYNAMIC_EMAIL', true );
}
if ( ! defined( 'ARROBO_CO_SECURITY' ) ) {
	define( 'ARROBO_CO_SECURITY', true );
}
if ( ! defined( 'ARROBO_CO_WP_CLEANUP' ) ) {
	define( 'ARROBO_CO_WP_CLEANUP', true );
}
if ( ! defined( 'ARROBO_CO_DISABLE_GUTENBERG' ) ) {
	define( 'ARROBO_CO_DISABLE_GUTENBERG', true );
}
if ( ! defined( 'ARROBO_CO_DISABLE_COMMENTS' ) ) {
	define( 'ARROBO_CO_DISABLE_COMMENTS', true );
}
if ( ! defined( 'ARROBO_CO_WP_PERFORMANCE' ) ) {
	define( 'ARROBO_CO_WP_PERFORMANCE', true );
}
if ( ! defined( 'ARROBO_CO_SELF_UPDATE' ) ) {
	define( 'ARROBO_CO_SELF_UPDATE', true );
}

// ========================
// CONFIGURATION
// ========================

if ( ! defined( 'ARROBO_CO_FOOTER_URL' ) ) {
	define( 'ARROBO_CO_FOOTER_URL', 'https://arrobo.ec' );
}
if ( ! defined( 'ARROBO_CO_HOSTING' ) ) {
	define( 'ARROBO_CO_HOSTING', 'kinsta' );
}
if ( ! defined( 'ARROBO_CO_HOSTING_URL' ) ) {
	define( 'ARROBO_CO_HOSTING_URL', '' );
}
if ( ! defined( 'ARROBO_CO_LOGIN_COLOR_PRIMARY' ) ) {
	define( 'ARROBO_CO_LOGIN_COLOR_PRIMARY', '#1F123F' );
}
if ( ! defined( 'ARROBO_CO_LOGIN_COLOR_SECONDARY' ) ) {
	define( 'ARROBO_CO_LOGIN_COLOR_SECONDARY', '#1E293B' );
}
if ( ! defined( 'ARROBO_CO_LOGIN_COLOR_ACCENT' ) ) {
	define( 'ARROBO_CO_LOGIN_COLOR_ACCENT', '#E40046' );
}
if ( ! defined( 'ARROBO_CO_UPDATE_URL' ) ) {
	define( 'ARROBO_CO_UPDATE_URL', 'https://arrobo.ec/agency/update.json' );
}
if ( ! defined( 'ARROBO_CO_UPDATE_FREQUENCY' ) ) {
	define( 'ARROBO_CO_UPDATE_FREQUENCY', 30 );
}
if ( ! defined( 'ARROBO_CO_HEARTBEAT_BEHAVIOR' ) ) {
	define( 'ARROBO_CO_HEARTBEAT_BEHAVIOR', 'only_editing' );
}
if ( ! defined( 'ARROBO_CO_HEARTBEAT_FREQUENCY' ) ) {
	define( 'ARROBO_CO_HEARTBEAT_FREQUENCY', 60 );
}
if ( ! defined( 'ARROBO_CO_POST_REVISIONS' ) ) {
	define( 'ARROBO_CO_POST_REVISIONS', 3 );
}
if ( ! defined( 'ARROBO_CO_AUTOSAVE_INTERVAL' ) ) {
	define( 'ARROBO_CO_AUTOSAVE_INTERVAL', 300 );
}

// ========================
// HELPERS
// ========================

/**
 * Check if Perfmatters plugin is active.
 *
 * @return bool
 */
function arrobo_co_perfmatters_active() {
	return defined( 'PERFMATTERS_VERSION' );
}

/**
 * Get hosting provider name and URL from presets or custom config.
 *
 * @return array{name: string, url: string}|false False if hosting is 'none'.
 */
function arrobo_co_get_hosting() {
	$hosting = strtolower( trim( ARROBO_CO_HOSTING ) );

	if ( 'none' === $hosting ) {
		return false;
	}

	$presets = array(
		'kinsta'     => array(
			'name' => 'Kinsta',
			'url'  => 'https://kinsta.com/pricing/?kaid=IZVRWVGIWNZT',
		),
		'hostinger'  => array(
			'name' => 'Hostinger',
			'url'  => 'https://www.hostg.xyz/aff_c?offer_id=815&aff_id=207603',
		),
		'siteground' => array(
			'name' => 'SiteGround',
			'url'  => 'https://www.siteground.com/go/ftrpx8e00g',
		),
	);

	if ( isset( $presets[ $hosting ] ) ) {
		return $presets[ $hosting ];
	}

	// Custom hosting: use ARROBO_CO_HOSTING as name, ARROBO_CO_HOSTING_URL as link.
	return array(
		'name' => ARROBO_CO_HOSTING,
		'url'  => ARROBO_CO_HOSTING_URL,
	);
}

// ========================
// MODULE 1: LOGIN BRANDING & STYLING
// ========================

if ( ARROBO_CO_LOGIN_BRANDING ) {

	/**
	 * Enqueue custom login styles with branding.
	 */
	add_action( 'login_enqueue_scripts', 'arrobo_co_login_styles' );

	function arrobo_co_login_styles() {
		$logo_url       = '';
		$custom_logo_id = get_theme_mod( 'custom_logo' );

		if ( $custom_logo_id ) {
			$logo_image = wp_get_attachment_image_url( $custom_logo_id, 'medium' );
			if ( $logo_image ) {
				$logo_url = $logo_image;
			}
		}

		$color_primary   = esc_attr( ARROBO_CO_LOGIN_COLOR_PRIMARY );
		$color_secondary = esc_attr( ARROBO_CO_LOGIN_COLOR_SECONDARY );
		$color_accent    = esc_attr( ARROBO_CO_LOGIN_COLOR_ACCENT );

		?>
		<style>
			:root {
				--arrobo-primary: <?php echo $color_primary; ?>;
				--arrobo-secondary: <?php echo $color_secondary; ?>;
				--arrobo-accent: <?php echo $color_accent; ?>;
			}

			body.login {
				background-color: var(--arrobo-primary);
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
			}

			#login h1 a {
				<?php if ( $logo_url ) : ?>
				background-image: url('<?php echo esc_url( $logo_url ); ?>');
				background-size: contain;
				background-repeat: no-repeat;
				background-position: center;
				width: 100%;
				height: 80px;
				<?php else : ?>
				display: none;
				<?php endif; ?>
			}

			#loginform {
				background: var(--arrobo-secondary);
				border: none;
				border-radius: 15px;
				padding: 26px 24px;
				box-shadow: 0 4px 24px rgba(0, 0, 0, 0.25);
			}

			#loginform label {
				color: #e2e8f0;
				font-weight: 500;
			}

			#loginform input[type="text"],
			#loginform input[type="password"] {
				padding: 12px;
				border-radius: 8px;
				border: 1px solid rgba(255, 255, 255, 0.15);
				background: rgba(255, 255, 255, 0.08);
				color: #f1f5f9;
				font-size: 14px;
				transition: border-color 0.2s ease;
			}

			#loginform input[type="text"]:focus,
			#loginform input[type="password"]:focus {
				border-color: var(--arrobo-accent);
				box-shadow: 0 0 0 1px var(--arrobo-accent);
				outline: none;
				background: rgba(255, 255, 255, 0.12);
			}

			#wp-submit {
				background: var(--arrobo-accent);
				border: none;
				border-radius: 8px;
				color: #ffffff;
				font-size: 14px;
				font-weight: 600;
				padding: 10px 24px;
				cursor: pointer;
				transition: opacity 0.2s ease, transform 0.1s ease;
				text-shadow: none;
			}

			#wp-submit:hover {
				opacity: 0.9;
				transform: translateY(-1px);
			}

			#wp-submit:active {
				transform: translateY(0);
			}

			.login #nav,
			.login #backtoblog {
				text-align: center;
			}

			.login #nav a,
			.login #backtoblog a {
				color: rgba(255, 255, 255, 0.65);
				text-decoration: none;
				transition: color 0.2s ease;
			}

			.login #nav a:hover,
			.login #backtoblog a:hover {
				color: #ffffff;
			}

			.login .message,
			.login .success {
				border-left-color: var(--arrobo-accent);
				background: rgba(255, 255, 255, 0.06);
				color: #e2e8f0;
				border-radius: 8px;
			}

			#login_error {
				border-left-color: #ef4444;
				background: rgba(239, 68, 68, 0.1);
				color: #fca5a5;
				border-radius: 8px;
			}

			#login_error a {
				color: #fca5a5;
			}

			.login input[type="checkbox"] {
				accent-color: var(--arrobo-accent);
			}

			.login .forgetmenot label {
				color: rgba(255, 255, 255, 0.65);
			}

			.privacy-policy-page-link a {
				color: rgba(255, 255, 255, 0.5) !important;
			}
		</style>
		<?php
	}

	/**
	 * Point login logo link to site home.
	 */
	add_filter( 'login_headerurl', 'arrobo_co_login_headerurl' );

	function arrobo_co_login_headerurl() {
		return esc_url( home_url( '/' ) );
	}

	/**
	 * Set login logo alt text to site name.
	 */
	add_filter( 'login_headertext', 'arrobo_co_login_headertext' );

	function arrobo_co_login_headertext() {
		return esc_html( get_bloginfo( 'name' ) );
	}
}

// ========================
// MODULE 2: CLEAN ADMIN BAR
// ========================

if ( ARROBO_CO_CLEAN_ADMIN_BAR ) {

	/**
	 * Remove WordPress branding and quick-action nodes from the admin bar.
	 *
	 * @param WP_Admin_Bar $wp_admin_bar Admin bar instance.
	 */
	add_action( 'admin_bar_menu', 'arrobo_co_clean_admin_bar', 999 );

	function arrobo_co_clean_admin_bar( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'wp-logo' );
		$wp_admin_bar->remove_node( 'new-content' );
		$wp_admin_bar->remove_node( 'elementor_edit_page' );
		$wp_admin_bar->remove_node( 'jetelements' );
	}
}

// ========================
// MODULE 3: ADMIN FOOTER BRANDING
// ========================

if ( ARROBO_CO_ADMIN_FOOTER ) {

	/**
	 * Replace admin footer text with custom branding.
	 *
	 * @return string
	 */
	add_filter( 'admin_footer_text', 'arrobo_co_admin_footer_text', 9999 );

	function arrobo_co_admin_footer_text() {
		$text = sprintf(
			'Gracias por elegir <a href="%s" target="_blank">Arrobo & Co</a>',
			esc_url( ARROBO_CO_FOOTER_URL )
		);

		$hosting = arrobo_co_get_hosting();

		if ( $hosting ) {
			$hosting_name = esc_html( $hosting['name'] );

			if ( ! empty( $hosting['url'] ) ) {
				$text .= sprintf(
					' y por alojar tu sitio web con <a href="%s" target="_blank">%s</a>',
					esc_url( $hosting['url'] ),
					$hosting_name
				);
			} else {
				$text .= sprintf(
					' y por alojar tu sitio web con %s',
					$hosting_name
				);
			}
		}

		return $text;
	}
}

// ========================
// MODULE 4: DYNAMIC EMAIL SENDER
// ========================

if ( ARROBO_CO_DYNAMIC_EMAIL ) {

	/**
	 * Set the "From" email address dynamically based on site domain.
	 *
	 * @return string
	 */
	add_filter( 'wp_mail_from', 'arrobo_co_mail_from' );

	function arrobo_co_mail_from() {
		$parsed = wp_parse_url( home_url() );
		$domain = isset( $parsed['host'] ) ? $parsed['host'] : 'localhost';
		return 'noreply@' . $domain;
	}

	/**
	 * Set the "From" name to the site title.
	 *
	 * @return string
	 */
	add_filter( 'wp_mail_from_name', 'arrobo_co_mail_from_name' );

	function arrobo_co_mail_from_name() {
		return get_bloginfo( 'name' );
	}
}

// ========================
// MODULE 5: SECURITY
// ========================

if ( ARROBO_CO_SECURITY ) {

	// TODO: Add Ottokit (SureTriggers) detection here if future security
	// hardening requires REST API exceptions. Detection example:
	// For Ottokit: check for 'suretriggers/suretriggers.php' in active plugins.

	// ----------------------------------------
	// 5.1 — Hide REST Users Endpoint
	// ----------------------------------------

	/**
	 * Block access to /wp/v2/users endpoints only.
	 *
	 * @param array $endpoints Registered REST endpoints.
	 * @return array
	 */
	add_filter( 'rest_endpoints', 'arrobo_co_disable_rest_users' );

	function arrobo_co_disable_rest_users( $endpoints ) {
		if ( isset( $endpoints['/wp/v2/users'] ) ) {
			unset( $endpoints['/wp/v2/users'] );
		}
		if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
			unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}
		return $endpoints;
	}

	// ----------------------------------------
	// 5.2 — Disable XML-RPC
	// ----------------------------------------

	add_filter( 'xmlrpc_enabled', '__return_false' );

	/**
	 * Remove X-Pingback header.
	 *
	 * @param array $headers HTTP headers.
	 * @return array
	 */
	add_filter( 'wp_headers', 'arrobo_co_remove_x_pingback' );

	function arrobo_co_remove_x_pingback( $headers ) {
		unset( $headers['X-Pingback'] );
		return $headers;
	}

	// ----------------------------------------
	// 5.3 — Remove WP Version
	// (Skipped if Perfmatters is active)
	// ----------------------------------------

	/**
	 * Remove version from script and style query strings.
	 *
	 * @param string $src Asset source URL.
	 * @return string
	 */
	function arrobo_co_remove_wp_version_strings( $src ) {
		if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) !== false ) {
			$src = remove_query_arg( 'ver', $src );
		}
		return $src;
	}

	add_action( 'plugins_loaded', 'arrobo_co_maybe_remove_wp_version', 0 );

	function arrobo_co_maybe_remove_wp_version() {
		if ( arrobo_co_perfmatters_active() ) {
			return;
		}
		remove_action( 'wp_head', 'wp_generator' );
		add_filter( 'the_generator', '__return_empty_string' );
		add_filter( 'script_loader_src', 'arrobo_co_remove_wp_version_strings', 10, 1 );
		add_filter( 'style_loader_src', 'arrobo_co_remove_wp_version_strings', 10, 1 );
	}

	// ----------------------------------------
	// 5.4 — Disable File Editing
	// ----------------------------------------

	if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
		define( 'DISALLOW_FILE_EDIT', true );
	}

	// ----------------------------------------
	// 5.5 — Block Author Enumeration
	// ----------------------------------------

	/**
	 * Redirect author enumeration requests (?author=N) to home.
	 */
	add_action( 'template_redirect', 'arrobo_co_block_author_enumeration' );

	function arrobo_co_block_author_enumeration() {
		if ( is_admin() ) {
			return;
		}
		if ( isset( $_GET['author'] ) && is_numeric( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	}

	// ============================================
	// 5.6 — DISABLE APPLICATION PASSWORDS
	// Desactivar esta subsección si Ottokit u otro
	// servicio requiere Application Passwords.
	// ============================================

	add_filter( 'wp_is_application_passwords_available', '__return_false' );

	// ----------------------------------------
	// 5.7 — Security Headers
	// ----------------------------------------

	/**
	 * Send additional security headers.
	 */
	add_action( 'send_headers', 'arrobo_co_security_headers' );

	function arrobo_co_security_headers() {
		if ( headers_sent() ) {
			return;
		}
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	}

	// ----------------------------------------
	// 5.8 — Disable PHP Execution in Uploads
	// (Apache/LiteSpeed only — Nginx like Kinsta
	//  handles this at server config level)
	// ----------------------------------------

	/**
	 * Create .htaccess in uploads dir to block PHP execution.
	 */
	add_action( 'admin_init', 'arrobo_co_protect_uploads_dir' );

	function arrobo_co_protect_uploads_dir() {
		$upload_dir = wp_upload_dir();
		$htaccess   = trailingslashit( $upload_dir['basedir'] ) . '.htaccess';

		if ( file_exists( $htaccess ) ) {
			return;
		}

		$rules  = "# Arrobo & Co — Deny PHP execution in uploads\n";
		$rules .= "<Files *.php>\n";
		$rules .= "deny from all\n";
		$rules .= "</Files>\n";

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		@file_put_contents( $htaccess, $rules );
	}
}

// ========================
// MODULE 6: WP CLEANUP
// ========================

if ( ARROBO_CO_WP_CLEANUP ) {

	// ----------------------------------------
	// 6.1 — Disable Emojis
	// ----------------------------------------

	/**
	 * Remove WordPress emoji scripts and styles.
	 */
	function arrobo_co_disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		add_filter( 'tiny_mce_plugins', 'arrobo_co_disable_emojis_tinymce' );
		add_filter( 'wp_resource_hints', 'arrobo_co_disable_emojis_dns_prefetch', 10, 2 );
	}

	/**
	 * Remove wpemoji from TinyMCE plugins.
	 *
	 * @param array $plugins TinyMCE plugins.
	 * @return array
	 */
	function arrobo_co_disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		}
		return array();
	}

	/**
	 * Remove emoji DNS prefetch.
	 *
	 * @param array  $urls          URLs to prefetch.
	 * @param string $relation_type Relation type.
	 * @return array
	 */
	function arrobo_co_disable_emojis_dns_prefetch( $urls, $relation_type ) {
		if ( 'dns-prefetch' === $relation_type ) {
			$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
			$urls          = array_diff( $urls, array( $emoji_svg_url ) );
		}
		return $urls;
	}

	// ----------------------------------------
	// 6.2 — Remove oEmbed
	// ----------------------------------------

	/**
	 * Remove oEmbed-related actions and scripts.
	 */
	function arrobo_co_disable_oembed() {
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	}

	function arrobo_co_dequeue_embed_script() {
		wp_dequeue_script( 'wp-embed' );
	}

	// ----------------------------------------
	// Register cleanup hooks after plugins load (Perfmatters detection).
	// ----------------------------------------

	add_action( 'plugins_loaded', 'arrobo_co_maybe_wp_cleanup', 0 );

	function arrobo_co_maybe_wp_cleanup() {
		if ( arrobo_co_perfmatters_active() ) {
			return;
		}

		// 6.1 — Disable Emojis.
		add_action( 'init', 'arrobo_co_disable_emojis' );

		// 6.2 — Remove oEmbed.
		add_action( 'init', 'arrobo_co_disable_oembed', 9999 );
		add_action( 'wp_footer', 'arrobo_co_dequeue_embed_script' );

		// 6.3 — Clean wp_head.
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
	}
}

// ========================
// MODULE 7: DISABLE GUTENBERG
// ========================

if ( ARROBO_CO_DISABLE_GUTENBERG ) {

	/**
	 * Dequeue Gutenberg block styles from the frontend.
	 */
	function arrobo_co_dequeue_block_styles() {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
	}

	add_action( 'plugins_loaded', 'arrobo_co_maybe_disable_gutenberg', 0 );

	function arrobo_co_maybe_disable_gutenberg() {
		if ( arrobo_co_perfmatters_active() ) {
			return;
		}
		add_filter( 'use_block_editor_for_post', '__return_false' );
		add_filter( 'use_widgets_block_editor', '__return_false' );
		add_action( 'wp_enqueue_scripts', 'arrobo_co_dequeue_block_styles', 20 );
	}
}

// ========================
// MODULE 8: DISABLE COMMENTS
// ========================

if ( ARROBO_CO_DISABLE_COMMENTS ) {

	/**
	 * Disable comment support on all post types and remove admin UI elements.
	 */
	function arrobo_co_disable_comments_admin() {
		$post_types = get_post_types( array(), 'names' );
		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	}

	function arrobo_co_disable_comments_menu() {
		remove_menu_page( 'edit-comments.php' );
	}

	/**
	 * @param WP_Admin_Bar $wp_admin_bar Admin bar instance.
	 */
	function arrobo_co_disable_comments_admin_bar( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'comments' );
	}

	function arrobo_co_disable_comments_hide_existing() {
		return array();
	}

	function arrobo_co_disable_comments_remove_url_field( $fields ) {
		unset( $fields['url'] );
		return $fields;
	}

	function arrobo_co_disable_comments_dequeue_reply() {
		wp_dequeue_script( 'comment-reply' );
	}

	function arrobo_co_disable_comments_redirect() {
		global $pagenow;
		if ( 'edit-comments.php' === $pagenow ) {
			wp_safe_redirect( admin_url() );
			exit;
		}
	}

	add_action( 'plugins_loaded', 'arrobo_co_maybe_disable_comments', 0 );

	function arrobo_co_maybe_disable_comments() {
		if ( arrobo_co_perfmatters_active() ) {
			return;
		}
		add_action( 'admin_init', 'arrobo_co_disable_comments_admin' );
		add_action( 'admin_menu', 'arrobo_co_disable_comments_menu' );
		add_action( 'admin_bar_menu', 'arrobo_co_disable_comments_admin_bar', 999 );
		add_filter( 'comments_open', '__return_false', 20 );
		add_filter( 'pings_open', '__return_false', 20 );
		add_filter( 'comments_array', 'arrobo_co_disable_comments_hide_existing', 10, 2 );
		add_filter( 'comment_form_default_fields', 'arrobo_co_disable_comments_remove_url_field' );
		add_action( 'wp_enqueue_scripts', 'arrobo_co_disable_comments_dequeue_reply', 20 );
		add_action( 'admin_init', 'arrobo_co_disable_comments_redirect' );
	}
}

// ========================
// MODULE 9: WP PERFORMANCE
// ========================

if ( ARROBO_CO_WP_PERFORMANCE ) {

	// ----------------------------------------
	// 9.1 — Disable Password Strength Meter
	// (Saves ~400KB JS on non-profile pages)
	// ----------------------------------------

	function arrobo_co_disable_password_strength_meter() {
		wp_dequeue_script( 'zxcvbn-async' );
		wp_dequeue_script( 'password-strength-meter' );
	}

	// ----------------------------------------
	// 9.2 — Heartbeat API Control
	// ----------------------------------------

	function arrobo_co_heartbeat_control() {
		$behavior = ARROBO_CO_HEARTBEAT_BEHAVIOR;

		if ( 'default' === $behavior ) {
			return;
		}

		if ( 'disable' === $behavior ) {
			wp_deregister_script( 'heartbeat' );
			return;
		}

		// 'only_editing': allow heartbeat only in post editor.
		if ( 'only_editing' === $behavior ) {
			global $pagenow;
			if ( 'post.php' !== $pagenow && 'post-new.php' !== $pagenow ) {
				wp_deregister_script( 'heartbeat' );
			}
		}
	}

	/**
	 * Set custom heartbeat frequency.
	 *
	 * @param array $settings Heartbeat settings.
	 * @return array
	 */
	function arrobo_co_heartbeat_frequency( $settings ) {
		$settings['interval'] = (int) ARROBO_CO_HEARTBEAT_FREQUENCY;
		return $settings;
	}

	// ----------------------------------------
	// Register performance hooks after plugins load (Perfmatters detection).
	// ----------------------------------------

	add_action( 'plugins_loaded', 'arrobo_co_maybe_wp_performance', 0 );

	function arrobo_co_maybe_wp_performance() {
		if ( arrobo_co_perfmatters_active() ) {
			return;
		}

		// 9.1 — Disable Password Strength Meter.
		add_action( 'wp_enqueue_scripts', 'arrobo_co_disable_password_strength_meter', 20 );

		// 9.2 — Heartbeat API Control.
		add_action( 'init', 'arrobo_co_heartbeat_control', 1 );
		add_filter( 'heartbeat_settings', 'arrobo_co_heartbeat_frequency' );

		// 9.3 — Limit Post Revisions.
		if ( ! defined( 'WP_POST_REVISIONS' ) ) {
			define( 'WP_POST_REVISIONS', (int) ARROBO_CO_POST_REVISIONS );
		}

		// 9.4 — Autosave Interval.
		if ( ! defined( 'AUTOSAVE_INTERVAL' ) ) {
			define( 'AUTOSAVE_INTERVAL', (int) ARROBO_CO_AUTOSAVE_INTERVAL );
		}
	}
}

// ========================
// MODULE 10: SELF-UPDATER
// ========================

if ( ARROBO_CO_SELF_UPDATE ) {

	/**
	 * Register custom cron schedule based on ARROBO_CO_UPDATE_FREQUENCY.
	 *
	 * @param array $schedules Existing cron schedules.
	 * @return array
	 */
	add_filter( 'cron_schedules', 'arrobo_co_update_cron_schedule' );

	function arrobo_co_update_cron_schedule( $schedules ) {
		$days = max( 1, (int) ARROBO_CO_UPDATE_FREQUENCY );
		$schedules['arrobo_co_update_interval'] = array(
			'interval' => $days * DAY_IN_SECONDS,
			'display'  => sprintf( 'Every %d days (Arrobo & Co)', $days ),
		);
		return $schedules;
	}

	/**
	 * Schedule the update check cron event if not already scheduled.
	 */
	add_action( 'admin_init', 'arrobo_co_schedule_update_check' );

	function arrobo_co_schedule_update_check() {
		if ( ! wp_next_scheduled( 'arrobo_co_update_check' ) ) {
			wp_schedule_event( time(), 'arrobo_co_update_interval', 'arrobo_co_update_check' );
		}
	}

	/**
	 * Run the update check: fetch remote JSON, compare versions, download if newer.
	 */
	add_action( 'arrobo_co_update_check', 'arrobo_co_run_update_check' );

	function arrobo_co_run_update_check() {
		$update_url = ARROBO_CO_UPDATE_URL;

		// Fetch the remote update manifest.
		$response = wp_remote_get( $update_url, array(
			'timeout'   => 15,
			'sslverify' => true,
		) );

		if ( is_wp_error( $response ) ) {
			return;
		}

		$status_code = wp_remote_retrieve_response_code( $response );
		if ( 200 !== $status_code ) {
			return;
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( ! is_array( $data ) || empty( $data['version'] ) || empty( $data['download_url'] ) ) {
			return;
		}

		// Only update if remote version is greater than local.
		if ( version_compare( $data['version'], ARROBO_CO_VERSION, '<=' ) ) {
			return;
		}

		// Security: only allow downloads from the same domain as the update URL.
		$allowed_host  = wp_parse_url( $update_url, PHP_URL_HOST );
		$download_host = wp_parse_url( $data['download_url'], PHP_URL_HOST );

		// Allow GitHub releases (github.com and objects.githubusercontent.com).
		$allowed_hosts = array( $allowed_host, 'github.com', 'objects.githubusercontent.com' );
		if ( ! in_array( $download_host, $allowed_hosts, true ) ) {
			return;
		}

		// Download the new file.
		$file_response = wp_remote_get( $data['download_url'], array(
			'timeout'   => 15,
			'sslverify' => true,
		) );

		if ( is_wp_error( $file_response ) ) {
			return;
		}

		if ( 200 !== wp_remote_retrieve_response_code( $file_response ) ) {
			return;
		}

		$file_content = wp_remote_retrieve_body( $file_response );

		// Validate: must be PHP and contain the expected plugin header.
		if ( strpos( $file_content, '<?php' ) !== 0 ) {
			return;
		}
		if ( strpos( $file_content, 'Plugin Name: Arrobo & Co Core' ) === false ) {
			return;
		}

		// Write the updated file.
		$target = WPMU_PLUGIN_DIR . '/arrobo-core.php';

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		$written = @file_put_contents( $target, $file_content );

		if ( false !== $written ) {
			// Store update info for admin notice.
			set_transient( 'arrobo_co_updated', $data['version'], DAY_IN_SECONDS );
		}
	}

	/**
	 * Show admin notice after successful update (once).
	 */
	add_action( 'admin_notices', 'arrobo_co_update_admin_notice' );

	function arrobo_co_update_admin_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$updated_version = get_transient( 'arrobo_co_updated' );
		if ( ! $updated_version ) {
			return;
		}

		delete_transient( 'arrobo_co_updated' );

		printf(
			'<div class="notice notice-success is-dismissible"><p><strong>Arrobo & Co Core</strong> actualizado a v%s.</p></div>',
			esc_html( $updated_version )
		);
	}

} else {

	// Clean up cron event if self-update module is disabled.
	$timestamp = wp_next_scheduled( 'arrobo_co_update_check' );
	if ( $timestamp ) {
		wp_unschedule_event( $timestamp, 'arrobo_co_update_check' );
	}
}
