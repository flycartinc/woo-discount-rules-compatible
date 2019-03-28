<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

/**
 * Plugin Directory.
 */
define('WOO_DISCOUNT_COMPATIBLE_DIR', untrailingslashit(plugin_dir_path(__FILE__)));

/**
 * Plugin Directory URI.
 */
define('WOO_DISCOUNT_COMPATIBLE_URI', untrailingslashit(plugin_dir_url(__FILE__)));

/**
 * Plugin Base Name.
 */
define('WOO_DISCOUNT_COMPATIBLE_PLUGIN_BASENAME', plugin_basename(__FILE__));

if(!class_exists('FlycartWooDiscountRulesCompatible')) {
    class FlycartWooDiscountRulesCompatible
    {
        private static $_instance = null;

        /**
         * FlycartWooDiscountRulesCompatible constructor.
         */
        function __construct()
        {
            $this->checkForPluginUpdates();
        }

        /**
         * Check for plugin updates - this will check for git releases
         */
        function checkForPluginUpdates(){
            \Puc_v4_Factory::buildUpdateChecker('https://github.com/flycartinc/woo-discount-rules-compatible', dirname(__FILE__).'/woo-discount-rules-compatible.php', 'woo-discount-rules-compatible');
        }

        /**
         * Get the single instance
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Bootstrap
         */
        public function bootstrap() {
            $this->includeFiles();
            if (is_admin()) {
                $this->loadAdminScripts();
            }
        }

        /**
         * To include Files
         * */
        protected function includeFiles(){
            include_once(dirname(__FILE__).'/includes/admin.php');
            include_once(dirname(__FILE__).'/includes/compatibility.php');
        }

        /**
         * Admin hooks
         * */
        protected function loadAdminScripts(){
            // Init Admin Menu
            add_action('admin_menu', 'FWDRCIncludesAdmin::adminMenu');
        }
    }

    FlycartWooDiscountRulesCompatible::instance()->bootstrap();
}