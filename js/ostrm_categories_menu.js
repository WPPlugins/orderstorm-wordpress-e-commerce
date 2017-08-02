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
jQuery
(
	function ()
	{
		var	menuItemsGroup = jQuery('div.ostrm_categories_menu.topmenu div.ostrm_categories_menu_list ul li, div.ostrm_categories_menu.submenu div.ostrm_categories_menu_list ul li');

		function showMenuForItem()
		{
			var	pos = jQuery(this).position(),
				width = jQuery(this).innerWidth(),
				height = jQuery(this).innerHeight(),
				rightPadding = parseInt(jQuery(this).css("padding-right")),
				parentMenu = jQuery(this).closest('div.ostrm_categories_menu'),
				topMenu = jQuery(this).closest('div.ostrm_categories_menu.topmenu'),
				strMenuType,
				subMenu,
				strMenuDirection,
				left,
				top,
				subMenuCSS = {};

			if (topMenu.hasClass('horizontal'))
			{
				strMenuType = 'horizontal';
			}
			if (topMenu.hasClass('sidebar'))
			{
				strMenuType = 'sidebar';
			}

			subMenu = jQuery(this).children('div.ostrm_categories_menu.submenu');

			if (topMenu.hasClass('dir_down'))
			{
				strMenuDirection = 'down';
			}
			if (topMenu.hasClass('dir_up'))
			{
				strMenuDirection = 'up';
			}
			if (topMenu.hasClass('dir_left'))
			{
				strMenuDirection = 'left';
			}
			if (topMenu.hasClass('dir_right'))
			{
				strMenuDirection = 'right';
			}

			switch(strMenuDirection)
			{
				case 'right':
					left = pos.left + width - rightPadding + 2;
					top = pos.top;
					subMenuCSS.width = String(width) + "px";
					break;
				case 'left':
					left = pos.left - width;
					top = pos.top;
					subMenuCSS.width = String(width) + "px";
					break;
				case 'down':
					left = pos.left;
					top = pos.top + height;
					break;
				case 'up':
					left = pos.left;
					top = pos.top - height;
					break;
				default:
					left = pos.left + width;
					top = pos.top;
					subMenuCSS.width = String(width) + "px";
					break;
			}
			subMenuCSS.position = 'absolute';
			subMenuCSS.left = String(left) + "px";
			subMenuCSS.top = String(top) + "px";

			subMenu.css(subMenuCSS).topZIndex().show();
		}

		function hideMenuForItem()
		{
			var	subMenu = jQuery(this).children('div.ostrm_categories_menu.submenu');

			setTimeout
			(
				function()
				{
					subMenu.hide();
				},
				300
			);
		}

		menuItemsGroup.hover(showMenuForItem, hideMenuForItem);
	}
);
