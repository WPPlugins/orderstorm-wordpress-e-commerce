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
(
	function ($)
	{
		$.fn.inlineTextEdit = function (options)
		{
			options = $.extend
			(
				{
					eventType:'click',
					hoverClass:'ITEhover',
					inputClass:'ITEinput',
					hasInputClass:'ITEhasInput',
					webService:'',
					parameterName:'',
					canEdit:function (element) { return true; },
					ajaxCanEdit: function (yesCallback) { callback(); },
					hoverInWhenEditable: undefined,
					hoverOutWhenEditable: undefined,
					hoverInWhenNotEditable: undefined,
					hoverOutWhenNotEditable: undefined,
					ajaxEditIfAllowed: function (callback) { callback(); },
					save:function (fieldValue, successCallback, cancelCallback) { successCallback(); },
					trimContent: false
				},
				options
			);

			return $.each
			(
				this,
				function (indexInArray, valueOfElement)
				{
					var self = $(this);

					self.value = self.text();

					if (options.trimContent === true) self.value = jQuery.trim(self.value);

					self.bind
					(
						options.eventType,
						function (event)
						{
							if (options.canEdit(self))
							{
								options.ajaxEditIfAllowed
								(
									function ()
									{
										var html = self.html(),
											offset = self.offset();

										if (options.trimContent === true) html = jQuery.trim(html);

										self
										.removeClass(options.hoverClass)
										.addClass(options.hasInputClass)
										.html(html + '<input type="text" value="' + self.value  + '" class="' + options.inputClass + '" />')
										.find('input')
											.topZIndex()
											.offset
											(
												{
													top:offset.top - (self.find('input').outerHeight(false) - self.find('input').innerHeight() + 1),
													left:offset.left - (self.find('input').outerWidth(false) - self.find('input').innerWidth())
												}
											)
											.bind
											(
												'click',
												function (event)
												{
													event.stopPropagation();
												}
											)
											.bind
											(
												'blur',
												function (event)
												{
													if ($(event.target).val() !== self.value && (typeof options.save) === 'function')
													{
														options.save
														(
															$(event.target).val(),
															function ()
															{
																self.value = $(event.target).val();
																if (options.trimContent === true) self.value = jQuery.trim(self.value);
																self.text(self.value).removeClass(options.hasInputClass);
															},
															function ()
															{
																self.text(self.value).removeClass(options.hasInputClass);
															}
														);
													}
													else
													{
														self.value = $(event.target).val();
														self.text(self.value).removeClass(options.hasInputClass);
													}
												}
											)
											.focus();
									}
								);
							}
						}
					)
					.hover
					(
						function (event)
						{
							if (!self.hasClass(options.hasInputClass) && options.canEdit(self))
							{
								options.ajaxCanEdit
								(
									function ()
									{
										self.addClass(options.hoverClass);
										if ((typeof options.hoverInWhenEditable) === 'function')
										{
											options.hoverInWhenEditable();
										}
									},
									function ()
									{
										self.removeClass(options.hoverClass);
										if ((typeof options.hoverInWhenNotEditable) === 'function')
										{
											options.hoverInWhenNotEditable();
										}
									}
								);
							}
						},
						function (event)
						{
							if (!self.hasClass(options.hasInputClass) && self.hasClass(options.hoverClass))
							{
								self.removeClass(options.hoverClass);
							}
						}
					);
				}
			);
		}
	}
)(jQuery);