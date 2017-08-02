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
class orderstorm_ecommerce_categories_menu extends WP_Widget
{
	private $product_category_page_slug;
	private $use_seo_friendly_product_category_links;

	function widget($args, $instance)
	{
		if ($GLOBALS['osws']->should_categories_menu_be_rendered() === true)
		{
			extract($args);

			$title = apply_filters('widget_title', $instance['title']);

			switch ($instance['menu_type'])
			{
				case '1':
					$ostrm_menu_type = 'sidebar';
					break;
				case '2':
					$ostrm_menu_type = 'horizontal';
					break;
				default:
					$ostrm_menu_type = 'sidebar';
					break;
			}

			switch ($instance['unfolding_direction'])
			{
				case '1':
					$ostrm_menu_unfolding_direction = 'right';
					break;
				case '2':
					$ostrm_menu_unfolding_direction = 'left';
					break;
				case '3':
					$ostrm_menu_unfolding_direction = 'down';
					break;
				case '4':
					$ostrm_menu_unfolding_direction = 'up';
					break;
				default:
					$ostrm_menu_unfolding_direction = 'right';
					break;
			}

			$max_level = $instance['max_level'];
			if (OrderStormECommerceForWordPress::isAllNumericDigits($max_level))
			{
				$max_level = intval($max_level);
				if ($max_level === 0)
				{
					$max_level = NULL;
				}
			}
			else
			{
				$max_level = NULL;
			}

			$parent_category_guid = $instance['parent_category_guid'];
			if (OrderStormECommerceForWordPress::isWellFormedGUID($parent_category_guid))
			{
				$parent_category_guid = '{' . strtoupper(str_replace(array('{', '}'), '', $parent_category_guid)) . '}';
			}
			else
			{
				$parent_category_guid = NULL;
			}
			$instance['parent_category_guid'] = $parent_category_guid;

			$ostrCategories = $GLOBALS['osws']->get_category_menu($parent_category_guid, $max_level);
			$rowCount = $ostrCategories->rowCount();
			if ($rowCount > 0)
			{
				echo($before_widget);

				if ($title)
				{
					echo($before_title . $title . $after_title);
				}

				$there_is_a_parent_category = !is_null($parent_category_guid);
				if (!empty($ostrCategories) && (!$there_is_a_parent_category || ($there_is_a_parent_category && ($rowCount > 1))))
				{
					$parent_category_tree_level = 0;
					$parent_category_guid = '';
					$parent_category_description = '';
					$category_tree_level = 0;
					$category_guid = '';
					$category_description = '';
					$last_for_level = false;
					$previous_category_tree_level = 0;
					$previous_category_guid = '';
					$previous_category_description = '';
					$previous_last_for_level = false;

					for($rowIndex = 0; $rowIndex < $rowCount; $rowIndex++)
					{
						if ($previous_category_tree_level == 0)
						{
							if ($there_is_a_parent_category)
							{
								if ($parent_category_tree_level == 0)
								{
									$parent_category_tree_level = $ostrCategories->fieldValue($rowIndex, 'level');
									$parent_category_guid = $ostrCategories->fieldValue($rowIndex, 'category_guid');
									$parent_category_description = $ostrCategories->fieldValue($rowIndex, 'category_description');
								}
								else
								{
									$previous_category_tree_level = $ostrCategories->fieldValue($rowIndex, 'level') - 1;
									$previous_category_guid = $ostrCategories->fieldValue($rowIndex, 'category_guid');
									$previous_category_description = $ostrCategories->fieldValue($rowIndex, 'category_description');
									$previous_category_pg_link = $ostrCategories->fieldValue($rowIndex, 'pg_link');
									$previous_category_link_to = $ostrCategories->fieldValue($rowIndex, 'link_to');
									$previous_last_for_level = $ostrCategories->fieldValue($rowIndex, 'last_for_level');
									$this->ostrm_categories_menu_start($previous_category_tree_level, $ostrm_menu_type, $ostrm_menu_unfolding_direction);
								}
							}
							else
							{
								$previous_category_tree_level = $ostrCategories->fieldValue($rowIndex, 'level');
								$previous_category_guid = $ostrCategories->fieldValue($rowIndex, 'category_guid');
								$previous_category_description = $ostrCategories->fieldValue($rowIndex, 'category_description');
								$previous_category_pg_link = $ostrCategories->fieldValue($rowIndex, 'pg_link');
								$previous_category_link_to = $ostrCategories->fieldValue($rowIndex, 'link_to');
								$previous_last_for_level = $ostrCategories->fieldValue($rowIndex, 'last_for_level');
								$this->ostrm_categories_menu_start($previous_category_tree_level, $ostrm_menu_type, $ostrm_menu_unfolding_direction);
							}
						}
						else
						{
							$category_tree_level = ($there_is_a_parent_category?$ostrCategories->fieldValue($rowIndex, 'level') - 1:$ostrCategories->fieldValue($rowIndex, 'level'));
							$category_guid = $ostrCategories->fieldValue($rowIndex, 'category_guid');
							$category_description = $ostrCategories->fieldValue($rowIndex, 'category_description');
							$category_pg_link = $ostrCategories->fieldValue($rowIndex, 'pg_link');
							$category_link_to = $ostrCategories->fieldValue($rowIndex, 'link_to');
							$last_for_level = $ostrCategories->fieldValue($rowIndex, 'last_for_level');

							$this->ostrm_categories_menu_item_start($previous_category_pg_link, $previous_category_link_to, $previous_category_guid, $previous_category_description, $previous_last_for_level);

							if ($category_tree_level <> $previous_category_tree_level)
							{
								if ($category_tree_level > $previous_category_tree_level)
								{
									$this->ostrm_categories_menu_start($category_tree_level, $ostrm_menu_type, $ostrm_menu_unfolding_direction);
								}
								else
								{
									$this->ostrm_categories_submenu_end($previous_category_tree_level, $category_tree_level);
								}
							}
							else
							{
								$this->ostrm_categories_menu_item_end();
							}

							$previous_category_tree_level = $category_tree_level;
							$previous_category_guid = $category_guid;
							$previous_category_description = $category_description;
							$previous_category_pg_link = $category_pg_link;
							$previous_category_link_to = $category_link_to;
							$previous_last_for_level = $last_for_level;
						}
					}
					$this->ostrm_categories_menu_item_start($previous_category_pg_link, $previous_category_link_to, $previous_category_guid, $previous_category_description, $previous_last_for_level);
					$this->ostrm_categories_menu_item_end();
					$this->ostrm_categories_menu_end();
					$this->ostrm_categories_submenu_end($previous_category_tree_level, 1);
				}

				echo($after_widget);
			}
		}
	}

	private function ostrm_categories_menu_start($level, $ostrm_categories_menu_type, $ostrm_categories_menu_unfolding_direction)
	{
		$strMenuDirectionClass = 'dir_' . $ostrm_categories_menu_unfolding_direction;
?>
				<div class="ostrm_categories_menu <?php echo($ostrm_categories_menu_type); ?> <?php echo(strval($level > 1?"submenu":"topmenu " . $strMenuDirectionClass)); ?>">
					<div class="ostrm_categories_mt">
						<div class="ostrm_categories_menu_list">
							<ul>
<?php
	}

	private function ostrm_categories_menu_end()
	{
?>
							</ul>
						</div>
					</div>
				</div>
<?php
	}

	private function ostrm_categories_menu_item_start($category_pg_link, $category_link_to, $category_guid, $category_description, $last_item)
	{
?>
							<li<?php echo(strval($last_item?" class=\"last\"":"")); ?>>
								<a href="<?php echo($GLOBALS['osws']->build_product_category_page_link($category_pg_link, $category_link_to)); ?>"><?php echo($category_description); ?></a>
<?php
	}

	private function ostrm_categories_menu_item_end()
	{
?>
							</li>
<?php
	}

	private function ostrm_categories_submenu_end($previous_category_tree_level, $category_tree_level)
	{
		for ($counter = 1; $counter <= ($previous_category_tree_level - $category_tree_level); $counter = $counter + 1)
		{
			$this->ostrm_categories_menu_item_end();
			$this->ostrm_categories_menu_end();
		}
	}

	function orderstorm_ecommerce_categories_menu()
	{
		$this->product_category_page_slug = get_option('orderstorm_ecommerce_product_category_page_slug');
		$this->use_seo_friendly_product_category_links = get_option('orderstorm_ecommerce_use_seo_friendly_product_category_links');

		$widget_ops = array('classname' => 'widget_ostrm_categories_menu', 'description' => __('Recursive menu listing of OrderStorm categories', 'orderstorm-wordpress-e-commerce'));
		$control_ops = array('id_base' => 'orderstorm_ecommerce_categories_menu');
		$this->WP_Widget('orderstorm_ecommerce_categories_menu', __('OrderStorm Categories Menu', 'orderstorm-wordpress-e-commerce'), $widget_ops, $control_ops);
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['menu_type'] = $new_instance['menu_type'];
		$instance['unfolding_direction'] = $new_instance['unfolding_direction'];

		$max_level = $new_instance['max_level'];
		if (OrderStormECommerceForWordPress::isAllNumericDigits($max_level))
		{
			$max_level = sprintf('%u', intval($max_level));
		}
		else
		{
			$max_level = '0';
		}
		$instance['max_level'] = $max_level;

		$parent_category_guid = $new_instance['parent_category_guid'];
		if (OrderStormECommerceForWordPress::isWellFormedGUID($parent_category_guid))
		{
			$parent_category_guid = '{' . strtoupper(str_replace(array('{', '}'), '', $parent_category_guid)) . '}';
		}
		else
		{
			$parent_category_guid = '';
		}
		$instance['parent_category_guid'] = $parent_category_guid;

		return $instance;
	}

	function form($instance)
	{
		$defaults =	array
					(
						'title' => __('Categories', 'orderstorm-wordpress-e-commerce'),
						'menu_type' => '1',
						'unfolding_direction' => '1',
						'max_level' => '0',
						'parent_category_guid' => ''
					);
		$instance = wp_parse_args((array) $instance, $defaults);
?>
<p>
	<label for="<?php echo($this->get_field_id('title')); ?>"><?php echo(__('Title', 'orderstorm-wordpress-e-commerce')); ?>:</label>
	<input type = "text" class="widefat" id="<?php echo($this->get_field_id('title')); ?>" name="<?php echo($this->get_field_name('title')); ?>" value="<?php echo($instance['title']); ?>" />
</p>
<p>
	<label for="<?php echo($this->get_field_id('menu_type')); ?>"><?php echo(__('Menu type', 'orderstorm-wordpress-e-commerce')); ?>:</label>
	<select class="widefat" id="<?php echo($this->get_field_id('menu_type')); ?>" name="<?php echo($this->get_field_name('menu_type')); ?>">
		<option <?php if (1 == $instance['menu_type'] ) {echo('selected="selected"');} ?> value="1"><?php echo(__('sidebar', 'orderstorm-wordpress-e-commerce')); ?></option>
	</select>
</p>
<p>
	<label for="<?php echo($this->get_field_id('unfolding_direction')); ?>"><?php echo(__('Menu unfolding direction', 'orderstorm-wordpress-e-commerce')); ?>:</label>
	<select class="widefat" id="<?php echo($this->get_field_id('unfolding_direction')); ?>" name="<?php echo($this->get_field_name('unfolding_direction')); ?>">
		<option <?php if ('1' == $instance['unfolding_direction'] ) {echo('selected="selected"');} ?> value="1"><?php echo(__('right', 'orderstorm-wordpress-e-commerce')); ?></option>
	</select>
</p>
<p>
	<label for="<?php echo($this->get_field_id('max_level')); ?>"><?php echo(__('Maximum menu level depth (<small><i>0 = all levels</i></small>)', 'orderstorm-wordpress-e-commerce')); ?>:</label>
	<input type = "text" class="widefat" id="<?php echo($this->get_field_id('max_level')); ?>" name="<?php echo($this->get_field_name('max_level')); ?>" value="<?php echo($instance['max_level']); ?>" />
</p>
<p>
	<label for="<?php echo($this->get_field_id('parent_category_guid')); ?>"><?php echo(__('Parent category key (<small><i>&lt;empty&gt; = from the top</i></small>)', 'orderstorm-wordpress-e-commerce')); ?>:</label>
	<input type = "text" class="widefat" id="<?php echo($this->get_field_id('parent_category_guid')); ?>" name="<?php echo($this->get_field_name('parent_category_guid')); ?>" value="<?php echo($instance['parent_category_guid']); ?>" />
</p>
<?php
	}
}
?>
