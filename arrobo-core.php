<?php
/**
 * Plugin Name: Arrobo & Co Core
 * Description: MU-Plugin modular — Branding, seguridad y optimización WP by Arrobo & Co
 * Version:     1.0.0
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

// ========================
// HELPER: Hosting Presets
// ========================

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
		'kinsta'    => array(
			'name' => 'Kinsta',
			'url'  => 'https://kinsta.com/pricing/?kaid=IZVRWVGIWNZT',
		),
		'hostinger' => array(
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
// HELPER: Perfmatters Detection
// ========================

/**
 * Check if Perfmatters plugin is active.
 *
 * @return bool
 */
function arrobo_co_perfmatters_active() {
	return defined( 'PERFMATTERS_VERSION' );
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
		$logo_url = '';
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
	 * Remove WordPress branding nodes from the admin bar.
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
	add_filter( 'admin_footer_text', 'arrobo_co_admin_footer_text' );

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
	// defined('JEENGINE_VERSION') already protects JetEngine.
	// For Ottokit: defined('JEENGINE_VERSION') or check for 'suretriggers/suretriggers.php'

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

	if ( ! arrobo_co_perfmatters_active() ) {

		// Remove from head.
		remove_action( 'wp_head', 'wp_generator' );

		// Remove from feeds.
		add_filter( 'the_generator', '__return_empty_string' );

		/**
		 * Remove version from script and style query strings.
		 *
		 * @param string $src Asset source URL.
		 * @return string
		 */
		add_filter( 'script_loader_src', 'arrobo_co_remove_wp_version_strings', 10, 1 );
		add_filter( 'style_loader_src', 'arrobo_co_remove_wp_version_strings', 10, 1 );

		function arrobo_co_remove_wp_version_strings( $src ) {
			if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) !== false ) {
				$src = remove_query_arg( 'ver', $src );
			}
			return $src;
		}
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

	// Skip entirely if Perfmatters handles these optimizations.
	if ( ! arrobo_co_perfmatters_active() ) {

		// ----------------------------------------
		// 6.1 — Disable Emojis
		// ----------------------------------------

		/**
		 * Remove WordPress emoji scripts and styles.
		 */
		add_action( 'init', 'arrobo_co_disable_emojis' );

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
		add_action( 'init', 'arrobo_co_disable_oembed', 9999 );

		function arrobo_co_disable_oembed() {
			remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
			remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		}

		add_action( 'wp_footer', 'arrobo_co_dequeue_embed_script' );

		function arrobo_co_dequeue_embed_script() {
			wp_dequeue_script( 'wp-embed' );
		}

		// ----------------------------------------
		// 6.3 — Clean wp_head
		// ----------------------------------------

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

	// Skip if Perfmatters is active (it can handle Gutenberg disabling).
	if ( ! arrobo_co_perfmatters_active() ) {

		// Disable Block Editor for posts.
		add_filter( 'use_block_editor_for_post', '__return_false' );

		// Disable Block Editor for widgets.
		add_filter( 'use_widgets_block_editor', '__return_false' );

		/**
		 * Dequeue Gutenberg block styles from the frontend.
		 */
		add_action( 'wp_enqueue_scripts', 'arrobo_co_dequeue_block_styles', 20 );

		function arrobo_co_dequeue_block_styles() {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
			wp_dequeue_style( 'global-styles' );
			wp_dequeue_style( 'classic-theme-styles' );
		}
	}
}
