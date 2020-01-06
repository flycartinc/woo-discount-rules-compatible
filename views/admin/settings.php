<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
?>
<h2><?php esc_html_e('Woo Discount Rules - Compatible', 'woo-discount-rules-compatible-compatible'); ?></h2>
<?php

if (is_string($data)) $data = json_decode($data, true);
$has_compatibility_plugin = false;
?>

<div class="container-fluid woo_discount_loader_outer">
    <div class="row-fluid">
        <div class="col-md-12">
            <form method="post" id="discount_config">
                <div class="row">
                    <div class="">
                        <h4><?php esc_html_e('Add compatible for the plugin', 'woo-discount-rules-compatible'); ?></h4>
                        <hr>
                    </div>
                    <div class="">
                        <?php
                        $data['compatible_wcs_realmag777'] = (isset($data['compatible_wcs_realmag777']) ? $data['compatible_wcs_realmag777'] : 0);
                        if ( is_plugin_active( 'woocommerce-currency-switcher/index.php' ) || ($data['compatible_wcs_realmag777'] == 1)) {
                            $has_compatibility_plugin = true;
                            ?>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label>
                                        <input type="checkbox" name="wdrc[compatible_wcs_realmag777]" id="compatible_wcs_realmag777" value="1" <?php if ($data['compatible_wcs_realmag777'] == 1) { ?> checked <?php } ?>>
                                        <?php esc_html_e('Add compatible for WooCommerce Currency Switcher', 'woo-discount-rules-compatible'); ?>
                                    </label>
                                </div>
                                <?php
                                $data['compatible_wcs_realmag777_strict_based_on_currency'] = (isset($data['compatible_wcs_realmag777_strict_based_on_currency']) ? $data['compatible_wcs_realmag777_strict_based_on_currency'] : 0);
                                ?>
                                <div class="col-md-12">
                                    <label>
                                        <input type="checkbox" name="wdrc[compatible_wcs_realmag777_strict_based_on_currency]" id="compatible_wcs_realmag777_strict_based_on_currency" value="1" <?php if ($data['compatible_wcs_realmag777_strict_based_on_currency'] == 1) { ?> checked <?php } ?>>
                                        <?php _e('WooCommerce Currency Switcher - (<b>Additionally use this, only when the above doesn\'t work</b>)', 'woo-discount-rules-compatible'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        }
                        //Wocommerce multi currency
                        $data['compatible_wmc_villatheme'] = (isset($data['compatible_wmc_villatheme']) ? $data['compatible_wmc_villatheme'] : 0);
                        if ( is_plugin_active( 'woo-multi-currency/woo-multi-currency.php' ) || is_plugin_active( 'woocommerce-multi-currency/woocommerce-multi-currency.php' ) || ($data['compatible_wmc_villatheme'] == 1)) {
                            $has_compatibility_plugin = true;
                            ?>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label>
                                        <input type="checkbox" name="wdrc[compatible_wmc_villatheme]" id="compatible_wmc_villatheme" value="1" <?php if ($data['compatible_wmc_villatheme'] == 1) { ?> checked <?php } ?>>
                                        <?php esc_html_e('Add compatible for Multi Currency for WooCommerce', 'woo-discount-rules-compatible'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        }
                        //WooCommerce Wholesale Prices - Rymera Web Co
                        $data['compatible_wholesale_price'] = (isset($data['compatible_wholesale_price']) ? $data['compatible_wholesale_price'] : 0);
                        if ( is_plugin_active( 'woocommerce-wholesale-prices/woocommerce-wholesale-prices.bootstrap.php' ) || ($data['compatible_wholesale_price'] == 1)) {
                            $has_compatibility_plugin = true;
                            ?>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label>
                                        <input type="checkbox" name="wdrc[compatible_wholesale_price]" id="compatible_wholesale_price" value="1" <?php if ($data['compatible_wholesale_price'] == 1) { ?> checked <?php } ?>>
                                        <?php esc_html_e('Add compatible for WooCommerce Wholesale Prices', 'woo-discount-rules-compatible'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        }
                        //WooCommerce Product Add-ons - WooCommerce
                        $data['compatible_product_addon'] = (isset($data['compatible_product_addon']) ? $data['compatible_product_addon'] : 0);
                        if ( is_plugin_active( 'woocommerce-product-addons/woocommerce-product-addons.php' ) || ($data['compatible_product_addon'] == 1)) {
                            $has_compatibility_plugin = true;
                            ?>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label>
                                        <input type="checkbox" name="wdrc[compatible_product_addon]" id="compatible_product_addon" value="1" <?php if ($data['compatible_product_addon'] == 1) { ?> checked <?php } ?>>
                                        <?php esc_html_e('Add compatible for WooCommerce Product Add-ons', 'woo-discount-rules-compatible'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        }
                        //WooCommerce Product Bundles - SomewhereWarm
                        $data['compatible_product_bundles'] = (isset($data['compatible_product_bundles']) ? $data['compatible_product_bundles'] : 0);
                        if ( is_plugin_active( 'woocommerce-product-bundles/woocommerce-product-bundles.php' ) || ($data['compatible_product_bundles'] == 1)) {
                            $has_compatibility_plugin = true;
                            ?>
                            <div class="row form-group">
                                <div class="col-md-2">
                                    <label>
                                        <input type="checkbox" name="wdrc[compatible_product_bundles]" id="compatible_product_bundles" value="1" <?php if ($data['compatible_product_bundles'] == 1) { ?> checked <?php } ?>>
                                        <?php esc_html_e('Add compatible for WooCommerce Product Bundles', 'woo-discount-rules-compatible'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        }
                        //WooCommerce Gravity Forms Product Add-ons - Lucas Stark
                        $data['compatible_product_addon_lucas'] = (isset($data['compatible_product_addon_lucas']) ? $data['compatible_product_addon_lucas'] : 0);
                        if ( is_plugin_active( 'woocommerce-gravityforms-product-addons/gravityforms-product-addons.php' ) || ($data['compatible_product_addon_lucas'] == 1)) {
                            $has_compatibility_plugin = true;
                            ?>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label>
                                        <input type="checkbox" name="wdrc[compatible_product_addon_lucas]" id="compatible_product_addon_lucas" value="1" <?php if ($data['compatible_product_addon_lucas'] == 1) { ?> checked <?php } ?>>
                                        <?php esc_html_e('Add compatible for WooCommerce Gravity Forms Product Add-ons', 'woo-discount-rules-compatible'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        }

                        //Role Based price - Varun sridharan
                        $data['compatible_role_based_price'] = (isset($data['compatible_role_based_price']) ? $data['compatible_role_based_price'] : 0);
                        if ( is_plugin_active( 'woocommerce-role-based-price/woocommerce-role-based-price.php' ) || ($data['compatible_role_based_price'] == 1)) {
                            $has_compatibility_plugin = true;
                            ?>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label>
                                        <input type="checkbox" name="wdrc[compatible_role_based_price]" id="compatible_role_based_price" value="1" <?php if ($data['compatible_role_based_price'] == 1) { ?> checked <?php } ?>>
                                        <?php esc_html_e('Add compatible for WooCommerce Role Based Price', 'woo-discount-rules-compatible'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        }

                        //Extra Product Options (Product Addons) for WooCommerce - ThemeHiGH
                        $data['compatible_extra_product_option_theme_high'] = (isset($data['compatible_extra_product_option_theme_high']) ? $data['compatible_extra_product_option_theme_high'] : 0);
                        if ( is_plugin_active( 'woo-extra-product-options/woo-extra-product-options.php' ) || ($data['compatible_extra_product_option_theme_high'] == 1)) {
                            $has_compatibility_plugin = true;
                            ?>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label>
                                        <input type="checkbox" name="wdrc[compatible_extra_product_option_theme_high]" id="compatible_extra_product_option_theme_high" value="1" <?php if ($data['compatible_extra_product_option_theme_high'] == 1) { ?> checked <?php } ?>>
                                        <?php esc_html_e('Add compatible for Extra Product Options (Product Addons) for WooCommerce', 'woo-discount-rules-compatible'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        }

                        //WooCommerce Composite Products - SomewhereWarm
                        $data['compatible_woocommerce_composite_product'] = (isset($data['compatible_woocommerce_composite_product']) ? $data['compatible_woocommerce_composite_product'] : 0);
                        if ( is_plugin_active( 'woocommerce-composite-products/woocommerce-composite-products.php' ) || ($data['compatible_woocommerce_composite_product'] == 1)) {
                            $has_compatibility_plugin = true;
                            ?>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label>
                                        <input type="checkbox" name="wdrc[compatible_woocommerce_composite_product]" id="compatible_woocommerce_composite_product" value="1" <?php if ($data['compatible_woocommerce_composite_product'] == 1) { ?> checked <?php } ?>>
                                        <?php esc_html_e('Add compatible for WooCommerce Composite Products', 'woo-discount-rules-compatible'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <?php if(!$has_compatibility_plugin){ ?>
                            <div class="">
                                <?php esc_html_e('There is no plugin found which makes conflict with Discount Rules for WooCommerce', 'woo-discount-rules-compatible'); ?>
                            </div>
                        <?php } else {
                            ?>
                            <div class="col-md-12">
                                <br/>
                                <input type="hidden" name="wdrc[save]" value="1"/>
                                <input type="submit" id="save_compatibility_config" value="<?php esc_html_e('Save', 'woo-discount-rules-compatible'); ?>" class="button save_compatibility_config button-primary"/>
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="woo_discount_loader">
        <div class="lds-ripple"><div></div><div></div></div>
    </div>
</div>