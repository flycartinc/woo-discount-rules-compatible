<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Class FWDRCIncludesCompatibility
 */
if (!class_exists('FWDRCIncludesCompatibility')) {
    class FWDRCIncludesCompatibility
    {
        protected static $discount_base;

        /**
         * Initialize the scripts
         * */
        public static function init()
        {
            //Wocommerce Currency switcher
            $compatible_wcs_realmag = FWDRCIncludesAdmin::getConfigData('compatible_wcs_realmag777', 0);
            if ($compatible_wcs_realmag == "1") {
                add_filter('woocs_fixed_raw_woocommerce_price', 'FWDRCIncludesCompatibility::compatible_with_currency_switcher_realmag777', 10, 3);
            }

            //Wocommerce multi currency
            $compatible_wmc_villatheme = FWDRCIncludesAdmin::getConfigData('compatible_wmc_villatheme', 0);
            if ($compatible_wmc_villatheme == "1") {
                add_filter('woo_discount_rules_before_apply_discount', function ($price, $product, $cart){
                    return FWDRCIncludesCompatibility::compatible_with_woocommerce_multi_currency_villatheme($price);
                }, 10, 3);

                add_filter('woo_discount_rules_before_calculate_discount_from_subtotal_in_cart', function ($subtotal, $discount_type, $rule){
                    return FWDRCIncludesCompatibility::compatible_with_woocommerce_multi_currency_villatheme($subtotal, true, $discount_type);
                }, 10, 3);
            }

            //WooCommerce Wholesale Prices - Rymera Web Co
            $compatible_wholesale_price = FWDRCIncludesAdmin::getConfigData('compatible_wholesale_price', 0);
            if ($compatible_wholesale_price == "1") {
                add_filter('woo_discount_rules_remove_event_woocommerce_before_calculate_totals', '__return_true');
                add_filter('woo_discount_rules_do_sale_tag_through_strikeout_price', '__return_false');
                add_filter('woo_discount_rules_run_variation_strike_out_with_ajax', '__return_false');
                add_filter('woo_discount_rules_run_variation_strikeout_through_ajax', '__return_false');
                add_filter('wwp_filter_wholesale_price_html', 'FWDRCIncludesCompatibility::compatible_with_wholesale_strikeout_HTML', 100, 7);
                add_filter('woo_discount_rules_has_price_override', 'FWDRCIncludesCompatibility::checkHasWholesalePriceForAnProduct', 10, 2);
                add_filter('woo_discount_rules_price_strikeout_before_discount_price', 'FWDRCIncludesCompatibility::compatible_with_wholesale_before_price_strikeout', 10, 2);
            }

            //WooCommerce Product Add-ons - WooCommerce
            $compatible_product_addon = FWDRCIncludesAdmin::getConfigData('compatible_product_addon', 0);
            if ($compatible_product_addon == "1") {
                add_filter('woo_discount_rules_has_price_override', 'FWDRCIncludesCompatibility::compatible_with_woocommerce_product_addon_price_override', 10, 3);
                add_filter('woo_discount_rules_price_rule_final_amount_applied', 'FWDRCIncludesCompatibility::compatible_with_woocommerce_product_addon_change_final_amount', 10, 6);
            }

            //WooCommerce Product Bundles - SomewhereWarm
            $compatible_product_bundles = FWDRCIncludesAdmin::getConfigData('compatible_product_bundles', 0);
            if ($compatible_product_bundles == "1") {
                add_filter('woo_discount_rules_remove_event_woocommerce_before_calculate_totals', '__return_true');
                add_filter('woo_discount_rules_has_price_override', '__return_true');
            }

            //WooCommerce Gravity Forms Product Add-ons - Lucas Stark
            $compatible_product_addon_lucas = FWDRCIncludesAdmin::getConfigData('compatible_product_addon_lucas', 0);
            if ($compatible_product_addon_lucas == "1") {
                add_filter('woo_discount_rules_has_price_override', '__return_true');
            }

            //Role Based price - Varun sridharan
            $compatible_role_based_price = FWDRCIncludesAdmin::getConfigData('compatible_role_based_price', 0);
            if ($compatible_role_based_price == "1") {
                add_filter('wc_rbp_product_get_price', 'FWDRCIncludesCompatibility::compatible_with_woocommerce_role_based_price_on_get_price', 10, 3);
            }

            //Extra Product Options (Product Addons) for WooCommerce - ThemeHiGH
            $compatible_extra_product_option_theme_high = FWDRCIncludesAdmin::getConfigData('compatible_extra_product_option_theme_high', 0);
            if ($compatible_extra_product_option_theme_high == "1") {
                add_filter('woo_discount_rules_remove_event_woocommerce_before_calculate_totals', '__return_true');
                add_filter( 'woo_discount_rules_apply_rules_repeatedly', '__return_true' );
                add_filter('woo_discount_rules_do_not_apply_discount_for_free_product', '__return_false');
                add_filter('woo_discount_rules_has_price_override', 'FWDRCIncludesCompatibility::compatible_with_extra_product_option_override', 10, 4);
                add_filter('woo_discount_rules_skip_discount_for_free_product', 'FWDRCIncludesCompatibility::compatible_with_extra_product_option_skip_discount_for_free_product', 10, 2);
                add_filter('woo_discount_rules_reduce_qty_skip_discount_for_free_product', 'FWDRCIncludesCompatibility::compatible_with_extra_product_option_reduce_qty_skip_discount_for_free_product', 10, 2);
            }

            //WooCommerce Composite Products - SomewhereWarm
            $compatible_woocommerce_composite_product = FWDRCIncludesAdmin::getConfigData('compatible_woocommerce_composite_product', 0);
            if ($compatible_woocommerce_composite_product == "1") {
                add_filter('woo_discount_rules_exclude_cart_item_from_discount', 'FWDRCIncludesCompatibility::compatible_with_woocommerce_composite_product', 10, 2);
            }

            add_action('deactivated_plugin', 'FWDRCIncludesCompatibility::detect_plugin_deactivation', 10, 2);
        }

        /**
         * To handle remove option when the plugin is deactivated
         * */
        public static function detect_plugin_deactivation($plugin, $network_activation)
        {
            if ($plugin == "woocommerce-currency-switcher/index.php") {
                self::disable_an_option('compatible_wcs_realmag777');
            } elseif ($plugin == "woo-multi-currency/woo-multi-currency.php" || $plugin == "woocommerce-multi-currency/woocommerce-multi-currency.php") {
                self::disable_an_option('compatible_wmc_villatheme');
            } elseif ($plugin == "woocommerce-wholesale-prices/woocommerce-wholesale-prices.bootstrap.php") {
                self::disable_an_option('compatible_wholesale_price');
            } elseif ($plugin == "woocommerce-product-addons/woocommerce-product-addons.php") {
                self::disable_an_option('compatible_product_addon');
            } elseif ($plugin == "woocommerce-product-bundles/woocommerce-product-bundles.php") {
                self::disable_an_option('compatible_product_bundles');
            } elseif ($plugin == "woocommerce-gravityforms-product-addons/gravityforms-product-addons.php") {
                self::disable_an_option('compatible_product_addon_lucas');
            } elseif ($plugin == "woocommerce-role-based-price/woocommerce-role-based-price.php") {
                self::disable_an_option('compatible_role_based_price');
            } elseif ($plugin == "woo-extra-product-options/woo-extra-product-options.php") {
                self::disable_an_option('compatible_extra_product_option_theme_high');
            } elseif ($plugin == "woocommerce-composite-products/woocommerce-composite-products.php") {
                self::disable_an_option('compatible_woocommerce_composite_product');
            }
        }

        /**
         * disable an option
         * */
        protected static function disable_an_option($option_key)
        {
            $config = FWDRCIncludesAdmin::getConfig();
            if (is_string($config)) $config = json_decode($config, true);
            if (isset($config[$option_key])) {
                unset($config[$option_key]);
                $params = json_encode($config);
                update_option('woo-discount-compatibility', $params);
            }
        }

        /**
         * To make compatible with woocommerce currency switcher - realmag777
         * */
        public static function compatible_with_currency_switcher_realmag777($tmp_val, $product_data, $price)
        {
            remove_filter('woocs_fixed_raw_woocommerce_price', 'FWDRCIncludesCompatibility::compatible_with_currency_switcher_realmag777', 10, 3);
            global $flycart_woo_discount_rules;
            if (!empty($flycart_woo_discount_rules)) {
                global $product;
                if (empty($product)) {
                    $discount_price = $flycart_woo_discount_rules->pricingRules->getDiscountPriceOfProduct($product_data);
                    if ($discount_price !== null) $tmp_val = $discount_price;
                }
            }
            add_filter('woocs_fixed_raw_woocommerce_price', 'FWDRCIncludesCompatibility::compatible_with_currency_switcher_realmag777', 10, 3);

            return $tmp_val;
        }

        /**
         * To make compatible with woocommerce multi currency - villatheme
         * */
        public static function compatible_with_woocommerce_multi_currency_villatheme($price, $is_cart = false, $discount_type = 'percentage_discount'){
            $path = WP_PLUGIN_DIR.'/woo-multi-currency/includes/data.php';
            if(file_exists($path)) require_once $path;

            $path = WP_PLUGIN_DIR.'/woocommerce-currency-switcher/includes/data.php';
            if(file_exists($path)) require_once $path;

            $process_conversion = true;
            if($is_cart === true){
                if($discount_type !== 'percentage_discount'){
                    $process_conversion = false;
                }
            }
            if($process_conversion){
                $class_exists = false;
                if(class_exists('WOOMULTI_CURRENCY_F_Data')){
                    $setting         = new WOOMULTI_CURRENCY_F_Data();
                    $class_exists = true;
                } elseif(class_exists('WOOMULTI_CURRENCY_Data')){
                    $setting         = new WOOMULTI_CURRENCY_Data();
                    $class_exists = true;
                }
                if($class_exists === true){
                    $selected_currencies = $setting->get_list_currencies();
                    $current_currency    = $setting->get_current_currency();
                    if ( ! $current_currency ) {
                        return $price;
                    }
                    if ( $price ) {
                        $price = $price / $selected_currencies[ $current_currency ]['rate'];
                    }
                }
            }

            return $price;
        }

        /**
         * To make compatible with WooCommerce Wholesale Prices - Rymera Web Co
         * */
        public static function compatible_with_wholesale_strikeout_HTML($wholesale_price_html, $price, $product, $user_wholesale_role, $wholesale_price_title_text, $raw_wholesale_price, $source){
            global $flycart_woo_discount_rules;
            if(isset($flycart_woo_discount_rules->pricingRules)){
                if(empty($raw_wholesale_price)){
                    $product->woo_discount_rules_do_not_run_strikeout = 1;
                } else {
                    $product->set_price($raw_wholesale_price);
                    $wholesale_price_html = $flycart_woo_discount_rules->pricingRules->replaceVisiblePricesOptimized($wholesale_price_html, $product);
                    $product->woo_discount_rules_do_not_run_strikeout = 1;
                }
            }

            return $wholesale_price_html;
        }

        /**
         * To make compatible with WooCommerce Wholesale Prices - Rymera Web Co
         * */
        public static function checkHasWholesalePriceForAnProduct($hasWholesalePrice, $product){
            if(isset($product->wwp_data)){
                if(isset($product->wwp_data['wholesale_priced']) && $product->wwp_data['wholesale_priced'] == 'yes'){
                    $hasWholesalePrice = 1;
                }
            }

            return $hasWholesalePrice;
        }

        /**
         * To make compatible with WooCommerce Wholesale Prices - Rymera Web Co
         * */
        public static function compatible_with_wholesale_before_price_strikeout($price_html, $product){
            $price_html = str_replace('<del class="original-computed-price">', '', $price_html);
            $price_html = str_replace('</del>', '', $price_html);
            return $price_html;
        }

        /**
         * To make compatible with WooCommerce Product Add-ons - WooCommerce
         * */
        public static function compatible_with_woocommerce_product_addon_price_override($has_price_override, $product, $on_apply_discount){
            if($on_apply_discount == 'on_apply_discount') $has_price_override = true;
            return $has_price_override;
        }

        /**
         * To make compatible with WooCommerce Product Add-ons - WooCommerce
         * */
        public static function compatible_with_woocommerce_product_addon_change_final_amount($discountedPrice, $price, $discount, $additionalDetails, $product, $product_page){
            if($discountedPrice < 0) $discountedPrice = 0;
            $total_price = $product->get_price();
            $addon_price = 0;
            if($price != $total_price){
                $addon_price = $total_price - $price;
            }
            $discountedPrice = $discountedPrice + $addon_price;

            return $discountedPrice;
        }

        /**
         * To make compatible with Role Based price - Varun sridharan
         * */
        public static function compatible_with_woocommerce_role_based_price_on_get_price($wcrbp_price, $product, $role_based_pricing_object){
            $changes = $product->get_changes();
            if(!empty($changes)){
                if(isset($changes['price'])){
                    $wcrbp_price = $changes['price'];
                }
            }
            return $wcrbp_price;
        }

        /**
         * To make compatible with Extra Product Options (Product Addons) for WooCommerce - ThemeHiGH
         * */
        public static function compatible_with_extra_product_option_reduce_qty_skip_discount_for_free_product($reduce_quantity, $cart_item){
            $_product = $cart_item['data'];
            if(!empty($_product)){
                $price = $_product->get_price();
                if($price == 0){
                    return $cart_item['quantity'];
                }
            }

            return $reduce_quantity;
        }

        /**
         * To make compatible with Extra Product Options (Product Addons) for WooCommerce - ThemeHiGH
         * */
        public static function compatible_with_extra_product_option_skip_discount_for_free_product($skip_free_product, $cart_item){
            $_product = $cart_item['data'];
            if(!empty($_product)){
                $price = $_product->get_price();
                if($price == 0){
                    return true;
                    /*if(!empty($cart_item['thwepo_options'])){
                        return true;
                    }*/
                }
            }

            return $skip_free_product;
        }

        /**
         * To make compatible with Extra Product Options (Product Addons) for WooCommerce - ThemeHiGH
         * */
        public static function compatible_with_extra_product_option_override($hasPriceOverride, $product, $on_apply_discount, $cart_item){
            if(isset($cart_item['thwepo_options'])){
                if(!empty($cart_item['thwepo_options'])){
                    return true;
                }
            }

            return false;
        }

        /**
         * To make compatible with WooCommerce Composite Products
         * */
        public static function compatible_with_woocommerce_composite_product($status, $cart_item){
            if(isset($cart_item['composite_item']) && !empty($cart_item['composite_item'])){
                $status = true;
            }
            return $status;
        }

        /**
         * Is countable object or array
         * */
        public static function is_countable($data){
            if((is_array($data) || is_object($data))){
                if(is_object($data)) $data = (array)$data;
                if(count($data)) return true;
            }
            return false;
        }
    }

    FWDRCIncludesCompatibility::init();
}