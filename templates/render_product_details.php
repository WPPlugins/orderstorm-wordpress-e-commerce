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
?>
<div class="product page">
	<form name="ostrm_product_details_form" id="ostrm_product_details_form" method="POST">
	<div class="product_image">
<?php if (orderstorm_ecommerce('product', 'has_media_settings')):?>
	<?php if (orderstorm_ecommerce('product', 'present_ad_gallery') && orderstorm_ecommerce('product', 'media', 'exist')):?>
		<div class="ad-gallery product-ad-gallery">
			<div class="ad-image-wrapper">
			</div>
			<div class="ad-controls">
			</div>
			<div class="ad-nav">
				<div class="ad-thumbs">
					<ul class="ad-thumb-list">
		<?php while (orderstorm_ecommerce('product', 'media', 'next')): ?>
			<?php if (orderstorm_ecommerce('product', 'medium', 'preview', 'has', 'serving_url') && orderstorm_ecommerce('product', 'medium', 'thumbnail', 'has', 'serving_url')):?>
						<li id="<?php orderstorm_ecommerce('product', 'medium', 'thumbnail', 'position_key'); ?>"<?php if (orderstorm_ecommerce('product', 'medium', 'zoom', 'has', 'serving_url')): ?> data-zoom="<?php if (is_ssl() && orderstorm_ecommerce('product', 'medium', 'zoom', 'has', 'serving_surl')): ?><?php orderstorm_ecommerce('product', 'medium', 'zoom', 'serving_surl'); ?><?php else: ?><?php orderstorm_ecommerce('product', 'medium', 'zoom', 'serving_url'); ?><?php endif; ?>"<?php endif; ?> >
							<a href="<?php if (is_ssl() && orderstorm_ecommerce('product', 'medium', 'preview', 'has', 'serving_surl')): ?><?php orderstorm_ecommerce('product', 'medium', 'preview', 'serving_surl'); ?><?php else: ?><?php orderstorm_ecommerce('product', 'medium', 'preview', 'serving_url'); ?><?php endif; ?>" >
								<img src="<?php if (is_ssl() && orderstorm_ecommerce('product', 'medium', 'thumbnail', 'has', 'serving_surl')): ?><?php orderstorm_ecommerce('product', 'medium', 'thumbnail', 'serving_surl'); ?><?php else: ?><?php orderstorm_ecommerce('product', 'medium', 'thumbnail', 'serving_url'); ?><?php endif; ?>" <?php if (orderstorm_ecommerce('product', 'medium', 'thumbnail', 'has', 'description')):?>longdesc="<?php orderstorm_ecommerce('product', 'medium', 'thumbnail', 'description'); ?>"<?php endif; ?> <?php if (orderstorm_ecommerce('product', 'medium', 'thumbnail', 'has', 'alt')):?>alt="<?php orderstorm_ecommerce('product', 'medium', 'thumbnail', 'alt'); ?>"<?php endif; ?> />
							</a>
						</li>
			<?php endif; ?>
		<?php endwhile; ?>
					</ul>
				</div>
			</div>
		</div>
	<?php endif;?>
<?php else:?>
	<?php if (orderstorm_ecommerce('product', 'has_extended_image') && orderstorm_ecommerce('meta_data', 'display_extended_image_for_product') && orderstorm_ecommerce('meta_data', 'display_large_image_for_product')): ?>
		<a href="<?php orderstorm_ecommerce('product', 'large_image_url'); ?>">
	<?php endif; ?>
	<?php if (orderstorm_ecommerce('product', 'has_extended_image')): ?>
		<img src="<?php orderstorm_ecommerce('product', 'medium_image_url'); ?>" alt="" border="0" />
	<?php elseif (orderstorm_ecommerce('product', 'has_default_medium_image')): ?>
		<img src="<?php orderstorm_ecommerce('product', 'default_medium_image_url'); ?>" alt="" border="0" />
	<?php endif; ?>
	<?php if (orderstorm_ecommerce('product', 'has_extended_image') && orderstorm_ecommerce('meta_data', 'display_large_image_for_product') && orderstorm_ecommerce('meta_data', 'display_large_image_for_product')): ?>
		</a>
	<?php endif; ?>
<?php endif;?>
<?php if (orderstorm_ecommerce('product', 'has_html5_drawing')): ?>
	<?php orderstorm_ecommerce('product', 'html5_drawing'); ?>
<?php endif; ?>
	</div>
	<div id="edit_product"><?php _e('You are logged in:', 'orderstorm-wordpress-e-commerce'); ?> <a href="https://www.orderstorm.com/sa/user/admin/product.asp?p_id=<?php orderstorm_ecommerce('product', 'guid'); ?>" target="_blank"><?php _e('Edit this product', 'orderstorm-wordpress-e-commerce'); ?></a> | <a href="javascript:void(0);" class="add_images">Add images</a></div>
<?php if (!orderstorm_ecommerce('product', 'should_name_be_used_as_product_page_title')): ?>
	<p class="product_name no_pre_spacer" title="<?php orderstorm_ecommerce('encode_html_entities', orderstorm_ecommerce('product', 'name', true)); ?>"><span id="product_name" class="ITE"><?php orderstorm_ecommerce('product', 'name'); ?></span></p>
<?php endif; ?>
	<div id="short_description" class="short_description ITA"><?php orderstorm_ecommerce('product', 'short_description'); ?></div>
<?php if (orderstorm_ecommerce('meta_data', 'display_in_stock_date')): ?>
	<p><font color="Red"><?php orderstorm_ecommerce('product', 'in_stock_date_caption', 'Due to the popularity of this item we are currently out of stock and will start shipping this item after <b>%s</b>. Order now to make sure you get one as soon as they are in stock!'); ?></font></p>
<?php endif; ?>
<?php if (orderstorm_ecommerce('meta_data', 'display_product_days_to_ship') && orderstorm_ecommerce('product', 'product_has_a_usual_days_to_ship')): ?>
	<p><font color="Red">This item usually takes about <span id="days_to_ship"><?php orderstorm_ecommerce('product', 'usual_days_to_ship'); ?></span><span id="up_to_days_to_ship"><?php if (orderstorm_ecommerce('product', 'product_has_a_usual_maximum_of_days_to_ship')): ?> to <?php orderstorm_ecommerce('product', 'usual_maximum_of_days_to_ship'); ?><?php endif; ?></span> days to ship</font></p>
<?php endif; ?>
<?php if (orderstorm_ecommerce('meta_data', 'display_item_number')): ?>
	<p class="no_inter_line"><?php if (orderstorm_ecommerce('meta_data', 'there_is_a_label_for_item_number_on_product_page')): ?><?php orderstorm_ecommerce('meta_data', 'label_for_item_number_on_product_page'); ?><?php else: ?><?php _e('item no.', 'orderstorm-wordpress-e-commerce'); ?><?php endif; ?> <span id="item_number" class="item_number ITE"><?php orderstorm_ecommerce('product', 'item_number'); ?></span></p>
<?php endif; ?>
<?php if (orderstorm_ecommerce('meta_data', 'display_retail_price') &&
			orderstorm_ecommerce('product', 'has_retail_price') && 
			!orderstorm_ecommerce('product', 'has_product_order_form')): ?>
	<p class="no_inter_line"><?php if (orderstorm_ecommerce('meta_data', 'there_is_a_label_for_retail_price_on_product_page')): ?><?php orderstorm_ecommerce('meta_data', 'label_for_retail_price_on_product_page'); ?><?php else: ?><?php _e('retail', 'orderstorm-wordpress-e-commerce'); ?><?php endif; ?> <span id="retail_price" class="retail_price ITE"><?php orderstorm_ecommerce('money_format', orderstorm_ecommerce('product', 'retail_price', true)) ?></span></p>
<?php endif; ?>
<?php if (orderstorm_ecommerce('meta_data', 'display_your_cost') &&
			!orderstorm_ecommerce('product', 'has_product_order_form')): ?>
	<p class="no_inter_line"><?php if (orderstorm_ecommerce('meta_data', 'there_is_a_label_for_your_cost_on_product_page')): ?><?php orderstorm_ecommerce('meta_data', 'label_for_your_cost_on_product_page'); ?><?php else: ?><?php _e('your cost', 'orderstorm-wordpress-e-commerce'); ?><?php endif; ?> <span id="your_cost" class="your_cost ITE"><?php orderstorm_ecommerce('money_format', orderstorm_ecommerce('product', 'your_cost', true)) ?></span></p>
<?php elseif (orderstorm_ecommerce('meta_data', 'not_for_sale')): ?>
	<p><b><?php _e('This item is currently not available for sale. This page is made available for informational purposes only.', 'orderstorm-wordpress-e-commerce'); ?></b></p>
<?php endif; ?>
<?php if (orderstorm_ecommerce('meta_data', 'display_quantity_in_stock')): ?>
	<p>
	<?php if (orderstorm_ecommerce('product', 'is_in_stock')): ?>
		<?php _e('In stock and ready to ship.', 'orderstorm-wordpress-e-commerce'); ?>
	<?php else: ?>
		<?php _e('This item is currently on back order.', 'orderstorm-wordpress-e-commerce'); ?>
	<?php endif; ?>
	</p>
<?php endif; ?>
	<hr class="separator"/>
<?php if (orderstorm_ecommerce('meta_data', 'display_product_images')): ?>
	<p><?php if (orderstorm_ecommerce('meta_data', 'there_is_a_label_for_extended_links_on_product_page')): ?><?php orderstorm_ecommerce('meta_data', 'label_for_extended_links_on_product_page'); ?><?php else: ?><?php _e('Related Links:', 'orderstorm-wordpress-e-commerce'); ?><?php endif; ?></p>
	<?php if (orderstorm_ecommerce('product', 'images', 'exist')): ?>
	<ul>
		<?php while (orderstorm_ecommerce('product', 'images', 'next')): ?>
		<li><a href="<?php orderstorm_ecommerce('product_image', 'link'); ?>" target="_blank" class="nav1"><?php orderstorm_ecommerce('product_image', 'description'); ?></a></li>
		<?php endwhile; ?>
	</ul>
	<?php endif; ?>
<?php endif; ?>
<?php if (orderstorm_ecommerce('meta_data', 'display_product_features') && orderstorm_ecommerce('product', 'features', 'exist')): ?>
	<div class="features_table">
		<table cellspacing="0">
			<colgroup>
				<col />
				<col />
				<col />
			</colgroup>
			<tbody>
	<?php if (orderstorm_ecommerce('meta_data', 'there_is_a_label_for_features_on_the_product_page')): ?>
				<tr>
					<td colspan="2" class="header"><?php orderstorm_ecommerce('meta_data', 'label_for_features_on_the_product_page'); ?></td>
					<td align="right" class="header"></td>
				</tr>
	<?php endif; ?>
	<?php while (orderstorm_ecommerce('product', 'features', 'next_group')): ?>
		<?php if (orderstorm_ecommerce('product', 'features', 'count') > 1 || (orderstorm_ecommerce('product', 'features', 'count') === 1 && !orderstorm_ecommerce('feature_group', 'is_other'))): ?>
				<tr>
					<td colspan="3">
						<div>
			<?php if (orderstorm_ecommerce('feature_group', 'is_other')): ?>
				<?php if (orderstorm_ecommerce('meta_data', 'there_is_a_text_for_other_options')): ?>
							<?php orderstorm_ecommerce('meta_data', 'text_for_other_options'); ?>
				<?php else: ?>
							<?php _e('other options', 'orderstorm-wordpress-e-commerce'); ?>
				<?php endif; ?>
			<?php elseif (orderstorm_ecommerce('feature_group', 'display_type') === 'productsList'):?>
			<?php elseif (orderstorm_ecommerce('feature_group', 'display_type') === 'productOrderForm'):?>
			<?php else: ?>
							<?php orderstorm_ecommerce('feature_group', 'name'); ?>
			<?php endif; ?>
			<?php if (orderstorm_ecommerce('feature_group', 'display_type') === 'productsList'): ?>
			<?php elseif (orderstorm_ecommerce('feature_group', 'display_type') === 'productOrderForm'):?>
			<?php elseif (orderstorm_ecommerce('feature_group', 'is_required')): ?>
							<font color="Red"> (required)</font>
			<?php endif; ?>
						</div>
		<?php endif; ?>
		<?php if (orderstorm_ecommerce('feature_group', 'display_type') === 'dropdown'): ?>
						<select name="feature[<?php orderstorm_ecommerce('feature_group', 'name_id'); ?>]">
			<?php if (!orderstorm_ecommerce('feature_group', 'is_required')): ?>
							<option value="null" selected="selected">NONE</option>
			<?php endif; ?>
		<?php elseif (orderstorm_ecommerce('feature_group', 'display_type') === 'colorSelector'): ?>
						<br /><input type="hidden" value="" name="feature[<?php orderstorm_ecommerce('feature_group', 'name_id'); ?>]" />
						<div id="color-picker-<?php orderstorm_ecommerce('feature_group', 'name_id'); ?>" style="display:inline-block"></div>
						<span id="selected-color-<?php orderstorm_ecommerce('feature_group', 'name_id'); ?>" class="selected-color"></span>
		<?php elseif (orderstorm_ecommerce('feature_group', 'display_type') === 'productsList' || orderstorm_ecommerce('feature_group', 'display_type') === 'productOrderForm'): ?>
						<table>
							<tr>
								<td><?php orderstorm_ecommerce('feature_group', 'name'); ?></td>
			<?php if (orderstorm_ecommerce('feature_group', 'display_your_cost') ||
						orderstorm_ecommerce('feature_group', 'display_feature_price')): ?>
								<td>price</td>
			<?php endif; ?>
			<?php if (orderstorm_ecommerce('feature_group', 'display_instock') ||
						orderstorm_ecommerce('feature_group', 'display_quan_instock')): ?>
								<td>in stock</td>
			<?php endif; ?>
								<td>quantity</td>
							</tr>
		<?php else: ?>
					</td>
				</tr>
		<?php endif; ?>
		<?php while (orderstorm_ecommerce('feature_group', 'features', 'next')): ?>
			<?php if (orderstorm_ecommerce('feature_group', 'display_type') === 'dropdown'): ?>
							<option value="<?php orderstorm_ecommerce('feature', 'product_guid'); ?>"<?php if (orderstorm_ecommerce('feature', 'is_default')): ?> selected="selected"<?php endif; ?>>
				<?php if (!orderstorm_ecommerce('feature', 'is_feature_only')): ?>
								<a href="<?php orderstorm_ecommerce('feature', 'product_page_link'); ?>" target="_blank"><?php orderstorm_ecommerce('feature', 'name'); ?></a>
				<?php else: ?>
								<?php orderstorm_ecommerce('feature', 'name'); ?>
				<?php endif; ?>
				<?php if (orderstorm_ecommerce('feature', 'is_required')): ?>
								<font color="Red"><?php _e('(required)', 'orderstorm-wordpress-e-commerce'); ?></font>
				<?php endif; ?>
				<?php if (orderstorm_ecommerce('meta_data', 'display_feature_prices') && orderstorm_ecommerce('feature', 'has_a_price')): ?>
								<?php if (orderstorm_ecommerce('feature', 'price', true) > 0): ?>+<?php else: ?>-<?php endif; ?><?php orderstorm_ecommerce('money_format', orderstorm_ecommerce('feature', 'price', true)); ?>
				<?php endif; ?>
							</option>
			<?php elseif (orderstorm_ecommerce('feature_group', 'display_type') === 'productsList'): ?>
							<tr class="productsListRow">
								<td><?php orderstorm_ecommerce('feature', 'name'); ?></td>
				<?php if (orderstorm_ecommerce('feature_group', 'display_your_cost') ||
							orderstorm_ecommerce('feature_group', 'display_feature_price')): ?>
								<td><?php if (orderstorm_ecommerce('feature_group', 'display_feature_price') &&
												orderstorm_ecommerce('feature', 'has_a_price')): ?><?php orderstorm_ecommerce('money_format', orderstorm_ecommerce('feature', 'price', true)); ?><?php endif; ?></td>
				<?php endif; ?>
				<?php if (orderstorm_ecommerce('feature_group', 'display_instock')): ?>
								<td><input type="checkbox"<?php if (orderstorm_ecommerce('feature', 'has_quantity_in_stock') && orderstorm_ecommerce('feature', 'quantity_in_stock', true) > 0): ?> checked="checked"<?php endif; ?> disabled="disabled" /></td>
				<?php elseif (orderstorm_ecommerce('feature_group', 'display_quan_instock')): ?>
								<td><?php if (orderstorm_ecommerce('feature', 'has_quantity_in_stock')): ?><?php if (orderstorm_ecommerce('feature', 'quantity_in_stock', true) > 0): ?><?php orderstorm_ecommerce('feature', 'quantity_in_stock'); ?><?php else: ?>0<?php endif; ?><?php else: ?>0<?php endif; ?></td>
				<?php endif; ?>
				<?php $display_order_quantity_field = true;
				if ((orderstorm_ecommerce('feature_group', 'display_instock') || orderstorm_ecommerce('feature_group', 'display_quan_instock')) &&
					((!orderstorm_ecommerce('feature', 'has_quantity_in_stock') || orderstorm_ecommerce('feature', 'quantity_in_stock', true) <= 0) && !orderstorm_ecommerce('feature_group', 'allow_outofstock_order'))):
					$display_order_quantity_field = false;
				endif; ?>
								<td><?php if($display_order_quantity_field): ?><input type="text" name="productsList[<?php orderstorm_ecommerce('feature_group', 'name_id'); ?>][<?php orderstorm_ecommerce('feature_group', 'features', 'index'); ?>]" size="4" /><?php endif; ?></td>
							</tr>
			<?php elseif (orderstorm_ecommerce('feature_group', 'display_type') === 'productOrderForm'): ?>
							<tr class="productsOrderFormRow">
								<td><?php orderstorm_ecommerce('feature', 'name'); ?></td>
				<?php if (orderstorm_ecommerce('feature_group', 'display_your_cost') ||
							orderstorm_ecommerce('feature_group', 'display_feature_price')): ?>
								<td><?php if (orderstorm_ecommerce('feature_group', 'display_feature_price') &&
												orderstorm_ecommerce('feature', 'has_a_price')): ?><?php orderstorm_ecommerce('money_format', orderstorm_ecommerce('feature', 'price', true)); ?><?php endif; ?></td>
				<?php endif; ?>
				<?php if (orderstorm_ecommerce('feature_group', 'display_instock')): ?>
								<td><input type="checkbox"<?php if (orderstorm_ecommerce('feature', 'has_quantity_in_stock') && orderstorm_ecommerce('feature', 'quantity_in_stock', true) > 0): ?> checked="checked"<?php endif; ?> disabled="disabled" /></td>
				<?php elseif (orderstorm_ecommerce('feature_group', 'display_quan_instock')): ?>
								<td><?php if (orderstorm_ecommerce('feature', 'has_quantity_in_stock')): ?><?php if (orderstorm_ecommerce('feature', 'quantity_in_stock', true) > 0): ?><?php orderstorm_ecommerce('feature', 'quantity_in_stock'); ?><?php else: ?>0<?php endif; ?><?php else: ?>0<?php endif; ?></td>
				<?php endif; ?>
				<?php $display_order_quantity_field = true;
				if ((orderstorm_ecommerce('feature_group', 'display_instock') || orderstorm_ecommerce('feature_group', 'display_quan_instock')) &&
					((!orderstorm_ecommerce('feature', 'has_quantity_in_stock') || orderstorm_ecommerce('feature', 'quantity_in_stock', true) <= 0) && !orderstorm_ecommerce('feature_group', 'allow_outofstock_order'))):
					$display_order_quantity_field = false;
				endif; ?>
								<td><?php if($display_order_quantity_field): ?><input type="text" name="productOrderForm[<?php orderstorm_ecommerce('feature_group', 'name_id'); ?>][<?php orderstorm_ecommerce('feature_group', 'features', 'index'); ?>]" size="4" /><?php endif; ?></td>
							</tr>
			<?php elseif (orderstorm_ecommerce('feature_group', 'display_type') !== 'colorSelector'): ?>
				<tr>
					<td />
					<td>
				<?php if (orderstorm_ecommerce('feature_group', 'is_other')): ?>
						<input type="checkbox" value="<?php orderstorm_ecommerce('feature', 'product_guid'); ?>" name="feature[<?php orderstorm_ecommerce('feature_group', 'name_id'); ?>][<?php orderstorm_ecommerce('feature_group', 'features', 'index'); ?>]"<?php if (orderstorm_ecommerce('feature', 'is_required')): ?> checked="checked" disabled="disabled"<?php endif; ?> />
				<?php else: ?>
					<?php if (orderstorm_ecommerce('feature_group', 'display_type') === 'radio'): ?>
						<input type="radio" value="<?php orderstorm_ecommerce('feature', 'product_guid'); ?>" name="feature[<?php orderstorm_ecommerce('feature_group', 'name_id'); ?>]"<?php if (orderstorm_ecommerce('feature', 'is_default')): ?> checked="checked"<?php endif; ?> />
					<?php else: ?>
						<input type="checkbox" value="<?php orderstorm_ecommerce('feature', 'product_guid'); ?>" name="feature[<?php orderstorm_ecommerce('feature_group', 'name_id'); ?>][<?php orderstorm_ecommerce('feature_group', 'features', 'index'); ?>]"<?php if (orderstorm_ecommerce('feature', 'is_required')): ?> checked="checked" disabled="disabled"<?php endif; ?> />
					<?php endif; ?>
				<?php endif; ?>
				<?php if (orderstorm_ecommerce('feature', 'is_feature_only')): ?>
						<a href="<?php orderstorm_ecommerce('feature', 'product_page_link'); ?>" target="_blank"><?php orderstorm_ecommerce('feature', 'name'); ?></a>
				<?php else: ?>
						<?php orderstorm_ecommerce('feature', 'name'); ?>
				<?php endif; ?>
				<?php if (orderstorm_ecommerce('feature', 'is_required')): ?>
						<font color="Red">(required)</font>
				<?php endif; ?>
					</td>
					<td align="right">
				<?php if (orderstorm_ecommerce('meta_data', 'display_feature_prices')): ?>
					<?php if (orderstorm_ecommerce('feature', 'price', true) > 0): ?>
						Add <?php orderstorm_ecommerce('money_format', orderstorm_ecommerce('feature', 'price', true)); ?>
					<?php elseif (orderstorm_ecommerce('feature', 'price', true) < 0): ?>
						<font color="Red"><?php orderstorm_ecommerce('money_format', orderstorm_ecommerce('feature', 'price', true)); ?></font>
					<?php endif; ?>
				<?php endif; ?>
					</td>
				</tr>
			<?php endif; ?>
		<?php endwhile; ?>
		<?php if (orderstorm_ecommerce('feature_group', 'display_type') === 'dropdown'): ?>
						</select>
					</td>
				</tr>
		<?php elseif (orderstorm_ecommerce('feature_group', 'display_type') === 'productsList' || orderstorm_ecommerce('feature_group', 'display_type') === 'productOrderForm'): ?>
							</table>
		<?php endif; ?>
	<?php endwhile; ?>
			</tbody>
		</table>
		<hr class="separator" />
	</div>
<?php endif; ?>
<input type="hidden" name="id" value="<?php orderstorm_ecommerce('product', 'guid'); ?>" />
<?php if (orderstorm_ecommerce('meta_data', 'display_product_ordering_information')): ?>
	<?php if (orderstorm_ecommerce('meta_data', 'allow_users_to_place_orders')): ?>
		<div class="quantity">
		<?php if (orderstorm_ecommerce('product', 'has_products_lists') || orderstorm_ecommerce('product', 'has_product_order_form')): ?>
			<input type="hidden" name="Quantity" id="Quantity" value="<?php orderstorm_ecommerce('product', 'proposed_order_quantity'); ?>" />
		<?php else: ?>
			<label for="Quantity"><?php _e('How many:', 'orderstorm-wordpress-e-commerce'); ?></label>
			<input type="text" name="Quantity" id="Quantity" value="<?php orderstorm_ecommerce('product', 'proposed_order_quantity'); ?>" size="3" maxlength="6" />
		<?php endif; ?>
		<?php if (orderstorm_ecommerce('meta_data', 'there_is_an_image_for_the_add_product_to_order_button')): ?>
			<input type="image" name="add_to_cart" id="add_to_cart" value="Add to cart" src="<?php orderstorm_ecommerce('meta_data', 'add_product_to_order_button_image_url') ?>" />
		<?php else: ?>
			<input type="submit" name="add_to_cart" id="add_to_cart" value="<?php if (orderstorm_ecommerce('meta_data', 'there_is_a_label_for_the_add_product_to_order_button')): orderstorm_ecommerce('meta_data', 'add_product_to_order_button_label'); else: _e('Add to cart', 'orderstorm-wordpress-e-commerce'); endif; ?>" />
		<?php endif; ?>
		</div>
		<hr class="separator" />
	<?php endif; ?>
	</form>
	<?php if (orderstorm_ecommerce('meta_data', 'display_minimum_product_order_quantity')): ?>
	<p><font color="Red"><?php orderstorm_ecommerce('product', 'minimum_order_quantity_caption', 'There is a required <b>minimum order of %s</b> on this item.'); ?></font></p>
	<?php endif; ?>
	<?php if (orderstorm_ecommerce('meta_data', 'display_product_shipping_information')): ?>
	<p class="<?php if (orderstorm_ecommerce('product', 'ships_for_free')): ?>ships_free<?php else: ?>does_not_ship_free<?php endif; ?>">
	<?php if (orderstorm_ecommerce('product', 'ships_for_free')): ?>
		<?php if (orderstorm_ecommerce('meta_data', 'there_is_a_product_ships_for_free_text')): ?>
			<?php orderstorm_ecommerce('meta_data', 'product_ships_for_free_text'); ?>
		<?php else: ?>
			<?php _e('this product ships free', 'orderstorm-wordpress-e-commerce'); ?>
		<?php endif; ?>
	<?php else: ?>
		<?php if (orderstorm_ecommerce('meta_data', 'there_is_a_product_does_not_ship_for_free_text')): ?>
			<?php orderstorm_ecommerce('meta_data', 'product_does_not_ship_for_free_text'); ?>
		<?php else: ?>
			<?php _e('this product does not ship free', 'orderstorm-wordpress-e-commerce'); ?>
		<?php endif; ?>
	<?php endif; ?>
	</p>
	<?php endif; ?>
<?php else: ?>
	</form>
<?php endif; ?>
<?php if (orderstorm_ecommerce('meta_data', 'allow_users_to_place_orders')): ?>
	<?php if (orderstorm_ecommerce('product', 'quantity_discounts', 'exist')): ?>
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2" class="qty_discount title"><?php orderstorm_ecommerce('meta_data', 'product_page_quantity_discount_label'); ?></td>
		</tr>
		<?php while (orderstorm_ecommerce('product', 'quantity_discounts', 'next')): ?>
		<tr>
			<td valign="top" class="qty_discount">-&nbsp;</td>
			<td class="qty_discount"><?php orderstorm_ecommerce('quantity_discount', 'quantity_and_price_caption', 'Buy %1$s&#8230; pay only %2$s ea.'); ?></td>
		</tr>
		<?php endwhile; ?>
	</table>
	<?php endif; ?>
<?php endif; ?>
<?php if (orderstorm_ecommerce('meta_data', 'display_long_description')): ?>
	<p><?php orderstorm_ecommerce('product', 'long_description'); ?></p>
<?php endif; ?>
<?php if (orderstorm_ecommerce('meta_data', 'should_questions_and_answers_be_displayed_on_the_product_page')): ?>
	<?php if (orderstorm_ecommerce('product', 'questions_and_answers', 'exist')): ?>
	<div class="qa">
		<div class="title"><?php _e('The Q&amp;A on this Product', 'orderstorm-wordpress-e-commerce'); ?></div>
		<?php while (orderstorm_ecommerce('product', 'questions_and_answers', 'next')): ?>
		<div class="<?php if (orderstorm_ecommerce('product', 'questions_and_answers', 'at_the_beginning')): ?>first <?php endif; ?>row">
			<b><?php _e('QUESTION:', 'orderstorm-wordpress-e-commerce'); ?>&nbsp;&nbsp;</b><?php orderstorm_ecommerce('product_question_and_answer', 'question'); ?><br />
			<b><?php _e('ANSWER:', 'orderstorm-wordpress-e-commerce'); ?>&nbsp;&nbsp;</b><?php orderstorm_ecommerce('product_question_and_answer', 'answer'); ?>
		</div>
		<?php endwhile; ?>
	</div>
	<?php endif; ?>
	<div class="qa_form">
		<div class="title"><?php _e('Still have questions about this product?', 'orderstorm-wordpress-e-commerce'); ?></div>
		<div class="form">
			<form name="ostrm_product_question" id="ostrm_product_question" method="POST">
				<input type="hidden" name="id" value="<?php orderstorm_ecommerce('product', 'guid'); ?>" />
				<div class="row">
					<span class="label"><label for="question"><?php _e('Ask your question here:', 'orderstorm-wordpress-e-commerce'); ?></label></span>
					<span class="formw"><textarea id="question" name="question" class="field" cols="50" rows="5"></textarea></span>
				</div>
				<div class="row">
					<span class="label"><label for="email"><?php _e('Your email (so we can send you the answer):', 'orderstorm-wordpress-e-commerce'); ?></label></span>
					<span class="formw"><input type="text" id="email" name="email" class="field" size="40" maxlength="255" value="<?php orderstorm_ecommerce('product', 'questions_and_answers', 'e_mail_address'); ?>" /></span>
				</div>
				<div class="row">
					<span class="label"></span>
					<span class="formw"><input type="submit" value="<?php _e('Send your question', 'orderstorm-wordpress-e-commerce'); ?>" /></span>
				</div>
				<div class="spacer">&nbsp;</div>
			</form>
		</div>
	</div>
<?php endif; ?>
</div>
