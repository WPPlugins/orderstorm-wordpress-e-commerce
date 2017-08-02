<?php
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
require_once('JSON.php');
require_once('CLASS_jsonResultSet.php');

class OrderStormECommerceForWordPress
{
	private $ecommerce_host_name;
	private $json_obj;
	private $key_guid;

	private $product_category_page_slug;
	private $product_category_page_id;
	private $use_seo_friendly_product_category_links;
	private $category_link;

	private $product_page_slug;
	private $product_page_id;
	private $use_seo_friendly_product_links;
	private $product_link;

	private $product_link_for_shortcodes;
	private $product_data_for_shortcodes;

	private $title_tag;
	private $meta_description;
	private $meta_keywords;

	private $category_data;
	private $product_data;

	private $meta_data;

	private $should_render_left_sidebar;
	private $should_render_right_sidebar;
	private $should_render_categories_menu;

	private $guid;
	private $category_display_left_sidebar;
	private $category_display_right_sidebar;
	private $category_display_categories_menu;
	private $detail_display_left_sidebar;
	private $detail_display_right_sidebar;
	private $detail_display_categories_menu;
	private $detail_product_name_editable_in_title;
	private $names_in_title;
	private $plugin_test_checkout;
	private $checkout_url;
	private $add_images_url;
	private $cart_images_url;
	private $small_images_prefix;
	private $medium_images_prefix;
	private $large_images_prefix;
	private $category_image_prefix;
	private $default_small_image;
	private $default_medium_image;
	private $default_category_image;

	private $current_load_timestamp;
	private $last_category_update_timestamp;
	private $categories_menu_cache_timestamps;

	private $create_product_sitemap;
	private $create_category_sitemap;
	private $last_sitemap_update_timestamp;

	private $url_rewrite_rules;

	private $configuration_options;

	private $search_for_products;
	private $search_for_categories;

	private $currency_code;
	private $currency_description;
	private $currency_sign;
	private $sign_align_right;
	private $code_align_right;
	private $prefer_code_over_sign;
	private $decimals;
	private $dec_point;
	private $thousands_sep;
	private $force_ssl_for_generated_urls;

	private $current_page;
	private $search_results;
	private $total_results_count;
	private $top_page;
	private $wp_title_already_processed;
	private $rel_canonical_filter_processed;
	private $meta_description_filter_processed;
	private $meta_keys_filter_processed;

	private $sub_categories = null;
	private $sub_categories_index = null;
	private $sub_categories_count = null;
	private $sub_category = null;

	private $category_products = null;
	private $category_products_index = null;
	private $category_products_count = null;
	private $category_product = null;

	private $features = null;
	private $feature_groups_index = null;
	private $feature_groups_count = null;
	private $feature_groups_keys = null;
	private $feature_group_name_id = null;
	private $feature_group = null;
	private $features_in_the_group = null;
	private $features_index = null;
	private $features_count = null;

	private $product_questions_and_answers = null;
	private $product_questions_and_answers_index = null;
	private $product_questions_and_answers_count = null;

	private $product_quantity_discounts = null;
	private $product_quantity_discounts_count = null;
	private $product_quantity_discounts_index = null;

	private $product_images = null;
	private $product_images_count = null;
	private $product_images_index = null;

	private $media_settings = null;

	private $product_media = null;
	private $product_media_count = null;
	private $product_media_index = null;

	private $product_media_gallery_start_at_index = null;

	private $category_media = null;
	private $category_media_count = null;
	private $category_media_index = null;

	private $sub_category_media = null;
	private $sub_category_media_count = null;
	private $sub_category_media_index = null;

	public static function log_me($message) {
	    if (WP_DEBUG === true) {
	        if (is_array($message) || is_object($message)) {
	            error_log(print_r($message, true));
	        } else {
	            error_log($message);
	        }
	    }
	}

	public function force_redirect($url)
	{
		echo('<meta http-equiv="refresh" content="0;url=' . $url . '" />');
		exit();
	}

	public static function get_default_key()
	{
		return '{9B7A2964-78CE-45DB-968E-725447AEB534}';
	}

	public function get_option($option_name)
	{
		$return = "";
		if (isset($this->configuration_options[$option_name]))
		{
			$return = $this->configuration_options[$option_name];
		}

		return $return;
	}

	public function checkout_url()
	{
		return $this->checkout_url;
	}

	public function add_images_url() {
		return $this->add_images_url;
	}

	public function build_product_category_page_link($cat_link, $link_to)
	{
		if (!is_null($link_to))
		{
			if (strlen(trim($link_to)))
			{
				return $link_to;
			}
		}

		$use_seo_friendly_product_category_links = (get_option('permalink_structure')?TRUE:FALSE);
		if ($use_seo_friendly_product_category_links)
		{
			$use_seo_friendly_product_category_links = $this->use_seo_friendly_product_category_links;
		}

		if ($this->force_ssl_for_generated_urls === TRUE) {
			$product_category_page_link = home_url('/', 'https');
		} else {
			$product_category_page_link = home_url('/');
		}
		if (!($this->product_category_page_id && $use_seo_friendly_product_category_links))
		{
			$product_category_page_link .= '?pagename=';
		}

		$product_category_page_link .= $this->product_category_page_slug;
		if (!($this->product_category_page_id && $use_seo_friendly_product_category_links))
		{
			$product_category_page_link .= '&cat_link=';
		}
		else
		{
			$product_category_page_link .= '/';
		}
		if (!empty($cat_link))
		{
			$product_category_page_link .= $cat_link;
			if ($use_seo_friendly_product_category_links)
			{
				$product_category_page_link .= '/';
			}
		}

		return $product_category_page_link;
	}

	public function build_product_page_link($product_link, $link_back)
	{
		if (!is_null($link_back))
		{
			if (strlen(trim($link_back)))
			{
				return $link_back;
			}
		}

		$use_seo_friendly_product_links = (get_option('permalink_structure')?TRUE:FALSE);
		if ($use_seo_friendly_product_links)
		{
			$use_seo_friendly_product_links = $this->use_seo_friendly_product_links;
		}

		if ($this->force_ssl_for_generated_urls === TRUE) {
			$product_page_link = home_url('/', 'https');
		} else {
			$product_page_link = home_url('/');
		}
		if (!($this->product_page_id && $use_seo_friendly_product_links))
		{
			$product_page_link .= '?pagename=';
		}

		$product_page_link .= $this->product_page_slug;
		if (!($this->product_page_id && $use_seo_friendly_product_links))
		{
			$product_page_link .= '&product_link=';
		}
		else
		{
			$product_page_link .= '/';
		}
		if (!empty($product_link))
		{
			$product_page_link .= $product_link;
			if ($use_seo_friendly_product_links)
			{
				$product_page_link .= '/';
			}
		}

		return $product_page_link;
	}

	public function build_category_image_url($name, $extension)
	{
		return $this->cart_images_url . $this->category_image_prefix . $name . '.' . strtolower($extension);
	}

	public function build_default_category_image_url()
	{
		return $this->default_category_image;
	}

	public function build_product_small_image_url($name, $extension)
	{
		return $this->cart_images_url . $this->small_images_prefix . '/' . $name . '.' . strtolower($extension);
	}

	public function build_default_product_small_image_url()
	{
		return $this->default_small_image;
	}

	public function build_product_medium_image_url($name, $extension)
	{
		return $this->cart_images_url . $this->medium_images_prefix . '/' . $name . '.' . strtolower($extension);
	}

	public function build_default_product_medium_image_url()
	{
		return $this->default_medium_image;
	}

	public function build_product_large_image_url($name, $extension)
	{
		return $this->cart_images_url . $this->large_images_prefix . '/' . $name . '.' . strtolower($extension);
	}

	public function do_not_render_left_sidebar()
	{
		$this->should_render_left_sidebar = FALSE;
	}

	public function should_left_sidebar_be_rendered()
	{
		$return = FALSE;

		if ($this->should_render_left_sidebar === TRUE)
		{
			$return = TRUE;
		}

		return $return;
	}

	public function do_not_render_right_sidebar()
	{
		$this->should_render_right_sidebar = FALSE;
	}

	public function should_right_sidebar_be_rendered()
	{
		$return = FALSE;

		if ($this->should_render_right_sidebar === TRUE)
		{
			$return = TRUE;
		}

		return $return;
	}

	public function do_not_render_categories_menu()
	{
		$this->should_render_categories_menu = FALSE;
	}

	public function should_categories_menu_be_rendered()
	{
		$return = FALSE;

		if ($this->should_render_categories_menu === TRUE)
		{
			$return = TRUE;
		}

		return $return;
	}

	public function zero_variable_if_null(&$variable)
	{
		if (isset($variable))
		{
			if (is_null($variable))
			{
				$variable = 0;
			}
		}
	}

	public function get_title_tag()
	{
		$return = '';

		if (isset($this->title_tag)) $return = $this->title_tag;

		return $return;
	}

	public function get_meta_description()
	{
		$return = '';

		if (isset($this->meta_description)) $return = $this->meta_description;

		return $return;
	}

	public function get_meta_keywords()
	{
		$return = '';

		if (isset($this->meta_keywords)) $return = $this->meta_keywords;

		return $return;
	}

	public function get_product_category_page_slug()
	{
		return $this->product_category_page_slug;
	}

	public function get_product_category_page_id()
	{
		return $this->product_category_page_id;
	}

	public function get_product_page_slug()
	{
		return $this->product_page_slug;
	}

	public function get_product_page_id()
	{
		return $this->product_page_id;
	}

	public function get_cart_images_url()
	{
		if (!is_null($this->cart_images_url))
		{
			return $this->cart_images_url;
		}
		else
		{
			return "";
		}
	}

	public function get_small_images_prefix()
	{
		if (!is_null($this->small_images_prefix))
		{
			return $this->small_images_prefix;
		}
		else
		{
			return "";
		}
	}

	public function get_medium_images_prefix()
	{
		if (!is_null($this->medium_images_prefix))
		{
			return $this->medium_images_prefix;
		}
		else
		{
			return "";
		}
	}

	public function get_large_images_prefix()
	{
		if (!is_null($this->large_images_prefix))
		{
			return $this->large_images_prefix;
		}
		else
		{
			return "";
		}
	}

	public function get_category_image_prefix()
	{
		if (!is_null($this->category_image_prefix))
		{
			return $this->category_image_prefix;
		}
		else
		{
			return "";
		}
	}

	public function get_default_small_image()
	{
		if (!is_null($this->default_small_image))
		{
			return $this->default_small_image;
		}
		else
		{
			return "";
		}
	}

	public function get_default_medium_image()
	{
		if (!is_null($this->default_medium_image))
		{
			return $this->default_medium_image;
		}
		else
		{
			return "";
		}
	}

	public function get_default_category_image()
	{
		if (!is_null($this->default_category_image))
		{
			return $this->default_category_image;
		}
		else
		{
			return "";
		}
	}

	public function get_current_load_timestamp()
	{
		return $this->current_load_timestamp;
	}

	public function delete_cached_category_menu($category_guid, $max_level)
	{
		delete_option($category_guid . $max_level);
		unset($this->categories_menu_cache_timestamps[$category_guid][$max_level]);
		if(!count($this->categories_menu_cache_timestamps[$category_guid] > 0))
		{
			unset($this->categories_menu_cache_timestamps[$category_guid]);
		}

		update_option('orderstorm_ecommerce_categories_menu_cache_timestamps', $this->categories_menu_cache_timestamps);
	}

	public function get_category_menu($parent_category_guid, $max_level)
	{
		$return = NULL;

		if (is_null($parent_category_guid))
		{
			$parent_category_guid = '{}';
		}

		if (is_null($max_level))
		{
			$max_level = 0;
		}

		$cached_category_menu_name = 'ostcm' . $parent_category_guid . $max_level;

		if ($parent_category_guid === '{}' || OrderStormECommerceForWordPress::isWellFormedGUID($parent_category_guid))
		{
			$categories_menu_cache_timestamp = NULL;

			if (!is_null($this->last_category_update_timestamp))
			{
				if (is_array($this->categories_menu_cache_timestamps))
				{
					if (array_key_exists($parent_category_guid, $this->categories_menu_cache_timestamps) && is_array($this->categories_menu_cache_timestamps[$parent_category_guid]))
					{
						if(array_key_exists($max_level, $this->categories_menu_cache_timestamps[$parent_category_guid]))
						{
							$categories_menu_cache_timestamp = $this->categories_menu_cache_timestamps[$parent_category_guid][$max_level];
						}
					}
				}
			}

			if (!is_null($categories_menu_cache_timestamp))
			{
				if ($categories_menu_cache_timestamp >= $this->last_category_update_timestamp)
				{
					if (false === ($return = get_option($cached_category_menu_name)))
					{
						$categories_menu_cache_timestamp = NULL;
						$this->delete_cached_category_menu($parent_category_guid, $max_level);
					}
				}
				else
				{
						$categories_menu_cache_timestamp = NULL;
						$this->delete_cached_category_menu($parent_category_guid, $max_level);
				}
			}

			if (is_null($categories_menu_cache_timestamp) || is_null($return) || ($return->rowCount() <= 0))
			{
				$return = $GLOBALS['osws']->get_category_tree_by_guid((($parent_category_guid === '{}')?NULL:$parent_category_guid), (($max_level === 0)?NULL:$max_level));
				delete_option($cached_category_menu_name);
				add_option($cached_category_menu_name, $return, '', 'no');
				$this->set_category_menu_timestamp($parent_category_guid, $max_level);
			}
		}

		return $return;
}

	public function set_category_menu_timestamp($parent_category_guid, $max_level)
	{
		if (!is_array($this->categories_menu_cache_timestamps))
		{
			$this->categories_menu_cache_timestamps = array();
		}
		if (!(array_key_exists($parent_category_guid, $this->categories_menu_cache_timestamps) && is_array($this->categories_menu_cache_timestamps[$parent_category_guid])))
		{
			$this->categories_menu_cache_timestamps[$parent_category_guid] = array();
		}
		$this->categories_menu_cache_timestamps[$parent_category_guid][$max_level] = $this->current_load_timestamp;

		update_option('orderstorm_ecommerce_categories_menu_cache_timestamps', $this->categories_menu_cache_timestamps);
	}

	public function delete_categories_menu_cache()
	{
		if (isset($this->categories_menu_cache_timestamps) && is_array($this->categories_menu_cache_timestamps))
		{
			foreach($this->categories_menu_cache_timestamps as $parent_category_guid => $timestamps_for_max_levels)
			{
				if (isset($timestamps_for_max_levels) && is_array($timestamps_for_max_levels))
				{
					foreach($timestamps_for_max_levels as $max_level => $timestamp)
					{
						delete_option('ostcm' . $parent_category_guid . $max_level);
					}
				}
			}
		}

		$this->categories_menu_cache_timestamps = array();
		update_option('orderstorm_ecommerce_categories_menu_cache_timestamps', $this->categories_menu_cache_timestamps);
	}

	public function __construct($configuration_options = array())
	{
		$this->configuration_options = $configuration_options;

		$this->should_render_left_sidebar = TRUE;
		$this->should_render_right_sidebar = TRUE;
		$this->should_render_categories_menu = TRUE;

		if (!session_id())
		{
			session_start();
		}

		$this->json_obj = new Moxiecode_JSON();
		$this->orderstorm_ecommerce_host_name  = get_option('orderstorm_ecommerce_host_name', '');
		$this->ecommerce_host_name = 'https://' . $this->orderstorm_ecommerce_host_name . '/orderstorm_ecommerce.os';
		$this->key_guid = get_option('orderstorm_ecommerce_key_guid', '');

		$this->title_tag = NULL;
		$this->meta_description = NULL;
		$this->meta_keywords = NULL;

		$this->meta_data = array();

		$this->category_display_left_sidebar = NULL;
		$this->category_display_right_sidebar = NULL;
		$this->category_display_categories_menu = NULL;
		$this->detail_display_left_sidebar = NULL;
		$this->detail_display_right_sidebar = NULL;
		$this->detail_display_categories_menu = NULL;
		$this->detail_product_name_editable_in_title = NULL;
		$this->names_in_title = NULL;
		$this->plugin_test_checkout = NULL;
		$this->checkout_url = NULL;
		$this->add_images_url = NULL;
		$this->cart_images_url = NULL;
		$this->small_images_prefix = NULL;
		$this->medium_images_prefix = NULL;
		$this->large_images_prefix = NULL;
		$this->category_image_prefix = NULL;
		$this->default_small_image = NULL;
		$this->default_medium_image = NULL;
		$this->default_category_image = NULL;
		$this->last_category_update_timestamp = NULL;
		$current_load_datetime = new DateTime();
		$this->current_load_timestamp = intval($current_load_datetime->format('U'), 10);
		unset($current_load_datetime);
		$this->categories_menu_cache_timestamps = get_option('orderstorm_ecommerce_categories_menu_cache_timestamps');
		$this->create_product_sitemap = NULL;
		$this->create_category_sitemap = NULL;
		$this->last_sitemap_update_timestamp = NULL;
		if ($this->categories_menu_cache_timestamps === FALSE)
		{
			$this->categories_menu_cache_timestamps = array();
			add_option('orderstorm_ecommerce_categories_menu_cache_timestamps', $this->categories_menu_cache_timestamps, '', 'yes');
		}

		$this->current_page = NULL;
		$this->search_results = NULL;
		$this->total_results_count = NULL;
		$this->top_page = NULL;

		$this->search_for_products = NULL;
		$this->search_for_categories = NULL;
		$this->currency_code = NULL;
		$this->currency_description = NULL;
		$this->currency_sign = NULL;
		$this->sign_align_right = NULL;
		$this->code_align_right = NULL;
		$this->prefer_code_over_sign = NULL;
		$this->decimals = NULL;
		$this->dec_point = NULL;
		$this->thousands_sep = NULL;
		$this->force_ssl_for_generated_urls = FALSE;

		$cart_info_for_plugin = $this->get_cart_info_for_plugin();
		$meta_data = $cart_info_for_plugin->metaData();
		$this->meta_data = array_merge_recursive($this->meta_data, $meta_data);
		if (array_key_exists('ckp', $this->meta_data)) {
			if (!OrderStormECommerceForWordPress::isWellFormedGUID($this->meta_data['ckp'])) {
				$this->meta_data['ckp'] = null;
			}
		} else {
			$this->meta_data['ckp'] = null;
		}
		if ($cart_info_for_plugin->rowCount() > 0)
		{
			$cart_info_for_plugin = $cart_info_for_plugin->row(0);
			$this->category_display_left_sidebar = $cart_info_for_plugin['category_display_left_sidebar'];
			$this->category_display_right_sidebar = $cart_info_for_plugin['category_display_right_sidebar'];
			$this->category_display_categories_menu = $cart_info_for_plugin['category_display_categories_menu'];
			$this->detail_display_left_sidebar = $cart_info_for_plugin['detail_display_left_sidebar'];
			$this->detail_display_right_sidebar = $cart_info_for_plugin['detail_display_right_sidebar'];
			$this->detail_display_categories_menu = $cart_info_for_plugin['detail_display_categories_menu'];
			$this->detail_product_name_editable_in_title = $cart_info_for_plugin['detail_product_name_editable_in_title'];
			$this->names_in_title = $cart_info_for_plugin["names_in_title"];
			$this->plugin_test_checkout = $cart_info_for_plugin['plugin_test_checkout'];
			$this->checkout_url = $cart_info_for_plugin['checkout_url'];
			$this->add_images_url = 'https://orderstormapp.appspot.com/image-upload';
			$this->cart_images_url = $cart_info_for_plugin['cart_images_url'];
			$this->small_images_prefix = $cart_info_for_plugin['small_images_prefix'];
			$this->medium_images_prefix = $cart_info_for_plugin['med_images_prefix'];
			$this->large_images_prefix = $cart_info_for_plugin['lg_images_prefix'];
			$this->category_image_prefix = $cart_info_for_plugin['category_image_prefix'];
			$this->default_small_image = $cart_info_for_plugin['default_s'];
			$this->default_medium_image = $cart_info_for_plugin['default_m'];
			$this->default_category_image = $cart_info_for_plugin['default_cat'];

			$this->product_category_page_slug = $cart_info_for_plugin['product_categories_page_slug'];
			$this->product_page_slug = $cart_info_for_plugin['product_page_slug'];

			$this->use_seo_friendly_product_category_links = $cart_info_for_plugin['seo_category_links'];
			$this->use_seo_friendly_product_links = $cart_info_for_plugin['seo_product_links'];

			$this->product_category_page_id = OrderStormECommerceForWordPress::get_page_id_by_slug($this->product_category_page_slug);
			$this->product_page_id = OrderStormECommerceForWordPress::get_page_id_by_slug($this->product_page_slug);

			$this->create_product_sitemap = $cart_info_for_plugin['create_product_sitemap'];
			$this->create_category_sitemap = $cart_info_for_plugin['create_category_sitemap'];

			try
			{
				$last_category_update = new DateTime($cart_info_for_plugin['category_updated']);
				$this->last_category_update_timestamp = intval($last_category_update->format('U'), 10);
				unset($last_category_update);
			}
			catch(Exception $e)
			{
				$this->last_category_update_timestamp = NULL;
			}

			try
			{
				$last_sitemap_update = new DateTime($cart_info_for_plugin['sitemap_updated']);
				$this->last_sitemap_update_timestamp = intval($last_sitemap_update->format('U'), 10);
				unset($last_sitemap_update);
			}
			catch(Exception $e)
			{
				$this->last_sitemap_update_timestamp = NULL;
			}

			$this->search_for_products = $cart_info_for_plugin['product_search'];
			$this->search_for_categories = $cart_info_for_plugin['cat_search'];
			$this->currency_code = $cart_info_for_plugin['currency_code'];
			$this->currency_description = $cart_info_for_plugin['currency_description'];
			$this->currency_sign = $cart_info_for_plugin['currency_sign'];
			$this->sign_align_right = $cart_info_for_plugin['sign_align_right'];
			$this->code_align_right = $cart_info_for_plugin['code_align_right'];
			$this->prefer_code_over_sign = $cart_info_for_plugin['prefer_code_over_sign'];
			$this->decimals = $cart_info_for_plugin['decimals'];
			$this->dec_point = $cart_info_for_plugin['dec_point'];
			$this->thousands_sep = $cart_info_for_plugin['thousands_sep'];
			$this->force_ssl_for_generated_urls = $cart_info_for_plugin['all_ssl'];

			$cart_media_settings = $this->get_cart_media_settings_header();
			$media_settings_count = $cart_media_settings->rowCount();
			if ($media_settings_count > 0)
			{
				$this->media_settings = array();
				for ($counter = 0; $counter < $media_settings_count; $counter++) {
					$media_setting = $cart_media_settings->row($counter);
					$media_setting_name = $media_setting['name'];
					if (!isset($this->media_settings[$media_setting_name])) {
						$this->media_settings[$media_setting_name] = array();
					}
					$this->media_settings[$media_setting_name]['display_type_key'] = $media_setting['slide_display_type_key'];
				}
				$media_setting_names = array_keys($this->media_settings);
				foreach ($media_setting_names as $media_setting_name) {
					$media_sizes = $this->get_sizes_for_a_cart_media_setting($this->media_settings[$media_setting_name]['display_type_key']);
					$media_sizes_count = $media_sizes->rowCount();
					for ($counter = 0; $counter < $media_sizes_count; $counter++) {
						$media_size = $media_sizes->row($counter);
						if (!isset($this->media_settings[$media_setting_name]['layers'])) {
							$this->media_settings[$media_setting_name]['layers'] = array();
						}
						$layer_type_id = $media_size['slide_layer_type_id'];
						$layer_property_name = $media_size['name'];
						$layer_property_value = $media_size['value'];
						if (!isset($this->media_settings[$media_setting_name]['layers'][$layer_type_id])) {
							$this->media_settings[$media_setting_name]['layers'][$layer_type_id] = array();
						}
						$this->media_settings[$media_setting_name]['layers'][$layer_type_id][$layer_property_name] = $layer_property_value;
					}
				}
			}
		}

		$this->url_rewrite_rules = array();
		$this->url_rewrite_rules[] = array
		(
			FALSE,
			array(),
			'os1bilco2015'
		);
		$this->url_rewrite_rules[] = array
		(
			TRUE,
			array('orderstorm-pp-cancel-url$' => 'index.php?pp_cancel_url=true'),
			'token'
		);
		$this->url_rewrite_rules[] = array
		(
			TRUE,
			array('orderstorm-pp-return-url$' => 'index.php?pp_return_url=true'),
			'PayerID'
		);
		$this->url_rewrite_rules[] = array
		(
			FALSE,
			array(),
			'pp_return_url'
		);
		$this->url_rewrite_rules[] = array
		(
			FALSE,
			array(),
			'pp_cancel_url'
		);
		$this->url_rewrite_rules[] = array
		(
			(OrderStormECommerceForWordPress::is_page_published($this->product_category_page_id) && $this->use_seo_friendly_product_category_links)?TRUE:FALSE,
			array('(' . $this->product_category_page_slug . ')/([^/]*)/page/([1-9]{1}[0-9]*)(/|)$' => 'index.php?pagename=$matches[1]&cat_link=$matches[2]&page_number=$matches[3]'),
			'page_number'
		);
		$this->url_rewrite_rules[] = array
		(
			(OrderStormECommerceForWordPress::is_page_published($this->product_category_page_id) && $this->use_seo_friendly_product_category_links)?TRUE:FALSE,
			array('(' . $this->product_category_page_slug . ')/([^/]*)(/|)$' => 'index.php?pagename=$matches[1]&cat_link=$matches[2]'),
			'cat_link'
		);
		$this->url_rewrite_rules[] = array
		(
			(OrderStormECommerceForWordPress::is_page_published($this->product_page_id) && $this->use_seo_friendly_product_links)?TRUE:FALSE,
			array('(' . $this->product_page_slug . ')/([^/]*)(/|)$' => 'index.php?pagename=$matches[1]&product_link=$matches[2]'),
			'product_link'
		);
		$this->wp_title_already_processed = false;
		$this->rel_canonical_filter_processed = false;
		$this->meta_description_filter_processed = false;
		$this->meta_keys_filter_processed = false;
	}

	public function get_orderstorm_ecommerce_host_name() {
		return $this->orderstorm_ecommerce_host_name;
	}

	public function get_url_rewrite_rules()
	{
		$rules = array();
		foreach($this->url_rewrite_rules as $rule)
		{
			if ($rule[0] === TRUE)
			{
				$rules = $rules + $rule[1];
			}
		}

		return $rules;
	}

	public function add_rewrite_query_vars($vars)
	{
		foreach($this->url_rewrite_rules as $rule)
		{
			array_push($vars, $rule[2]);
		}

		return $vars;
	}

	public function need_to_flush_rules()
	{
		global $wp_rewrite;

		$result = FALSE;

		$current_rules = $wp_rewrite->rules;
		if (!is_array($current_rules))
		{
			$current_rules = array();
		}

		foreach($this->url_rewrite_rules as $rule)
		{
			$rule_key = key($rule[1]);
			$rule_value = current($rule[1]);

			if ($rule[0] === TRUE)	// should be an active rule
			{
				$keys_found = array_keys($input = $current_rules, $search_value = $rule_value, $strict = TRUE);
				if (count($keys_found) !== 1)
				{
					$result = TRUE;
				}
				else
				{
					if($keys_found[0] !== $rule_key)
					{
						$result = TRUE;
					}
				}
			}
			else	// should be an inactive rule
			{
				if (in_array($needle = $rule_value, $haystack = $current_rules, $strict = TRUE))
				{
					$result = TRUE;
				}
			}
		}

		return $result;
	}

	public function get_use_seo_friendly_product_category_links()
	{
		$result = FALSE;

		if($this->use_seo_friendly_product_category_links)
		{
			$result = TRUE;
		}

		return $result;
	}

	public function get_use_seo_friendly_product_links()
	{
		$result = FALSE;

		if($this->use_seo_friendly_product_links)
		{
			$result = TRUE;
		}

		return $result;
	}

	public function get_create_product_sitemap()
	{
		$result = FALSE;

		if($this->create_product_sitemap)
		{
			$result = TRUE;
		}

		return $result;
	}

	public function get_create_category_sitemap()
	{
		$result = FALSE;

		if($this->create_category_sitemap)
		{
			$result = TRUE;
		}

		return $result;
	}

	public function get_display_categories_in_search()
	{
		$result = FALSE;

		if($this->search_for_categories)
		{
			$result = TRUE;
		}

		return $result;
	}

	public function get_display_products_in_search()
	{
		$result = FALSE;

		if($this->search_for_products)
		{
			$result = TRUE;
		}

		return $result;
	}

	public static function trigger_error_on_error_scrape($error_message, $error_number = E_USER_NOTICE)
	{
		if(isset($_GET['action']))
		{
			if ($_GET['action'] === 'error_scrape')
			{
				echo('<strong>' . $error_message . '</strong>');
				exit();
			}
		}
		else
		{
			trigger_error($error_message, $error_number);
		}
	}

	public static function plugin_custom_configuration_url_path()
	{
		return rtrim(plugin_dir_url(__FILE__), '/') . '-custom';
	}

	public static function plugin_full_path()
	{
		return dirname(__FILE__);
	}

	public static function plugin_basename()
	{
		return basename(dirname(__FILE__));
	}

	public static function plugin_parent_directory()
	{
		return dirname(dirname(__FILE__));
	}

	public static function plugin_custom_configuration_path()
	{
		return dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . basename(dirname(__FILE__)) . '-custom';
	}

	public static function add_to_cart_url()
	{
		return OrderStormECommerceForWordPress::plugin_default_configuration_url() . '/add-to-cart.php';
	}

	public static function isWellFormedGUID($strGUID)
	{
		return !empty($strGUID) && preg_match('/^\{[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}\}$/', $strGUID);
	}

	public static function isGUIDwithoutBraces($strGUID)
	{
		return !empty($strGUID) && preg_match('/^[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}$/', $strGUID);
	}

	public static function isAllNumericDigits($input)
	{
		return(ctype_digit(strval($input)));
	}

	public static function isValidIPv4address($ip_address)
	{
		$ValidIpAddressRegex = '/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/';

		return preg_match($ValidIpAddressRegex, $ip_address);
	}

	public static function isValidHostName($host_name)
	{
		$ValidHostnameRegex = '/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\\-]*[a-zA-Z0-9])\\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\\-]*[A-Za-z0-9])$/';

		return preg_match($ValidHostnameRegex, $host_name);
	}

	public static function curl_fetch_ajax($url, array $arguments = NULL, $ssl = FALSE, $post = FALSE, $timeout = 15)
	{
		$options = array(
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_TIMEOUT => $timeout,
		);
		if ($ssl === TRUE)
		{
			$options[CURLOPT_SSLVERSION] = 3;
			$options[CURLOPT_SSL_VERIFYPEER] = !get_option('orderstorm_ecommerce_do_not_verify_ssl_peer_certificate', FALSE);
			$options[CURLOPT_SSL_VERIFYHOST] = 2;
		}
		if ($post === TRUE)
		{
			$options[CURLOPT_URL] = $url;
			$options[CURLOPT_POST] = 1;
			$options[CURLOPT_FRESH_CONNECT] = 1;
			$options[CURLOPT_FORBID_REUSE] = 1;
			$options[CURLOPT_POSTFIELDS] = http_build_query($arguments);
		}
		else
		{
			$options[CURLOPT_URL] = $url . '?' . http_build_query($arguments);
		}

		$handle = curl_init();
		curl_setopt_array($handle, $options);

		$output = curl_exec($handle);
		if (curl_errno($handle) !== 0)
		{
			$output = '{"curl_fetch_ajax_error":{"errno":' . curl_errno($handle) . ',"error":"' . curl_error($handle) . '"}}';
		}
		return $output;
	}

	public static function get_page_id_by_slug($page_slug)
	{
    	$page = get_page_by_path($page_slug);
		if ($page)
		{
			return $page->ID;
		}
		else
		{
			return null;
		}
	}

	public static function is_page_published($page_id)
	{
		$return = FALSE;

		$page_data = get_page($page_id);

		if(is_object($page_data))
		{
			if($page_data->post_status === 'publish')
			{
				$return = TRUE;
			}
		}

		return $return;
	}

	public static function get_boolean_option_value($option_name)
	{
		$result = get_option($option_name);
		if (empty($result))
		{
			$result = FALSE;
		}
		else
		{
			if ($result)
			{
				$result = TRUE;
			}
			else
			{
				$result = FALSE;
			}
		}

		return $result;
	}

	public function get_tld_list()
	{
		return	$this->request_service
				(
					'get_tld_list',
					array
					(
					),
					180
				);
	}

	public function get_site_map()
	{
		return	$this->request_service
				(
					'site_map',
					array
					(
					),
					180
				);
	}

	public function cancel_pp_express_checkout_transaction($token)
	{
		return	$this->request_service
				(
					'cancel_pp_express_checkout_transaction',
					array
					(
						'token' => $token
					)
				);
	}

	public function get_pp_express_checkout_transaction_details($token, $payerId)
	{
		return	$this->request_service
				(
					'get_pp_express_checkout_transaction_details',
					array
					(
						'token' => $token,
						'payer_id' => $payerId
					)
				);
	}

	public function search_products_and_categories()
	{
		global $wp_query;

		if ($GLOBALS['wp_query'] === $wp_query)
		{
			$this->current_page = intval($wp_query->get('paged'));
			if (empty($this->current_page)) $this->current_page = 1;

			$ip = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:null;
			$this->search_results =	$this->request_service
									(
										'search_products_and_categories_for_plugin',
										array
										(
											'search_text' => get_search_query($escaped = false),
											'results_per_page' => intval(get_option('posts_per_page')),
											'current_page' => $this->current_page,
											'ip' => $ip
										)
									);
			$search_results_metadata = $this->search_results->metaData();
			$this->total_results_count = $search_results_metadata['TotalResultsCount'];
			$this->top_page = $search_results_metadata['TopPage'];
		}
		else
		{
			$this->search_results = array();

			$this->search_results[] = array();
			$this->search_results[] = array();
			$this->search_results[] = null;
		}
	}

	public function wp_filter_pre_get_posts_for_search($wp_query)
	{
		if ($this->search_for_products || $this->search_for_categories)
		{
			if (!is_admin() && $GLOBALS['wp_query'] === $wp_query)
			{
				if ($wp_query->is_search())
				{
					$this->search_products_and_categories();
				}
			}
		}

		return $wp_query;
	}

	public function wp_filter_the_posts_for_search($posts)
	{
		global $wp_query;

		if ($this->search_for_products || $this->search_for_categories)
		{
			if (!is_admin() && $GLOBALS['wp_query'] === $wp_query)
			{
				$current_datetime = new DateTime();

				if ($wp_query->is_search())
				{
					$local_results = $wp_query->found_posts;
					$osws_results_count = $this->search_results->rowCount();
					$locally_found_posts = $posts;
					$osws_posts = array();
					for ($counter = 0; $counter < $osws_results_count; $counter++)
					{
						$type = $this->search_results->fieldValue($counter, 'type');

						$post = new stdClass();
						$post->guid = $this->search_results->fieldValue($counter, 'pg_link');
						$post->link_override = $this->search_results->fieldValue($counter, 'link_override');
						$post->post_author = '1';
						$post->post_date = $current_datetime->format('Y-m-d H:i:s');
						$post->post_type = ($type === 'P'?'orderstorm-product':($type === 'C'?'orderstorm-category':'?'));
						$post->post_title = $this->search_results->fieldValue($counter, 'name');
						$post->post_content = $this->search_results->fieldValue($counter, 'short_description');
						if (empty($post->post_content))
						{
							$post->post_excerpt = null;
						}
						$post->post_status = 'closed';
						$post->comment_status = 'closed';
						$post->ping_status = 'closed';
						array_push
						(
							$osws_posts,
							$post
						);
					}

					$locally_found_posts_count = count($locally_found_posts);
					if ($locally_found_posts_count > 0)
					{
						for ($counter = 0; $counter < $locally_found_posts_count; $counter++)
						{
							array_push($osws_posts, $locally_found_posts[$counter]);
						}
					}

					if (count($osws_posts) === intval(get_option('posts_per_page')))
					{
						if ($this->current_page === 1)
						{
							$wp_query->max_num_pages = 2;
						}
						else
						{
							$wp_query->max_num_pages = $this->current_page + 1;
						}
					}
					else
					{
						if (((intval(get_option('posts_per_page')) * ($this->current_page - 1)) + count($osws_posts) + $locally_found_posts_count) <= (intval(get_option('posts_per_page')) * $this->current_page))
						{
							$wp_query->max_num_pages = $this->current_page;
						}
					}

					return $osws_posts;
				}
				else
				{
					return $posts;
				}
			}
			else
			{
				return $posts;
			}
		}
		else
		{
			return $posts;
		}
	}

	public function wp_filter_post_limits_for_search($limits)
	{
		global $wp_query;

		if ($this->search_for_products || $this->search_for_categories)
		{
			if (!is_admin() && $GLOBALS['wp_query'] === $wp_query)
			{
				if ($wp_query->is_search())
				{
					$local_results_first_quantity = ($this->top_page * intval(get_option('posts_per_page'))) - $this->total_results_count;
					$limits = '';
					$lower_limit = 0;
					$quantity = 0;
					if ($this->current_page < $this->top_page)
					{
						$lower_limit = 0;
						$quantity = 0;
					}
					elseif ($this->current_page === $this->top_page)
					{
						$lower_limit = 0;
						$quantity = $local_results_first_quantity;
					}
					else
					{
						$lower_limit = $local_results_first_quantity + (($this->current_page - $this->top_page - 1) * intval(get_option('posts_per_page')));
						$quantity = intval(get_option('posts_per_page'));
					}

					$limits = 'LIMIT ' . $lower_limit .',' . $quantity;
				}
			}
		}

		return $limits;
	}

	public function wp_filter_the_permalink_for_search($permalink)
	{
		global $wp_query;

		if ($this->search_for_products || $this->search_for_categories)
		{
			if (!is_admin() && $GLOBALS['wp_query'] === $wp_query)
			{
				if ($wp_query->is_search())
				{
					switch ($wp_query->post->post_type)
					{
						case 'orderstorm-product':
							$permalink = $this->build_product_page_link($wp_query->post->guid, $wp_query->post->link_override);
							break;
						case 'orderstorm-category':
							$permalink = $this->build_product_category_page_link($wp_query->post->guid, $wp_query->post->link_override);
							break;
					}
				}
			}
		}

		return $permalink;
	}

	public function wp_filter_excerpt_more_for_search($more)
	{
		global $wp_query;

		if ($this->search_for_products || $this->search_for_categories)
		{
			if (!is_admin() && $GLOBALS['wp_query'] === $wp_query)
			{
				if ($wp_query->is_search())
				{
					if ($wp_query->post->post_type === 'orderstorm-product' || $wp_query->post->post_type === 'orderstorm-category')
					{
						$more = ' &hellip; <a href="'. esc_url($this->wp_filter_the_permalink_for_search(get_permalink())) . '">' . __('Continue reading <span class="meta-nav">&rarr;</span>', 'orderstorm-wordpress-e-commerce') . '</a>';
						$more = apply_filters('orderstorm-wordpress-e-commerce-excerpt-more', $more);
					}
				}
			}
		}

		return $more;
	}

	private function performAJAXrequest($ajax_request, $timeout = 15)
	{
		return	$this->json_obj->decode
				(
					$this->curl_fetch_ajax
					(
						$this->ecommerce_host_name,
						$ajax_request,
						TRUE,
						TRUE,
						$timeout
					)
				);
	}

	private function get_category_tree_by_guid($from_category_guid = NULL, $how_many_levels_deep = NULL)
	{
		return	$this->request_service
				(
					'get_category_tree_by_guid',
					array
					(
						'from_category_guid' => $from_category_guid,
						'how_many_levels_deep' => $how_many_levels_deep
					)
				);
	}

	private function get_category_by_page_link($page_link)
	{
		return	$this->request_service
				(
					'get_category_by_page_link',
					array
					(
						'page_link' => $page_link
					)
				);
	}

	public function get_category_by_category_guid($category_guid)
	{
		return	$this->request_service
				(
					'get_category_by_category_guid',
					array
					(
						'category_guid' => $category_guid
					)
				);
	}

	private function get_category_info_by_guid($category_guid)
	{
		return	$this->request_service
				(
					'get_category_info_by_guid',
					array
					(
						'category_guid' => $category_guid
					)
				);
	}

	private function get_categories($category_guid)
	{
		return	$this->request_service
				(
					'get_categories',
					array
					(
						'category_guid' => $category_guid
					)
				);
	}

	private function get_products($category_guid)
	{
		$products =	$this->request_service
					(
						'get_products_paginated',
						array
						(
							'category_guid' => $category_guid,
							'current_page' => $this->current_page
						)
					);
		$products_metadata = $products->metaData();
		if (isset($products_metadata['TotalResultsCount'])) $this->total_results_count = $products_metadata['TotalResultsCount'];
		if (isset($products_metadata['TopPage'])) $this->top_page = $products_metadata['TopPage'];

		return $products;
	}

	private function get_product_by_page_link($page_link)
	{
		return	$this->request_service
				(
					'get_product_by_page_link',
					array
					(
						'page_link' => $page_link
					)
				);
	}

	public function get_product_by_product_guid($product_guid)
	{
		return	$this->request_service
				(
					'get_product_by_product_guid',
					array
					(
						'product_guid' => $product_guid
					)
				);
	}

	private function get_product_information_for_shortcodes($product_guid)
	{
		return	$this->request_service
				(
					'get_product_information_for_shortcodes',
					array
					(
						'product_guid' => $product_guid
					)
				);
	}

	private function get_product_details($product_guid)
	{
		return	$this->request_service
				(
					'get_product_details',
					array
					(
						'product_guid' => $product_guid
					)
				);
	}

	private function get_product_meta_tags($product_guid)
	{
		return	$this->request_service
				(
					'get_product_meta_tags',
					array
					(
						'product_guid' => $product_guid
					)
				);
	}

	private function get_vendor_for_product($product_id)
	{
		return	$this->request_service
				(
					'get_vendor_for_product',
					array
					(
						'product_id' => $product_id
					)
				);
	}

	private function get_product_images($product_id)
	{
		return	$this->request_service
				(
					'get_product_images',
					array
					(
						'product_id' => $product_id
					)
				);
	}

	private function get_product_features($product_id)
	{
		return	$this->request_service
				(
					'get_product_features',
					array
					(
						'product_id' => $product_id
					)
				);
	}

	private function get_questions_and_answers_for_a_product($product_id)
	{
		return	$this->request_service
				(
					'get_questions_and_answers_for_a_product',
					array
					(
						'product_id' => $product_id
					)
				);
	}

	private function get_product_quantity_discounts($product_guid)
	{
		return	$this->request_service
				(
					'get_product_quantity_discounts_WS',
					array
					(
						'product_guid' => $product_guid
					)
				);
	}

	private function get_order_summary($order_key_guid)
	{
		return	$this->request_service
				(
					'get_order_summary',
					array
					(
						'order_key_guid' => $order_key_guid
					)
				);
	}

	private function get_cart_info_for_plugin()
	{
		return	$this->request_service
				(
					'get_cart_info_for_plugin',
					array
					(
					)
				);
	}

	private function get_cart_media_settings_header() {
		return	$this->request_service(
			'get_cart_media_settings_header',
			array(
			)
		);
	}

	private function get_sizes_for_a_cart_media_setting($display_type_key) {
		return	$this->request_service(
			'get_sizes_for_a_cart_media_setting',
			array(
				'display_type_key' => $display_type_key
			)
		);
	}

	private function get_cart_media($display_type_key, $media_key) {
		return	$this->request_service(
			'get_cart_media',
			array(
				'display_type_key' => $display_type_key,
				'media_key' => $media_key
			)
		);
	}

	private function request_service($service, $arguments, $timeout = 15)
	{
		$ajax_request =	array
						(
							'AJAX_Request' => $this->json_obj->encode
							(
								array
								(
									'key_GUID' => $this->key_guid,
									'session_id' => session_id(),
									'service' => $service,
									'arguments' => $arguments
								)
							)
						);

		return new jsonResultSet($this->performAJAXrequest($ajax_request, $timeout));
	}

	private function get_html_draw($product_key)
	{
		return	$this->request_service
				(
					'get_html_draw_WS',
					array
					(
						'product_key' => $product_key
					)
				);
	}

	private function set_property_if_valid_string($string, &$property)
	{
		if (!is_null($string))
		{
			$string = trim(strval($string));
			if (!empty($string))
			{
				$property = $string;
			}
		}
	}

	public function prepare_category_information($cat_link = null)
	{
		global $wp_query;

		if (!($this->category_display_left_sidebar === true))
		{
			$this->do_not_render_left_sidebar();
		}
		if (!($this->category_display_right_sidebar === true))
		{
			$this->do_not_render_right_sidebar();
		}
		if (!($this->category_display_categories_menu === true))
		{
			$this->do_not_render_categories_menu();
		}

		$this->category_link = NULL;
		$this->category_data = array();
		$category_info = NULL;
		$category_guid = NULL;

		if (is_null($cat_link))
		{
			if (isset($wp_query->query_vars['cat_link']) && strlen(trim($wp_query->query_vars['cat_link'])) > 0)
			{
				$this->category_link = $wp_query->query_vars['cat_link'];
			}
		}
		else
		{
			$this->category_link = $cat_link;
		}
		if (isset($wp_query->query_vars['page_number']) && strlen(trim($wp_query->query_vars['page_number'])) > 0 && ctype_digit($wp_query->query_vars['page_number']))
		{
			$this->current_page = intval($wp_query->query_vars['page_number']);
		}
		else
		{
			$this->current_page = 1;
		}

		if (!empty($this->category_link))
		{
			if (OrderStormECommerceForWordPress::isWellFormedGUID($this->category_link) || OrderStormECommerceForWordPress::isGUIDwithoutBraces($this->category_link))
			{
				$category_guid = $this->category_link;
				if (OrderStormECommerceForWordPress::isGUIDwithoutBraces($category_guid))
				{
					$category_guid = "{" . $category_guid . "}";
				}

				$category_info = $this->get_category_by_category_guid($category_guid);
				if ($category_info->rowCount() > 0)
				{
					$this->category_link = $category_info->fieldValue(0, 'pg_link');
				}
			}

			$category_info = $this->get_category_by_page_link($this->category_link);
			if ($category_info->rowCount() > 0)
			{
				$category_guid = $category_info->fieldValue(0, 'category_guid');
			}
		}

		if (!empty($category_guid))
		{
			if (OrderStormECommerceForWordPress::isWellFormedGUID($category_guid))
			{
				$category_info = $this->get_category_info_by_guid($category_guid);
				if ($category_info->rowCount() === 1)
				{
					$this->category_data['guid'] = $category_guid;

					$row = $category_info->row(0);
					foreach ($row as $key => $value)
					{
						$this->category_data[$key] = $value;
					}
					$this->set_property_if_valid_string($category_info->fieldValue(0, 'meta_description'), $this->meta_description);
					$this->set_property_if_valid_string($category_info->fieldValue(0, 'meta_keywords'), $this->meta_keywords);
					if (!empty($this->category_data['html_title']))
					{
						$this->set_property_if_valid_string(trim($this->category_data['html_title']), $this->title_tag);
					}
					else
					{
						if (!is_null($this->category_data['category_description']))
						{
							$this->set_property_if_valid_string(htmlentities(trim($this->category_data['category_description'])), $this->title_tag);
						}
					}
				}
			}
		}
		else
		{
			$this->category_data['guid'] = '0';
		}
	}

	public function category_description_is_not_empty() {
		return isset($this->category_data['category_description']) && trim($this->category_data['category_description']) != false;
	}

	public function get_category_description()
	{
		$result = '';

		if ($this->category_description_is_not_empty()) {
			$result = $this->category_data['category_description'];
		}

		return $result;
	}

	public function category_long_description_is_not_empty() {
		return isset($this->category_data['category_long_description']) && trim($this->category_data['category_long_description']) != false;
	}

	public function get_category_long_description()
	{
		$result = '';

		if ($this->category_long_description_is_not_empty()) {
			$result = $this->category_data['category_long_description'];
		}

		return $result;
	}

	private function get_html_drawing_for_product($product_key)
	{
		$return = "";

		if ($this->isWellFormedGUID($product_key))
		{
			$product_html_drawing = $this->get_html_draw($product_key);
			if ($product_html_drawing->rowCount() === 1)
			{
				$return = $product_html_drawing->fieldValue(0, 'html_draw');
			}
		}

		return $return;
	}

	public function product_has_html5_drawing()
	{
		$return = FALSE;

		if (isset($this->product_data) && is_array($this->product_data) && isset($this->product_data['html_drawing']))
		{
			$return = TRUE;
		}

		return $return;
	}

	public function prepare_product_information_for_shortcodes($product_link = null)
	{
		$this->product_link_for_shortcodes = $product_link;
		$this->product_data_for_shortcodes = array();
		$product_info = null;
		$product_guid = null;

		if (!empty($this->product_link_for_shortcodes))
		{
			if (OrderStormECommerceForWordPress::isWellFormedGUID($this->product_link_for_shortcodes) || OrderStormECommerceForWordPress::isGUIDwithoutBraces($this->product_link_for_shortcodes))
			{
				$product_guid = $this->product_link_for_shortcodes;
				if (OrderStormECommerceForWordPress::isGUIDwithoutBraces($product_guid))
				{
					$product_guid = "{" . $product_guid . "}";
				}

				$product_info = $this->get_product_by_product_guid($product_guid);
				if ($product_info->rowCount() > 0)
				{
					$this->product_link_for_shortcodes = $product_info->fieldValue(0, 'pg_link');
				}
			}

			if (is_null($product_guid))
			{
				$product_info = $this->get_product_by_page_link($this->product_link_for_shortcodes);
				if ($product_info->rowCount() > 0)
				{
					$product_guid = $product_info->fieldValue(0, 'product_guid');
				}
			}
		}

		if (!empty($product_guid))
		{
			if ($this->isWellFormedGUID($product_guid))
			{
				$product_details = $this->get_product_information_for_shortcodes($product_guid);
				$meta_data = $product_details->metaData();
				$this->meta_data = array_merge_recursive($this->meta_data, $meta_data);
				if ($product_details->rowCount() === 1)
				{
					$this->product_data['guid'] = $product_guid;

					$row = $product_details->row(0);
					foreach ($row as $key => $value)
					{
						$this->product_data_for_shortcodes[$key] = $value;
					}
				}
			}
		}
	}

	public function prepare_product_information($product_link = null, $output_javascript_data = true)
	{
		global $wp_query;

		if (!($this->detail_display_left_sidebar === true))
		{
			$this->do_not_render_left_sidebar();
		}
		if (!($this->detail_display_right_sidebar === true))
		{
			$this->do_not_render_right_sidebar();
		}
		if (!($this->detail_display_categories_menu === true))
		{
			$this->do_not_render_categories_menu();
		}

		$this->product_link = null;
		$this->product_data = array();
		$product_info = null;
		$product_guid = null;
		$product_has_an_html_drawing = FALSE;
		$product_html_drawing = '';

		if (is_null($product_link))
		{
			if (isset($wp_query->query_vars['product_link']) && strlen(trim($wp_query->query_vars['product_link'])) > 0)
			{
				$this->product_link = $wp_query->query_vars['product_link'];
			}
		}
		else
		{
			$this->product_link = $product_link;
		}
		if ($output_javascript_data === true)
		{
			$this->product_data['features_for_js'] = array();
		}

		if (!empty($this->product_link))
		{
			if (OrderStormECommerceForWordPress::isWellFormedGUID($this->product_link) || OrderStormECommerceForWordPress::isGUIDwithoutBraces($this->product_link))
			{
				$product_guid = $this->product_link;
				if (OrderStormECommerceForWordPress::isGUIDwithoutBraces($product_guid))
				{
					$product_guid = "{" . $product_guid . "}";
				}

				$product_info = $this->get_product_by_product_guid($product_guid);
				if ($product_info->rowCount() > 0)
				{
					$this->product_link = $product_info->fieldValue(0, 'pg_link');
				}
			}

			$product_info = $this->get_product_by_page_link($this->product_link);
			if ($product_info->rowCount() > 0)
			{
				$product_guid = $product_info->fieldValue(0, 'product_guid');
			}
		}

		if (!empty($product_guid))
		{
			if ($this->isWellFormedGUID($product_guid))
			{
				$product_details = $this->get_product_details($product_guid);
				$meta_data = $product_details->metaData();
				$this->meta_data = array_merge_recursive($this->meta_data, $meta_data);
				if ($product_details->rowCount() === 1)
				{
					$this->product_data['guid'] = $product_guid;

					$row = $product_details->row(0);
					foreach ($row as $key => $value)
					{
						$this->product_data[$key] = $value;
					}

					if (!isset($this->product_data['product_id']))
					{
						$this->force_redirect(home_url());
					}

					$product_vendor_info = $this->get_vendor_for_product($this->product_data['product_id']);
					if ($product_vendor_info->rowCount() === 1)
					{
						$vendor_info = array();
						$row = $product_vendor_info->row(0);
						foreach ($row as $key => $value)
						{
							$vendor_info[$key] = $value;
						}
						$this->product_data['vendor'] = $vendor_info;
					}
					$product_meta_keywords = $this->get_product_meta_tags($product_guid);
					if ($product_meta_keywords->rowCount() === 1)
					{
						$row = $product_meta_keywords->row(0);
						foreach ($row as $key => $value)
						{
							$this->product_data[$key] = $value;
						}
					}
					$this->set_property_if_valid_string($this->product_data['meta_description'], $this->meta_description);
					$this->set_property_if_valid_string($this->product_data['meta_keywords'], $this->meta_keywords);
					if (!empty($this->product_data['html_title']))
					{
						$this->set_property_if_valid_string($this->product_data['html_title'], $this->title_tag);
					}
					else
					{
						if (!is_null($this->product_data['short_description']))
						{
							$this->set_property_if_valid_string(htmlentities($this->product_data['short_description']), $this->title_tag);
						}
					}
					if (!empty($this->product_data['product_id']))
					{
						$images = array();
						if ($this->product_has_media_settings()) {
							if ($this->present_ad_gallery_for_product()) {
								$product_media = $this->get_cart_media($this->media_settings['product']['display_type_key'], $this->product_data['guid']);
								$product_media_count = $product_media->rowCount();
								if ($product_media_count > 0) {
									$product_medium_index = null;
									$start_at_index = 0;
									$old_slide_layer_type_id = null;
									$this->product_media = array();
									for ($product_media_counter = 0; $product_media_counter < $product_media_count; $product_media_counter++) {
										$medium_row = $product_media->row($product_media_counter);
										$slide_layer_type_id = $medium_row['slide_layer_type_id'];
										unset($medium_row['slide_layer_type_id']);
										switch ($slide_layer_type_id) {
											case 7:
												$this->product_media[] = array('thumbnail' => $medium_row);
												end($this->product_media);
												$product_medium = &$this->product_media[key($this->product_media)];
												if (is_null($product_medium_index)) {
													$product_medium_index = 0;
												} else {
													$product_medium_index++;
												}
												if ($medium_row['default_media']) {
													$start_at_index = $product_medium_index;
												}
												break;
											case 8:
												if (7 === $old_slide_layer_type_id) {
													$product_medium['preview'] = $medium_row;
												}
												if ($medium_row['default_media']) {
													$start_at_index = $product_medium_index;
												}
												break;
											case 9:
												if (8 === $old_slide_layer_type_id) {
													$product_medium['zoom'] = $medium_row;
												}
												if ($medium_row['default_media']) {
													$start_at_index = $product_medium_index;
												}
												break;
										}
										$old_slide_layer_type_id = $slide_layer_type_id;
									}
									$this->product_media_count = count($this->product_media);
									$this->product_media_gallery_start_at_index = $start_at_index;
								}
							}
						} else {
							$product_images = $this->get_product_images($this->product_data['product_id']);
							$meta_data = $product_images->metaData();
							$this->meta_data = array_merge_recursive($this->meta_data, $meta_data);
							$rowCount = $product_images->rowCount();
							if ($rowCount > 0)
							{
								for ($intCounter = 0; $intCounter < $rowCount; $intCounter++)
								{
									$images_row = array();
									foreach ($product_images->row($intCounter) as $key => $value)
									{
										$images_row[$key] = $value;
									}
									$images[] = $images_row;
								}
							}
						}
						$this->product_data['images'] = $images;

						$features = array();
						if ($output_javascript_data === true)
						{
							$features_for_js = array();
						}
						$this->product_data['has_products_lists'] = false;
						$this->product_data['has_product_order_form'] = false;
						$product_features = $this->get_product_features($this->product_data['product_id']);
						$meta_data = $product_features->metaData();
						$this->meta_data = array_merge_recursive($this->meta_data, $meta_data);
						$rowCount = $product_features->rowCount();
						if ($rowCount > 0)
						{
							$previous_feature_group_name_id = NULL;
							for ($intCounter = 0; $intCounter < $rowCount; $intCounter++)
							{
								$feature_group_name_id = NULL;
								$product_features_row = $product_features->row($intCounter);
								$feature_group_name_id = is_null($product_features_row['feature_group_name_id'])?'oo':$product_features_row['feature_group_name_id'];
								$feature_group_name = (is_null($product_features_row['feature_group_name']) || strlen(trim($product_features_row['feature_group_name'])) === 0)?'[[OTHER_OPTIONS]]':$product_features_row['feature_group_name'];
								if ($feature_group_name_id !== $previous_feature_group_name_id)
								{
									$previous_feature_group_name_id = $feature_group_name_id;
									$features[$feature_group_name_id] = array();
									$features_for_js[$feature_group_name_id] = array();
									$features[$feature_group_name_id]['name'] = $feature_group_name;
									$features_for_js[$feature_group_name_id]['name'] = str_replace('"', '\u0022', $feature_group_name);
									$features[$feature_group_name_id]['features'] = array();
									$features_for_js[$feature_group_name_id]['features'] = array();
									$features[$feature_group_name_id]['feature_group_is_required'] = is_null($product_features_row['required'])?FALSE:$product_features_row['required'];
									$features_for_js[$feature_group_name_id]['feature_group_is_required'] = $features[$feature_group_name_id]['feature_group_is_required'];
									$features[$feature_group_name_id]['feature_display_type'] = is_null($product_features_row["feature_display_type_id"])?-1:$product_features_row["feature_display_type_id"];
									switch ($features[$feature_group_name_id]['feature_display_type'])
									{
										case -1:
											$features[$feature_group_name_id]['feature_display_type'] = 'checkbox';
											break;
										case 1:
											$features[$feature_group_name_id]['feature_display_type'] = 'radio';
											break;
										case 2:
											$features[$feature_group_name_id]['feature_display_type'] = 'dropdown';
											break;
										case 3:
											$features[$feature_group_name_id]['feature_display_type'] = 'checkbox';
											break;
										case 4:
											$features[$feature_group_name_id]['feature_display_type'] = 'colorSelector';
											if ($product_has_an_html_drawing === FALSE)
											{
												$product_html_drawing = $this->get_html_drawing_for_product($this->product_data['guid']);
												if (!is_null($product_html_drawing) && strlen(trim($product_html_drawing)) > 0)
												{
													$product_has_an_html_drawing = TRUE;
												}
											}
											break;
										case 5:
											$features[$feature_group_name_id]['feature_display_type'] = 'productsList';
											$this->product_data['has_products_lists'] = true;
											$this->product_data['has_product_order_form'] = false;
											break;
										case 6:
											$features[$feature_group_name_id]['feature_display_type'] = 'productOrderForm';
											$this->product_data['has_product_order_form'] = true;
											$this->product_data['has_products_lists'] = false;
											break;
									}
									$features_for_js[$feature_group_name_id]['feature_display_type'] = $features[$feature_group_name_id]['feature_display_type'];
									$features[$feature_group_name_id]['feature_group_display_your_cost'] = is_null($product_features_row['display_your_cost'])?FALSE:$product_features_row['display_your_cost'];
									$features[$feature_group_name_id]['feature_group_display_feature_price'] = is_null($product_features_row['display_feature_price'])?FALSE:$product_features_row['display_feature_price'];
									$features[$feature_group_name_id]['feature_group_display_instock'] = is_null($product_features_row['display_instock'])?FALSE:$product_features_row['display_instock'];
									$features[$feature_group_name_id]['feature_group_display_quan_instock'] = is_null($product_features_row['display_quan_instock'])?FALSE:$product_features_row['display_quan_instock'];
									$features[$feature_group_name_id]['feature_group_allow_outofstock_order'] = is_null($product_features_row['allow_outofstock_order'])?FALSE:$product_features_row['allow_outofstock_order'];
								}
								$features_row = array();

								$features_row['feature_product_guid'] = $product_features_row['product_guid'];
								$features_row['feature_is_required'] = is_null($product_features_row['f_required'])?FALSE:$product_features_row['f_required'];
								$features_row['feature_is_default'] = is_null($product_features_row['default_feature'])?FALSE:$product_features_row['default_feature'];
								$features_row['feature_only'] = is_null($product_features_row['feature_only'])?FALSE:$product_features_row['feature_only'];
								$features_row['feature_pg_link'] = strlen(is_null($product_features_row['pg_link'])?'':trim($product_features_row['pg_link'])) === 0?$product_features_row['feature_product_guid']:trim($product_features_row['pg_link']);
								$features_row['feature_link_back'] = $product_features_row['link_back'];
								$features_row['feature_name'] = $product_features_row['name'];
								$features_row['feature_price'] = is_null($product_features_row['feature_price'])?$product_features_row['your_cost']:$product_features_row['feature_price'];
								$features_row['feature_quantity_in_stock'] = $product_features_row['quantity_in_stock'];
								$features_row['feature_hex'] = $product_features_row['hex'];

								$features[$feature_group_name_id]['features'][] = $features_row;

								if ($output_javascript_data === true)
								{
									$features_row_for_js = array();

									$features_row_for_js['feature_product_guid'] = $product_features_row['product_guid'];
									$features_row_for_js['feature_is_required'] = $features_row['feature_is_required'];
									$features_row_for_js['feature_is_default'] = $features_row['feature_is_default'];
									$features_row_for_js['feature_only'] = $features_row['feature_only'];
									$features_row_for_js['feature_pg_link'] = $features_row['feature_pg_link'];
									$features_row_for_js['feature_link_back'] = $features_row['feature_link_back'];
									$features_row_for_js['feature_name'] = str_replace('"', '\u0022', $features_row['feature_name']);
									$features_row_for_js['feature_price'] = $features_row['feature_price'];
									$features_row_for_js['feature_hex'] = $product_features_row['hex'];

									$features_for_js[$feature_group_name_id]['features'][] = $features_row_for_js;
								}
							}
						}
						$this->product_data['features'] = $features;
						if ($output_javascript_data === true)
						{
							$this->product_data['features_for_js'] = $features_for_js;
						}
						if ($product_has_an_html_drawing === TRUE)
						{
							$this->product_data['html_drawing'] = $product_html_drawing;
						}

						$questions_and_answers = array();
						$product_questions_and_answers = $this->get_questions_and_answers_for_a_product($this->product_data['product_id']);
						$meta_data = $product_questions_and_answers->metaData();
						$this->meta_data = array_merge_recursive($this->meta_data, $meta_data);
						$rowCount = $product_questions_and_answers->rowCount();
						if ($rowCount > 0)
						{
							for ($intCounter = 0; $intCounter < $rowCount; $intCounter++)
							{
								$product_questions_and_answers_row = $product_questions_and_answers->row($intCounter);
								$questions_and_answers[] = $product_questions_and_answers_row;
							}
						}
						$this->product_data['questions_and_answers'] = $questions_and_answers;

						$quantity_discounts = array();
						$product_quantity_discounts = $this->get_product_quantity_discounts($this->product_data['guid']);
						$meta_data = $product_quantity_discounts->metaData();
						$this->meta_data = array_merge_recursive($this->meta_data, $meta_data);
						$rowCount = $product_quantity_discounts->rowCount();
						if ($rowCount > 0)
						{
							for ($intCounter = 0; $intCounter < $rowCount; $intCounter++)
							{
								$product_quantity_discounts_row = $product_quantity_discounts->row($intCounter);
								$quantity_discounts_row = array();
								$quantity_discounts_row['quantity'] = is_null($product_quantity_discounts_row['quantity'])?0:$product_quantity_discounts_row['quantity'];
								$quantity_discounts_row['price'] = is_null($product_quantity_discounts_row['price'])?0:$product_quantity_discounts_row['price'];
								$quantity_discounts[] = $quantity_discounts_row;
							}
						}
						$this->product_data['quantity_discounts'] = $quantity_discounts;
					}
				}
			}
			if ($output_javascript_data === true)
			{
				wp_enqueue_script('ostrm_product_details_form', plugin_dir_url(__FILE__) . 'js/ostrm_product_details_form.js', array('jquery'), '1.0', true);
				$ajaxGlobals = array
				(
					'action' => 'add_to_cart',
					'ajaxURL' => admin_url('admin-ajax.php'),
					'ostrmCartNonce' => wp_create_nonce('orderstorm_nonce'),
					'productFeaturesData' => stripslashes($this->json_obj->encode($this->product_data['features_for_js']))
				);
				wp_localize_script
				(
					'ostrm_product_details_form',
					'ajaxGlobals',
					$ajaxGlobals
				);
			}
		}
	}

	public function get_product_name()
	{
		return $this->product_data["name"];
	}

	private function product_category_navigation_page_link($direction, $caption)
	{
		$product_category_navigation_page_link = '';
		$link_page_number = 1;
		$use_pretty_permalinks = $this->product_category_page_id && $this->use_seo_friendly_product_category_links;

		if	(
				($direction === 'next' && $this->top_page > 1 && $this->current_page < $this->top_page)
				|| ($direction === 'previous' && $this->top_page > 1 && $this->current_page > 1)
			)
		{
			$link_page_number = $this->current_page + (($direction === 'next')?1:-1);

			$product_category_navigation_page_link = $this->build_product_category_page_link($this->category_link, $this->category_data["link_to"]);
			if ($link_page_number !== 1)
			{
				if (!$use_pretty_permalinks)
				{
					$product_category_navigation_page_link .= '&page_number=';
				}
				else
				{
					$product_category_navigation_page_link .= 'page/';
				}

				$product_category_navigation_page_link .= strval($link_page_number);

				if ($use_pretty_permalinks)
				{
					$product_category_navigation_page_link .= '/';
				}
			}
		}

		if (!empty($product_category_navigation_page_link))
		{
			$product_category_navigation_page_link =	'<a class="pcat-nav-'
														. (($direction === 'next')?'next':'prev')
														. '" href="'
														. $product_category_navigation_page_link
														. '">'
														. $caption
														. '</a>';
		}

		return $product_category_navigation_page_link;
	}

	public function get_shopping_cart_status_html($idSuffix, $class, $widget_before = NULL, $widget_title = NULL, $widget_after = NULL)
	{
		$html = "";

		$order_key_guid = null;

		if (isset($_SESSION['order_key_guid']))
		{
			$order_key_guid = $_SESSION['order_key_guid'];
		}
		$order_summary = $this->get_order_summary($order_key_guid);

		if ($order_summary->rowCount() === 1)
		{
			$row = $order_summary->row(0);
			$order_products_total = $row['s_order_products_total'];
			$ship = $row['ship'];
			$tax = $row['tax'];
			$quantity = $row['quantity'];
			if ($quantity > 0)
			{
				if (is_null($idSuffix) || !is_string($idSuffix))
				{
					$idSuffix = '';
				}
				else
				{
					$idSuffix = '_' . $idSuffix;
				}
				if (!is_null($widget_before))
				{
					$html .= $widget_before;
				}
				if (!is_null($widget_title))
				{
					$html .= $widget_title;
				}
				$html .=	"<div id=\"ostrm_shopping_cart_status" . $idSuffix . "\" class=\"" . $class . "\">"
							. "<div class=\"items_qty\"><span class=\"qty\">" . $quantity . "</span> item" . (($quantity > 1)?'s':'') . " in cart</div>"
							. "<div class=\"order_total\">" . $this->money_format($order_products_total) . "</div>"
							. "<div class=\"view_cart_button\">View Cart</div>"
							. "</div>";

				if (!is_null($widget_after))
				{
					$html .= $widget_after;
				}
			}
		}

		return $html;
	}

	public function display_shopping_cart_status($idSuffix)
	{
		echo($this->get_shopping_cart_status_html($idSuffix, 'ostrm_shopping_cart_status'));
	}

	private function get_category_tile_element_html($categoryRow, $tile_size = 'medium')
	{
		$html =	'<a href="' . $this->build_product_category_page_link($categoryRow['pg_link'], $categoryRow["link_to"]) . '">'
				. '<label>' . $categoryRow['category_description'] . '</label>'
				. '<div>';
		if ($categoryRow['category_image_extention_id'] !== 1)
		{
			$html .= '<img src="' . $this->build_category_image_url($categoryRow['category_id'], $categoryRow['category_image_extention']) . '" />';
		}
		else
		{
			if (!is_null($this->default_category_image))
			{
				$html .= '<img src="' . $this->build_default_category_image_url() . '" />';
			}
		}
		$html .= 	'</div>'
					. '</a>';

		return '<div class="tile_' . $tile_size . '">' . $html . '</div>';
	}

	public function money_format($amount)
	{
		$formatted_amount = "";

		$decimals = $this->decimals;
		$dec_point = $this->dec_point;
		$thousands_sep = $this->thousands_sep;
		$currency_sign = $this->currency_sign;
		$currency_code = $this->currency_code;
		$sign_align_right = $this->sign_align_right;
		$code_align_right = $this->code_align_right;
		$prefer_code_over_sign = $this->prefer_code_over_sign;

		if (!is_null($decimals))
		{
			if (!is_numeric($decimals))
			{
				$decimals = 2;
			}
			if (!is_int($decimals))
			{
				$decimals = 2;
			}
			if (!ctype_digit((string)$decimals))
			{
				$decimals = 2;
			}
			if ($decimals < 1)
			{
				$decimals = 2;
			}
		}
		else
		{
			$decimals = 2;
		}

		if (!is_null($dec_point))
		{
			if (strlen(trim($dec_point)) < 1)
			{
				$dec_point = ".";
			}
		}
		else
		{
			$dec_point = ".";
		}

		if (!is_null($thousands_sep))
		{
			if (strlen(trim($thousands_sep)) < 1)
			{
				$thousands_sep = "";
			}
		}
		else
		{
			$thousands_sep = "";
		}

		$formatted_amount = number_format($amount, $decimals, $dec_point, $thousands_sep);

		if (!is_null($currency_sign))
		{
			if (strlen(trim($currency_sign)) < 1)
			{
				$currency_sign = null;
			}
		}

		if (!is_null($sign_align_right))
		{
			if (gettype($sign_align_right) !== "boolean")
			{
				$sign_align_right = false;
			}
		}

		if (!is_null($currency_code))
		{
			if (strlen(trim($currency_code)) < 1)
			{
				$currency_code = null;
			}
		}

		if (!is_null($code_align_right))
		{
			if (gettype($code_align_right) !== "boolean")
			{
				$code_align_right = false;
			}
		}

		if (!is_null($prefer_code_over_sign))
		{
			if (gettype($prefer_code_over_sign) !== "boolean")
			{
				$prefer_code_over_sign = false;
			}
		}

		$use_currency_code = false;
		if (!is_null($currency_sign))
		{
			if (!$prefer_code_over_sign)
			{
				$formatted_amount = (($sign_align_right)?$formatted_amount . $currency_sign:$currency_sign . $formatted_amount);
			}
			else
			{
				$use_currency_code = true;
			}
		}
		else
		{
			$use_currency_code = true;
		}
		if (!is_null($currency_code) && $use_currency_code)
		{
			$formatted_amount = (($code_align_right)?$formatted_amount . " " . $currency_code:$currency_code . " " . $formatted_amount);
		}

		return $formatted_amount;
	}

	public function set_first_page_title_has_been_queried()
	{
		$this->configuration_options["first_page_title_has_been_queried"] = TRUE;
	}

	public function should_product_name_be_editable_in_title()
	{
		if (gettype($this->detail_product_name_editable_in_title) === "boolean")
		{
			return $this->detail_product_name_editable_in_title;
		}
		else
		{
			return true;
		}
	}

	public function should_product_category_name_be_used_as_product_category_page_title()
	{
		return $this->should_product_name_be_used_as_product_page_title();
	}

	public function should_product_name_be_used_as_product_page_title()
	{
		if (gettype($this->names_in_title) === "boolean")
		{
			return $this->names_in_title;
		}
		else
		{
			return true;
		}
	}

	public function get_product_link_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_link_for_shortcodes))
		{
			return $this->product_link_for_shortcodes;
		}
		else
		{
			return null;
		}
	}

	public function get_product_link_override_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["link_back"]))
		{
			return $this->product_data_for_shortcodes["link_back"];
		}
		else
		{
			return null;
		}
	}

	public function get_product_id_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["product_id"]))
		{
			return $this->product_data_for_shortcodes["product_id"];
		}
		else
		{
			return null;
		}
	}

	public function get_product_name_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["name"]))
		{
			return $this->product_data_for_shortcodes["name"];
		}
		else
		{
			return null;
		}
	}

	public function get_product_item_number_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["item_number"]))
		{
			return $this->product_data_for_shortcodes["item_number"];
		}
		else
		{
			return null;
		}
	}

	public function get_product_short_description_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["short_description"]))
		{
			return $this->product_data_for_shortcodes["short_description"];
		}
		else
		{
			return null;
		}
	}

	public function get_product_long_description_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["long_description"]))
		{
			return $this->product_data_for_shortcodes["long_description"];
		}
		else
		{
			return null;
		}
	}

	public function get_product_thumbnail_image_extension_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["thumbnail_image_extention"]))
		{
			return $this->product_data_for_shortcodes["thumbnail_image_extention"];
		}
		else
		{
			return null;
		}
	}

	public function get_product_extended_image_extension_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["extended_image_extention"]))
		{
			return $this->product_data_for_shortcodes["extended_image_extention"];
		}
		else
		{
			return null;
		}
	}

	public function get_product_full_size_extended_image_extension_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["full_size_extended_image_extention"]))
		{
			return $this->product_data_for_shortcodes["full_size_extended_image_extention"];
		}
		else
		{
			return null;
		}
	}

	public function get_product_not_for_sale_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["not_for_sale"]))
		{
			$not_for_sale = $this->product_data_for_shortcodes["not_for_sale"];

			if (is_null($not_for_sale))
			{
				$not_for_sale = false;
			}

			return $not_for_sale;
		}
		else
		{
			return null;
		}
	}

	public function get_product_deleted_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["deleted"]))
		{
			$deleted = $this->product_data_for_shortcodes["deleted"];

			if (is_null($deleted))
			{
				$deleted = false;
			}

			return $deleted;
		}
		else
		{
			return null;
		}
	}

	public function get_product_retail_price_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["retail_price"]))
		{
			return $this->product_data_for_shortcodes["retail_price"];
		}
		else
		{
			return null;
		}
	}

	public function get_product_your_cost_for_shortcodes()
	{
		if (isset($this->product_data_for_shortcodes) && is_array($this->product_data_for_shortcodes) && isset($this->product_data_for_shortcodes["your_cost"]))
		{
			return $this->product_data_for_shortcodes["your_cost"];
		}
		else
		{
			return null;
		}
	}

	public function is_category_data_loaded()
	{
		if (isset($this->category_data) && is_array($this->category_data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_category_link_override()
	{
		$link_override = null;

		if (isset($this->category_data) && is_array($this->category_data) && isset($this->category_data['link_to']))
		{
			$link_override = $this->category_data["link_to"];
			if (!is_null($link_override))
			{
				$link_override = trim($link_override);
				if (strlen($link_override) <= 0)
				{
					$link_override = null;
				}
			}
		}

		return $link_override;
	}

	public function is_product_data_loaded()
	{
		if (isset($this->product_data) && is_array($this->product_data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_product_link_override()
	{
		$link_override = null;

		if (isset($this->product_data) && is_array($this->product_data) && isset($this->product_data['link_back']))
		{
			$link_override = $this->product_data["link_back"];
			if (!is_null($link_override))
			{
				$link_override = trim($link_override);
				if (strlen($link_override) <= 0)
				{
					$link_override = null;
				}
			}
		}

		return $link_override;
	}

	public function has_wp_title_already_been_processed()
	{
		return $this->wp_title_already_processed;
	}

	public function set_wp_title_as_already_processed()
	{
		$this->wp_title_already_processed = true;
	}

	public function get_rel_canonical_filter_processed()
	{
		return $this->rel_canonical_filter_processed;
	}

	public function set_rel_canonical_filter_as_processed()
	{
		$this->rel_canonical_filter_processed = true;
	}

	public function get_meta_description_filter_processed()
	{
		return $this->meta_description_filter_processed;
	}

	public function set_meta_description_filter_as_processed()
	{
		$this->meta_description_filter_processed = true;
	}

	public function get_meta_keys_filter_processed()
	{
		return $this->meta_keys_filter_processed;
	}

	public function set_meta_keys_filter_as_processed()
	{
		$this->meta_keys_filter_processed = true;
	}

	public function there_are_sub_categories() {
		return !is_null($this->sub_categories) && !empty($this->sub_categories_count);
	}

	public function get_current_sub_category() {
		if (!is_null($this->sub_categories) && !empty($this->sub_categories_count) && !is_null($this->sub_categories_index)) {
			return $this->sub_categories->row($this->sub_categories_index);
		} else {
			return false;
		}
	}

	public function there_are_category_products() {
		return !is_null($this->category_products) && !empty($this->category_products_count);
	}

	public function get_current_category_product() {
		if ($this->there_are_category_products() && !is_null($this->category_products_index)) {
			return $this->category_products->row($this->category_products_index);
		} else {
			return false;
		}
	}

	public function category_product_present_thumbnail() {
		if ($this->category_product) {
			$serving_url = $this->category_product['serving_url'];
			$serving_surl = $this->category_product['serving_surl'];
			if (!(is_null($serving_url) || is_null($serving_surl)) && (empty($serving_url) || empty($serving_surl))) {
				return false;
			}
			return true;
		}
	}

	public function category_product_has_thumbnail_serving_url() {
		if ($this->category_product) {
			$serving_url = $this->category_product['serving_url'];
			return !is_null($serving_url) && !empty($serving_url);
		}
	}

	public function category_product_has_thumbnail_serving_surl() {
		if ($this->category_product) {
			$serving_surl = $this->category_product['serving_surl'];
			return !is_null($serving_surl) && !empty($serving_surl);
		}
	}

	public function there_are_product_features() {
		return !is_null($this->features) && !empty($this->features);
	}

	public function there_are_features_in_the_group() {
		return !is_null($this->features_in_the_group) && !empty($this->features_in_the_group);
	}

	public function there_are_product_questions_and_answers() {
		return !is_null($this->product_questions_and_answers) && !empty($this->product_questions_and_answers);
	}

	public function there_are_product_quantity_discounts() {
		return !is_null($this->product_quantity_discounts) && !empty($this->product_quantity_discounts);
	}

	public function there_are_product_images() {
		return !is_null($this->product_images) && !empty($this->product_images);
	}

	public function product_has_media_settings() {
		return !empty($this->media_settings) &&
			array_key_exists('product', $this->media_settings) &&
			array_key_exists('layers', $this->media_settings['product']) &&
			!empty($this->media_settings['product']['layers']);
	}

	public function product_has_media_layer_type($media_layer_type) {
		return $this->product_has_media_settings() &&
			OrderStormECommerceForWordPress::isAllNumericDigits($media_layer_type) &&
			array_key_exists((string) $media_layer_type, $this->media_settings['product']['layers']);
	}

	public function present_ad_gallery_for_product() {
		return $this->product_has_media_layer_type(7) && $this->product_has_media_layer_type(8);
	}

	public function product_media_thumbnail_width() {
		if (!$this->present_ad_gallery_for_product()) {
			return false;
		}
		return $this->media_settings['product']['layers']['7']['width'];
	}

	public function product_media_preview_width() {
		if (!$this->present_ad_gallery_for_product()) {
			return false;
		}
		return $this->media_settings['product']['layers']['8']['width'];
	}

	public function product_media_zoom_width() {
		if (!($this->present_ad_gallery_for_product() && array_key_exists('9', $this->media_settings['product']['layers']))) {
			return false;
		}
		return $this->media_settings['product']['layers']['9']['width'];
	}

	public function there_are_media_for_the_product() {
		return !is_null($this->product_media) && !empty($this->product_media);
	}

	public function medium_has($media, $index, $type, $has) {
		$property = $media[$index][$type][$has];
		return !is_null($property) && !empty($property);
	}

	public function get_product_media_gallery_start_at_index() {
		return $this->product_media_gallery_start_at_index;
	}

	public function category_has_media_settings() {
		return !empty($this->media_settings) &&
			array_key_exists('category', $this->media_settings) &&
			array_key_exists('layers', $this->media_settings['category']) &&
			!empty($this->media_settings['category']['layers']);
	}

	public function category_has_media_layer_type($media_layer_type) {
		return $this->category_has_media_settings() &&
			OrderStormECommerceForWordPress::isAllNumericDigits($media_layer_type) &&
			array_key_exists((string) $media_layer_type, $this->media_settings['category']['layers']);
	}

	public function present_category_image() {
		return $this->category_has_media_layer_type(10);
	}

	public function there_are_media_for_the_category() {
		return !is_null($this->category_media) && !empty($this->category_media);
	}

	public function category_media_image_width() {
		if (!$this->present_category_image()) {
			return false;
		}
		return $this->media_settings['category']['layers']['10']['width'];
	}

	public function there_are_media_for_this_sub_category() {
		return !is_null($this->sub_category_media) && !empty($this->sub_category_media);
	}

	public function echo_or_return($named_parameters) {
		if (!is_array($named_parameters)) {
			return false;
		}

		$max_num_args = 4;

		extract($named_parameters);

		if (!isset($formatted_value)
			|| !isset($value)
			|| (!is_null($type) && !isset($type))
			|| (!is_null($type) && !is_string($type))
			|| !isset($num_args)
			|| !is_int($num_args)
			|| !isset($return)
			|| !is_bool($return)
			|| !is_int($max_num_args)) {
			return false;
		}

		switch ($type) {
			case NULL:						// Use NULL to avoid checking for data type
				break;
			case 'boolean':
				if (!is_bool($value)) {
					return false;
				}
				break;
			case 'numeric':
				if (!is_numeric($value)) {
					return false;
				}
				break;
			case 'integer':
				if (!is_int($value)) {
					return false;
				}
				break;
			case 'double':
				if (!is_double($value)) {
					return false;
				}
				break;
			case 'string':
				if (!is_string($value)) {
					return false;
				}
				break;
			case 'array':
				if (!is_array($value)) {
					return false;
				}
				break;
			case 'object':
				if (!is_object($value)) {
					return false;
				}
				break;
			case 'resource':
				return false;
				break;
			case 'NULL':
				return false;
				break;
			case 'unknown type':
				return false;
				break;
			default:
				return false;
				break;
		}

		if ($num_args > $max_num_args) {
			return false;
		}

		if ($return) {
			return $formatted_value;
		} else {
			echo($formatted_value);
			return true;
		}
	}

	public function api() {
		$num_args = func_num_args();

		if ($num_args < 1 || $num_args > 5) {
			return false;
		}

		$parms = array('first', 'second', 'third', 'fourth', 'fifth');

		$func_args = func_get_args();
		$args = array_combine(array_slice($parms, 0, $num_args), $func_args);
		extract($args);

		if (isset($first) && is_string($first)) {
			if ($first == 'api' && isset($second) && is_int($second) && isset($third) && is_array($third)) {
				$num_args = $second;

				if ($num_args < 1 || $num_args > 5) {
					return false;
				}

				$func_args = $third;
				unset($first);
				unset($second);
				unset($third);
				unset($fourth);
				unset($fifth);
				$args = array_combine(array_slice($parms, 0, $num_args), $func_args);
				extract($args);
			}
			if (isset($first) && is_string($first)) {
				if (isset($second)) {
					switch ($first) {
						case 'money_format':
							$return = false;
							if (isset($third)) {
								$return = $third;
							}
							return $this->echo_or_return(array(
								'formatted_value' => $this->money_format($second),
								'value' => $second,
								'type' => 'numeric',
								'num_args' => $num_args,
								'return' => $return));
							break;
						case 'encode_html_entities':
							$return = false;
							if (isset($third)) {
								$return = $third;
							}
							if (isset($fourth)) {
								if (!is_bool($fourth)) {
									return false;
								} else {
									return $this->echo_or_return(array(
										'formatted_value' => htmlentities($second, $fourth),
										'value' => $second,
										'type' => 'string',
										'num_args' => $num_args,
										'return' => $return,
										'max_num_args' => 4));
								}
							} else {
									return $this->echo_or_return(array(
										'formatted_value' => htmlentities($second),
										'value' => $second,
										'type' => 'string',
										'num_args' => $num_args,
										'return' => $return,
										'max_num_args' => 4));
							}
							break;
						default:
							if (is_string($second)) {
								switch ($first) {
									case 'meta_data':
										switch ($second) {
											case 'ckp':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												if (!isset($this->meta_data['ckp'])) {
													$this->meta_data['ckp'] = null;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['ckp'],
													'value' => $this->meta_data['ckp'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'force_ssl_for_generated_urls':
												return $this->force_ssl_for_generated_urls;
												break;
											case 'display_extended_image_for_product':
												return $this->meta_data['extended_image_extention_display'];
												break;
											case 'display_large_image_for_product':
												return $this->meta_data['full_size_extended_image_extention_display'];
												break;
											case 'allow_users_to_place_orders':
												return $this->meta_data['allow_order'];
												break;
											case 'should_questions_and_answers_be_displayed_on_the_product_page':
												return $this->meta_data['detail_vendor_question'];
												break;
											case 'display_long_description':
												return $this->meta_data['long_description_display'];
												break;
											case 'display_product_ordering_information':
												return $this->meta_data['order_display'];
												break;
											case 'display_minimum_product_order_quantity':
												return $this->meta_data['display_min_order_quantity'];
												break;
											case 'display_retail_price':
												return $this->meta_data["retail_price_display"];
												break;
											case 'display_your_cost':
												return $this->meta_data["your_cost_display"];
												break;
											case 'display_item_number':
												return $this->meta_data['item_number_display'];
												break;
											case 'there_is_a_label_for_item_number_on_product_page':
												return !is_null($this->meta_data['detail_item_number_label']);
												break;
											case 'there_is_a_label_for_retail_price_on_product_page':
												return !is_null($this->meta_data['detail_retail_label']);
												break;
											case 'there_is_a_label_for_your_cost_on_product_page':
												return !is_null($this->meta_data['detail_your_cost_label']);
												break;
											case 'there_is_an_image_for_the_add_product_to_order_button':
												return !is_null($this->meta_data['add_image']);
												break;
											case 'there_is_a_label_for_the_add_product_to_order_button':
												return !is_null($this->meta_data['add_button_label']);
												break;
											case 'display_product_shipping_information':
												return $this->meta_data['display_shipping'];
												break;
											case 'display_product_days_to_ship':
												return $this->meta_data['display_days_to_ship'];
												break;
											case 'there_is_a_product_ships_for_free_text':
												return !is_null($this->meta_data['detail_free_ship_text']);
												break;
											case 'there_is_a_product_does_not_ship_for_free_text':
												return !is_null($this->meta_data['detail_no_free_ship_text']);
												break;
											case 'there_is_a_label_for_extended_links_on_product_page':
												return !is_null($this->meta_data["extended_links_label"]);
												break;
											case 'there_is_a_text_for_other_options':
												return !is_null($this->meta_data["detail_other_options_text"]);
												break;
											case 'not_for_sale':
												return $this->meta_data['not_for_sale'];
												break;
											case 'display_quantity_in_stock':
												return $this->meta_data['quantity_in_stock_display'];
												break;
											case 'display_in_stock_date':
												return $this->meta_data['display_in_stock_date'];
												break;
											case 'display_product_images':
												$result = isset($this->meta_data['images_display']);
												if ($result) {
													$result = $this->meta_data['images_display'];
												}
												return $result;
												break;
											case 'display_product_features':
												return $this->meta_data['features_display'];
												break;
											case 'display_feature_prices':
												return $this->meta_data['display_feature_prices'];
												break;
											case 'label_for_item_number_on_product_page':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['detail_item_number_label'],
													'value' => $this->meta_data['detail_item_number_label'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'label_for_retail_price_on_product_page':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['detail_retail_label'],
													'value' => $this->meta_data['detail_retail_label'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'label_for_your_cost_on_product_page':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['detail_your_cost_label'],
													'value' => $this->meta_data['detail_your_cost_label'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'there_is_a_label_for_features_on_the_product_page':
												return !is_null($this->meta_data['detail_features_label']);
												break;
											case 'label_for_features_on_the_product_page':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['detail_features_label'],
													'value' => $this->meta_data['detail_features_label'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'add_product_to_order_button_image_url':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['add_image'],
													'value' => $this->meta_data['add_image'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'add_product_to_order_button_label':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['add_button_label'],
													'value' => $this->meta_data['add_button_label'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'label_for_extended_links_on_product_page':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['extended_links_label'],
													'value' => $this->meta_data['extended_links_label'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'text_for_other_options':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['detail_other_options_text'],
													'value' => $this->meta_data['detail_other_options_text'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'product_ships_for_free_text';
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['detail_free_ship_text'],
													'value' => $this->meta_data['detail_free_ship_text'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'product_does_not_ship_for_free_text';
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['detail_no_free_ship_text'],
													'value' => $this->meta_data['detail_no_free_ship_text'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'product_page_quantity_discount_label':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->meta_data['detail_quan_discount_label'],
													'value' => $this->meta_data['detail_quan_discount_label'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											default:
												return false;
												break;
										}
										break;
									case 'category':
										switch ($second) {
											case 'has':
												if ($num_args !== 3 || !isset($third) && !is_string($third)) {
													return false;
												}
												switch($third) {
													case 'media_settings':
														return $this->category_has_media_settings();
														break;
													default:
														return false;
														break;
												}
												break;
											case 'display_type_key':
												if (!$this->category_has_media_settings()) {
													return false;
												}
												return $this->media_settings['category']['display_type_key'];
												break;
											case 'present_image':
												return $this->present_category_image();
												break;
											case 'media':
												if ($num_args !== 3 || !isset($third) && !is_string($third)) {
													return false;
												}
												switch($third) {
													case 'exist':
														return $this->there_are_media_for_the_category();
														break;
													case 'at_the_beginning':
														return $this->category_media_index === 0;
														break;
													case 'next':
														if ($this->there_are_media_for_the_category()) {
															if (is_null($this->category_media_index)) {
																$this->category_media_index = 0;
																return true;
															} else {
																if (($this->category_media_index + 1) < $this->category_media_count) {
																	$this->category_media_index++;
																	return true;
																} else {
																	return false;
																}
															}
														} else {
															return false;
														}
														break;
													case 'reset':
														if ($this->there_are_media_for_the_category()) {
															$this->category_media_index = 0;
														}
														break;
													case 'index':
														$return = false;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->category_media_index,
															'value' => $this->category_media_index,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'count':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->category_media_count,
															'value' => $this->category_media_count,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'image_width':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->category_media_image_width(),
															'value' => $this->category_media_image_width(),
															'type' => 'string',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													default:
														return false;
														break;
												}
												break;
											case 'should_name_be_used_as_category_page_title':
												if ($num_args !== 2) {
													return true;
												}

												return $this->should_product_category_name_be_used_as_product_category_page_title();
												break;
											case 'description':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->get_category_description();
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'long_description_is_not_empty':
												if ($num_args !== 2) {
													return true;
												}

												return $this->category_long_description_is_not_empty();
												break;
											case 'long_description':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->get_category_long_description();
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'has_default_image':
												return !is_null($this->default_category_image);
												break;
											case 'default_image_url':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->build_default_category_image_url();
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'sub_categories':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}

												switch ($third) {
													case 'exist':
														if (is_null($this->sub_categories)) {
															$this->sub_categories = $this->get_categories($this->category_data['guid']);
															$this->sub_categories_count = $this->sub_categories->rowCount();
															if ($this->sub_categories_count > 0) {
																return true;
															} else {
																return false;
															}
														} else {
															return $this->there_are_sub_categories();
														}
														break;
													case 'next':
														if ($this->there_are_sub_categories()) {
															if (is_null($this->sub_categories_index)) {
																$this->sub_categories_index = 0;
																return true;
															} else {
																if (($this->sub_categories_index + 1) < $this->sub_categories_count) {
																	$this->sub_categories_index++;
																	return true;
																} else {
																	return false;
																}
															}
														} else {
															if (is_null($this->sub_categories)) {
																$this->sub_categories = $this->get_categories($this->category_data['guid']);
																$this->sub_categories_count = $this->sub_categories->rowCount();
																if ($this->sub_categories_count > 0) {
																	$this->sub_categories_index = 0;
																	return true;
																} else {
																	return false;
																}
															} else {
																return false;
															}
														}
														break;
													case 'reset':
														if ($this->there_are_sub_categories()) {
															$this->sub_categories_index = 0;
														}
														break;
													case 'index':
														$return = false;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->sub_categories_index,
															'value' => $this->sub_categories_index,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'count':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->sub_categories_count,
															'value' => $this->sub_categories_count,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													default:
														return false;
														break;
												}
												break;
											case 'products':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}

												switch ($third) {
													case 'exist':
														if (is_null($this->category_products)) {
															$this->category_products = $this->get_products($this->category_data['guid']);
															$this->category_products_count = $this->category_products->rowCount();
															if ($this->category_products_count > 0) {
																return true;
															} else {
																return false;
															}
														} else {
															return $this->there_are_category_products();
														}
														break;
													case 'next':
														if ($this->there_are_category_products()) {
															if (is_null($this->category_products_index)) {
																$this->category_products_index = 0;
																return true;
															} else {
																if (($this->category_products_index + 1) < $this->category_products_count) {
																	$this->category_products_index++;
																	return true;
																} else {
																	return false;
																}
															}
														} else {
															if (is_null($this->category_products)) {
																$this->category_products = $this->get_products($this->category_data['guid']);
																$this->category_products_count = $this->category_products->rowCount();
																if ($this->category_products_count > 0) {
																	$this->category_products_index = 0;
																	return true;
																} else {
																	return false;
																}
															} else {
																return false;
															}
														}
														break;
													case 'reset':
														if ($this->there_are_category_products()) {
															$this->category_products_index = 0;
														}
														break;
													case 'index':
														$return = false;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->category_products_index,
															'value' => $this->category_products_index,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'count':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->category_products_count,
															'value' => $this->category_products_count,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													default:
														return false;
														break;
												}
											case 'navigation_previous_page_link':
												if ($num_args < 3 || !isset($third) || !is_string($third)) {
													return false;
												}

												$return = false;
												if (isset($fourth)) {
													$return = $fourth;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_category_navigation_page_link('previous', __($third, 'orderstorm-wordpress-e-commerce')),
													'value' => $third,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return,
													'max_num_args' => 4));
												break;
											case 'navigation_next_page_link':
												if ($num_args < 3 || !isset($third) || !is_string($third)) {
													return false;
												}

												$return = false;
												if (isset($fourth)) {
													$return = $fourth;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_category_navigation_page_link('next', __($third, 'orderstorm-wordpress-e-commerce')),
													'value' => $third,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return,
													'max_num_args' => 4));
												break;
											case 'navigation_current_page_caption':
												if ($num_args < 3 || !isset($third) || !is_string($third)) {
													return false;
												}

												$return = false;
												if (isset($fourth)) {
													$return = $fourth;
												}
												return $this->echo_or_return(array(
													'formatted_value' => sprintf(__($third, 'orderstorm-wordpress-e-commerce'), $this->current_page, $this->top_page),
													'value' => $third,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return,
													'max_num_args' => 4));
												break;
										}
										break;
									case 'sub_category':
										if (!$this->sub_category = $this->get_current_sub_category()) {
											return false;
										} else {
											// Load sub-category media here
											if ($this->category_has_media_settings()) {
												if ($this->present_category_image()) {
/*													$this->sub_category_media = $this->get_cart_media(
														$this->media_settings['category']['display_type_key'],
														$this->sub_category['category_guid']
													);
													$this->sub_category_media_count = $this->sub_category_media->rowCount();
													if ($this->sub_category_media_count > 0) {
														var_dump($this->sub_category_media*_count*);
													}
*/												}
											}
										}
										switch ($second) {
											case 'has':
												if ($num_args !== 3 || !isset($third) && !is_string($third)) {
													return false;
												}
												switch($third) {
													case 'serving_url':
													case 'serving_surl':
														$result = false;
														if ($this->category_has_media_settings()) {
															if ($this->present_category_image()) {
																$property = $this->sub_category[$third];
																$result = !is_null($property) && !empty($property);
															}
														}
														return $result;
														break;
													default:
														return false;
														break;
												}
												break;
											case 'serving_url':
											case 'serving_surl':
												$result = false;
												if (!$this->category_has_media_settings()) {
													return false;
												}
												if (!$this->present_category_image()) {
													return false;
												}
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->sub_category[$second],
													'value' => $this->sub_category[$second],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'key':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->sub_category['category_guid'],
													'value' => $this->sub_category['category_guid'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return,
													'max_num_args' => 3));
												break;
											case 'media':
												if ($num_args !== 3 || !isset($third) && !is_string($third)) {
													return false;
												}
												switch($third) {
													case 'exist':
														return $this->there_are_media_for_this_sub_category();
														break;
													case 'at_the_beginning':
														return $this->sub_category_media_index === 0;
														break;
													case 'next':
														if ($this->there_are_media_for_this_sub_category()) {
															if (is_null($this->sub_category_media_index)) {
																$this->sub_category_media_index = 0;
																return true;
															} else {
																if (($this->sub_category_media_index + 1) < $this->sub_category_media_count) {
																	$this->sub_category_media_index++;
																	return true;
																} else {
																	return false;
																}
															}
														} else {
															return false;
														}
														break;
													case 'reset':
														if ($this->there_are_media_for_this_sub_category()) {
															$this->sub_category_media_index = 0;
														}
														break;
													case 'index':
														$return = false;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->sub_category_media_index,
															'value' => $this->sub_category_media_index,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'count':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->sub_category_media_count,
															'value' => $this->sub_category_media_count,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'image_width':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->category_media_image_width(),
															'value' => $this->category_media_image_width(),
															'type' => 'string',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													default:
														return false;
														break;
												}
												break;
											case 'medium':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}
												switch($third) {
													case 'image':
														if ($num_args < 4 || !isset($fourth) && !is_string($fourth)) {
															return false;
														}
														switch($fourth) {
															case 'has':
																if ($num_args !== 5 || !isset($fifth) && !is_string($fifth)) {
																	return false;
																}
																switch($fifth) {
																	case 'url':
																	case 'alt':
																	case 'name':
																	case 'description':
																	case 'serving_url':
																	case 'serving_surl':
																	case 'position_key':
																		return $this->medium_has(
																			$this->sub_category_media,
																			$sub_category_media_index,
																			$third,
																			$fifth);
																		break;
																	default:
																		return false;
																		break;
																}
																break;
															case 'url':
															case 'alt':
															case 'name':
															case 'description':
															case 'serving_url':
															case 'serving_surl':
															case 'position_key':
																$return = false;
																if (isset($fifth)) {
																	$return = $fifth;
																}
																return $this->echo_or_return(array(
																	'formatted_value' => $this->product_media[$this->product_media_index][$third][$fourth],
																	'value' => $this->product_media[$this->product_media_index][$third][$fourth],
																	'type' => 'string',
																	'num_args' => $num_args,
																	'return' => $return));
																break;
															default:
																return false;
																break;
														}
														break;
													default:
														return false;
														break;
												}
												break;
											case 'page_link':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->build_product_category_page_link($this->sub_category['pg_link'], $this->sub_category["link_to"]);
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'description':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->sub_category['category_description'],
													'value' => $this->sub_category['category_description'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'has_image':
												return $this->sub_category['category_image_extention_id'] !== 1;
												break;
											case 'image_url':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->build_category_image_url($this->sub_category['category_id'], $this->sub_category["category_image_extention"]);
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											default:
												return false;
												break;
										}
										break;
									case 'product':
										switch ($second) {
											case 'should_name_be_used_as_product_page_title':
												if ($num_args !== 2) {
													return true;
												}

												return $this->should_product_name_be_used_as_product_page_title();
												break;
											case 'has_media_settings':
												return $this->product_has_media_settings();
												break;
											case 'has_media_layer_type':
												if ($num_args !== 3) {
													return false;
												}
												return $this->product_has_media_layer_type($third);
												break;
											case 'display_type_key':
												if (!$this->product_has_media_settings()) {
													return false;
												}
												return $this->media_settings['product']['display_type_key'];
												break;
											case 'present_ad_gallery':
												return $this->present_ad_gallery_for_product();
												break;
											case 'media':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}
												switch ($third) {
													case 'exist':
														return $this->there_are_media_for_the_product();
														break;
													case 'at_the_beginning':
														return $this->product_media_index === 0;
														break;
													case 'next':
														if ($this->there_are_media_for_the_product()) {
															if (is_null($this->product_media_index)) {
																$this->product_media_index = 0;
																return true;
															} else {
																if (($this->product_media_index + 1) < $this->product_media_count) {
																	$this->product_media_index++;
																	return true;
																} else {
																	return false;
																}
															}
														} else {
															return false;
														}
														break;
													case 'reset':
														if ($this->there_are_media_for_the_product()) {
															$this->product_media_index = 0;
														}
														break;
													case 'index':
														$return = false;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->product_media_index,
															'value' => $this->product_media_index,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'count':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->product_media_count,
															'value' => $this->product_media_count,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'thumbnail_width':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->product_media_thumbnail_width(),
															'value' => $this->product_media_thumbnail_width(),
															'type' => 'string',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'preview_width':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->product_media_preview_width(),
															'value' => $this->product_media_preview_width(),
															'type' => 'string',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'zoom_width':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->product_media_zoom_width(),
															'value' => $this->product_media_zoom_width(),
															'type' => 'string',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													default:
														return false;
														break;
												}
												break;
											case 'medium':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}
												switch ($third) {
													case 'thumbnail':
													case 'preview':
													case 'zoom':
														if ($num_args < 4 || !isset($fourth) && !is_string($fourth)) {
															return false;
														}
														switch($fourth) {
															case 'has':
																if ($num_args !== 5 || !isset($fifth) && !is_string($fifth)) {
																	return false;
																}
																switch($fifth) {
																	case 'url':
																	case 'alt':
																	case 'name':
																	case 'description':
																	case 'serving_url':
																	case 'serving_surl':
																	case 'position_key':
																		return $this->medium_has($this->product_media, $this->product_media_index, $third, $fifth);
																		break;
																	default:
																		return false;
																		break;
																}
																break;
															case 'url':
															case 'alt':
															case 'name':
															case 'description':
															case 'serving_url':
															case 'serving_surl':
															case 'position_key':
																$return = false;
																if (isset($fifth)) {
																	$return = $fifth;
																}
																return $this->echo_or_return(array(
																	'formatted_value' => $this->product_media[$this->product_media_index][$third][$fourth],
																	'value' => $this->product_media[$this->product_media_index][$third][$fourth],
																	'type' => 'string',
																	'num_args' => $num_args,
																	'return' => $return));
																break;
															default:
																return false;
																break;
														}
														break;
													default:
														return false;
														break;
												}
												break;
											case 'has_default_small_image':
												return !is_null($this->default_small_image);
												break;
											case 'default_small_image_url':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->build_default_product_small_image_url();
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'has_default_medium_image':
												return !is_null($this->default_medium_image);
												break;
											case 'default_medium_image_url':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->build_default_product_medium_image_url();
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'has_extended_image':
												return $this->product_data['extended_image_extention_id'] !== 1;
												break;
											case 'large_image_url':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->build_product_large_image_url($this->product_data["product_id"], $this->product_data["extended_image_extention"]);
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'medium_image_url':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->build_product_medium_image_url($this->product_data["product_id"], $this->product_data["extended_image_extention"]);
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'guid':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->product_data['guid'];
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'has_html5_drawing':
												return isset($this->product_data['html_drawing']);
												break;
											case 'html5_drawing':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_data['html_drawing'],
													'value' => $this->product_data['html_drawing'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'name':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_data['name'],
													'value' => $this->product_data['name'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'short_description':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_data['short_description'],
													'value' => $this->product_data['short_description'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'long_description':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_data['long_description'],
													'value' => $this->product_data['long_description'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'product_has_a_usual_days_to_ship':
												return isset($this->product_data['days_to_ship']);
												break;
											case 'usual_days_to_ship':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_data['days_to_ship'],
													'value' => $this->product_data['days_to_ship'],
													'type' => NULL,
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'product_has_a_usual_maximum_of_days_to_ship':
												return isset($this->product_data['up_to_days_to_ship']);
												break;
											case 'usual_maximum_of_days_to_ship':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_data['up_to_days_to_ship'],
													'value' => $this->product_data['up_to_days_to_ship'],
													'type' => NULL,
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'item_number':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_data['item_number'],
													'value' => $this->product_data['item_number'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'has_retail_price':
												return !empty($this->product_data['retail_price']);
												break;
											case 'retail_price':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_data['retail_price'],
													'value' => $this->product_data['retail_price'],
													'type' => 'numeric',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'your_cost':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_data['your_cost'],
													'value' => $this->product_data['your_cost'],
													'type' => 'numeric',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'is_in_stock':
												return $this->product_data['quantity_in_stock'] > 0;
												break;
											case 'in_stock_date':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_data['in_stock_date'],
													'value' => $this->product_data['in_stock_date'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'in_stock_date_caption':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}

												$return = false;
												if (isset($fourth)) {
													$return = $fourth;
												}
												return $this->echo_or_return(array(
													'formatted_value' => sprintf(__($third, 'orderstorm-wordpress-e-commerce'), $this->product_data['in_stock_date']),
													'value' => $third,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'minimum_order_quantity':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_data['min_order_quantity'],
													'value' => $this->product_data['min_order_quantity'],
													'type' => 'numeric',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'minimum_order_quantity_caption':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}

												$return = false;
												if (isset($fourth)) {
													$return = $fourth;
												}
												return $this->echo_or_return(array(
													'formatted_value' => sprintf(__($third, 'orderstorm-wordpress-e-commerce'), $this->product_data['min_order_quantity']),
													'value' => $third,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'proposed_order_quantity':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												if ($this->meta_data['display_min_order_quantity']) {
													$value = $this->product_data['min_order_quantity'];
												} else {
													$value = 1;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'numeric',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'ships_for_free':
												return $this->product_data['ship_free'];
												break;
											case 'has_products_lists':
												return $this->product_data['has_products_lists'];
												break;
											case 'has_product_order_form':
												return $this->product_data['has_product_order_form'];
												break;
											case 'features':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}

												switch ($third) {
													case 'exist':
														if (is_null($this->features)) {
															$this->features = $this->product_data['features'];
															$this->feature_groups_keys = array_keys($this->features);
															$this->feature_groups_count = count($this->features);
															if ($this->feature_groups_count > 0) {
																return true;
															} else {
																return false;
															}
														} else {
															return $this->there_are_product_features();
														}
														break;
													case 'at_the_beginning':
														return $this->feature_groups_index === 0;
														break;
													case 'next_group':
														if ($this->there_are_product_features()) {
															if (is_null($this->feature_groups_index)) {
																$this->feature_groups_index = 0;
																$this->feature_group_name_id = $this->feature_groups_keys[$this->feature_groups_index];
																$this->feature_group = $this->features[$this->feature_group_name_id];
																$this->features_in_the_group = $this->feature_group['features'];
																$this->features_count = count($this->features_in_the_group);
																$this->features_index = null;
																return true;
															} else {
																if (($this->feature_groups_index + 1) < $this->feature_groups_count) {
																	$this->feature_groups_index++;
																	$this->feature_group_name_id = $this->feature_groups_keys[$this->feature_groups_index];
																	$this->feature_group = $this->features[$this->feature_group_name_id];
																	$this->features_in_the_group = $this->feature_group['features'];
																	$this->features_count = count($this->features_in_the_group);
																	$this->features_index = null;
																	return true;
																} else {
																	return false;
																}
															}
														} else {
															if (is_null($this->features)) {
																$this->features = $this->product_data['features'];
																$this->feature_groups_keys = array_keys($this->features);
																$this->feature_groups_count = count($this->features);
																if ($this->feature_groups_count > 0) {
																	$this->feature_groups_index = 0;
																	$this->feature_group_name_id = $this->feature_groups_keys[$this->feature_groups_index];
																	$this->feature_group = $this->features[$this->feature_group_name_id];
																	$this->features_in_the_group = $this->feature_group['features'];
																	$this->features_count = count($this->features_in_the_group);
																	$this->features_index = null;
																	return true;
																} else {
																	return false;
																}
															} else {
																return false;
															}
														}
														break;
													case 'reset':
														if ($this->there_are_product_features()) {
															$this->feature_groups_index = 0;
															$this->feature_group_name_id = $this->feature_groups_keys[$this->feature_groups_index];
															$this->feature_group = $this->features[$this->feature_group_name_id];
															$this->features_in_the_group = $this->feature_group['features'];
															$this->features_count = count($this->features_in_the_group);
															$this->features_index = null;
														}
														break;
													case 'index':
														$return = false;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->feature_groups_index,
															'value' => $this->feature_groups_index,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'count':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->feature_groups_count,
															'value' => $this->feature_groups_count,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													default:
														return false;
														break;
												}
												break;
											case 'quantity_discounts':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}

												switch ($third) {
													case 'exist':
														if (is_null($this->product_quantity_discounts)) {
															$this->product_quantity_discounts = $this->product_data['quantity_discounts'];
															$this->product_quantity_discounts_count = count($this->product_quantity_discounts);
															if ($this->product_quantity_discounts_count > 0) {
																return true;
															} else {
																return false;
															}
														} else {
															return $this->there_are_product_quantity_discounts();
														}
														break;
													case 'at_the_beginning':
														return $this->product_quantity_discounts_index === 0;
														break;
													case 'next':
														if ($this->there_are_product_quantity_discounts()) {
															if (is_null($this->product_quantity_discounts_index)) {
																$this->product_quantity_discounts_index = 0;
																return true;
															} else {
																if (($this->product_quantity_discounts_index + 1) < $this->product_quantity_discounts_count) {
																	$this->product_quantity_discounts_index++;
																	return true;
																} else {
																	return false;
																}
															}
														} else {
															if (is_null($this->product_quantity_discounts)) {
																$this->product_quantity_discounts = $this->product_data['quantity_discounts'];
																$this->product_quantity_discounts_count = count($this->product_quantity_discounts);
																if ($this->product_quantity_discounts_count > 0) {
																	$this->product_quantity_discounts_index = 0;
																	return true;
																} else {
																	return false;
																}
															} else {
																return false;
															}
														}
														break;
													case 'reset':
														if ($this->there_are_product_quantity_discounts()) {
															$this->product_quantity_discounts_index = 0;
														}
														break;
													case 'index':
														$return = false;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->product_quantity_discounts_index,
															'value' => $this->product_quantity_discounts_index,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'count':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->product_quantity_discounts_count,
															'value' => $this->product_quantity_discounts_count,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													default:
														return false;
														break;
												}
												break;
											case 'images':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}

												switch ($third) {
													case 'exist':
														if (is_null($this->product_images)) {
															$this->product_images = $this->product_data['images'];
															$this->product_images_count = count($this->product_images);
															if ($this->product_images_count > 0) {
																return true;
															} else {
																return false;
															}
														} else {
															return $this->there_are_product_images();
														}
														break;
													case 'at_the_beginning':
														return $this->product_images_index === 0;
														break;
													case 'next':
														if ($this->there_are_product_images()) {
															if (is_null($this->product_images_index)) {
																$this->product_images_index = 0;
																return true;
															} else {
																if (($this->product_images_index + 1) < $this->product_images_count) {
																	$this->product_images_index++;
																	return true;
																} else {
																	return false;
																}
															}
														} else {
															if (is_null($this->product_images)) {
																$this->product_images = $this->product_data['images'];
																$this->product_images_count = count($this->product_images);
																if ($this->product_images_count > 0) {
																	$this->product_images_index = 0;
																	return true;
																} else {
																	return false;
																}
															} else {
																return false;
															}
														}
														break;
													case 'reset':
														if ($this->there_are_product_images()) {
															$this->product_images_index = 0;
														}
														break;
													case 'index':
														$return = false;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->product_images_index,
															'value' => $this->product_images_index,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'count':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->product_images_count,
															'value' => $this->product_images_count,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													default:
														return false;
														break;
												}
												break;
											case 'questions_and_answers':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}

												switch ($third) {
													case 'exist':
														if (is_null($this->product_questions_and_answers)) {
															$this->product_questions_and_answers = $this->product_data['questions_and_answers'];
															$this->product_questions_and_answers_count = count($this->product_questions_and_answers);
															if ($this->product_questions_and_answers_count > 0) {
																return true;
															} else {
																return false;
															}
														} else {
															return $this->there_are_product_questions_and_answers();
														}
														break;
													case 'at_the_beginning':
														return $this->product_questions_and_answers_index === 0;
														break;
													case 'next':
														if ($this->there_are_product_questions_and_answers()) {
															if (is_null($this->product_questions_and_answers_index)) {
																$this->product_questions_and_answers_index = 0;
																return true;
															} else {
																if (($this->product_questions_and_answers_index + 1) < $this->product_questions_and_answers_count) {
																	$this->product_questions_and_answers_index++;
																	return true;
																} else {
																	return false;
																}
															}
														} else {
															if (is_null($this->product_questions_and_answers)) {
																$this->product_questions_and_answers = $this->product_data['questions_and_answers'];
																$this->product_questions_and_answers_count = count($this->product_questions_and_answers);
																if ($this->product_questions_and_answers_count > 0) {
																	$this->product_questions_and_answers_index = 0;
																	return true;
																} else {
																	return false;
																}
															} else {
																return false;
															}
														}
														break;
													case 'reset':
														if ($this->there_are_product_questions_and_answers()) {
															$this->product_questions_and_answers_index = 0;
														}
														break;
													case 'index':
														$return = false;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->product_questions_and_answers_index,
															'value' => $this->product_questions_and_answers_index,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'count':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->product_questions_and_answers_count,
															'value' => $this->product_questions_and_answers_count,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'e_mail_address':
														$return = false;
														if (isset($fourth)) {
															$return = $fourth;
														}
														$value = '';
														if (isset($_SESSION["qa_email"])) {
															$value = $_SESSION["qa_email"];
														}
														return $this->echo_or_return(array(
															'formatted_value' => $value,
															'value' => $value,
															'type' => 'string',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													default:
														return false;
														break;
												}
												break;
											default:
												return false;
												break;
										}
										break;
									case 'feature_group':
										switch ($second) {
											case 'name_id':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->feature_group_name_id,
													'value' => $this->feature_group_name_id,
													'type' => null,
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'name':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->feature_group['name'],
													'value' => $this->feature_group['name'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'is_required':
												$result = false;
												if (!is_null($this->feature_group['feature_group_is_required'])) {
													$result = $this->feature_group['feature_group_is_required'];
												}
												return $result;
												break;
											case 'display_type':
												$return = true;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->feature_group['feature_display_type'],
													'value' => $this->feature_group['feature_display_type'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'is_other':
												return $this->feature_group_name_id === 'oo';
												break;
											case 'display_your_cost':
												$result = false;
												if (!is_null($this->feature_group['feature_group_display_your_cost'])) {
													$result = $this->feature_group['feature_group_display_your_cost'];
												}
												return $result;
												break;
											case 'display_feature_price':
												$result = false;
												if (!is_null($this->feature_group['feature_group_display_feature_price'])) {
													$result = $this->feature_group['feature_group_display_feature_price'];
												}
												return $result;
												break;
											case 'display_instock':
												$result = false;
												if (!is_null($this->feature_group['feature_group_display_instock'])) {
													$result = $this->feature_group['feature_group_display_instock'];
												}
												return $result;
												break;
											case 'display_quan_instock':
												$result = false;
												if (!is_null($this->feature_group['feature_group_display_quan_instock'])) {
													$result = $this->feature_group['feature_group_display_quan_instock'];
												}
												return $result;
												break;
											case 'allow_outofstock_order':
												$result = false;
												if (!is_null($this->feature_group['feature_group_allow_outofstock_order'])) {
													$result = $this->feature_group['feature_group_allow_outofstock_order'];
												}
												return $result;
												break;
											case 'features':
												if ($num_args < 3 || !isset($third) && !is_string($third)) {
													return false;
												}

												switch ($third) {
													case 'exist':
														return $this->there_are_features_in_the_group();
														break;
													case 'at_the_beginning':
														return $this->features_index === 0;
														break;
													case 'next':
														if ($this->there_are_features_in_the_group()) {
															if (is_null($this->features_index)) {
																$this->features_index = 0;
																return true;
															} else {
																if (($this->features_index + 1) < $this->features_count) {
																	$this->features_index++;
																	return true;
																} else {
																	return false;
																}
															}
														} else {
															return false;
														}
														break;
													case 'reset':
														if ($this->there_are_features_in_the_group()) {
															$this->features_index = 0;
														}
														break;
													case 'index':
														$return = false;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->features_index,
															'value' => $this->features_index,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													case 'count':
														$return = true;
														if (isset($fourth)) {
															$return = $fourth;
														}
														return $this->echo_or_return(array(
															'formatted_value' => $this->features_count,
															'value' => $this->features_count,
															'type' => 'integer',
															'num_args' => $num_args,
															'return' => $return,
															'max_num_args' => 4));
														break;
													default:
														return false;
														break;
												}
												break;
											default:
												return false;
												break;
										}
										break;
									case 'feature':
										switch ($second) {
											case 'product_guid':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->features_in_the_group[$this->features_index]['feature_product_guid'],
													'value' => $this->features_in_the_group[$this->features_index]['feature_product_guid'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'is_required':
												return $this->features_in_the_group[$this->features_index]['feature_is_required'];
											case 'is_default':
												return $this->features_in_the_group[$this->features_index]['feature_is_default'];
												break;
											case 'is_feature_only':
												return $this->features_in_the_group[$this->features_index]['feature_only'];
												break;
											case 'product_page_link':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->build_product_page_link($this->features_in_the_group[$this->features_index]['feature_pg_link'], $this->features_in_the_group[$this->features_index]['feature_link_back']);
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'name':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->features_in_the_group[$this->features_index]['feature_name'],
													'value' => $this->features_in_the_group[$this->features_index]['feature_name'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'has_a_price':
												return $this->features_in_the_group[$this->features_index]['feature_price'] != null &&
														$this->features_in_the_group[$this->features_index]['feature_price'] != 0;
												break;
											case 'price':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->features_in_the_group[$this->features_index]['feature_price'],
													'value' => $this->features_in_the_group[$this->features_index]['feature_price'],
													'type' => 'numeric',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'has_quantity_in_stock':
												return $this->features_in_the_group[$this->features_index]['feature_quantity_in_stock'] != null;
												break;
											case 'quantity_in_stock':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->features_in_the_group[$this->features_index]['feature_quantity_in_stock'],
													'value' => $this->features_in_the_group[$this->features_index]['feature_quantity_in_stock'],
													'type' => 'numeric',
													'num_args' => $num_args,
													'return' => $return));
												break;
											default:
												return false;
												break;
										}
										break;
									case 'product_image':
										switch ($second) {
											case 'link':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_images[$this->product_images_index]['image_link'],
													'value' => $this->product_images[$this->product_images_index]['image_link'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'description':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_images[$this->product_images_index]['image_description'],
													'value' => $this->product_images[$this->product_images_index]['image_description'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											default:
												return false;
												break;
										}
										break;
									case 'quantity_discount':
										switch ($second) {
											case 'quantity':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_quantity_discounts[$this->product_quantity_discounts_index]['quantity'],
													'value' => $this->product_quantity_discounts[$this->product_quantity_discounts_index]['quantity'],
													'type' => 'numeric',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'price':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_quantity_discounts[$this->product_quantity_discounts_index]['price'],
													'value' => $this->product_quantity_discounts[$this->product_quantity_discounts_index]['price'],
													'type' => 'numeric',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'quantity_and_price_caption':
												if ($num_args < 3 || !isset($third) || !is_string($third)) {
													return false;
												}

												$return = false;
												if (isset($fourth)) {
													$return = $fourth;
												}

												if (isset($fifth)) {
													if (!is_bool($fifth)) {
														return false;
													}
												} else {
													$fifth = false;
												}

												$quantity = $this->product_quantity_discounts[$this->product_quantity_discounts_index]['quantity'];
												$price = $this->product_quantity_discounts[$this->product_quantity_discounts_index]['price'];
												if (!$fifth) {
													$price = $this->money_format($price);
												}

												$value = sprintf(__($third, 'orderstorm-wordpress-e-commerce'), $quantity, $price);
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return,
													'max_num_args' => 5));
												break;
											default:
												return false;
												break;
										}
										break;
									case 'product_question_and_answer':
										switch ($second) {
											case 'question':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_questions_and_answers[$this->product_questions_and_answers_index]['question'],
													'value' => $this->product_questions_and_answers[$this->product_questions_and_answers_index]['question'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'answer':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->product_questions_and_answers[$this->product_questions_and_answers_index]['answer'],
													'value' => $this->product_questions_and_answers[$this->product_questions_and_answers_index]['answer'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											default:
												return false;
												break;
										}
										break;
									case 'category_product':
										if (!$this->category_product = $this->get_current_category_product()) {
											return false;
										}
										switch ($second) {
											case 'present_thumbnail':
												return $this->category_product_present_thumbnail();
												break;
											case 'has':
												if ($num_args !== 3 || !isset($third) && !is_string($third)) {
													return false;
												}
												switch($third) {
													case 'has_thumbnail_serving_url':
														return $this->category_product_has_thumbnail_serving_url($third);
														break;
													case 'has_thumbnail_serving_surl':
														return $this->category_product_has_thumbnail_serving_surl($third);
														break;
													case 'thumbnail_image':
														return $this->category_product['thumbnail_image_extention_id'] !== 1;
														break;
													case 'item_number':
														return isset($this->category_product['item_number']) && !empty($this->category_product['item_number']);
														break;
													default:
														return false;
														break;
												}
												break;
											case 'page_link':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->build_product_page_link($this->category_product['pg_link'], $this->category_product['link_back']);
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'name':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->category_product['name'],
													'value' => $this->category_product['name'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'short_description':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->category_product['short_description'],
													'value' => $this->category_product['short_description'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'thumbnail_serving_url':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->category_product['serving_url'],
													'value' => $this->category_product['serving_url'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'thumbnail_serving_surl':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->category_product['serving_surl'],
													'value' => $this->category_product['serving_surl'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'thumbnail_image_url':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												$value = $this->build_product_small_image_url($this->category_product['product_id'], $this->category_product["thumbnail_image_extention"]);
												return $this->echo_or_return(array(
													'formatted_value' => $value,
													'value' => $value,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'your_cost':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->category_product['your_cost'],
													'value' => $this->category_product['your_cost'],
													'type' => 'numeric',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'item_number':
												$return = false;
												if (isset($third)) {
													$return = $third;
												}
												return $this->echo_or_return(array(
													'formatted_value' => $this->category_product['item_number'],
													'value' => $this->category_product['item_number'],
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											case 'item_number_with_caption':
												if ($num_args < 3 || !isset($third) || !is_string($third)) {
													return false;
												}

												$return = false;
												if (isset($fourth)) {
													$return = $fourth;
												}
												return $this->echo_or_return(array(
													'formatted_value' => sprintf(__($third, 'orderstorm-wordpress-e-commerce'), $this->category_product['item_number']),
													'value' => $third,
													'type' => 'string',
													'num_args' => $num_args,
													'return' => $return));
												break;
											default:
												return false;
												break;
										}
										break;
									default:
										return false;
										break;
								}
							} else {
								return false;
							}
							break;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
}
?>
