<?php
/*
Plugin Name: OrderStorm e-Commerce
Plugin URI: http://www.orderstorm.com/wordpress-ecommerce
Description: OrderStorm e-Commerce offers creative product display, automated drop shipping, robust order management and PCI compliance. To get started 1) <a href="http://www.orderstorm.com/ecommerce-wordpress-plugin-pricing/">Sign up for an OrderStorm API key</a>, and 2) Go to the plugin <a href="admin.php?page=orderstorm_ecommerce_settings_menu">Main</a> page, and save your API key.
Version: 1.0
Author: OrderStorm, Inc.
Author URI: http://www.orderstorm.com
License: GPL2 or later
Text Domain: orderstorm-wordpress-e-commerce
*/

/*
	Copyright (C) 2010-2015 OrderStorm, Inc. (e-mail: wordpress-ecommerce@orderstorm.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
require_once('CLASS_OrderStormECommerceForWordPress.php');
require_once('CLASS_OrderStormECommerceCategoriesMenu.php');
require_once('CLASS_OrderStormECommerceShoppingCartStatusWidget.php');

$orderstorm_wordpress_e_commerce_configuration = array();

$custom_localization_files = OrderStormECommerceForWordPress::plugin_custom_configuration_path() . DIRECTORY_SEPARATOR;
$default_localization_files = OrderStormECommerceForWordPress::plugin_full_path() . DIRECTORY_SEPARATOR;
$orderstorm_wordpress_e_commerce_configuration['localization_files'] = $default_localization_files;
if (file_exists($custom_localization_files))
{
	$orderstorm_wordpress_e_commerce_configuration['localization_files'] = $custom_localization_files;
}

$plugin_custom_configuration_url_path = OrderStormECommerceForWordPress::plugin_custom_configuration_url_path();

$custom_localization_script = OrderStormECommerceForWordPress::plugin_custom_configuration_path() . DIRECTORY_SEPARATOR . 'OrderStormEcommerceLocalization.php';
$default_localization_script = OrderStormECommerceForWordPress::plugin_full_path() . DIRECTORY_SEPARATOR . 'OrderStormEcommerceLocalization.php';
if (file_exists($custom_localization_script))
{
	require_once($custom_localization_script);
}
elseif (file_exists($default_localization_script))
{
	require_once($default_localization_script);
}

$custom_ssk_css_file = OrderStormECommerceForWordPress::plugin_custom_configuration_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormSSK.css';
$default_ssk_css_file = OrderStormECommerceForWordPress::plugin_full_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormSSK.css';
if (file_exists($custom_ssk_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['ssk_style_sheet_url'] = $plugin_custom_configuration_url_path . '/' . 'css' . '/' . 'OrderStormSSK.css';
}
elseif (file_exists($default_ssk_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['ssk_style_sheet_url'] = plugin_dir_url(__FILE__) . 'css' . '/' . 'OrderStormSSK.css';
}

$custom_categories_menu_widget_css_file = OrderStormECommerceForWordPress::plugin_custom_configuration_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormCategoriesMenuWidget.css';
$default_categories_menu_widget_css_file = OrderStormECommerceForWordPress::plugin_full_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormCategoriesMenuWidget.css';
if (file_exists($custom_categories_menu_widget_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['categories_menu_widget_style_sheet_url'] = $plugin_custom_configuration_url_path . '/' . 'css' . '/' . 'OrderStormCategoriesMenuWidget.css';
}
elseif (file_exists($default_categories_menu_widget_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['categories_menu_widget_style_sheet_url'] = plugin_dir_url(__FILE__) . 'css' . '/' . 'OrderStormCategoriesMenuWidget.css';
}

$custom_product_categories_css_file = OrderStormECommerceForWordPress::plugin_custom_configuration_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormProductCategories.css';
$default_product_categories_css_file = OrderStormECommerceForWordPress::plugin_full_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormProductCategories.css';
if (file_exists($custom_product_categories_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['product_categories_style_sheet_url'] = $plugin_custom_configuration_url_path . '/' . 'css' . '/' . 'OrderStormProductCategories.css';
}
elseif (file_exists($default_product_categories_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['product_categories_style_sheet_url'] = plugin_dir_url(__FILE__) . 'css' . '/' . 'OrderStormProductCategories.css';
}

$custom_products_css_file = OrderStormECommerceForWordPress::plugin_custom_configuration_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormProducts.css';
$default_products_css_file = OrderStormECommerceForWordPress::plugin_full_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormProducts.css';
if (file_exists($custom_products_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['products_style_sheet_url'] = $plugin_custom_configuration_url_path . '/' . 'css' . '/' . 'OrderStormProducts.css';
}
elseif (file_exists($default_products_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['products_style_sheet_url'] = plugin_dir_url(__FILE__) . 'css' . '/' . 'OrderStormProducts.css';
}

$custom_product_details_css_file = OrderStormECommerceForWordPress::plugin_custom_configuration_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormProductDetails.css';
$default_product_details_css_file = OrderStormECommerceForWordPress::plugin_full_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormProductDetails.css';
if (file_exists($custom_product_details_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['product_details_style_sheet_url'] = $plugin_custom_configuration_url_path . '/' . 'css' . '/' . 'OrderStormProductDetails.css';
}
elseif (file_exists($default_product_details_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['product_details_style_sheet_url'] = plugin_dir_url(__FILE__) . 'css' . '/' . 'OrderStormProductDetails.css';
}

$custom_category_page_template_file = OrderStormECommerceForWordPress::plugin_custom_configuration_path() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'category_page.php';
$default_category_page_template_file = OrderStormECommerceForWordPress::plugin_full_path() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'category_page.php';

$custom_product_details_template_file = OrderStormECommerceForWordPress::plugin_custom_configuration_path() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'render_product_details.php';
$default_product_details_template_file = OrderStormECommerceForWordPress::plugin_full_path() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'render_product_details.php';

$custom_shopping_cart_status_tag_css_file = OrderStormECommerceForWordPress::plugin_custom_configuration_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormShoppingCartStatusTag.css';
$default_shopping_cart_status_tag_css_file = OrderStormECommerceForWordPress::plugin_full_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormShoppingCartStatusTag.css';
if (file_exists($custom_shopping_cart_status_tag_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['shopping_cart_status_tag_style_sheet_url'] = $plugin_custom_configuration_url_path . '/' . 'css' . '/' . 'OrderStormShoppingCartStatusTag.css';
}
elseif (file_exists($default_shopping_cart_status_tag_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['shopping_cart_status_tag_style_sheet_url'] = plugin_dir_url(__FILE__) . 'css' . '/' . 'OrderStormShoppingCartStatusTag.css';
}

$custom_shopping_cart_status_widget_css_file = OrderStormECommerceForWordPress::plugin_custom_configuration_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormShoppingCartStatusWidget.css';
$default_shopping_cart_status_widget_css_file = OrderStormECommerceForWordPress::plugin_full_path() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'OrderStormShoppingCartStatusWidget.css';
if (file_exists($custom_shopping_cart_status_widget_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['shopping_cart_status_widget_style_sheet_url'] = $plugin_custom_configuration_url_path . '/' . 'css' . '/' . 'OrderStormShoppingCartStatusWidget.css';
}
elseif (file_exists($default_shopping_cart_status_widget_css_file))
{
	$orderstorm_wordpress_e_commerce_configuration['shopping_cart_status_widget_style_sheet_url'] = plugin_dir_url(__FILE__) . 'css' . '/' . 'OrderStormShoppingCartStatusWidget.css';
}

$orderstorm_wordpress_e_commerce_configuration['fancybox_style_sheet_url'] = plugin_dir_url(__FILE__) . 'js/fancybox/jquery.fancybox-1.3.4.css';

$orderstorm_wordpress_e_commerce_configuration['first_page_title_has_been_queried'] = FALSE;

$GLOBALS['osws'] = new OrderStormECommerceForWordPress($configuration_options = $orderstorm_wordpress_e_commerce_configuration);

function orderstorm_ecommerce() {
	$num_args = func_num_args();
	$args = func_get_args();
	return $GLOBALS['osws']->api('api', $num_args, $args);
}

add_action('init', 'orderstorm_wordpress_e_commerce_init');
add_action('admin_enqueue_scripts', 'orderstorm_wordpress_e_commerce_admin_enqueue_scripts');
add_action('wp_enqueue_scripts', 'orderstorm_wordpress_e_commerce_wp_enqueue_scripts');

add_action('sm_buildmap', 'add_orderstorm_pages_to_google_xml_sitemaps');
add_filter('rewrite_rules_array','orderstorm_ecommerce_insert_rewrite_rules');
add_filter('query_vars','orderstorm_ecommerce_insert_rewrite_query_vars');
add_action('widgets_init', 'orderstorm_ecommerce_load_widgets');
if (is_admin())
{
	register_activation_hook(__FILE__, 'activate_orderstorm_ecommerce_plugin');
	register_deactivation_hook(__FILE__, 'deactivate_orderstorm_ecommerce_plugin');
	add_action('admin_menu', 'create_orderstorm_ecommerce_option_menu');
	add_action('wp_ajax_api_key_signup', 'orderstorm_ecommerce_api_key_signup' );
	add_action('wp_ajax_nopriv_add_to_cart', 'orderstorm_ecommerce_add_to_cart' );
	add_action('wp_ajax_add_to_cart', 'orderstorm_ecommerce_add_to_cart' );
	add_action('wp_ajax_nopriv_submit_product_question', 'orderstorm_ecommerce_submit_product_question');
	add_action('wp_ajax_submit_product_question', 'orderstorm_ecommerce_submit_product_question' );
	add_action('wp_ajax_nopriv_pp_return_url', 'orderstorm_ecommerce_pp_return_url' );
	add_action('wp_ajax_pp_return_url', 'orderstorm_ecommerce_add_to_cart' );
	add_action('wp_ajax_nopriv_pp_cancel_url', 'orderstorm_ecommerce_pp_cancel_url' );
	add_action('wp_ajax_pp_cancel_url', 'orderstorm_ecommerce_pp_cancel_url' );
}
else
{
	add_filter('wp_title', 'orderstorm_ecommerce_wp_title', 10, 3);

	remove_action("wp_head", "rel_canonical");
	add_filter("aioseop_canonical_url", "orderstorm_ecommerce_rel_canonical_filter");
	add_filter("aioseop_description_override", "orderstorm_ecommerce_meta_description_filter");
	add_filter("aioseop_keywords", "orderstorm_ecommerce_meta_keywords_filter");
	add_action("wp_head", "orderstorm_ecommerce_wp_head_action");

	add_filter("the_title", "orderstorm_ecommerce_the_title", 10, 2);
	add_filter('parse_request', 'orderstorm_ecommerce_parse_request_filter');
	add_filter('pre_get_posts', 'orderstorm_ecommerce_pre_get_posts_filter_for_search');
	add_filter('post_limits', 'orderstorm_ecommerce_post_limits_filter_for_search');
	add_filter('the_posts', 'orderstorm_ecommerce_the_posts_filter_for_search');
	add_filter('the_permalink', 'orderstorm_ecommerce_the_permalink_filter_for_search');
	add_filter('excerpt_more', 'orderstorm_ecommerce_excerpt_more_filter_for_search', 11);
}

function orderstorm_ecommerce_wp_title($old_title, $separator, $separator_location)
{
	if (!is_singular())
	{
		return $old_title;
	}

	$is_category_page = false;
	$is_product_page = false;

	global $wp_the_query;
	if (!$id = $wp_the_query->get_queried_object_id())
	{
		return $old_title;
	}

	if ($id === $GLOBALS["osws"]->get_product_category_page_id())
	{
		$is_category_page = true;
		if(!$GLOBALS["osws"]->has_wp_title_already_been_processed())
		{
			$GLOBALS["osws"]->prepare_category_information();
		}
	}
	elseif ($id === $GLOBALS["osws"]->get_product_page_id())
	{
		$is_product_page = true;
		if(!$GLOBALS["osws"]->has_wp_title_already_been_processed())
		{
			$GLOBALS["osws"]->prepare_product_information();
		}
	}

	$GLOBALS["osws"]->set_wp_title_as_already_processed();

	if ($is_category_page || $is_product_page)
	{
		$title = $GLOBALS["osws"]->get_title_tag();
		$test = trim($title);
		if (empty($test))
		{
			$title = wp_strip_all_tags((($is_category_page)?$GLOBALS["osws"]->get_category_description():$GLOBALS["osws"]->get_product_name()));
		}
	}
	else
	{
		return $old_title;
	}

	$title = trim($title);
	if (!empty($title))
	{
		$padded_separator = " " . $separator . " ";
		if ($separator_location === "right")
		{
			$title .= $padded_separator;
		}
		else
		{
			$title = $padded_separator . $title;
		}
	}

	return $title;
}

function orderstorm_ecommerce_rel_canonical_filter($url)
{
	$GLOBALS["osws"]->set_rel_canonical_filter_as_processed();

	$page_type = 0;

	if (!is_singular())
	{
		return $url;
	}

	global $wp_the_query;
	if (!$id = $wp_the_query->get_queried_object_id())
	{
		return $url;
	}

	if ($id === $GLOBALS["osws"]->get_product_category_page_id())
	{
		$page_type = 1;
	}
	elseif ($id === $GLOBALS["osws"]->get_product_page_id())
	{
		$page_type = 2;
	}
	if ($page_type === 1 || $page_type === 2)
	{
		global $wp_query;

		$category_link = "";
		$product_link = "";
		$link_override = null;
		if ($page_type === 1)
		{
			if ($GLOBALS["osws"]->is_category_data_loaded())
			{
				$link_override = $GLOBALS["osws"]->get_category_link_override();
				if(is_null($link_override))
				{
					$category_link = $wp_query->query_vars["cat_link"];
					if (OrderStormECommerceForWordPress::isWellFormedGUID($category_link) || OrderStormECommerceForWordPress::isGUIDwithoutBraces($category_link))
					{
						$category_guid = $category_link;
						if (OrderStormECommerceForWordPress::isGUIDwithoutBraces($category_guid))
						{
							$category_guid = "{" . $category_guid . "}";
						}

						$category_info = $GLOBALS["osws"]->get_category_by_category_guid($category_guid);
						if ($category_info->rowCount() > 0)
						{
							$category_link = $category_info->fieldValue(0, 'pg_link');
						}
					}
				}
			}
		}
		if ($page_type === 2)
		{
			if ($GLOBALS["osws"]->is_product_data_loaded())
			{
				$link_override = $GLOBALS["osws"]->get_product_link_override();
				if(is_null($link_override))
				{
					$product_link = $wp_query->query_vars["product_link"];
					if (OrderStormECommerceForWordPress::isWellFormedGUID($product_link) || OrderStormECommerceForWordPress::isGUIDwithoutBraces($product_link))
					{
						$product_guid = $product_link;
						if (OrderStormECommerceForWordPress::isGUIDwithoutBraces($product_guid))
						{
							$product_guid = "{" . $product_guid . "}";
						}

						$product_info = $GLOBALS["osws"]->get_product_by_product_guid($product_guid);
						if ($product_info->rowCount() > 0)
						{
							$product_link = $product_info->fieldValue(0, 'pg_link');
						}
					}
				}
			}
		}
		return (($page_type === 1)?$GLOBALS["osws"]->build_product_category_page_link($category_link, $link_override):$GLOBALS["osws"]->build_product_page_link($product_link, $link_override));
	}
	else
	{
		return $url;
	}
}

function orderstorm_ecommerce_meta_description_filter($description)
{
	$GLOBALS["osws"]->set_meta_description_filter_as_processed();

	$page_type = 0;

	if (!is_singular())
	{
		return $description;
	}

	global $wp_the_query;
	if (!$id = $wp_the_query->get_queried_object_id())
	{
		return $description;
	}

	if ($id === $GLOBALS["osws"]->get_product_category_page_id())
	{
		$page_type = 1;
	}
	elseif ($id === $GLOBALS["osws"]->get_product_page_id())
	{
		$page_type = 2;
	}
	if ($page_type === 1 || $page_type === 2)
	{
		return trim($GLOBALS["osws"]->get_meta_description());
	}
	else
	{
		return $description;
	}
}

function orderstorm_ecommerce_meta_keywords_filter($keywords)
{
	$GLOBALS["osws"]->set_meta_keys_filter_as_processed();

	$page_type = 0;

	if (!is_singular())
	{
		return $keywords;
	}

	global $wp_the_query;
	if (!$id = $wp_the_query->get_queried_object_id())
	{
		return $keywords;
	}

	if ($id === $GLOBALS["osws"]->get_product_category_page_id())
	{
		$page_type = 1;
	}
	elseif ($id === $GLOBALS["osws"]->get_product_page_id())
	{
		$page_type = 2;
	}
	if ($page_type === 1 || $page_type === 2)
	{
		return trim($GLOBALS["osws"]->get_meta_keywords());
	}
	else
	{
		return $keywords;
	}
}

function orderstorm_ecommerce_wp_head_action()
{
	if (!$GLOBALS["osws"]->get_rel_canonical_filter_processed())
	{
		$url = null;

		$url = orderstorm_ecommerce_rel_canonical_filter($url);
		if (!is_null($url))
		{
			echo("<link rel=\"canonical\" href=\"" . $url . "\" />\n");
		}
		else
		{
			if (function_exists("rel_canonical"))
			{
				rel_canonical();
			}
		}
	}

	if (!$GLOBALS["osws"]->get_meta_description_filter_processed())
	{
		$description = null;

		$description = orderstorm_ecommerce_meta_description_filter($description);
		if (!is_null($description) && gettype($description) === "string" && strlen(trim($description)) > 0)
		{
			echo("<meta name=\"description\" content=\"" . $description . "\" />");
		}
	}

	if (!$GLOBALS["osws"]->get_meta_keys_filter_processed())
	{
		$keywords = null;

		$keywords = orderstorm_ecommerce_meta_keywords_filter($keywords);
		if (!is_null($keywords) && gettype($keywords) === "string" && strlen(trim($keywords)) > 0 )
		{
			echo("<meta name=\"keywords\" content=\"" . $keywords . "\" />");
		}
	}
}

function orderstorm_ecommerce_the_title($title, $id = null)
{
	$page_type = 0;

	if (in_the_loop() && !$GLOBALS["osws"]->get_option("first_page_title_has_been_queried"))
	{
		if ($id === $GLOBALS["osws"]->get_product_category_page_id() && $GLOBALS["osws"]->should_product_category_name_be_used_as_product_category_page_title())
		{
			$page_type = 1;
		}
		elseif ($id === $GLOBALS["osws"]->get_product_page_id() && $GLOBALS["osws"]->should_product_name_be_used_as_product_page_title())
		{
			$page_type = 2;
		}
	}
	if ($page_type === 1 || $page_type === 2)
	{
		$GLOBALS["osws"]->set_first_page_title_has_been_queried();
		$title = wp_strip_all_tags((($page_type === 1)?$GLOBALS["osws"]->get_category_description():$GLOBALS["osws"]->get_product_name()));
		if ($page_type === 2 && $GLOBALS["osws"]->should_product_name_be_editable_in_title())
		{
			$title = "<p class=\"product_name no_pre_spacer\" title=\"" . str_replace("\"", "&quot;", $title) . "\"><span id=\"product_name\" class=\"ITE ITEhover\">" . $title . "</span></p>";
		}
	}

	return $title;
}

function orderstorm_ecommerce_parse_request_filter(&$wp)
{
	if (in_array($wp->request, array(
			'orderstorm-pp-return-url',
			'orderstorm-pp-cancel-url'
		), $strict=true))
	{
		switch($wp->request)
		{
			case 'orderstorm-pp-return-url':
				if (isset($wp->query_vars['pp_return_url'])
					&& $wp->query_vars['pp_return_url'] === 'true'
					&& isset($wp->query_vars['token'])
					&& isset($wp->query_vars['PayerID']))
				{
					$token = $wp->query_vars['token'];
					$payerID = $wp->query_vars['PayerID'];
					$result = $GLOBALS['osws']->get_pp_express_checkout_transaction_details($token, $payerID);
					if ($result->rowCount() === 1)
					{
						$errorMessage = $result->fieldValue(0, 'errorMessage');
						if ($result->fieldValue(0, 'success') && $payerID === $result->fieldValue(0, 'payerID'))
						{
							$_SESSION['showCheckout'] = true;
							wp_redirect($result->fieldValue(0, 'sourceURL'));
							exit();
						}
						else
						{
							wp_redirect(home_url());
							exit();
						}
					}
					else
					{
						wp_redirect(home_url());
						exit();
					}
				}
				break;
			case 'orderstorm-pp-cancel-url':
				if (isset($wp->query_vars['pp_cancel_url'])
					&& $wp->query_vars['pp_cancel_url'] === 'true'
					&& isset($wp->query_vars['token']))
				{
					$result = $GLOBALS['osws']->cancel_pp_express_checkout_transaction($wp->query_vars['token']);
					if ($result->rowCount() === 1)
					{
						wp_redirect($result->fieldValue(0, 'source_url'));
						exit();
					}
					else
					{
						wp_redirect(home_url());
						exit();
					}
				}
				break;
		}
	}
}

function orderstorm_wordpress_e_commerce_init()
{
	load_plugin_textdomain( 'orderstorm-wordpress-e-commerce', false, $GLOBALS['osws']->get_option('localization_files'));
}

function orderstorm_wordpress_e_commerce_admin_enqueue_scripts()
{
	orderstorm_ecommerce_flush_rewrite_rules();
	wp_enqueue_script('jquery_topzindex', plugin_dir_url(__FILE__) . 'js/jquery.topzindex.min.js', array('jquery'), '1.2', false);
	wp_enqueue_script('JavaScript_Compatibility', plugin_dir_url(__FILE__) . 'js/JavaScript_Compatibility.js', array(), false, false);
	wp_enqueue_script('JsonResultSet', plugin_dir_url(__FILE__) . 'js/CLASS_JsonResultSet.js', array('JavaScript_Compatibility', 'jquery'), false, false);
	wp_enqueue_script('OrderStormWebServiceUtilities', plugin_dir_url(__FILE__) . 'js/OrderStormWebServiceUtilities.js', array('jquery'), false, false);
	wp_enqueue_script('ostrm_ecommerce_admin', plugin_dir_url(__FILE__) . 'js/ostrm_ecommerce_admin.js', array('JavaScript_Compatibility', 'JsonResultSet', 'jquery'), '1.0', false);
	$ajaxGlobals = array
	(
		'action' => 'api_key_signup',
		'ajaxURL' => admin_url('admin-ajax.php'),
		'ostrmAdminNonce' => wp_create_nonce('orderstorm_admin_nonce')
	);
	wp_localize_script
	(
		'ostrm_ecommerce_admin',
		'ajaxGlobals',
		$ajaxGlobals
	);
}

function orderstorm_wordpress_e_commerce_wp_enqueue_scripts()
{
	global $wp;

	orderstorm_ecommerce_flush_rewrite_rules();
	if (orderstorm_ecommerce('product', 'has_media_settings') && orderstorm_ecommerce('product', 'present_ad_gallery')) {
		wp_enqueue_script('jquery-ui-position');
		wp_enqueue_script('jquery-ui-sortable');
		wp_register_style('jquery_context_menu_style_sheet', plugin_dir_url(__FILE__) . 'js/jquery-context-menu/jquery.contextMenu.css', array(), '1.2.7', 'all');
		wp_enqueue_style('jquery_context_menu_style_sheet');
		wp_enqueue_script('jquery_context_menu', plugin_dir_url(__FILE__) . 'js/jquery-context-menu/jquery.contextMenu.js', array('jquery-ui-position'), '1.2.7', false);
		wp_register_style('jquery_ad_gallery_style_sheet', plugin_dir_url(__FILE__) . 'js/ad-gallery/jquery.ad-gallery.css', array(), '1.2.7', 'all');
		wp_enqueue_style('jquery_ad_gallery_style_sheet');
		wp_enqueue_script('jquery_ad_gallery', plugin_dir_url(__FILE__) . 'js/ad-gallery/jquery.ad-gallery.min.js', array('jquery'), '1.2.7', false);
		wp_enqueue_script('jquery_touch_swipe', plugin_dir_url(__FILE__) . 'js/jquery.touchSwipe.min.js', array('jquery'), '1.6.5', false);
	}
	wp_enqueue_script('htmlentity', plugin_dir_url(__FILE__) . 'js/htmlentity.js', array(), false, false);
	wp_enqueue_script('ostrm_mousewheel', plugin_dir_url(__FILE__) . 'js/fancybox/jquery.mousewheel-3.0.4.pack.js', array('jquery'), '3.0.4', false);
	wp_enqueue_script('ostrm_fancy_box', plugin_dir_url(__FILE__) . 'js/fancybox/jquery.fancybox-1.3.4.pack.js', array('jquery'), '1.3.4', false);
	wp_enqueue_script('jquery_topzindex', plugin_dir_url(__FILE__) . 'js/jquery.topzindex.min.js', array('jquery'), '1.2', false);
	wp_enqueue_script('jquery_inlinetextedit', plugin_dir_url(__FILE__) . 'js/jquery.inlineTextEdit.js', array('jquery'), false, false);
	wp_enqueue_script('jquery_inlinetextarea', plugin_dir_url(__FILE__) . 'js/jquery.inlineTextArea.js', array('jquery'), false, false);
	wp_enqueue_script('JavaScript_Compatibility', plugin_dir_url(__FILE__) . 'js/JavaScript_Compatibility.js', array(), false, false);
	wp_enqueue_script('JsonResultSet', plugin_dir_url(__FILE__) . 'js/CLASS_JsonResultSet.js', array('JavaScript_Compatibility', 'jquery'), false, false);
	wp_enqueue_script('OrderStormWebServiceUtilities', plugin_dir_url(__FILE__) . 'js/OrderStormWebServiceUtilities.js', array('jquery'), false, false);
	wp_enqueue_script('OrderStormSSK', plugin_dir_url(__FILE__) . 'js/CLASS_OrderStormSSK.js', array('jquery', 'jquery_topzindex'), false, false);
	wp_enqueue_script('ostrm_ecommerce_general', plugin_dir_url(__FILE__) . 'js/ostrm_ecommerce_general.js', array('JavaScript_Compatibility', 'JsonResultSet', 'jquery', 'ostrm_mousewheel', 'ostrm_fancy_box'), '1.0', false);
	$ssk_style_sheet_url = $GLOBALS['osws']->get_option('ssk_style_sheet_url');
	if (!empty($ssk_style_sheet_url))
	{
		wp_register_style("orderstorm_ecommerce_ssk_style_sheet", $ssk_style_sheet_url, array(), "1.0", "all");
		wp_enqueue_style("orderstorm_ecommerce_ssk_style_sheet");
	}
	orderstorm_ecommerce_load_categories_menu_widget_style_sheet();
	$shopping_cart_status_tag_style_sheet_url = $GLOBALS['osws']->get_option('shopping_cart_status_tag_style_sheet_url');
	if (!empty($shopping_cart_status_tag_style_sheet_url))
	{
		wp_register_style("orderstorm_ecommerce_shopping_cart_status_tag_style_sheet", $shopping_cart_status_tag_style_sheet_url, array(), "1.0", "all");
		wp_enqueue_style("orderstorm_ecommerce_shopping_cart_status_tag_style_sheet");
	}
	orderstorm_ecommerce_load_shopping_cart_status_widget_style_sheet();
	$fancybox_style_sheet_url = $GLOBALS['osws']->get_option('fancybox_style_sheet_url');
	if (!empty($fancybox_style_sheet_url))
	{
		wp_register_style("orderstorm_ecommerce_fancybox_style_sheet", $fancybox_style_sheet_url, array(), "1.3.4", "all");
		wp_enqueue_style("orderstorm_ecommerce_fancybox_style_sheet");
	}
	$order_key_guid = null;
	if (isset($wp->query_vars['os1bilco2015']))
	{
		$order_key_guid = $wp->query_vars['os1bilco2015'];
		if (!OrderStormECommerceForWordPress::isWellFormedGUID($order_key_guid))
		{
			$order_key_guid = null;
		}
		else
		{
			$_SESSION['order_key_guid'] = $order_key_guid;
		}
	}
	if (is_null($order_key_guid))
	{
		$order_key_guid = isset($_SESSION['order_key_guid'])?$_SESSION['order_key_guid']:null;
	}
	$cartGlobals = array();
	$cartGlobals['hostName'] = $GLOBALS['osws']->get_orderstorm_ecommerce_host_name();
	$cartGlobals['orderKeyGUID'] = $order_key_guid;
	$cartGlobals['checkoutURL'] = $GLOBALS['osws']->checkout_url();
	$cartGlobals['addImagesURL'] = $GLOBALS['osws']->add_images_url();
	$cartGlobals['ckp'] = orderstorm_ecommerce('meta_data', 'ckp', true);
	$cartGlobals['cdtk'] = orderstorm_ecommerce('category', 'display_type_key');
	$cartGlobals['pdtk'] = orderstorm_ecommerce('product', 'display_type_key');
	if (isset($_SESSION['showCheckout']))
	{
		if ($_SESSION['showCheckout'] === true)
		{
			$cartGlobals['showCheckout'] = 'true';
		}
		unset($_SESSION['showCheckout']);
	}
	if (orderstorm_ecommerce('product', 'has_media_settings') && orderstorm_ecommerce('product', 'present_ad_gallery')) {
		$cartGlobals['adGalleryStartAtIndex'] = $GLOBALS['osws']->get_product_media_gallery_start_at_index();
		$cartGlobals['adGalleryLoaderImage'] = plugin_dir_url(__FILE__) . 'js/ad-gallery/loader.gif';
		$cartGlobals['productThumbnailsWidth'] = orderstorm_ecommerce('product', 'media', 'thumbnail_width');
		$cartGlobals['productPreviewWidth'] = orderstorm_ecommerce('product', 'media', 'preview_width');
		$cartGlobals['productZoomWidth'] = orderstorm_ecommerce('product', 'media', 'zoom_width');
	}
	wp_localize_script
	(
		'ostrm_ecommerce_general',
		'cartGlobals',
		$cartGlobals
	);

	$product_category_page_id = $GLOBALS['osws']->get_page_id_by_slug($GLOBALS['osws']->get_product_category_page_slug());
	$product_page_id = $GLOBALS['osws']->get_page_id_by_slug($GLOBALS['osws']->get_product_page_slug());
	add_shortcode('orderstorm_ecommerce_display_product_category_page', 'orderstorm_ecommerce_display_product_category_page');
	orderstorm_ecommerce_load_product_categories_style_sheet();
	orderstorm_ecommerce_load_products_style_sheet();
	orderstorm_ecommerce_load_product_details_style_sheet();
	wp_enqueue_script('ostrm_product_question_form', plugin_dir_url(__FILE__) . 'js/ostrm_product_question_form.js', array('jquery'), '1.0', false);
	wp_enqueue_script('ostrm_color_picker', plugin_dir_url(__FILE__) . 'js/jquery.colorpicker.js', array('jquery'), '0.1.0', false);
	add_shortcode("orderstorm_ecommerce_display_product_page", "orderstorm_ecommerce_display_product_page");
	add_shortcode("orderstorm_ecommerce_shopping_cart_status", "orderstorm_ecommerce_shopping_cart_status_shortcode");
 	add_shortcode("orderstorm_select_product", "orderstorm_select_product_shortcode");
 	add_shortcode("orderstorm_product_name", "orderstorm_product_name_shortcode");
 	add_shortcode("orderstorm_product_item_number", "orderstorm_product_item_number_shortcode");
 	add_shortcode("orderstorm_product_short_description", "orderstorm_product_short_description_shortcode");
 	add_shortcode("orderstorm_product_long_description", "orderstorm_product_long_description_shortcode");
 	add_shortcode("orderstorm_product_small_image", "orderstorm_product_small_image_shortcode");
 	add_shortcode("orderstorm_product_medium_image", "orderstorm_product_medium_image_shortcode");
 	add_shortcode("orderstorm_product_large_image", "orderstorm_product_large_image_shortcode");
 	add_shortcode("orderstorm_product_not_for_sale_or_deleted", "orderstorm_product_not_for_sale_or_deleted_shortcode");
 	add_shortcode("orderstorm_url_for_product_page", "orderstorm_url_for_product_page_shortcode");
 	add_shortcode("orderstorm_product_retail_price", "orderstorm_product_retail_price_shortcode");
 	add_shortcode("orderstorm_product_your_cost", "orderstorm_product_your_cost_shortcode");
}

function orderstorm_ecommerce_pre_get_posts_filter_for_search($wp_query)
{
	return $GLOBALS['osws']->wp_filter_pre_get_posts_for_search($wp_query);
}

function orderstorm_ecommerce_post_limits_filter_for_search($limits)
{
	return $GLOBALS['osws']->wp_filter_post_limits_for_search($limits);
}

function orderstorm_ecommerce_the_posts_filter_for_search($posts)
{
	return $GLOBALS['osws']->wp_filter_the_posts_for_search($posts);
}

function orderstorm_ecommerce_the_permalink_filter_for_search($permalink)
{
	return $GLOBALS['osws']->wp_filter_the_permalink_for_search($permalink);
}

function orderstorm_ecommerce_excerpt_more_filter_for_search($more)
{
	return $GLOBALS['osws']->wp_filter_excerpt_more_for_search($more);
}

function add_orderstorm_pages_to_google_xml_sitemaps()
{
	$generatorObject = &GoogleSitemapGenerator::GetInstance();
	if (!is_null($generatorObject))
	{
		$siteMap = $GLOBALS['osws']->get_site_map();
		$rowCount = $siteMap->rowCount();
		if ($rowCount > 0)
		{
			for ($row = 0; $row < $rowCount; $row++)
			{
				$page_link = $siteMap->fieldValue($row, 'page_link');
				$link_override = $siteMap->fieldValue($row, "link_override");
				$last_modification_timestamp = $siteMap->fieldValue($row, 'last_modification_timestamp');
				$priority = $siteMap->fieldValue($row, 'priority');
				$change_frequency = $siteMap->fieldValue($row, 'change_frequency');
				$type = $siteMap->fieldValue($row, 'type');
				$url = $page_link;
				switch ($type)
				{
					case 'C':
						$url = $GLOBALS['osws']->build_product_category_page_link($url, $link_override);
						break;
					case 'P':
						$url = $GLOBALS['osws']->build_product_page_link($url, $link_override);
						break;
				}
				$generatorObject->AddUrl($url, $last_modification_timestamp, $change_frequency, $priority);
			}
		}
	}
}

function orderstorm_ecommerce_api_key_signup()
{
	require_once('CLASS_jsonResultSet.php');
	require_once('CLASS_OrderStormECommerceForWordPress.php');

	$json_obj = new Moxiecode_JSON();
	$ecommerce_host_name = 'https://' . get_option('orderstorm_ecommerce_host_name', '') . '/orderstorm_ecommerce.os';
	$ws_key_guid = get_option('orderstorm_ecommerce_key_guid', '');

	$data = "";
	$fieldNames = array();
	$response = array();
	$response['blnSignupSuccessful'] = FALSE;
	$response['blnValidNonce'] = FALSE;
	$response['api_key'] = null;
	$response['messages'] = array();

	$nonce = '';
	if (isset($_POST['ostrmAdminNonce']))
	{
		$nonce = $_POST['ostrmAdminNonce'];
	}

	if (wp_verify_nonce($nonce, 'orderstorm_admin_nonce'))
	{
		$response['blnValidNonce'] = TRUE;
	}

	if ($response['blnValidNonce'] === TRUE)
	{
		$ajax_request = '';
		$ajax_request = $ajax_request . '{';
		$ajax_request = $ajax_request . '"key_GUID":"' . $ws_key_guid . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"session_id":"' . session_id() . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"service":"API_Key_signup"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"arguments":{';
		$ajax_request = $ajax_request . '"first_name":"' . $_POST['orderstorm_ecommerce_api_key_signup_first_name'] . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"last_name":"' . $_POST['orderstorm_ecommerce_api_key_signup_last_name'] . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"domain_name":"' . $_POST['orderstorm_ecommerce_api_key_signup_domain_name'] . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"domain_tld":"' . $_POST['orderstorm_ecommerce_api_key_signup_domain_tld'] . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"email":"' . $_POST['orderstorm_ecommerce_api_key_signup_email_address'] . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"password":"' . $_POST['orderstorm_ecommerce_api_key_signup_password'] . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"confirm_password":"' . $_POST['orderstorm_ecommerce_api_key_signup_confirm_password'] . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"ip":"' . $_SERVER['REMOTE_ADDR'] . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"url":"' . $_SERVER['HTTP_REFERER'] . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"source":"WP dashboard"';
		$ajax_request = $ajax_request . '}';
		$ajax_request = $ajax_request . '}';

		$data =	OrderStormECommerceForWordPress::curl_fetch_ajax
				(
					$ecommerce_host_name,
					array('AJAX_Request' => $ajax_request),
					TRUE,
					TRUE
				);

		$result =	new jsonResultSet
					(
						$json_obj->decode($data)
					);
		$fieldNames = $result->getFieldNames();

		$there_are_messages = true;
		$rowCount = $result->rowCount();

		if (array_key_exists("sort", $fieldNames) && array_key_exists("name", $fieldNames) && array_key_exists("value", $fieldNames))
		{
			for ($count = 0; $count < $rowCount; $count++)
			{
				if ($result->fieldValue($count, "name") === "api_key")
				{
					$response['blnSignupSuccessful'] = TRUE;
					$response['api_key'] = $result->fieldValue($count, "value");
				}
			}
		}
		else
		{
			$there_are_messages = false;
		}

		if ($response['blnSignupSuccessful'] === true)
		{
			if ($rowCount <= 1)
			{
				$there_are_messages = false;
			}
		}
		else
		{
			if ($rowCount < 1)
			{
				$there_are_messages = false;
			}
		}

		if ($there_are_messages === true)
		{
			$messageCount = 0;
			for ($count = 0; $count < $rowCount; $count ++)
			{
				if ($result->fieldValue($count, "name") !== "api_key")
				{
					$messageCount++;
					array_push($response['messages'], array($messageCount, $result->fieldValue($messageCount, "name"), $result->fieldValue($count, "value")));
				}
			}
		}
	}

	header('Content-type: application/json');
	echo($json_obj->encode($response));
	die();
}

function orderstorm_ecommerce_add_to_cart()
{
	require_once('CLASS_jsonResultSet.php');
	require_once('CLASS_OrderStormECommerceForWordPress.php');

	$json_obj = new Moxiecode_JSON();
	$ecommerce_host_name = 'https://' . get_option('orderstorm_ecommerce_host_name', '') . '/orderstorm_ecommerce.os';
	$ws_key_guid = get_option('orderstorm_ecommerce_key_guid', '');

	$response = array();
	$response['blnAddSuccessful'] = FALSE;
	$order_key_guid = null;
	$response['blnValidNonce'] = FALSE;

	$nonce = '';
	if (isset($_POST['ostrmCartNonce']))
	{
		$nonce = $_POST['ostrmCartNonce'];
	}

	if (wp_verify_nonce($nonce, 'orderstorm_nonce'))
	{
		$response['blnValidNonce'] = TRUE;
	}

	if ($response['blnValidNonce'] === TRUE)
	{
		if (isset($_SESSION['order_key_guid']))
		{
			$order_key_guid = $_SESSION['order_key_guid'];
		}

		$features = null;
		if (isset($_POST['feature']))
		{
			$features = $_POST['feature'];
		}

		$blnFirstFeatureGroup = TRUE;
		$ajax_request = '';
		$ajax_request = $ajax_request . '{';
		$ajax_request = $ajax_request . '"key_GUID":"' . $ws_key_guid . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"session_id":"' . session_id() . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"service":"add_product"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"arguments":{';
		$ajax_request = $ajax_request . '"product_guid":"' . $_POST['id'] . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"order_key_guid":';
		if (is_null($order_key_guid))
		{
			$ajax_request = $ajax_request . 'null';
		}
		else
		{
			$ajax_request = $ajax_request . '"' . $order_key_guid . '"';
		}
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"quantity":' . $_POST['Quantity'];
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"ip":"' . $_SERVER['REMOTE_ADDR'] . '"';
		$ajax_request = $ajax_request . ',';
		$ajax_request = $ajax_request . '"features":';
		if (is_array($features))
		{
			if (count($features) > 0)
			{
				$ajax_request .= '{';
				foreach($features as $featureGroup => $value)
				{
					if ($blnFirstFeatureGroup === TRUE)
					{
						$blnFirstFeatureGroup = FALSE;
					}
					else
					{
						$ajax_request = $ajax_request . ',';
					}
					$ajax_request = $ajax_request . '"' . $featureGroup . '":';
					if (is_array($value))
					{
						$blnFirstFeature = TRUE;
						foreach($value as $featureProductGUID)
						{
							if ($blnFirstFeature === TRUE)
							{
								$blnFirstFeature = FALSE;
								$ajax_request = $ajax_request . '[';
							}
							else
							{
								$ajax_request = $ajax_request . ',';
							}
							$ajax_request = $ajax_request . '"' . $featureProductGUID . '"';
						}
						if ($blnFirstFeature === FALSE)
						{
							$ajax_request = $ajax_request . ']';
						}
					}
					else
					{
						$ajax_request = $ajax_request . '["' . $value . '"]';
					}
				}
				$ajax_request .= '}';
			}
			else
			{
				$ajax_request .= 'null';
			}
		}
		else
		{
			$ajax_request .= 'null';
		}
		$ajax_request = $ajax_request . '}';
		$ajax_request = $ajax_request . '}';

		$result =	new jsonResultSet
					(
						$json_obj->decode
						(
							OrderStormECommerceForWordPress::curl_fetch_ajax
							(
								$ecommerce_host_name,
								array('AJAX_Request' => $ajax_request),
								TRUE,
								TRUE
							)
						)
					);
		if ($result->rowCount() === 1)
		{
			$response['blnAddSuccessful'] = TRUE;
			$row = $result->row(0);
			$new_order_key_guid = $row['order_key_guid'];
		}

		if (is_null($new_order_key_guid))
		{
			unset($_SESSION['order_key_guid']);
			$response['orderKeyGUID'] = null;
			session_destroy();
		}
		else
		{
			if ($new_order_key_guid !== $order_key_guid)
			{
				$_SESSION['order_key_guid'] = $new_order_key_guid;
			}
			$response['orderKeyGUID'] = $new_order_key_guid;
		}
	}

	header('Content-type: application/json');
	echo($json_obj->encode($response));
	die();
}

function orderstorm_ecommerce_submit_product_question()
{
	require_once('CLASS_jsonResultSet.php');
	require_once('CLASS_OrderStormECommerceForWordPress.php');

	$json_obj = new Moxiecode_JSON();
	$ecommerce_host_name = 'https://' . get_option('orderstorm_ecommerce_host_name', '') . '/orderstorm_ecommerce.os';
	$ws_key_guid = get_option('orderstorm_ecommerce_key_guid', '');

	$response = array();
	$response['blnAddSuccessful'] = FALSE;
	$response['blnValidNonce'] = FALSE;

	$nonce = '';
	if (isset($_POST['ostrmCartNonce']))
	{
		$nonce = $_POST['ostrmCartNonce'];
	}

	if (wp_verify_nonce($nonce, 'orderstorm_nonce'))
	{
		$response['blnValidNonce'] = TRUE;
	}

	if ($response['blnValidNonce'] === TRUE)
	{
		$product_guid = $_POST['id'];
		if (OrderStormECommerceForWordPress::isWellFormedGUID($product_guid))
		{
			$question = $_POST['question'];
			if (strip_tags($question) === $question)
			{
				$email = $_POST['email'];
				if (filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$ip = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:null;
					$referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;

					$ajax_request = '';
					$ajax_request = $ajax_request . '{';
					$ajax_request = $ajax_request . '"key_GUID":"' . $ws_key_guid . '"';
					$ajax_request = $ajax_request . ',';
					$ajax_request = $ajax_request . '"session_id":"' . session_id() . '"';
					$ajax_request = $ajax_request . ',';
					$ajax_request = $ajax_request . '"service":"submit_product_question"';
					$ajax_request = $ajax_request . ',';
					$ajax_request = $ajax_request . '"arguments":{';
					$ajax_request = $ajax_request . '"product_guid":"' . $product_guid . '"';
					$ajax_request = $ajax_request . ',';
					$ajax_request = $ajax_request . '"email":"' . $email . '"';
					$ajax_request = $ajax_request . ',';
					$ajax_request = $ajax_request . '"question":"' . $question . '"';
					$ajax_request = $ajax_request . ',';
					$ajax_request = $ajax_request . '"ip":';
					if (is_null($ip))
					{
						$ajax_request = $ajax_request . 'null';
					}
					else
					{
						$ajax_request = $ajax_request . '"' . $ip . '"';
					}
					$ajax_request = $ajax_request . ',';
					$ajax_request = $ajax_request . '"referer":';
					if (is_null($referer))
					{
						$ajax_request = $ajax_request . 'null';
					}
					else
					{
						$ajax_request = $ajax_request . '"' . $referer . '"';
					}
					$ajax_request = $ajax_request . '}';
					$ajax_request = $ajax_request . '}';

					$result =	new jsonResultSet
								(
									$json_obj->decode
									(
										OrderStormECommerceForWordPress::curl_fetch_ajax
										(
											$ecommerce_host_name,
											array('AJAX_Request' => $ajax_request),
											TRUE,
											TRUE
										)
									)
								);
					if ($result->rowCount() === 1)
					{
						$response['blnAddSuccessful'] = TRUE;
					}
				}
				else
				{
					$response['error'] = 3;
				}
			}
			else
			{
				$response['error'] = 2;
			}
		}
		else
		{
			$response['error'] = 1;
		}
	}

	header('Content-type: application/json');
	echo($json_obj->encode($response));
	die();
}

function orderstorm_ecommerce_load_categories_menu_widget_style_sheet()
{
	$categories_menu_widget_style_sheet_url = $GLOBALS['osws']->get_option('categories_menu_widget_style_sheet_url');
	if (!empty($categories_menu_widget_style_sheet_url))
	{
		wp_register_style("orderstorm_ecommerce_categories_menu_widget_style_sheet", $categories_menu_widget_style_sheet_url);
		wp_enqueue_style("orderstorm_ecommerce_categories_menu_widget_style_sheet");
	}
}

function orderstorm_ecommerce_load_shopping_cart_status_widget_style_sheet()
{
	$shopping_cart_status_widget_style_sheet_url = $GLOBALS['osws']->get_option('shopping_cart_status_widget_style_sheet_url');
	if (!empty($shopping_cart_status_widget_style_sheet_url))
	{
		wp_register_style("orderstorm_ecommerce_shopping_cart_status_widget_style_sheet", $shopping_cart_status_widget_style_sheet_url);
		wp_enqueue_style("orderstorm_ecommerce_shopping_cart_status_widget_style_sheet");
	}
}

function orderstorm_ecommerce_load_product_categories_style_sheet()
{
	$product_categories_style_sheet_url = $GLOBALS['osws']->get_option('product_categories_style_sheet_url');
	if (!empty($product_categories_style_sheet_url))
	{
		wp_register_style("orderstorm_ecommerce_product_categories_style_sheet", $product_categories_style_sheet_url);
		wp_enqueue_style("orderstorm_ecommerce_product_categories_style_sheet");
	}
}

function orderstorm_ecommerce_load_products_style_sheet()
{
	$products_style_sheet_url = $GLOBALS['osws']->get_option('products_style_sheet_url');
	if (!empty($products_style_sheet_url))
	{
		wp_register_style("orderstorm_ecommerce_products_style_sheet", $products_style_sheet_url);
		wp_enqueue_style("orderstorm_ecommerce_products_style_sheet");
	}
}

function orderstorm_ecommerce_load_product_details_style_sheet()
{
	$product_details_style_sheet_url = $GLOBALS['osws']->get_option('product_details_style_sheet_url');
	if (!empty($product_details_style_sheet_url))
	{
		wp_register_style("orderstorm_ecommerce_product_details_style_sheet", $product_details_style_sheet_url);
		wp_enqueue_style("orderstorm_ecommerce_product_details_style_sheet");
	}
}

function orderstorm_ecommerce_load_widgets()
{
	if (!is_admin())
	{
		wp_enqueue_script('ostrm_categories_menu', plugin_dir_url(__FILE__) . 'js/ostrm_categories_menu.js', array('jquery'), '1.0', false);
	}
	register_widget('orderstorm_ecommerce_categories_menu');
	register_widget('orderstorm_ecommerce_shopping_cart_status');
}

function orderstorm_ecommerce_flush_rewrite_rules()
{
	global $wp_rewrite;

	if ($GLOBALS['osws']->need_to_flush_rules())
	{
		$wp_rewrite->flush_rules($hard = true);
	}
}

function orderstorm_ecommerce_insert_rewrite_rules($rules)
{
	return $GLOBALS['osws']->get_url_rewrite_rules() + $rules;
}

function orderstorm_ecommerce_insert_rewrite_query_vars($vars)
{
	return $GLOBALS['osws']->add_rewrite_query_vars($vars);
}

function activate_orderstorm_ecommerce_plugin()
{
	add_option('orderstorm_ecommerce_key_guid', OrderStormECommerceForWordPress::get_default_key(), '', 'yes');	// This is the test key
	add_option('orderstorm_ecommerce_host_name', 'lima.orderstorm.com', '', 'yes');
	add_option("orderstorm_ecommerce_do_not_verify_ssl_peer_certificate", TRUE, '', 'yes');
	add_option('orderstorm_ecommerce_categories_menu_cache_timestamps', array(), '', 'yes');

	$GLOBALS['osws'] = new OrderStormECommerceForWordPress();

	$product_category_page_id = $GLOBALS['osws']->get_page_id_by_slug($GLOBALS['osws']->get_product_category_page_slug());
	$product_page_id = $GLOBALS['osws']->get_page_id_by_slug($GLOBALS['osws']->get_product_page_slug());

	if (!is_null($product_category_page_id))
	{
		wp_delete_post($product_category_page_id, true);
		$product_category_page_id = $GLOBALS['osws']->get_page_id_by_slug($GLOBALS['osws']->get_product_category_page_slug());
	}
	if (is_null($product_category_page_id))
	{
		$page = array
		(
			'post_type' => 'page',
			'post_name' => $GLOBALS['osws']->get_product_category_page_slug(),	// Default should be 'OrderStorm-ecommerce-category-page', when using the test key
			'post_title' => $GLOBALS['osws']->get_product_category_page_slug(),
			'post_content' => '[orderstorm_ecommerce_display_product_category_page]',
			'post_status' => 'publish',
			'comment_status' => 'closed',
			'ping_status' => 'closed'
		);
		if (wp_insert_post($post = $page, $wp_error = FALSE) === 0)
		{
			$GLOBALS['osws']->trigger_error_on_error_scrape('Failed to create the new "Product Category" page, as configured in your OrderStorm.com Storefront Settings page.', E_USER_ERROR);
		}
	}
	else
	{
		$GLOBALS['osws']->trigger_error_on_error_scrape('Failed to delete old "Product Category" page, in order to create the one configured in your OrderStorm.com Storefront Settings page.', E_USER_ERROR);
	}

	if (!is_null($product_page_id))
	{
		wp_delete_post($product_page_id, true);
		$product_page_id = $GLOBALS['osws']->get_page_id_by_slug($GLOBALS['osws']->get_product_page_slug());
	}
	if (is_null($product_page_id))
	{
		$page = array
		(
			'post_type' => 'page',
			'post_name' => $GLOBALS['osws']->get_product_page_slug(),	// Default should be 'OrderStorm-ecommerce-product-page', when using the test key
			'post_title' => $GLOBALS['osws']->get_product_page_slug(),
			'post_content' => '[orderstorm_ecommerce_display_product_page]',
			'post_status' => 'publish',
			'comment_status' => 'closed',
			'ping_status' => 'closed'
		);
		if (wp_insert_post($post = $page, $wp_error = FALSE) === 0)
		{
			$GLOBALS['osws']->trigger_error_on_error_scrape('Failed to create the new "Product" page, as configured in your OrderStorm.com Storefront Settings page.', E_USER_ERROR);
		}
	}
	else
	{
		$GLOBALS['osws']->trigger_error_on_error_scrape('Failed to delete old "Product" page, in order to create the one configured in your OrderStorm.com Storefront Settings page.', E_USER_ERROR);
	}
}

function deactivate_orderstorm_ecommerce_plugin()
{
	unregister_setting('orderstorm_ecommerce_main_settings_group', 'orderstorm_ecommerce_key_guid', 'orderstorm_ecommerce_validated_key');
	unregister_setting('orderstorm_ecommerce_advanced_settings_group', 'orderstorm_ecommerce_host_name', 'orderstorm_ecommerce_validated_host_name');
	unregister_setting('orderstorm_ecommerce_advanced_settings_group', 'orderstorm_ecommerce_do_not_verify_ssl_peer_certificate', 'orderstorm_ecommerce_validated_do_not_verify_ssl_peer_certificate');
}

function create_orderstorm_ecommerce_option_menu()
{
	add_menu_page(
		__('OrderStorm e-Commerce - Main Settings', 'orderstorm-wordpress-e-commerce'),
		__('OrderStorm e-Commerce', 'orderstorm-wordpress-e-commerce'),
		'administrator',
		'orderstorm_ecommerce_settings_menu',
		'orderstorm_ecommerce_main_settings_page'
	);
	add_submenu_page(
		'orderstorm_ecommerce_settings_menu',
		__('OrderStorm e-Commerce - Main Settings', 'orderstorm-wordpress-e-commerce'),
		__('Main', 'orderstorm-wordpress-e-commerce'),
		'administrator',
		'orderstorm_ecommerce_settings_menu',
		'orderstorm_ecommerce_main_settings_page'
	);
	add_submenu_page(
		'orderstorm_ecommerce_settings_menu',
		__('OrderStorm e-Commerce - Product Category Settings', 'orderstorm-wordpress-e-commerce'),
		__('Product Categories', 'orderstorm-wordpress-e-commerce'),
		'administrator',
		'orderstorm_ecommerce_product_categories_menu_option',
		'orderstorm_ecommerce_product_category_settings_page'
	);
	add_submenu_page(
		'orderstorm_ecommerce_settings_menu',
		__('OrderStorm e-Commerce - Product Settings', 'orderstorm-wordpress-e-commerce'),
		__('Products', 'orderstorm-wordpress-e-commerce'),
		'administrator',
		'orderstorm_ecommerce_products_menu_option',
		'orderstorm_ecommerce_product_settings_page'
	);
	add_submenu_page(
		'orderstorm_ecommerce_settings_menu',
		__('OrderStorm e-Commerce - Advanced Settings', 'orderstorm-wordpress-e-commerce'),
		__('Advanced', 'orderstorm-wordpress-e-commerce'),
		'administrator',
		'orderstorm_ecommerce_advanced_settings_menu_option',
		'orderstorm_ecommerce_advanced_settings_page'
	);
	add_action('admin_init', 'register_orderstorm_ecommerce_options');
}

function register_orderstorm_ecommerce_options()
{
	register_setting('orderstorm_ecommerce_main_settings_group', 'orderstorm_ecommerce_key_guid', 'orderstorm_ecommerce_validated_key');
	register_setting('orderstorm_ecommerce_advanced_settings_group', 'orderstorm_ecommerce_host_name', 'orderstorm_ecommerce_validated_host_name');
	register_setting('orderstorm_ecommerce_advanced_settings_group', 'orderstorm_ecommerce_do_not_verify_ssl_peer_certificate', 'orderstorm_ecommerce_validated_do_not_verify_ssl_peer_certificate');
}

function orderstorm_ecommerce_validated_key($key_GUID)
{
	$GLOBALS['osws']->delete_categories_menu_cache();

	if (OrderStormECommerceForWordPress::isWellFormedGUID($key_GUID))
	{
		return $key_GUID;
	}
	else
	{
		return '';
	}
}

function orderstorm_ecommerce_validated_host_name($host_name)
{
	$host_name = trim($host_name);

	if (strlen($host_name) > 0)
	{
		if(substr($host_name, -1) === '/')
		{
			$host_name = substr($host_name, 0, -1);
		}
	}

	if (!(OrderStormECommerceForWordPress::isValidIPv4address($host_name) || OrderStormECommerceForWordPress::isValidHostName($host_name)))
	{
		$host_name = '';
	}

	return $host_name;
}


function orderstorm_ecommerce_validated_do_not_verify_ssl_peer_certificate($do_not_verify_ssl_peer_certificate)
{
	if ($do_not_verify_ssl_peer_certificate !== "do_not_verify_ssl_peer_certificate")
	{
		return FALSE;
	}
	else
	{
		return TRUE;
	}
}

function orderstorm_ecommerce_main_settings_page()
{
	if (!get_option('orderstorm_ecommerce_key_guid'))
	{
		$api_key_msg = "<div style=\"color: red;\">No API key is currently installed.</div><div>Click <a id=\"setSampleKey\" href=\"javascript:(function () {jQuery('#orderstorm_ecommerce_key_guid').val('" . OrderStormECommerceForWordPress::get_default_key() . "'); jQuery('#OrderStormECommerceMainSettings').submit()})()\">here</a> to use the sample OrderStorm key</div><div>or fill out the form below to get a free key now.</div>";
	}
	else
	{
		if (get_option('orderstorm_ecommerce_key_guid') === OrderStormECommerceForWordPress::get_default_key())
		{
			$api_key_msg = "<div>This is the sample OrderStorm key.</div><div>Fill out the form below to get a free key now.</div>";
		}
		else
		{
			$api_key_msg = "This is your OrderStorm API key.";
		}
	}
?>
<div class="wrap">
	<h2>OrderStorm e-Commerce - Main</h2>

	<form name="OrderStormECommerceMainSettings" id="OrderStormECommerceMainSettings" method="post" action="options.php">
		<?php settings_fields('orderstorm_ecommerce_main_settings_group'); ?>
		<table class="form-table">
			<tr align="top">
				<th scope="row">Version:</th>
				<td>
					<input type="text" value="<?php $plugin_data = get_plugin_data(__FILE__); echo($plugin_data["Version"]); ?>" readonly="readonly" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">API key:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_key_guid" id="orderstorm_ecommerce_key_guid" style="width: 44ex;" maxlength="38" value="<?php echo(get_option('orderstorm_ecommerce_key_guid')); ?>" /><div style="margin-left: 10px; display:inline-block; vertical-align: top; font-weight: bold;"><?php echo($api_key_msg); ?></div>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>"/>
		</p>
	</form>
<?php
	if (!get_option('orderstorm_ecommerce_key_guid') || get_option('orderstorm_ecommerce_key_guid') === OrderStormECommerceForWordPress::get_default_key())
	{
		$tldList = $GLOBALS['osws']->get_tld_list();
		$rowCount = $tldList->rowCount();
		$tldListSelect = "";
		if ($rowCount > 0)
		{
			$tldListSelect .= "<select name=\"orderstorm_ecommerce_api_key_signup_domain_tld\" style=\"margin-left: 5px; width: 15ex;\">";
			for ($row = 0; $row < $rowCount; $row++)
			{
				$tld_guid = $tldList->fieldValue($row, 'guid');
				$tld = $tldList->fieldValue($row, 'tld');
				$tldListSelect .= '<option value="' . $tld_guid . '">' . $tld . '</option>';
			}
			$tldListSelect .= "</select>";
		}
?>
	<h2>API key signup - One easy step</2>
	<h3>Get a free API key and open your store today.</h3>
	<div>You can upgrade your plan any time - just  log in at <a href="http://www.orderstorm.com">OrderStorm.com</a> and go to My Account.</div>
	<div style="font-weight: bold; color: red; margin-top: 10px;">All fields are required</div>
	<form name="APIkeySignupForm" id="APIkeySignupForm" action="javascript:return false;">
		<table class="form-table">
			<tr align="top">
				<th scope="row">First name:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_api_key_signup_first_name" style="width: 67ex;" maxlength="255" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Last name:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_api_key_signup_last_name" style="width: 67ex;" maxlength="255" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Domain name:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_api_key_signup_domain_name" style="margin-right: 5px; width: 50ex;" maxlength="255" /><span style="font-weight: bold;">.</span><?php echo($tldListSelect); ?>
				</td>
			</tr>
			<tr align="top">
				<th scope="row">e-mail address:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_api_key_signup_email_address" style="width: 67ex;" maxlength="255" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Choose a password:</th>
				<td>
					<input type="password" name="orderstorm_ecommerce_api_key_signup_password" style="width: 67ex;" maxlength="255" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Confirm password:</th>
				<td>
					<input type="password" name="orderstorm_ecommerce_api_key_signup_confirm_password" style="width: 67ex;" maxlength="255" />
				</td>
			</tr>
			<tr align="top">
				<td colspan="2">
					By clicking <b>Submit</b> you agree to or <a href="http://www.orderstorm.com/about-wordpress-ecommerce/orderstorm-terms-and-conditions/">terms and conditions</a>.
				</tr>
			</tr>
			<tr align="top">
				<td colspan="2">
					<input type="submit" class="button-primary" value="<?php _e('Submit'); ?>"/>
				</tr>
			</tr>
			<tr align="top">
				<td colspan="2">
					After you click on <b>Submit</b>, the example API key will be replaced with your own key so you can start adding products to your store right away.
				</tr>
			</tr>
		</table>
	</form>
<?php
	}
?>
</div><?php
}

function orderstorm_ecommerce_product_category_settings_page()
{
?>
<div class="wrap">
	<h2>OrderStorm e-Commerce - Product Categories</h2>
	<p>
		A page entitled <b>&quot;orderstorm-ecommerce-category-page&quot;</b> is created on your site when the plugin is first installed. For displaying product categories on this
		site, this page <b>must</b> exist, containing the following <b>shortcode</b>: <b><code>[orderstorm_ecommerce_display_product_category_page]</code></b>. <i>Do not delete this
		page</i>. You can edit both the page <b>title</b> and the corresponding <b>page slug</b> in the <b>Permalink</b> field when you edit this page. The <b>slug</b> is the last
		segment of the permalink, presented between "<b>/</b>" (forward slash) characters. The corresponding <b>page slug</b> should be typed in the <b><i>category page slug</i></b>
		field in the <b>category page</b> section of your site's <b>OrderStorm.com Storefront Settings</b>. Note that you do not need to include this category page in your menu.
	</p>
	<h3 style="color: red;">
		These settings are configured in your site&#39;s <b>Storefront Settings</b> page and cannot be edited here. Login at
		<a href="http://www.orderstorm.com">http://www.OrderStorm.com</a> to make changes.
	</h3>
	<form name="OrderStormECommerceProductCategorySettings" method="post" action="options.php">
		<table class="form-table">
<?php
	$product_category_page_slug = $GLOBALS['osws']->get_product_category_page_slug();
?>
			<tr align="top">
				<th scope="row">Product category page slug:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_product_category_page_slug" style="width: 67ex;" maxlength="255" value="<?php echo($GLOBALS['osws']->get_product_category_page_slug()); ?>" readonly="readonly" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Product category page ID:</th>
				<td>
<?php
	$product_category_page_id = OrderStormECommerceForWordPress::get_page_id_by_slug($product_category_page_slug);
	$product_category_page_is_published = OrderStormECommerceForWordPress::is_page_published($product_category_page_id);
?>
					<input type="text" <?php if (!$product_category_page_id) {echo('style="color: red;" ');} ?>value="<?php echo($product_category_page_id?strval($product_category_page_id):'Page does not exist!'); ?>" readonly="readonly" />
<?php
	if ($product_category_page_id)
	{
?>
					<span style="margin-left: 10px; color: <?php echo($product_category_page_is_published?'green':'red'); ?>;"><?php echo($product_category_page_is_published?'Published':'Not published'); ?></span>
<?php
	}
?>
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Use SEO-friendly product category links?</th>
				<td>
					<input type="checkbox" name="orderstorm_ecommerce_use_seo_friendly_product_category_links" value="use_seo_friendly_product_category_links" <?php if ($GLOBALS['osws']->get_use_seo_friendly_product_category_links()) {echo(' checked="checked"');} ?> disabled="disabled" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Display product categories in search results?</th>
				<td>
					<input type="checkbox" name="orderstorm_ecommerce_display_categories_in_search" value="display_categories_in_search" <?php if ($GLOBALS['osws']->get_display_categories_in_search()) {echo(' checked="checked"');} ?> disabled="disabled" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Create product category page entries in the XML sitemap?</th>
				<td>
					<input type="checkbox" name="orderstorm_ecommerce_create_category_sitemap" value="create_category_sitemap" <?php if ($GLOBALS['osws']->get_create_category_sitemap()) {echo(' checked="checked"');} ?> disabled="disabled" />
				</td>
			</tr>
		</table>
	</form>
</div><?php
}

function orderstorm_ecommerce_product_settings_page()
{
?>
<div class="wrap">
	<h2>OrderStorm e-Commerce - Products</h2>
	<p>
		A page entitled <b>&quot;orderstorm-ecommerce-product-page&quot;</b> is created on your site when the plugin is first installed. For displaying products on this
		site, this page <b>must</b> exist, containing the following <b>shortcode</b>: <b><code>[orderstorm_ecommerce_display_product_page]</code></b>. <i>Do not delete this
		page</i>. You can edit both the page <b>title</b> and the corresponding <b>page slug</b> in the <b>Permalink</b> field when you edit this page. The <b>slug</b> is
		the last segment of the permalink, presented between "<b>/</b>" (forward slash) characters. The corresponding <b>page slug</b> should be typed in the <b><i>product
		page slug</i></b> field in the <b>product page</b> section of your site's <b>OrderStorm.com Storefront Settings</b>. Note that you do not need to include this
		product page in your menu.
	</p>
	<h3 style="color: red;">
		These settings are configured in your site&#39;s <b>Storefront Settings</b> page and cannot be edited here. Login at
		<a href="http://www.orderstorm.com">http://www.OrderStorm.com</a> to make changes.
	</h3>
	<form name="OrderStormECommerceProductSettings" method="post" action="options.php">
		<table class="form-table">
<?php
	$product_page_slug = $GLOBALS['osws']->get_product_page_slug();
?>
			<tr align="top">
				<th scope="row">Product page slug:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_product_page_slug" style="width: 67ex;" maxlength="255" value="<?php echo($GLOBALS['osws']->get_product_page_slug()); ?>" readonly="readonly" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Product page ID:</th>
				<td>
<?php
	$product_page_id = OrderStormECommerceForWordPress::get_page_id_by_slug($product_page_slug);
	$product_page_is_published = OrderStormECommerceForWordPress::is_page_published($product_page_id);
?>
					<input type="text" <?php if (!$product_page_id) {echo ('style="color: red;"');} ?>value="<?php echo($product_page_id?strval($product_page_id):'Page does not exist!'); ?>" readonly="readonly" />
<?php
	if ($product_page_id)
	{
?>
					<span style="margin-left: 10px; color: <?php echo($product_page_is_published?'green':'red'); ?>;"><?php echo(($product_page_is_published)?'Published':'Not published'); ?></span>
<?php
	}
?>
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Use SEO-friendly product links?</th>
				<td>
					<input type="checkbox" name="orderstorm_ecommerce_use_seo_friendly_product_links" value="use_seo_friendly_product_links" <?php if ($GLOBALS['osws']->get_use_seo_friendly_product_links()) {echo(' checked="checked"');} ?>" disabled="disabled" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Display products in search results?</th>
				<td>
					<input type="checkbox" name="orderstorm_ecommerce_display_products_in_search" value="display_products_in_search" <?php if ($GLOBALS['osws']->get_display_products_in_search()) {echo(' checked="checked"');} ?> disabled="disabled" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Create product page entries in the XML sitemap?</th>
				<td>
					<input type="checkbox" name="orderstorm_ecommerce_create_product_sitemap" value="create_product_sitemap" <?php if ($GLOBALS['osws']->get_create_product_sitemap()) {echo(' checked="checked"');} ?> disabled="disabled" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Is the product name editable in the page title?</th>
				<td>
					<input type="checkbox" name="orderstorm_ecommerce_product_name_editable_in_page_title" value="product_name_editable_in_page_title" <?php if ($GLOBALS['osws']->should_product_name_be_editable_in_title()) {echo(' checked="checked"');} ?> disabled="disabled" />
				</td>
			</tr>
		</table>
	</form>
</div><?php
}

function orderstorm_ecommerce_advanced_settings_page()
{
?>
<div class="wrap">
	<h2>OrderStorm e-Commerce - Advanced</h2>

	<form name="OrderStormECommerceAdvancedSettings" method="post" action="options.php">
		<?php settings_fields('orderstorm_ecommerce_advanced_settings_group'); ?>
		<table class="form-table">
			<tr align="top">
				<th scope="row">PHP version:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_php_version" style="width: 67ex;" maxlength="255" value="<?php echo(phpversion()); ?>" readonly="readonly" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Operating system:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_php_operating_system" style="width: 67ex;" maxlength="255" value="<?php echo(php_uname("s")); ?>" readonly="readonly" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Operating system release name:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_php_operating_system_release_name" style="width: 67ex;" maxlength="255" value="<?php echo(php_uname("r")); ?>" readonly="readonly" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Operating system version:</th>
				<td>
					<textarea name="orderstorm_ecommerce_php_operating_system_version" style="width: 67ex; background-color: #eeeeee;" rows="5" readonly="readonly"><?php echo(php_uname("v")); ?></textarea>
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Machine type:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_php_machine_type" style="width: 67ex;" maxlength="255" value="<?php echo(php_uname("m")); ?>" readonly="readonly" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Force HTTPS for product and category page URLs:</th>
				<td>
					<input type="checkbox" name="orderstorm_ecommerce_force_https_for_product_and_category_page_urls" <?php checked(orderstorm_ecommerce('meta_data', 'force_ssl_for_generated_urls')); ?> disabled="disabled" />
				</td>
			</tr>
			<tr align="top">
				<td colspan="2">
					<h3 style="width: 86ex; color: red; padding: 5px; -webkit-border-radius: 3px; border-radius: 3px; border-width: 1px; border-style: solid; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;">
						You should NOT change any options below, <b>UNLESS</b> you know what you are doing.<br />Ask <a href="mailto:support@orderstorm.com">OrderStorm, Inc.</a> for support before changing any of them.
					</h3>
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Host name:</th>
				<td>
					<input type="text" name="orderstorm_ecommerce_host_name" style="width: 67ex;" maxlength="255" value="<?php echo(get_option('orderstorm_ecommerce_host_name')); ?>" />
				</td>
			</tr>
			<tr align="top">
				<th scope="row">Do not verify SSL peer certificate:</th>
				<td>
					<input type="checkbox" name="orderstorm_ecommerce_do_not_verify_ssl_peer_certificate" value="do_not_verify_ssl_peer_certificate" <?php checked(get_option('orderstorm_ecommerce_do_not_verify_ssl_peer_certificate', TRUE), TRUE); ?> />
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>"/>
		</p>
	</form>
</div><?php
}

function orderstorm_ecommerce_display_product_category_page($attributes, $content = null, $tag = null)
{
	global
	$wp_the_query,
	$custom_category_page_template_file,
	$default_category_page_template_file;

	extract
	(
		shortcode_atts
		(
			array
			(
				'cat_link' => null
			),
			$attributes
		)
	);
	$id = $wp_the_query->get_queried_object_id();
	if ($id !== $GLOBALS["osws"]->get_product_category_page_id())
	{
		$GLOBALS['osws']->prepare_category_information($cat_link);
	}

	$html = '';

	ob_start();
	if (file_exists($custom_category_page_template_file))
	{
		require($custom_category_page_template_file);
	}
	elseif (file_exists($default_category_page_template_file))
	{
		require($default_category_page_template_file);
	}
	$html = ob_get_contents();
	ob_end_clean();

	return $html;
}

function orderstorm_ecommerce_display_product_page($attributes, $content = null, $tag = null)
{
	global
	$wp_the_query,
	$custom_product_details_template_file,
	$default_product_details_template_file;

	extract
	(
		shortcode_atts
		(
			array
			(
				'product_link' => null
			),
			$attributes
		)
	);
	$id = $wp_the_query->get_queried_object_id();
	if ($id !== $GLOBALS["osws"]->get_product_page_id())
	{
		$GLOBALS['osws']->prepare_product_information($product_link);
	}

	$html = '';

	ob_start();
	if (file_exists($custom_product_details_template_file))
	{
		require($custom_product_details_template_file);
	}
	elseif (file_exists($default_product_details_template_file))
	{
		require($default_product_details_template_file);
	}
	$html = ob_get_contents();
	ob_end_clean();

	return $html;
}

function orderstorm_ecommerce_shopping_cart_status_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"id_suffix" => "",
				"class_suffix" => "ostrm_shopping_cart_status"
			),
			$attributes
		)
	);

	return $GLOBALS['osws']->get_shopping_cart_status_html($id_suffix, $class_suffix);
}

function orderstorm_select_product_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null
			),
			$attributes
		)
	);

	$GLOBALS['osws']->prepare_product_information_for_shortcodes($product_link);

	return "";
}

function orderstorm_product_name_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null,
				"sanitize_markup" => "true"
			),
			$attributes
		)
	);
	$sanitize_markup = strtolower($sanitize_markup);

	if ($sanitize_markup === "true" || $sanitize_markup === "false")
	{
		if (!empty($product_link))
		{
			if ($product_link !== $GLOBALS['osws']->get_product_link_for_shortcodes())
			{
				orderstorm_select_product_shortcode($attributes);
			}
		}

		$product_name = $GLOBALS['osws']->get_product_name_for_shortcodes();

		if (is_null($product_name))
		{
			return "";
		}
		else
		{
			if ($sanitize_markup === "true")
			{
				return wp_kses_post($product_name);
			}
			else
			{
				return $product_name;
			}
		}
	}
	else
	{
		return "";
	}
}

function orderstorm_product_item_number_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null,
				"sanitize_markup" => "true"
			),
			$attributes
		)
	);
	$sanitize_markup = strtolower($sanitize_markup);

	if ($sanitize_markup === "true" || $sanitize_markup === "false")
	{
		if (!empty($product_link))
		{
			if ($product_link !== $GLOBALS['osws']->get_product_link_for_shortcodes())
			{
				orderstorm_select_product_shortcode($attributes);
			}
		}

		$item_number = $GLOBALS['osws']->get_product_item_number_for_shortcodes();

		if (is_null($item_number))
		{
			return "";
		}
		else
		{
			if ($sanitize_markup === "true")
			{
				return wp_kses_post($item_number);
			}
			else
			{
				return $item_number;
			}
		}
	}
	else
	{
		return "";
	}
}

function orderstorm_product_short_description_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null,
				"sanitize_markup" => "true"
			),
			$attributes
		)
	);
	$sanitize_markup = strtolower($sanitize_markup);

	if ($sanitize_markup === "true" || $sanitize_markup === "false")
	{
		if (!empty($product_link))
		{
			if ($product_link !== $GLOBALS['osws']->get_product_link_for_shortcodes())
			{
				orderstorm_select_product_shortcode($attributes);
			}
		}

		$short_description = $GLOBALS['osws']->get_product_short_description_for_shortcodes();

		if (is_null($short_description))
		{
			return "";
		}
		else
		{
			if ($sanitize_markup === "true")
			{
				return wp_kses_post($short_description);
			}
			else
			{
				return $short_description;
			}
		}
	}
	else
	{
		return "";
	}
}

function orderstorm_product_long_description_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null,
				"sanitize_markup" => "true"
			),
			$attributes
		)
	);
	$sanitize_markup = strtolower($sanitize_markup);

	if ($sanitize_markup === "true" || $sanitize_markup === "false")
	{
		if (!empty($product_link))
		{
			if ($product_link !== $GLOBALS['osws']->get_product_link_for_shortcodes())
			{
				orderstorm_select_product_shortcode($attributes);
			}
		}

		$long_description = $GLOBALS['osws']->get_product_long_description_for_shortcodes();

		if (is_null($long_description))
		{
			return "";
		}
		else
		{
			if ($sanitize_markup === "true")
			{
				return wp_kses_post($long_description);
			}
			else
			{
				return $long_description;
			}
		}
	}
	else
	{
		return "";
	}
}

function orderstorm_product_small_image_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null,
				"sanitize_markup" => "true"
			),
			$attributes
		)
	);
	$sanitize_markup = strtolower($sanitize_markup);

	if ($sanitize_markup === "true" || $sanitize_markup === "false")
	{
		if (!empty($product_link))
		{
			if ($product_link !== $GLOBALS['osws']->get_product_link_for_shortcodes())
			{
				orderstorm_select_product_shortcode($attributes);
			}
		}

		$product_id = $GLOBALS["osws"]->get_product_id_for_shortcodes();
		$small_image_extension = $GLOBALS["osws"]->get_product_thumbnail_image_extension_for_shortcodes();

		if (is_null($product_id) || is_null($small_image_extension))
		{
			return "";
		}
		else
		{
			$html = "<img src=\"" . $GLOBALS["osws"]->build_product_small_image_url($product_id, $small_image_extension) . "\" alt=\"\" border=\"0\" />";
			if ($sanitize_markup === "true")
			{
				return wp_kses_post($html);
			}
			else
			{
				return $html;
			}
		}
	}
	else
	{
		return "";
	}
}

function orderstorm_product_medium_image_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null,
				"sanitize_markup" => "true"
			),
			$attributes
		)
	);
	$sanitize_markup = strtolower($sanitize_markup);

	if ($sanitize_markup === "true" || $sanitize_markup === "false")
	{
		if (!empty($product_link))
		{
			if ($product_link !== $GLOBALS['osws']->get_product_link_for_shortcodes())
			{
				orderstorm_select_product_shortcode($attributes);
			}
		}

		$product_id = $GLOBALS["osws"]->get_product_id_for_shortcodes();
		$medium_image_extension = $GLOBALS["osws"]->get_product_extended_image_extension_for_shortcodes();

		if (is_null($product_id) || is_null($medium_image_extension))
		{
			return "";
		}
		else
		{
			$html = "<img src=\"" . $GLOBALS["osws"]->build_product_medium_image_url($product_id, $medium_image_extension) . "\" alt=\"\" border=\"0\" />";
			if ($sanitize_markup === "true")
			{
				return wp_kses_post($html);
			}
			else
			{
				return $html;
			}
		}
	}
	else
	{
		return "";
	}
}

function orderstorm_product_large_image_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null,
				"sanitize_markup" => "true"
			),
			$attributes
		)
	);
	$sanitize_markup = strtolower($sanitize_markup);

	if ($sanitize_markup === "true" || $sanitize_markup === "false")
	{
		if (!empty($product_link))
		{
			if ($product_link !== $GLOBALS['osws']->get_product_link_for_shortcodes())
			{
				orderstorm_select_product_shortcode($attributes);
			}
		}

		$product_id = $GLOBALS["osws"]->get_product_id_for_shortcodes();
		$large_image_extension = $GLOBALS["osws"]->get_product_full_size_extended_image_extension_for_shortcodes();

		if (is_null($product_id) || is_null($large_image_extension))
		{
			return "";
		}
		else
		{
			$html = "<img src=\"" . $GLOBALS["osws"]->build_product_large_image_url($product_id, $large_image_extension) . "\" alt=\"\" border=\"0\" />";
			if ($sanitize_markup === "true")
			{
				return wp_kses_post($html);
			}
			else
			{
				return $html;
			}
		}
	}
	else
	{
		return "";
	}
}

function orderstorm_product_not_for_sale_or_deleted_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null,
				"sanitize_markup" => "true"
			),
			$attributes
		)
	);
	$sanitize_markup = strtolower($sanitize_markup);

	if ($sanitize_markup === "true" || $sanitize_markup === "false")
	{
		if (!empty($product_link))
		{
			if ($product_link !== $GLOBALS['osws']->get_product_link_for_shortcodes())
			{
				orderstorm_select_product_shortcode($attributes);
			}
		}

		$not_for_sale = $GLOBALS["osws"]->get_product_not_for_sale_for_shortcodes();
		$deleted = $GLOBALS["osws"]->get_product_deleted_for_shortcodes();

		if (is_null($not_for_sale) || is_null($deleted))
		{
			return "";
		}
		else
		{
			$html = "";
			if ($not_for_sale || $deleted)
			{
				$html = __('This product is not available at this time', 'orderstorm-wordpress-e-commerce');
			}

			if ($sanitize_markup === "true")
			{
				return wp_kses_post($html);
			}
			else
			{
				return $html;
			}
		}
	}
	else
	{
		return "";
	}
}

function orderstorm_url_for_product_page_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null,
				"sanitize_markup" => "true"
			),
			$attributes
		)
	);
	$sanitize_markup = strtolower($sanitize_markup);

	if ($sanitize_markup === "true" || $sanitize_markup === "false")
	{
		if (!empty($product_link))
		{
			if ($product_link !== $GLOBALS['osws']->get_product_link_for_shortcodes())
			{
				orderstorm_select_product_shortcode($attributes);
			}
		}

		$slug = $GLOBALS["osws"]->get_product_link_for_shortcodes();
		$link_override = $GLOBALS["osws"]->get_product_link_override_for_shortcodes();

		if (is_null($slug))
		{
			return "";
		}
		else
		{
			$html = $GLOBALS["osws"]->build_product_page_link($slug, $link_override);
			if ($sanitize_markup === "true")
			{
				return wp_kses_post($html);
			}
			else
			{
				return $html;
			}
		}
	}
	else
	{
		return "";
	}
}

function orderstorm_product_retail_price_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null,
				"numeric" => "false"
			),
			$attributes
		)
	);
	$numeric = strtolower($numeric);

	if ($numeric === "true" || $numeric === "false")
	{
		if (!empty($product_link))
		{
			if ($product_link !== $GLOBALS['osws']->get_product_link_for_shortcodes())
			{
				orderstorm_select_product_shortcode($attributes);
			}
		}

		$product_retail_price = $GLOBALS['osws']->get_product_retail_price_for_shortcodes();

		if (is_null($product_retail_price))
		{
			return "";
		}
		else
		{
			if ($numeric === "true")
			{
				return $product_retail_price;
			}
			else
			{
				return $GLOBALS['osws']->money_format($product_retail_price);
			}
		}
	}
	else
	{
		return "";
	}
}

function orderstorm_product_your_cost_shortcode($attributes, $content = null, $tag = null)
{
	extract
	(
		shortcode_atts
		(
			array
			(
				"product_link" => null,
				"numeric" => "false"
			),
			$attributes
		)
	);
	$numeric = strtolower($numeric);

	if ($numeric === "true" || $numeric === "false")
	{
		if (!empty($product_link))
		{
			if ($product_link !== $GLOBALS['osws']->get_product_link_for_shortcodes())
			{
				orderstorm_select_product_shortcode($attributes);
			}
		}

		$your_cost = $GLOBALS['osws']->get_product_your_cost_for_shortcodes();

		if (is_null($your_cost))
		{
			return "";
		}
		else
		{
			if ($numeric === "true")
			{
				return $your_cost;
			}
			else
			{
				return $GLOBALS['osws']->money_format($your_cost);
			}
		}
	}
	else
	{
		return "";
	}
}
?>
