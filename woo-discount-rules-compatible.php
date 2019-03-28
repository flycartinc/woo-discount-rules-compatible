<?php
/**
 * Plugin name: Woo Discount Rules Compatible
 * Plugin URI: http://www.flycart.org
 * Description: To make compatible with Discount Rules for WooCommerce.
 * Author: Flycart Technologies LLP
 * Author URI: https://www.flycart.org
 * Version: 1.0.0
 * Text Domain: woo-discount-rules-compatible
 * Domain Path: /i18n/languages/
 * Requires at least: 4.6.1
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly
/**
 * Check if Woo Discount rule is enabled is active
 **/
if ( in_array( 'woo-discount-rules/woo-discount-rules.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    include_once(dirname(__FILE__) . '/loader.php');
}