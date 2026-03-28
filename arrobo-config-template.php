<?php
/**
 * Arrobo & Co — Site Configuration
 *
 * Client:  CLIENT_NAME
 * Created: YYYY-MM-DD
 *
 * Instructions:
 * 1. Copy this file to /wp-content/mu-plugins/arrobo-config.php
 * 2. Uncomment and modify ONLY the constants you need to override.
 * 3. This file loads BEFORE arrobo-core.php (alphabetical order),
 *    so any constant defined here takes priority.
 * 4. DO NOT rename this file — it must be arrobo-config.php.
 * 5. This file is NEVER auto-updated by the Self-Updater module.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ========================
// MODULE SWITCHES
// ========================
// Set to false to disable a module for this site.
// All modules default to true in arrobo-core.php.

// define( 'ARROBO_CO_LOGIN_BRANDING', true );
// define( 'ARROBO_CO_CLEAN_ADMIN_BAR', true );
// define( 'ARROBO_CO_ADMIN_FOOTER', true );
// define( 'ARROBO_CO_DYNAMIC_EMAIL', true );
// define( 'ARROBO_CO_SECURITY', true );
// define( 'ARROBO_CO_WP_CLEANUP', true );
// define( 'ARROBO_CO_DISABLE_GUTENBERG', true );
// define( 'ARROBO_CO_DISABLE_COMMENTS', true );
// define( 'ARROBO_CO_WP_PERFORMANCE', true );
// define( 'ARROBO_CO_SELF_UPDATE', true );

// ========================
// HOSTING
// ========================
// Presets: 'kinsta', 'hostinger', 'siteground', 'none'
// For custom hosting, set ARROBO_CO_HOSTING to the provider name
// and ARROBO_CO_HOSTING_URL to the affiliate/referral link.

// define( 'ARROBO_CO_HOSTING', 'kinsta' );
// define( 'ARROBO_CO_HOSTING_URL', '' );

// ========================
// LOGIN COLORS
// ========================

// define( 'ARROBO_CO_LOGIN_COLOR_PRIMARY', '#1F123F' );
// define( 'ARROBO_CO_LOGIN_COLOR_SECONDARY', '#1E293B' );
// define( 'ARROBO_CO_LOGIN_COLOR_ACCENT', '#E40046' );

// ========================
// BRANDING
// ========================

// define( 'ARROBO_CO_FOOTER_URL', 'https://arrobo.ec' );

// ========================
// PERFORMANCE
// ========================
// Heartbeat behavior: 'disable', 'only_editing', 'default'

// define( 'ARROBO_CO_HEARTBEAT_BEHAVIOR', 'only_editing' );
// define( 'ARROBO_CO_HEARTBEAT_FREQUENCY', 60 );
// define( 'ARROBO_CO_POST_REVISIONS', 3 );
// define( 'ARROBO_CO_AUTOSAVE_INTERVAL', 300 );

// ========================
// SELF-UPDATER
// ========================

// define( 'ARROBO_CO_UPDATE_URL', 'https://arrobo.ec/agency/update.json' );
// define( 'ARROBO_CO_UPDATE_FREQUENCY', 30 );
