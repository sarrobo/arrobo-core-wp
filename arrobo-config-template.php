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
// define( 'ARROBO_CO_EMAIL_DELIVERY', true );
// define( 'ARROBO_CO_MAIL_LOG', true );

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

// ========================
// EMAIL DELIVERY (RESEND SMTP)
// ========================
// Routes all wp_mail() — including every WooCommerce transactional email —
// through Resend's SMTP service.
//
// Requirements before this works:
//   1. Create a Resend account and verify this site's sending domain
//      (add the SPF/DKIM DNS records Resend provides).
//   2. Generate an API key and paste it below.
//
// The module stays inert (default wp_mail) until ARROBO_CO_RESEND_API_KEY
// is defined. It also stands down automatically if a dedicated SMTP plugin
// (WP Mail SMTP, FluentSMTP, Post SMTP, etc.) is active on the site.
//
// SECURITY: the API key is a per-site secret. Define it ONLY here — never
// in arrobo-core.php, which is public on GitHub and auto-updated.

// define( 'ARROBO_CO_RESEND_API_KEY', 're_xxxxxxxxxxxxxxxxxxxxxxxxxx' );

// SMTP port: 587 or 2587 (TLS), 465 or 2465 (SSL). Default 587.
// define( 'ARROBO_CO_RESEND_SMTP_PORT', 587 );

// ========================
// EMAIL POLICY (FROM / REPLY-TO)
// ========================
// From-address policy for Module 4:
//
//   'strict' (default)
//     Force noreply@<domain> on every email with priority 9999. Agency
//     policy wins over WooCommerce, plugins, themes — single source of
//     truth. Recommended for most sites.
//
//   'woo'
//     Register the same filter at priority 1 (low). Plugins that filter
//     wp_mail_from at default priority (10), including WooCommerce inside
//     WC_Email::send(), override us for the emails they control. But for
//     emails nobody else filters (WP core password reset, comment notices,
//     etc.) our filter is the fallback default — preventing the silent
//     wordpress@<domain> default that breaks providers requiring a
//     verified sender domain (Resend, SES, Postmark).
//
// define( 'ARROBO_CO_MAIL_FROM_POLICY', 'strict' );

// Domain used to build the noreply@<domain> From address. Override when
// the verified email-sending domain is NOT the same as the site domain —
// common best practice: send transactional mail from a subdomain like
// updates.example.com to isolate its deliverability reputation from the
// bare domain.
//
// If unset, falls back to the home_url() host with www. stripped.
//
// Example: site at https://eltioboris.com with Resend verifying
// updates.eltioboris.com → set this to 'updates.eltioboris.com'.
//
// define( 'ARROBO_CO_MAIL_FROM_DOMAIN', 'updates.cliente.com' );

// Optional Reply-To address. Independent of From policy. If defined and
// non-empty, every wp_mail() gets this Reply-To header. Useful when From
// is noreply@<subdomain> but customers still need a reachable mailbox.
//
// define( 'ARROBO_CO_MAIL_REPLY_TO', 'contacto@cliente.com' );

// ========================
// MAIL LOG (OBSERVABILITY)
// ========================
// Captures every wp_mail() attempt (metadata only — no message body or
// attachments) as a rolling buffer. Visible at:
//   Tools → Arrobo Mail Log
//
// Independent of host log retention. Critical for diagnosing mail issues
// on hosts that don't persist PHP error logs (Hostinger Shared, etc.).

// define( 'ARROBO_CO_MAIL_LOG_MAX', 100 );
