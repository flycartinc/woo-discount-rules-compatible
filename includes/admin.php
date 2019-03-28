<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if(!class_exists('FWDRCIncludesAdmin')) {
    class FWDRCIncludesAdmin
    {
        protected static $config = null;

        /**
         * Create New Menu On WooCommerce.
         */
        public static function adminMenu()
        {
            if (!is_admin()) return;

            global $submenu;
            if (isset($submenu['woocommerce'])) {
                add_submenu_page(
                    'woocommerce',
                    'Woo Discount Rules Compatible',
                    'Woo Discount Rules Compatible',
                    'edit_posts',
                    'woo_discount_rules_compatible',
                    'FWDRCIncludesAdmin::viewSettingPage'
                );
            }
        }

        /**
         *
         */
        public static function viewSettingPage()
        {
            self::saveConfig();
            $data = self::getConfig(1);
            require_once WOO_DISCOUNT_COMPATIBLE_DIR.'/views/admin/settings.php';
        }

        public static function getConfig($reload = 0){
            if(self::$config === null || $reload == 1){
                $option = get_option('woo-discount-compatibility');
                if (!$option || is_null($option)) {
                    self::$config = array();
                } else {
                    self::$config = $option;
                }
            }

            return self::$config;
        }

        public static function getConfigData($key, $default = ''){
            $options = self::getConfig();
            if (is_string($options)) $options = json_decode($options, true);
            if(isset($options[$key])){
                return $options[$key];
            }
            return $default;
        }

        protected static function saveConfig(){
            $option_type = 'woo-discount-compatibility';
            if(isset($_POST['wdrc'])){
                $wdrc = $_POST['wdrc'];
                if(isset($wdrc['save']) && $wdrc['save'] == 1){
                    $params = array();
                    foreach ($wdrc as $key => $value){
                        if($key != 'save'){
                            $params[$key] = sanitize_text_field($value);
                        }
                    }
                    $params = json_encode($params);
                    if (get_option($option_type)) {
                        update_option($option_type, $params);
                    } else {
                        add_option($option_type, $params);
                    }
                }
            }
        }
    }
}