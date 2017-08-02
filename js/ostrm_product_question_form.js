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
		function removeHTMLtagsFromElement(element)
		{
			return jQuery('<div>').html(element.val()).text();
		}

		function isValidEmailAddress(value)
		{
			// This regular expression was copied from a GPL-licensed jQuery plugin:
			// jquery.validate.js version 1.8.1
			// (http://bassistance.de/jquery-plugins/jquery-plugin-validation/)
			// At the moment of download, the source file stated the following for the function containing this expression:
			// "contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/"
			return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(value);
		}

		function validateProductQuestion(jsonOrderStormProductQuestionFormData)
		{
			var result = 0;

			jQuery('#question').val
			(
				function (i, v)
				{
					return jQuery('<div>').html(v).text();
				}
			);

			if (jQuery('#question').val() !== removeHTMLtagsFromElement(jQuery('#question')))
			{
				result = 1;
			}
			if (!isValidEmailAddress(jQuery('#email').val()))
			{
				result = 2;
			}

			return result;
		}

		function submitProductQuestionForm(event)
		{
			var orderStormProductQuestionFormData = jQuery('#ostrm_product_question').serializeArray();
			var validationResult = validateProductQuestion(orderStormProductQuestionFormData);

			event.preventDefault();

			if (validationResult === 0)
			{
				orderStormProductQuestionFormData.push({"name":"action", "value":"submit_product_question"});
				orderStormProductQuestionFormData.push({"name":"ostrmCartNonce", "value":ajaxGlobals.ostrmCartNonce});

				jQuery.ajax
				(
					{
						async:false,
						cache:false,
						contentType:"application/x-www-form-urlencoded",
						data:orderStormProductQuestionFormData,
						dataType:"json",
						error:	function (XMLHttpRequest, textStatus, errorThrown)
								{
									alert('Add failed.\n\ntextStatus = ' + textStatus + '\nerrorThrown = ' + errorThrown);
								},
						processData:true,
						success:	function (data, textStatus)
									{
										if (data.hasOwnProperty('blnAddSuccessful') && data.hasOwnProperty('blnValidNonce'))
										{
											if (data.blnAddSuccessful)
											{
												alert('Your product question has been successfully submitted.');
											}
											else
											{
												if (data.blnValidNonce !== true)
												{
													alert('Add failed -> Invalid Nonce.');
													window.location.href = '/';
												}
												else
												{
													if (data.hasOwnProperty('error'))
													{
														switch (data.error)
														{
															case 1:
																alert('Add failed -> Invalid Product ID.');
																break;
															case 2:
																alert('Add failed -> The question cannot contain HTTP/HTML tags.');
																break;
															case 3:
																alert('Add failed -> Invalid e-mail address.');
																break;
															default:
																alert('Add failed -> Unknown error.');
														}
													}
													else
													{
														alert('Add failed -> Unknown cause.');
													}
												}
											}
										}
										else
										{
											alert('Invalid response.');
										}
									},
						timeout:15000,
						type:"POST",
						url:ajaxGlobals.ajaxURL
					}
				);
			}
			else
			{
				switch (validationResult)
				{
					case 1:
						alert('Error 7701: The product question cannot contain HTML tags.');
						break;
					case 2:
						alert('Error 7702: A valid e-mail address must be entered to submit a product question');
						break;
					default:
						alert('Error 7766: Unknown validation error');
				}
			}
		}

		jQuery('#ostrm_product_question').submit(submitProductQuestionForm);
	}
);