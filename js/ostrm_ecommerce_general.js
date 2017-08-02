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
function showZoomedImage(zoom) {
	jQuery.fancybox({
		type: 'image',
		href: zoom,
		closeBtn: false,
		closeClick: true,
		openEffect: 'elastic',
		openSpeed: 150,
		closeEffect: 'elastic',
		closeSpeed: 150,
		helpers: {
			overlay: null
		}
	});
}

function doesUserHaveCartAccess(yesCallback, noCallback)
{
	window.osData.cartAccessLevel = 0;
	window.osData.requestSSKservice
	(
		'get_cart_access',
		{
		},
		'ResponseForGetCartAccess',
		function (resultSet)			// processResultSet
		{
			if (resultSet.rowCount() === 1)
			{
				window.osData.cartAccessLevel = resultSet.fieldValue(0, 'access_level');
			}
		},
		undefined,									// successRequestingService
		function (jqXHR, textStatus)				// completedRequestingService
		{
			if (window.osData.cartAccessLevel === 2)
			{
				if ((typeof yesCallback) === 'function')
				{
					yesCallback();
				}
			}
			else
			{
				if ((typeof noCallback) === 'function')
				{
					noCallback();
				}
			}
		},
		function (jqXHR, textStatus, errorThrown)	// errorRequestingService
		{
			if ((typeof noCallback) === 'function')
			{
				noCallback();
			}
		}
	);
}


function onSubCategoryImageContextMenuShow(data, pageX, pageY) {
	var currentCartAccessLevel = window.osData.cartAccessLevel;

	if (typeof doesUserHaveCartAccess === 'function') {
		doesUserHaveCartAccess(
			function () {
			},
			function () {
				data.$menu.hide();
			}
		);
	}

	if (currentCartAccessLevel === 2)
	{
		data.$menu.topZIndex();
	} else {
		return false;
	}
}

function deleteOnSort(thisADGallery, imageID, imageIndex) {
	window.osData.requestSSKservice
	(
		'delete_on_sort',
		{
			"object_key": imageID,
		},
		'ResponseForDeleteOnSort',
		function (resultSet)			// processResultSet
		{
			if (resultSet.rowCount() === 1)
			{
				var success = resultSet.fieldValue(0, 'success');

				if (!success) {
					alert('Image deletion failed');
				} else {
					if (!thisADGallery.in_transition) {
						if (thisADGallery.current_index === imageIndex) {
							if (imageIndex + 1 === thisADGallery.images.length) {
								if (imageIndex === 0) {
									jQuery(thisADGallery.preloads).empty();
									thisADGallery.removeImage(imageIndex);
									thisADGallery.wrapper.empty('.ad-controls');
									thisADGallery.wrapper.empty('.ad-thumb-list');
									thisADGallery.wrapper.remove('.ad-preloads');
								} else {
									thisADGallery.showImage(thisADGallery.current_index - 1, function () {
										jQuery(thisADGallery.preloads).empty();
										thisADGallery.removeImage(imageIndex);
									});
								}
							} else {
								thisADGallery.showImage(thisADGallery.current_index + 1, function () {
									jQuery(thisADGallery.preloads).empty();
									thisADGallery.removeImage(imageIndex);
									thisADGallery.current_index = imageIndex;
									thisADGallery.gallery_info.html((thisADGallery.current_index + 1) + ' / ' + thisADGallery.images.length);
								});
							}
						} else {
							jQuery(thisADGallery.preloads).empty();
							thisADGallery.removeImage(imageIndex);
							if (thisADGallery.current_index > imageIndex) {
								thisADGallery.current_index--;
							}
							thisADGallery.gallery_info.html((thisADGallery.current_index + 1) + ' / ' + thisADGallery.images.length);
						}
						if (thisADGallery.images.length <= 1) {
							thisADGallery.nav.hide();
						}
					}
				}
			}
		},
		undefined,									// successRequestingService
		undefined,
		function (jqXHR, textStatus, errorThrown)	// errorRequestingService
		{
			alert('Error requesting image deletion');
		}
	);
}

function onProductADGalleryContextMenuShow(data, pageX, pageY) {
	var currentProductAccessLevel = window.osData.productAccessLevel;
	var canEditProduct = data.$trigger.closest('div.product-ad-gallery').data('canEditProduct');

	if (typeof canEditProduct === 'function') {
		canEditProduct(
			function () {
			},
			function () {
				data.$menu.hide();
			}
		);
	}

	if (currentProductAccessLevel === 2)
	{
		data.$menu.topZIndex();
	} else {
		return false;
	}
}

jQuery
(
	function ()
	{
		window.osData = new OrderStormSSK
		(
			'https://' + cartGlobals.hostName + '/osss.os',
			'https://www.orderstorm.com/sa/s/ilisa.asp',
			'https://www.orderstorm.com/sa/s/ulifsa.asp'
		);

		jQuery(".add_category_image").hide();
		doesUserHaveCartAccess(
			function () {
				jQuery("div.tile_medium div:not(:has(img))").children("a.add_category_image").show();
			},
			function () {
				jQuery(".add_category_image").hide();
			}
		);
		jQuery("div.categories.list div.tile_medium img.category-image").click(function (event) {
			event.stopPropagation();
			event.preventDefault();

			var categoryPageLink = jQuery(event.target).data("pageLink");

			if (categoryPageLink) {
				window.location.href = categoryPageLink;
			}
		});
		jQuery("<div id=\"checkoutFrame\" style=\"display:none\" />").appendTo("body");
		jQuery("#checkoutFrame").fancybox
		(
			{
				'autoDimensions'	:	false,
				'autoScale'			:	false,
				'transitionIn'		:	'none',
				'transitionOut'		:	'none',
				'type'				:	'iframe',
				'modal'				:	false,
				'margin'			:	0,
				'onStart'			:	function (selectedArray, selectedIndex, selectedOptions)
										{
											this.href = cartGlobals.checkoutURL + '?order_key_guid=' + cartGlobals.orderKeyGUID + '&url=' + escape(parent.location);
											if (jQuery(window).width() <= 900)
											{
												this.width = 750;
											}
											else
											{
												this.width = '85%';
											}
											if (jQuery(window).height() <= 330)
											{
												this.height = 270;
											}
											else
											{
												this.height = '85%';
											}
										},
				'onComplete'		:	function(selectedArray, selectedIndex, selectedOptions)
										{
											jQuery("#fancybox-overlay").topZIndex();
											jQuery("#fancybox-wrap").topZIndex();
										},
				'onClosed'			:	function (selectedArray, selectedIndex, selectedOptions)
										{
											window.location.reload(true);
										}
			}
		);
		jQuery("div.ostrm_shopping_cart_status > div.view_cart_button, div.ostrm_shopping_cart_status_widget > div.view_cart_button").click
		(
			function ()
			{
				jQuery("#checkoutFrame").trigger('click');
			}
		);
		if (cartGlobals.hasOwnProperty('showCheckout') === true)
		{
			if (cartGlobals.showCheckout === 'true')
			{
				delete cartGlobals.showCheckout;
				jQuery("#checkoutFrame").trigger('click');
			}
		}

		jQuery("<div id=\"adImagesFrame\" style=\"display:none\" />").appendTo("body");
		jQuery("#adImagesFrame").fancybox
		(
			{
				'autoDimensions'	:	false,
				'autoScale'			:	false,
				'transitionIn'		:	'none',
				'transitionOut'		:	'none',
				'type'				:	'iframe',
				'modal'				:	false,
				'margin'			:	0,
				'onStart'			:	function (selectedArray, selectedIndex, selectedOptions)
										{
											var displayTypeKey, objectKey;
											if (typeof ajaxGlobals !== 'undefined') {
												displayTypeKey = cartGlobals.pdtk;
												objectKey = jQuery('form#ostrm_product_details_form > input[name="id"]').val();
											} else {
												displayTypeKey = cartGlobals.cdtk;
												objectKey = window.osData.currentKeyForImageUpload;
											}
											this.href = cartGlobals.addImagesURL + '?dtk=' + displayTypeKey + '&ok=' + objectKey + '&ckp=' + cartGlobals.ckp;
											if (jQuery(window).width() <= 900)
											{
												this.width = 750;
											}
											else
											{
												this.width = '85%';
											}
											if (jQuery(window).height() <= 330)
											{
												this.height = 270;
											}
											else
											{
												this.height = '85%';
											}
										},
				'onComplete'		:	function(selectedArray, selectedIndex, selectedOptions)
										{
											jQuery("#fancybox-overlay").topZIndex();
											jQuery("#fancybox-wrap").topZIndex();
										},
				'onClosed'			:	function (selectedArray, selectedIndex, selectedOptions)
										{
											window.location.reload(true);
										}
			}
		);
		jQuery("form#ostrm_product_details_form > div#edit_product > a.add_images, a.add_category_image").click
		(
			function (event)
			{
				window.osData.currentKeyForImageUpload = jQuery(event.target).data('key');
				jQuery("#adImagesFrame").trigger('click');
			}
		);
		jQuery
		(
			function ()
			{
				if (typeof window.osData.canEditProduct === 'function') {
					var showEditProduct, hideEditProduct;

					if (typeof window.osData.showEditProduct === 'function') {
						showEditProduct = window.osData.showEditProduct;
					}
					if (typeof window.osData.hideEditProduct === 'function') {
						hideEditProduct = window.osData.hideEditProduct;
					}
					window.osData.canEditProduct(showEditProduct, hideEditProduct);
				}
				if (typeof cartGlobals.adGalleryStartAtIndex !== 'undefined') {
					var adGalleryOptions = {
						start_at_index: cartGlobals.adGalleryStartAtIndex,
						update_window_hash: false,
						width: cartGlobals.productPreviewWidth,
						height: false,
						display_back_and_forward: true,
						callbacks: {
							init: function () {
								if (this.images.length <= 1) {
									this.nav.hide();
								}
							},
							afterImageVisible: function () {
								var thumbnailListElement = jQuery(this.images[this.current_index].thumb_link.context).parent();
								var zoom = thumbnailListElement.data('zoom');
								var imageID = thumbnailListElement.attr('id');
								if (zoom) {
									jQuery(this.current_image.context).data('zoom', zoom);
								}
								if (imageID) {
									jQuery(this.current_image.context).data('imageID', imageID);
								}
							},
						},
						slideshow: {
							enable: false,
							autostart: false,
						},
					};
					if (typeof cartGlobals.adGalleryLoaderImage !== 'undefined') {
						adGalleryOptions.loader_image = cartGlobals.adGalleryLoaderImage;
					}
  					window.osData.productADGalleries = jQuery('.product-ad-gallery').adGallery(adGalleryOptions);
					jQuery('.product-ad-gallery').on("click", ".ad-image", function(event) {
						event.stopPropagation();

						var zoom = jQuery(this).data('zoom');

						if (zoom) {
							showZoomedImage(zoom);
						}
					});
					jQuery.each(window.osData.productADGalleries, function (indexInArray, valueOfElement) {
						jQuery(valueOfElement.wrapper.context).data('ADGallery', valueOfElement);
						valueOfElement.gallery_info.hide();
						valueOfElement._centerImage = function (img_container, image_width, image_height) {
					        img_container.css('left', '0px');
					        if (image_width < this.image_wrapper_width) {
					            var dif = this.image_wrapper_width - image_width;
					            img_container.css('left', (dif / 2) + 'px');
					        };
						};
					});
					jQuery('div.product_image > div.product-ad-gallery > div.ad-nav').swipe({
						swipeLeft: function (event, direction, distance, duration, fingerCount) {
							event.preventDefault();
							event.stopPropagation();
							var thisADGallery = this.parent().data('ADGallery');

				            // We don't want to jump the whole width, since an image
				            // might be cut at the edge
				            var width = thisADGallery.nav_display_width - 50;
				            if (thisADGallery.settings.scroll_jump > 0) {
				                var width = thisADGallery.settings.scroll_jump;
				            };
			                var left = thisADGallery.thumbs_wrapper.scrollLeft() + width;
				            if (thisADGallery.settings.slideshow.stop_on_scroll) {
				                thisADGallery.slideshow.stop();
				            };
				            thisADGallery.thumbs_wrapper.animate({
				                scrollLeft: left + 'px'
				            });
				            return false;
						},
						swipeRight: function (event, direction, distance, duration, fingerCount) {
							event.preventDefault();
							event.stopPropagation();
							var thisADGallery = this.parent().data('ADGallery');

				            // We don't want to jump the whole width, since an image
				            // might be cut at the edge
				            var width = thisADGallery.nav_display_width - 50;
				            if (thisADGallery.settings.scroll_jump > 0) {
				                var width = thisADGallery.settings.scroll_jump;
				            };
			                var left = thisADGallery.thumbs_wrapper.scrollLeft() - width;
				            if (thisADGallery.settings.slideshow.stop_on_scroll) {
				                thisADGallery.slideshow.stop();
				            };
				            thisADGallery.thumbs_wrapper.animate({
				                scrollLeft: left + 'px'
				            });
				            return false;
						},
						threshold: 20,
						triggerOnTouchEnd: false,
					});
					jQuery('div.product_image > div.product-ad-gallery > div.ad-nav > div.ad-thumbs > ul.ad-thumb-list').sortable({
						start: function(event, ui) {
							event.stopPropagation();

							jQuery(this).data("oldIndex", jQuery.inArray(jQuery(ui.item).attr("id"), jQuery(this).sortable("toArray")));
						},
						stop: function(event, ui) {
							event.stopPropagation();

							var self = this;
							var thisADGallery = jQuery(this).closest('.product-ad-gallery').data('ADGallery');
							var oldIndex = jQuery(this).data("oldIndex");
							var imageID = ui.item.attr("id");
							var newIndex = jQuery.inArray(imageID, jQuery(this).sortable("toArray"));

							jQuery(this).removeData("oldIndex");
							if (window.osData.productAccessLevel !== 2 || oldIndex === newIndex || thisADGallery.in_transition) {
								jQuery(self).sortable("cancel");
							} else {
								if (thisADGallery.slideshow) {
									if (thisADGallery.slideshow.enabled) {
										thisADGallery.slideshow.disable();
										thisADGallery.slideshow.enable();
									}
								}
								window.osData.requestSSKservice
								(
									'sort',
									{
										"object_key": imageID,
										"index": newIndex,
									},
									'ResponseForSort',
									function (resultSet)			// processResultSet
									{
										if (resultSet.rowCount() === 1)
										{
											var success = resultSet.fieldValue(0, 'success');

											if (!success) {
												jQuery(self).sortable("cancel");
											} else {
												thisADGallery.images.move(oldIndex, newIndex);
												if (oldIndex > thisADGallery.current_index) {
													if (newIndex <= thisADGallery.current_index) {
														thisADGallery.current_index++;
													}
												} else {
													if (oldIndex < thisADGallery.current_index) {
														if (newIndex >= thisADGallery.current_index) {
															thisADGallery.current_index--;
														}
													} else {
														thisADGallery.current_index = newIndex;
													}
												}
												jQuery(thisADGallery.images).each(function () {
													this.preloaded = false;
												});
												jQuery(thisADGallery.preloads).empty();
												thisADGallery.gallery_info.html((thisADGallery.current_index + 1) + ' / ' + thisADGallery.images.length);
										        thisADGallery.thumbs_wrapper.find('a').each(
											        function (i) {
											            jQuery(this).data("ad-i", i);
											        }
												);
											}
										}
									},
									undefined,									// successRequestingService
									undefined,
									function (jqXHR, textStatus, errorThrown)	// errorRequestingService
									{
										jQuery(self).sortable("cancel");
									}
								);
							}
						}
					});
					jQuery(function () {
						jQuery('div.product_image > div.product-ad-gallery > div.ad-image-wrapper').swipe({
							swipeLeft: function (event, direction, distance, duration, fingerCount) {
								var thisADGallery = this.parent().data('ADGallery');

								event.preventDefault();
								event.stopPropagation();
								if (!thisADGallery.in_transition && fingerCount === 1) {
									if (thisADGallery.current_index + 1 === thisADGallery.images.length) {
										thisADGallery.showImage(0);
									} else {
										thisADGallery.nextImage();
									}
								}
							},
							swipeRight: function (event, direction, distance, duration, fingerCount) {
								var thisADGallery = this.parent().data('ADGallery');

								event.preventDefault();
								event.stopPropagation();
								if (!thisADGallery.in_transition && fingerCount === 1) {
									if (thisADGallery.current_index === 0) {
										thisADGallery.showImage(thisADGallery.images.length - 1);
									} else{
										thisADGallery.prevImage();
									}
								}
							},
							threshold: 25,
							triggerOnTouchEnd: false,
						});
					    jQuery.contextMenu({
							selector: 'div.product_image > div.product-ad-gallery > div.ad-image-wrapper > div.ad-image > img',
							callback: function (key, options) {
								var imageContainer = this.parent();
								var zoom = imageContainer.data('zoom');
								var thisADGallery = this.closest('div.product-ad-gallery').data('ADGallery');
								var imageID = imageContainer.data('imageID');
								var imageIndex = thisADGallery.current_index;

								switch (key) {
								case 'zoom':
									if (zoom) {
										showZoomedImage(zoom);
									}
									break;
								case 'delete':
									deleteOnSort(thisADGallery, imageID, imageIndex);
									break;
								}
							},
					        items: {
					            "zoom": {name: "Zoom", icon: "zoom"},
					            "sep1": "---------",
					            "delete": {name: "Delete", icon: "delete"},
					        },
							events: {
								show: onProductADGalleryContextMenuShow,
							},
							zIndex: 0,
						});
					    jQuery.contextMenu({
					        selector: 'div.product_image > div.product-ad-gallery > div.ad-nav > div.ad-thumbs > ul.ad-thumb-list > li > a',
					        callback: function(key, options) {
								var imageContainer = this.parent();
								var zoom = imageContainer.data('zoom');
								var thisADGallery = jQuery(options.$trigger[0].firstElementChild).closest('.product-ad-gallery').data('ADGallery');
								var imageID = imageContainer.attr('id');
								var imageIndex = this.data('adI');

								switch (key) {
								case 'zoom':
									if (zoom) {
										showZoomedImage(zoom);
									}
									break;
								case 'delete':
									deleteOnSort(thisADGallery, imageID, imageIndex);
									break;
								}
					        },
					        items: {
					            "zoom": {name: "Zoom", icon: "zoom"},
					            "sep1": "---------",
					            "delete": {name: "Delete", icon: "delete"},
					        },
							events: {
								show: onProductADGalleryContextMenuShow,
							},
							zIndex: 0,
					    });
					});
				}
				window.osData.initializeFloatingMessage();
			}
		);
	}
);
