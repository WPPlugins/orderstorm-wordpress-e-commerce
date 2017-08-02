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
<div class="categories page">
<?php

	if (orderstorm_ecommerce('category', 'present_image') && orderstorm_ecommerce('category', 'media', 'exist')):
?>
	<h1>Category media exist</h1>
<?php endif; ?>
<?php if (!orderstorm_ecommerce('category', 'should_name_be_used_as_category_page_title')): ?>
	<h1><?php orderstorm_ecommerce('category', 'description'); ?></h1>
<?php endif; ?>
<?php if (orderstorm_ecommerce('category', 'long_description_is_not_empty')): ?>
	<div class="long_description"><?php orderstorm_ecommerce('category', 'long_description'); ?></div>
<?php endif; ?>
</div>
<?php if (orderstorm_ecommerce('category', 'sub_categories', 'exist')): ?>
<div class="categories list">
	<?php while (orderstorm_ecommerce('category', 'sub_categories', 'next')): ?>
		<?php if (orderstorm_ecommerce('category', 'has', 'media_settings')): ?>
			<?php if (orderstorm_ecommerce('category', 'present_image')): ?>
	<div class="tile_medium">
		<a href="<?php orderstorm_ecommerce('sub_category', 'page_link'); ?>">
			<label><?php orderstorm_ecommerce('sub_category', 'description'); ?></label>
		</a>
		<div>
			<a class="add_category_image" href="javascript:void(0);" data-key="<?php orderstorm_ecommerce('sub_category', 'key'); ?>">Add image</a>
				<?php if (	(!is_ssl() && orderstorm_ecommerce('sub_category', 'has', 'serving_url')) ||
							(is_ssl() && orderstorm_ecommerce('sub_category', 'has', 'serving_surl'))): ?>
			<img class="category-image" src="<?php if (is_ssl()): orderstorm_ecommerce('sub_category', 'serving_surl'); else: orderstorm_ecommerce('sub_category', 'serving_url'); endif; ?>" data-page-link="<?php orderstorm_ecommerce('sub_category', 'page_link'); ?>" />
				<?php endif; ?>
		</div>
	</div>
			<?php endif; ?>
		<?php else: ?>
	<div class="tile_medium">
		<a href="<?php orderstorm_ecommerce('sub_category', 'page_link'); ?>">
			<label><?php orderstorm_ecommerce('sub_category', 'description'); ?></label>
		</a>
		<div>
		<?php if (orderstorm_ecommerce('sub_category', 'has_image')): ?>
			<img class="category-image" src="<?php orderstorm_ecommerce('sub_category', 'image_url') ?>" data-page-link="<?php orderstorm_ecommerce('sub_category', 'page_link'); ?>" />
		<?php else: ?>
			<span>&nbsp;</span>
		<?php endif; ?>
		</div>
	</div>
		<?php endif; ?>
	<?php endwhile; ?>
</div>
<?php endif; ?>
<?php if (orderstorm_ecommerce('category', 'products', 'exist')): ?>
<table class="products list">
	<?php while (orderstorm_ecommerce('category', 'products', 'next')): ?>
	<tr valign="top">
		<td class="product_image" align="center">
			<?php if (orderstorm_ecommerce('category_product', 'present_thumbnail')): ?>
			<a href="<?php orderstorm_ecommerce('category_product', 'page_link'); ?>" title="<?php orderstorm_ecommerce('category_product', 'name'); ?>">
				<?php if ((!is_ssl() && orderstorm_ecommerce('category_product', 'has', 'has_thumbnail_serving_url')) || (is_ssl() && orderstorm_ecommerce('category_product', 'has', 'has_thumbnail_serving_surl'))): ?>
				<img src="<?php if (is_ssl()): ?><?php orderstorm_ecommerce('category_product', 'thumbnail_serving_surl'); ?><?php else: ?><?php orderstorm_ecommerce('category_product', 'thumbnail_serving_url'); ?><?php endif; ?>" />
				<?php else: ?>
					<?php if (orderstorm_ecommerce('category_product', 'has', 'thumbnail_image')): ?>
				<img src="<?php orderstorm_ecommerce('category_product', 'thumbnail_image_url'); ?>" />
					<?php elseif (orderstorm_ecommerce('product', 'has_default_small_image')): ?>
				<img src="<?php orderstorm_ecommerce('product', 'default_small_image_url'); ?>" />
					<?php endif; ?>
				<?php endif; ?>
			</a>
			<?php endif; ?>
		</td>
		<td class="product_description">
			<h2><a href="<?php orderstorm_ecommerce('category_product', 'page_link'); ?>" title="<?php orderstorm_ecommerce('category_product', 'name'); ?>"><?php orderstorm_ecommerce('category_product', 'name'); ?></a></h2>
			<p>
			<?php if (orderstorm_ecommerce('category_product', 'has', 'item_number')): ?>
				<span class="item_number"><?php orderstorm_ecommerce('category_product', 'item_number_with_caption', 'Item #: %s'); ?></span>
			<?php endif; ?>
			<span class="price sale"><?php orderstorm_ecommerce('money_format', orderstorm_ecommerce('category_product', 'your_cost', true)); ?></span>
			</p>
			<div class="description"><?php orderstorm_ecommerce('category_product', 'short_description'); ?></div>
		</td>
	</tr>
	<?php endwhile; ?>
	<tr valign="top">
		<td colspan="2">
			<div class="pcat-nav"><?php
				orderstorm_ecommerce('category', 'navigation_previous_page_link', '<span class="pcat-nav-arrow">&larr;</span> Previous');
				orderstorm_ecommerce('category', 'navigation_next_page_link', 'Next <span class="pcat-nav-arrow">&rarr;</span>');
			?>	<div class="pcat-nav-caption">
					<?php orderstorm_ecommerce('category', 'navigation_current_page_caption', 'Page %d of %d'); ?>
				</div>
			</div>
		</td>
	</tr>
</table>
<?php endif; ?>
