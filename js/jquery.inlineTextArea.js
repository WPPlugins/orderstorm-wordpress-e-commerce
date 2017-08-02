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
		$.fn.inlineTextArea = function (options)
		{
			options = $.extend
			(
				{
					eventType:'click',
					hoverClass:'ITAhover',
					textAreaClass:'ITAtextarea',
					hasTextareaClass:'ITAhasTextarea',
					webService:'',
					parameterName:'',
					canEdit:function (element) { return true; },
					ajaxCanEdit: function (callback) { callback(); },
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

					self.value = self.html();

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
										var html = self.value,
											offset = self.offset();

										if (options.trimContent === true) html = jQuery.trim(html);

										self
										.removeClass(options.hoverClass)
										.addClass(options.hasTextareaClass)
										.html(html + '<textarea class="' + options.textareaClass + '" >' + self.value + '</textarea>')
										.find('textarea')
											.topZIndex()
											.offset
											(
												{
													top:offset.top - (self.find('textarea').outerHeight(false) - self.find('textarea').innerHeight() + 1),
													left:offset.left - (self.find('textarea').outerWidth(false) - self.find('textarea').innerWidth())
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
																self.html(self.value).removeClass(options.hasTextareaClass);
															},
															function ()
															{
																self.html(self.value).removeClass(options.hasTextareaClass);
															}
														);
													}
													else
													{
														self.value = $(event.target).val();
														self.html(self.value).removeClass(options.hasTextareaClass);
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
							if (!self.hasClass(options.hasTextareaClass) && options.canEdit(self))
							{
								options.ajaxCanEdit
								(
									function ()
									{
										self.addClass(options.hoverClass);
									}
								);
							}
						},
						function (event)
						{
							if (!self.hasClass(options.hasTextareaClass) && self.hasClass(options.hoverClass))
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