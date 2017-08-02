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
		var productFeaturesData = {};
		var indexForID = null;
		var indexForQuantity = null;
		var indexForProductOrderFormFeature = null;
		var formProductsLists = {};
		var numberOfFormProductsLists;
		var numberOfProductsToAddToCartFromLists = 0;
		var numberOfProductsFromListsAddedToCart = 0;
		var formProductOrderForms = {};
		var numberOfFormProductOrderForms;
		var numberOfFeaturesToAddToProductsFromProductOrderForms = 0;
		var numberOfFeaturesFromProductOrderFormsAddedToProducts = 0;

		if ((typeof ajaxGlobals) !== "undefined")
		{
			productFeaturesData = jQuery.parseJSON(ajaxGlobals.productFeaturesData);
		}

		function validateProductFeatures(jsonOrderStormProductFeaturesData, jsonOrderStormProductDetailsFormData)
		{
			var result = 0;

			var reFeaturePostVariable = /^feature\[([^\]]*)\].*$/;
			var reProductsListPostVariable = /^productsList\[([^\]]*)\].*$/;
			var reProductOrderFormPostVariable = /^productOrderForm\[([^\]]*)\].*$/;
			var reResult;
			var reResult2;
			var reResult3;
			var message = "";
			var member;
			var arrProductsListIDs = [];
			var numberOfProductsLists;
			var arrProductOrderFormIDs = [];
			var numberOfProductOrderForms;
			var arrFeatureGroupIDs = [];
			var numberOfFeatureGroups;
			var arrFormFeatureGroupIDs = [];
			var numberOfFormFeatureGroups;
			var objFormFeatureGroups = {};
			var blnResult;
			var blnResult2;
			var objFeatureGroupData;
			var nonRequiredFeatureGroupsWithNullValuesSelected = [];

			if ((typeof jsonOrderStormProductFeaturesData) === 'object')
			{
				for (member in jsonOrderStormProductFeaturesData)
				{
					memberIsAProductsList = false;
					memberIsAProductOrderForm = false;
					if (jsonOrderStormProductFeaturesData[member].hasOwnProperty('feature_display_type')) {
						if (jsonOrderStormProductFeaturesData[member].feature_display_type == 'productsList') {
							memberIsAProductsList = true;
						} else if (jsonOrderStormProductFeaturesData[member].feature_display_type == 'productOrderForm') {
							memberIsAProductOrderForm = true;
						}
					}
					if (memberIsAProductsList) {
						arrProductsListIDs.push(member);
					} else if (memberIsAProductOrderForm) {
						arrProductOrderFormIDs.push(member);
					} else {
						arrFeatureGroupIDs.push(member);
					}
				}
			}

			numberOfFeatureGroups = arrFeatureGroupIDs.length;
			numberOfProductsLists = arrProductsListIDs.length;
			numberOfProductOrderForms = arrProductOrderFormIDs.length;

			// Find every product list ID, product order form ID or feature group ID first
			jQuery.each
			(
				jsonOrderStormProductDetailsFormData,
				function(arrayIndex, arrayElement)
				{
					if (arrayElement.name == 'id') {
						indexForID = arrayIndex;
					}
					if (arrayElement.name == 'Quantity') {
						indexForQuantity = arrayIndex;
					}
					reFeaturePostVariable.lastIndex = 0;
					reResult = reFeaturePostVariable.exec(arrayElement.name);
					reResult2 = reProductsListPostVariable.exec(arrayElement.name);
					reResult3 = reProductOrderFormPostVariable.exec(arrayElement.name);
					if (reResult != null) {
						if (jQuery.inArray(reResult[1], arrFormFeatureGroupIDs) === -1) {
							arrFormFeatureGroupIDs.push(reResult[1]);
						}
					} else if (reResult2 != null) {
						if (!formProductsLists.hasOwnProperty(reResult2[1])) {
							formProductsLists[reResult2[1]] = {};
						}
					} else if (reResult3 != null) {
						if (!formProductOrderForms.hasOwnProperty(reResult3[1])) {
							formProductOrderForms[reResult3[1]] = {};
						}
					}
				}
			);

			numberOfFormFeatureGroups = arrFormFeatureGroupIDs.length;
			numberOfFormProductsLists = Object.keys(formProductsLists).length;
			numberOfFormProductOrderForms = Object.keys(formProductOrderForms).length;

			if (numberOfFormFeatureGroups <= numberOfFeatureGroups
				&& numberOfFormProductsLists <= numberOfProductsLists
				&& numberOfFormProductOrderForms <= numberOfProductOrderForms)
			{
				// Now, build an accessible object to put the user-chosen form features in it
				jQuery.each
				(
					arrFormFeatureGroupIDs,
					function(arrayIndex, arrayElement)
					{
						var arrFeatureGroup = [];

						objFormFeatureGroups[arrayElement] = arrFeatureGroup;
					}
				);

				// Now, populate said object
				jQuery.each
				(
					jsonOrderStormProductDetailsFormData,
					function(arrayIndex, arrayElement)
					{
						reFeaturePostVariable.lastIndex = 0;
						reResult = reFeaturePostVariable.exec(arrayElement.name);
						if (reResult != null)
						{
							objFormFeatureGroups[reResult[1]].push(arrayElement.value);
						}
					}
				);

				// Make sure the form feature groups are all valid for the product being added
				blnResult = true;
				jQuery.each
				(
					arrFormFeatureGroupIDs,
					function(arrayIndex, arrayElement)
					{
						if (jQuery.inArray(arrayElement, arrFeatureGroupIDs) === -1)
						{
							blnResult = false;
							return false;
						}
					}
				);
				if (blnResult === false)
				{
					// Some form feature group IS NOT a valid feature group for the product being
					// added
					result = 2;
				}
				else
				{
					// For every product feature group that is marked as required, make sure that
					// at least one product feature is selected from that group
					blnResult = true;
					jQuery.each
					(
						arrFeatureGroupIDs,
						function(arrayIndex, intFeatureGroupID)
						{
							if ((typeof jsonOrderStormProductFeaturesData) === 'object')
							{
								if (jsonOrderStormProductFeaturesData.hasOwnProperty(intFeatureGroupID))
								{
									objFeatureGroupData = jsonOrderStormProductFeaturesData[intFeatureGroupID];

									if (objFeatureGroupData.feature_group_is_required === true)
									{
										if (jQuery.inArray(intFeatureGroupID, arrFormFeatureGroupIDs) === -1)
										{
											// Some required feature group had NO FEATURE SELECTED from it in the form
											// feature data
											result = 3;
											blnResult = false;
											return false;
										}
										else
										{
											blnResult2 = false;
											jQuery.each
											(
												objFeatureGroupData.features,
												function(featureIndexInGroup, objFeature)
												{
													if (jQuery.inArray(objFeature.feature_product_guid, objFormFeatureGroups[intFeatureGroupID]) > -1)
													{
														blnResult2 = true;
														return false;
													}
												}
											);
											if (blnResult2 === false)
											{
												blnResult = false;
												return false;
											}
										}
									}
								}
							}
						}
					);
					if (blnResult === false)
					{
						// Found a required group for which no VALID feature was selected (there were
						// invalid features selected. CRITICAL ERROR!!!)
						result = 4;
					}
					else
					{
						// For each feature group with a feature display type of "radio", "dropdown" or "colorSelector",
						// verify that ONLY ONE feature is selected for such group
						blnResult = true;
						jQuery.each
						(
							arrFeatureGroupIDs,
							function(arrayIndex, intFeatureGroupID)
							{
								if ((typeof jsonOrderStormProductFeaturesData) === 'object')
								{
									if (jsonOrderStormProductFeaturesData.hasOwnProperty(intFeatureGroupID))
									{
										objFeatureGroupData = jsonOrderStormProductFeaturesData[intFeatureGroupID];

										if (objFeatureGroupData.feature_display_type === 'radio' || objFeatureGroupData.feature_display_type === 'dropdown' || objFeatureGroupData.feature_display_type === 'colorSelector')
										{
											var objFormFeatureGroup = objFormFeatureGroups[intFeatureGroupID];
											if ((typeof objFormFeatureGroup) === 'object')
											{
												if (Object.keys(objFormFeatureGroups[intFeatureGroupID]).length > 1)
												{
													blnResult = false;
													return false;
												}
											}
										}
									}
								}
							}
						);
						if (blnResult === false)
						{
							// Found more than one selected feature for a feature group with a feature
							// display type of "radio", "dropdown" or "colorSelector"
							result = 5;
						}
						else
						{
							// For required individual features, verify they are selected in the form
							blnResult = true;
							jQuery.each
							(
								arrFeatureGroupIDs,
								function(arrayIndex, intFeatureGroupID)
								{
									blnResult2 = true;

									if ((typeof jsonOrderStormProductFeaturesData) === 'object')
									{
										if (jsonOrderStormProductFeaturesData.hasOwnProperty(intFeatureGroupID))
										{
											objFeatureGroupData = jsonOrderStormProductFeaturesData[intFeatureGroupID];

											jQuery.each
											(
												objFeatureGroupData.features,
												function(featureIndexInGroup, objFeature)
												{
													if (objFeature.feature_is_required === true)
													{
														if (jQuery.inArray(objFeature.feature_product_guid, objFormFeatureGroups[intFeatureGroupID]) === -1)
														{
															blnResult2 = false;
															return false;
														}
													}
												}
											);
										}
									}
									if (blnResult2 === false)
									{
										blnResult = false;
										return false;
									}
								}
							);
							if (blnResult === false)
							{
								// Found a required individual feature which was NOT selected in the form
								result = 6;
							}
							else
							{
								// Verify all selected form features are valid for the product being
								// added to the cart
								blnResult = true;
								jQuery.each
								(
									arrFormFeatureGroupIDs,
									function(intFormFeatureGroupIndex, intFormFeatureGroupID)
									{
										blnResult2 = true;
										jQuery.each
										(
											objFormFeatureGroups[intFormFeatureGroupID],
											function(intFormFeatureIndex, strFormFeatureProductGUID)
											{
												blnResult3 = false;
												if ((typeof jsonOrderStormProductFeaturesData) === 'object')
												{
													if (jsonOrderStormProductFeaturesData.hasOwnProperty(intFormFeatureGroupID))
													{
														jQuery.each
														(
															jsonOrderStormProductFeaturesData[intFormFeatureGroupID].features,
															function(intFeatureIndexInGroup, objFeatureData)
															{
																var productFeatureGroup = jsonOrderStormProductFeaturesData[intFormFeatureGroupID];

																if (objFeatureData.feature_product_guid === strFormFeatureProductGUID)
																{
																	blnResult3 = true;
																	return false;
																}
																else
																{
																	if (strFormFeatureProductGUID === "null")
																	{
																		if (productFeatureGroup.feature_display_type === "dropdown" && productFeatureGroup.feature_group_is_required === false)
																		{
																			nonRequiredFeatureGroupsWithNullValuesSelected.push(intFormFeatureGroupID);
																			blnResult3 = true;
																			return false;
																		}
																	}
																}
															}
														);
													}
												}
												if (blnResult3 === false)
												{
													blnResult2 = false;
													return false;
												}
											}
										);
										if (blnResult2 === false)
										{
											blnResult = false;
											return false;
										}
									}
								);
								if (blnResult === false)
								{
									// Some selected form feature IS NOT a valid feature for the
									// product being added
									result = 7;
								}
							}
						}
					}
				}
			}
			else
			{
				// Number of form feature groups IS NOT less than or equal to the number
				// of valid feature groups of the product being added
				result = 1;
			}

			if (nonRequiredFeatureGroupsWithNullValuesSelected.length > 0)
			{
				jQuery.each
				(
					nonRequiredFeatureGroupsWithNullValuesSelected,
					function(intIndexOfFeatureGroupWithNullValue, strFeatureIndex)
					{
						var indexOfElementToDelete = null;

						jQuery.each
						(
							jsonOrderStormProductDetailsFormData,
							function (indexOfProductDetailsFormDataElement, objFormDataElement)
							{
								if (objFormDataElement.name === "feature[" + strFeatureIndex + "]")
								{
									indexOfElementToDelete = indexOfProductDetailsFormDataElement;
								}
							}
						);

						if (indexOfElementToDelete !== null)
						{
							jsonOrderStormProductDetailsFormData.splice(indexOfElementToDelete, 1);
						}
					}
				);
			}

			return result;
		}

		function activateColorPicker(colorPickerIDsuffix)
		{
			jQuery
			(
				function ()
				{
					jQuery("#color-picker-" + colorPickerIDsuffix).colorpicker
					(
						{
							limit:6,
							css:
							{
								container:
								{
									width: "170px",
									height: "24px",
									padding: "10px",
									border: "1px solid #000000",
									backgroundColor: "",
									position: "relative"
								},
								colors:
								{
									width: "32px",
									height: "32px",
									margin: 0,
									padding: 0,
									border: "1px solid #000000"
								}
							},
							callback:function(color, name, guid, group_id)
							{
								jQuery("#selected-color-" + colorPickerIDsuffix).html(name);
								jQuery('input[name="feature[' + colorPickerIDsuffix + ']"]').val(guid);
								if ((typeof osws) !== 'undefined') {
									osws.canvas.colors[colorPickerIDsuffix] = color;
								}
								refresh_canvas();
							},
							colorList:productFeaturesData[colorPickerIDsuffix]["features"],
							feature_group_name_id: colorPickerIDsuffix
						}
					);
				}
			);
		}

		function submitProductDetailsForm(event)
		{
			var orderStormProductDetailsFormData = jQuery('#ostrm_product_details_form').serializeArray();
			var validationResult = validateProductFeatures(productFeaturesData, orderStormProductDetailsFormData);
			var productsListID;
			var productOrderFormID;
			var productPostVariableName;
			var productQuantity;

			event.preventDefault();

			if (validationResult === 0) {
				if (numberOfFormProductsLists > 0) {
					for (productsListID in formProductsLists) {
						if (productFeaturesData.hasOwnProperty(productsListID)) {
							if (productFeaturesData[productsListID].hasOwnProperty('features')) {
								if (jQuery.isArray(productFeaturesData[productsListID].features)) {
									jQuery.each(productFeaturesData[productsListID].features,
										function(productIndexFromList, feature) {
											if (jQuery.isPlainObject(feature)) {
												if (feature.hasOwnProperty('feature_product_guid')) {
													productPostVariableName = 'productsList[' + productsListID + '][' + productIndexFromList + ']';
													if (isWellFormedGUID(feature.feature_product_guid)) {
														jQuery.each(orderStormProductDetailsFormData,
															function(propertyIndex, property) {
																if (jQuery.isPlainObject(property)) {
																	if (property.hasOwnProperty('name') && property.hasOwnProperty('value')) {
																		if (property.name == productPostVariableName) {
																			productQuantity = jQuery.trim(property.value);
																			if (productQuantity.length > 0) {
																				if (/^\d+$/.test(property.value)) {
																					productQuantity = parseInt(productQuantity, 10)
																					if (productQuantity > 0) {
																						formProductsLists[productsListID][productIndexFromList] = {
																							id: feature.feature_product_guid,
																							Quantity: productQuantity
																						};
																						numberOfProductsToAddToCartFromLists = numberOfProductsToAddToCartFromLists + 1;
																					} else {
																						validationResult = 8;
																					}
																				} else {
																					validationResult = 8;
																				}
																			}
																			delete(orderStormProductDetailsFormData[propertyIndex]);
																		}
																	}
																}
															}
														);
													}
												}
											}
										}
									);
								}
							}
						}
					}
					if (numberOfProductsToAddToCartFromLists <= 0) {
						// At least one of the products lists items has to have a quantity >= 1
						validationResult = 8;
					}
				} else if (numberOfFormProductOrderForms > 0) {
					for (productOrderFormID in formProductOrderForms) {
						if (productFeaturesData.hasOwnProperty(productOrderFormID)) {
							if (productFeaturesData[productOrderFormID].hasOwnProperty('features')) {
								if (jQuery.isArray(productFeaturesData[productOrderFormID].features)) {
									jQuery.each(productFeaturesData[productOrderFormID].features,
										function(productIndexFromProductOrderForm, feature) {
											if (jQuery.isPlainObject(feature)) {
												if (feature.hasOwnProperty('feature_product_guid')) {
													productPostVariableName = 'productOrderForm[' + productOrderFormID + '][' + productIndexFromProductOrderForm + ']';
													if (isWellFormedGUID(feature.feature_product_guid)) {
														jQuery.each(orderStormProductDetailsFormData,
															function(propertyIndex, property) {
																if (jQuery.isPlainObject(property)) {
																	if (property.hasOwnProperty('name') && property.hasOwnProperty('value')) {
																		if (property.name == productPostVariableName) {
																			productQuantity = jQuery.trim(property.value);
																			if (productQuantity.length > 0) {
																				if (/^\d+$/.test(property.value)) {
																					productQuantity = parseInt(productQuantity, 10)
																					if (productQuantity > 0) {
																						formProductOrderForms[productOrderFormID][productIndexFromProductOrderForm] = {
																							id: feature.feature_product_guid,
																							Quantity: productQuantity
																						};
																						numberOfFeaturesToAddToProductsFromProductOrderForms = numberOfFeaturesToAddToProductsFromProductOrderForms + 1;
																					} else {
																						validationResult = 9;
																					}
																				} else {
																					validationResult = 9;
																				}
																			}
																			delete(orderStormProductDetailsFormData[propertyIndex]);
																		}
																	}
																}
															}
														);
													}
												}
											}
										}
									);
								}
							}
						}
					}
					if (numberOfFeaturesToAddToProductsFromProductOrderForms <= 0) {
						// At least one of the product order forms items has to have a quantity >= 1
						validationResult = 9;
					}
				}
			}

			if (validationResult === 0)
			{
				orderStormProductDetailsFormData.push({"name":"action", "value":"add_to_cart"});
				orderStormProductDetailsFormData.push({"name":"ostrmCartNonce", "value":ajaxGlobals.ostrmCartNonce});

				if (numberOfProductsToAddToCartFromLists > 0) {
					for (listName in formProductsLists) {
						productsList = formProductsLists[listName];
						if (jQuery.isPlainObject(productsList)) {
							for (productIndex in productsList) {
								product = productsList[productIndex];
								if (jQuery.isPlainObject(product)) {
									if (product.hasOwnProperty('id') && product.hasOwnProperty('Quantity')) {
										orderStormProductDetailsFormData[indexForID].value = product.id;
										orderStormProductDetailsFormData[indexForQuantity].value = product.Quantity;
										jQuery.ajax
										(
											{
												async:false,
												cache:false,
												contentType:"application/x-www-form-urlencoded",
												data:orderStormProductDetailsFormData,
												dataType:"json",
												error:	function (XMLHttpRequest, textStatus, errorThrown)
														{
															alert('Add failed.');
														},
												processData:true,
												success:	function (data, textStatus)
															{
																if (data.hasOwnProperty('blnAddSuccessful') && data.hasOwnProperty('blnValidNonce'))
																{
																	if (data.blnAddSuccessful)
																	{
																		numberOfProductsFromListsAddedToCart = numberOfProductsFromListsAddedToCart + 1;
																		if (numberOfProductsFromListsAddedToCart == numberOfProductsToAddToCartFromLists) {
																			cartGlobals.orderKeyGUID = data.orderKeyGUID;
																			jQuery("#checkoutFrame").trigger('click');
																		}
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
																			alert('Add failed -> Unknown cause.');
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
								}
							}
						}
					}
				} else if (numberOfFeaturesToAddToProductsFromProductOrderForms > 0) {
					for (formName in formProductOrderForms) {
						productOrderForm = formProductOrderForms[formName];
						if (jQuery.isPlainObject(productOrderForm)) {
							for (productIndex in productOrderForm) {
								feature = productOrderForm[productIndex];
								if (jQuery.isPlainObject(feature)) {
									if (feature.hasOwnProperty('id') && feature.hasOwnProperty('Quantity')) {
										orderStormProductDetailsFormData[indexForQuantity].value = feature.Quantity;
										if (indexForProductOrderFormFeature === null) {
											orderStormProductDetailsFormData = orderStormProductDetailsFormData.concat([{"name":"feature[" + formName + "]","value":feature.id}]);
											// Find index of newly-added feature
											jQuery.each
											(
												orderStormProductDetailsFormData,
												function(arrayIndex, arrayElement)
												{
													if (arrayElement) {
														if (arrayElement.name == "feature[" + formName + "]") {
															indexForProductOrderFormFeature = arrayIndex;
														}
													}
												}
											);
										} else {
											orderStormProductDetailsFormData[indexForProductOrderFormFeature] = {"name":"feature[" + formName + "]","value":feature.id};
										}
										jQuery.ajax
										(
											{
												async:false,
												cache:false,
												contentType:"application/x-www-form-urlencoded",
												data:orderStormProductDetailsFormData,
												dataType:"json",
												error:	function (XMLHttpRequest, textStatus, errorThrown)
														{
															alert('Add failed.');
														},
												processData:true,
												success:	function (data, textStatus)
															{
																if (data.hasOwnProperty('blnAddSuccessful') && data.hasOwnProperty('blnValidNonce'))
																{
																	if (data.blnAddSuccessful)
																	{
																		numberOfFeaturesFromProductOrderFormsAddedToProducts = numberOfFeaturesFromProductOrderFormsAddedToProducts + 1;
																		if (numberOfFeaturesFromProductOrderFormsAddedToProducts == numberOfFeaturesToAddToProductsFromProductOrderForms) {
																			cartGlobals.orderKeyGUID = data.orderKeyGUID;
																			jQuery("#checkoutFrame").trigger('click');
																		}
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
																			alert('Add failed -> Unknown cause.');
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
								}
							}
						}
					}
				} else {
					jQuery.ajax
					(
						{
							async:false,
							cache:false,
							contentType:"application/x-www-form-urlencoded",
							data:orderStormProductDetailsFormData,
							dataType:"json",
							error:	function (XMLHttpRequest, textStatus, errorThrown)
									{
										alert('Add failed.');
									},
							processData:true,
							success:	function (data, textStatus)
										{
											if (data.hasOwnProperty('blnAddSuccessful') && data.hasOwnProperty('blnValidNonce'))
											{
												if (data.blnAddSuccessful)
												{
													cartGlobals.orderKeyGUID = data.orderKeyGUID;
													jQuery("#checkoutFrame").trigger('click');
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
														alert('Add failed -> Unknown cause.');
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
			}
			else
			{
				alert("Please select the required options.");
			}
		}

		function clear_canvas()
		{
			if ((typeof osws) !== 'undefined') {
				osws.canvas.colors = [];
			}
			refresh_canvas();
		}

		function refresh_canvas()
		{
			if ((typeof osws) !== 'undefined') {
				osws.canvas.draw_shape('myCanvas');
			}
		}

		jQuery.each
		(
			productFeaturesData,
			function (feature_group_name_id, feature_group)
			{
				if (feature_group.hasOwnProperty("feature_display_type"))
				{
					if (feature_group.feature_display_type === "colorSelector")
					{
						activateColorPicker(feature_group_name_id);
					}
				}
			}
		);

		if(typeof osws != 'undefined')
		{
			jQuery('#myCanvas').attr("width", osws.canvas.width);
			jQuery('#myCanvas').attr("height", osws.canvas.height);
			refresh_canvas();
		}

		function canEditProduct(yesCallback, noCallback)
		{
			window.osData.productAccessLevel = 0;
			window.osData.requestSSKservice
			(
				'get_product_access',
				{
					"product_guid":jQuery("#ostrm_product_details_form input[name='id']").val()
				},
				'ResponseForGetProductAccess',
				function (resultSet)			// processResultSet
				{
					if (resultSet.rowCount() === 1)
					{
						window.osData.productAccessLevel = resultSet.fieldValue(0, 'access_level');
					}
				},
				undefined,									// successRequestingService
				function (jqXHR, textStatus)				// completedRequestingService
				{
					if (window.osData.productAccessLevel === 2)
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

		function saveProductName(productName, successCallback, cancelCallback)
		{
			var savedMessage = 'Product Name <strong>updated</strong>',
				notSavedMessage = 'Product Name <b>NOT updated</b>';

			window.osData.requestSSKservice
			(
				'update_product_name',
				{
					"product_guid":jQuery("#ostrm_product_details_form input[name='id']").val(),
					"name":productName
				},
				'ResponseForUpdateProductName',
				function (resultSet)						// processResultSet
				{
					window.osData.recordsUpdatedForProductName = resultSet.fieldValue(0, 'records_updated');
				},
				undefined,									// successRequestingService
				function (jqXHR, textStatus)				// completedRequestingService
				{
					if (window.osData.recordsUpdatedForProductName === 1)
					{
						window.osData.showFloatingMessage(savedMessage);
						successCallback();
					}
					else
					{
						window.osData.showFloatingMessage(notSavedMessage);
						cancelCallback();
					}
				},
				function (jqXHR, textStatus, errorThrown)	// errorRequestingService
				{
					window.osData.showFloatingMessage(notSavedMessage);
					cancelCallback();
				}
			);
		}

		function saveShortDescription(shortDescription, successCallback, cancelCallback)
		{
			var savedMessage = 'Short Description <strong>updated</strong>',
				notSavedMessage = 'Short Description <b>NOT updated</b>';

			window.osData.requestSSKservice
			(
				'update_product_short_description',
				{
					"product_guid":jQuery("#ostrm_product_details_form input[name='id']").val(),
					"short_description":shortDescription
				},
				'ResponseForUpdateShortDescription',
				function (resultSet)						// processResultSet
				{
					window.osData.recordsUpdatedForShortDescription = resultSet.fieldValue(0, 'records_updated');
				},
				undefined,									// successRequestingService
				function (jqXHR, textStatus)				// completedRequestingService
				{
					if (window.osData.recordsUpdatedForShortDescription === 1)
					{
						window.osData.showFloatingMessage(savedMessage);
						successCallback();
					}
					else
					{
						window.osData.showFloatingMessage(notSavedMessage);
						cancelCallback();
					}
				},
				function (jqXHR, textStatus, errorThrown)	// errorRequestingService
				{
					window.osData.showFloatingMessage(notSavedMessage);
					cancelCallback();
				}
			);
		}

		function saveDaysToShip(daysToShip, successCallback, cancelCallback)
		{
			var savedMessage = 'Days to Ship <strong>updated</strong>',
				notSavedMessage = 'Days to Ship <b>NOT updated</b>';

			daysToShip = jQuery.trim(daysToShip);
			window.osData.requestSSKservice
			(
				'update_product_days_to_ship',
				{
					"product_guid":jQuery("#ostrm_product_details_form input[name='id']").val(),
					"days_to_ship":daysToShip
				},
				'ResponseForUpdateDaysToShip',
				function (resultSet)						// processResultSet
				{
					window.osData.recordsUpdatedForDaysToShip = resultSet.fieldValue(0, 'records_updated');
				},
				undefined,									// successRequestingService
				function (jqXHR, textStatus)				// completedRequestingService
				{
					if (window.osData.recordsUpdatedForDaysToShip === 1)
					{
						window.osData.showFloatingMessage(savedMessage);
						if (daysToShip === '1')
						{
							jQuery('#up_to_days_to_ship').html(' to 2');
						}
						else
						{
							jQuery('#up_to_days_to_ship').empty();
						}
						successCallback();
					}
					else
					{
						window.osData.showFloatingMessage(notSavedMessage);
						cancelCallback();
					}
				},
				function (jqXHR, textStatus, errorThrown)	// errorRequestingService
				{
					window.osData.showFloatingMessage(notSavedMessage);
					cancelCallback();
				}
			);
		}

		function saveItemNumber(itemNumber, successCallback, cancelCallback)
		{
			var savedMessage = 'Item Number <strong>updated</strong>',
				notSavedMessage = 'Item Number <b>NOT updated</b>';

			window.osData.requestSSKservice
			(
				'update_product_item_number',
				{
					"product_guid":jQuery("#ostrm_product_details_form input[name='id']").val(),
					"item_number":itemNumber
				},
				'ResponseForUpdateItemNumber',
				function (resultSet)						// processResultSet
				{
					window.osData.recordsUpdatedForItemNumber = resultSet.fieldValue(0, 'records_updated');
				},
				undefined,									// successRequestingService
				function (jqXHR, textStatus)				// completedRequestingService
				{
					if (window.osData.recordsUpdatedForItemNumber === 1)
					{
						window.osData.showFloatingMessage(savedMessage);
						successCallback();
					}
					else
					{
						window.osData.showFloatingMessage(notSavedMessage);
						cancelCallback();
					}
				},
				function (jqXHR, textStatus, errorThrown)	// errorRequestingService
				{
					window.osData.showFloatingMessage(notSavedMessage);
					cancelCallback();
				}
			);
		}

		function saveRetailPrice(retailPrice, successCallback, cancelCallback)
		{
			var savedMessage = 'Retail Price <strong>updated</strong>',
				notSavedMessage = 'Retail Price <b>NOT updated</b>';

			window.osData.requestSSKservice
			(
				'update_price_retail_price',
				{
					"product_guid":jQuery("#ostrm_product_details_form input[name='id']").val(),
					"retail_price":retailPrice
				},
				'ResponseForUpdateRetailPrice',
				function (resultSet)						// processResultSet
				{
					window.osData.recordsUpdatedForRetailPrice = resultSet.fieldValue(0, 'records_updated');
				},
				undefined,									// successRequestingService
				function (jqXHR, textStatus)				// completedRequestingService
				{
					if (window.osData.recordsUpdatedForRetailPrice === 1)
					{
						window.osData.showFloatingMessage(savedMessage);
						successCallback();
					}
					else
					{
						window.osData.showFloatingMessage(notSavedMessage);
						cancelCallback();
					}
				},
				function (jqXHR, textStatus, errorThrown)	// errorRequestingService
				{
					window.osData.showFloatingMessage(notSavedMessage);
					cancelCallback();
				}
			);
		}

		function saveYourCost(yourCost, successCallback, cancelCallback)
		{
			var savedMessage = 'Your Cost <strong>updated</strong>',
				notSavedMessage = 'Your Cost <b>NOT updated</b>';

			window.osData.requestSSKservice
			(
				'update_price_your_cost',
				{
					"product_guid":jQuery("#ostrm_product_details_form input[name='id']").val(),
					"your_cost":yourCost
				},
				'ResponseForUpdateYourCost',
				function (resultSet)						// processResultSet
				{
					window.osData.recordsUpdatedForYourCost = resultSet.fieldValue(0, 'records_updated');
				},
				undefined,									// successRequestingService
				function (jqXHR, textStatus)				// completedRequestingService
				{
					if (window.osData.recordsUpdatedForYourCost === 1)
					{
						window.osData.showFloatingMessage(savedMessage);
						successCallback();
					}
					else
					{
						window.osData.showFloatingMessage(notSavedMessage);
						cancelCallback();
					}
				},
				function (jqXHR, textStatus, errorThrown)	// errorRequestingService
				{
					window.osData.showFloatingMessage(notSavedMessage);
					cancelCallback();
				}
			);
		}

		function showEditProduct()
		{
			jQuery('#edit_product').show();
		}

		function hideEditProduct()
		{
			jQuery('#edit_product').hide();
		}

		jQuery('#product_name').inlineTextEdit
		(
			{
				ajaxCanEdit:canEditProduct,
				ajaxEditIfAllowed:canEditProduct,
				save:saveProductName,
				hoverInWhenEditable:showEditProduct,
				hoverInWhenNotEditable:hideEditProduct
			}
		);
		jQuery('div.product_image > div.product-ad-gallery').data('canEditProduct', canEditProduct);
		window.osData.canEditProduct = canEditProduct;
		window.osData.showEditProduct = showEditProduct;
		window.osData.hideEditProduct = hideEditProduct;
		jQuery('#short_description').inlineTextArea
		(
			{
				ajaxCanEdit:canEditProduct,
				ajaxEditIfAllowed:canEditProduct,
				save:saveShortDescription,
				trimContent:true,
				hoverInWhenEditable:showEditProduct,
				hoverInWhenNotEditable:hideEditProduct
			}
		);
		jQuery('#days_to_ship').inlineTextEdit
		(
			{
				ajaxCanEdit:canEditProduct,
				ajaxEditIfAllowed:canEditProduct,
				save:saveDaysToShip,
				trimContent:true,
				hoverInWhenEditable:showEditProduct,
				hoverInWhenNotEditable:hideEditProduct
			}
		);
		jQuery('#item_number').inlineTextEdit
		(
			{
				ajaxCanEdit:canEditProduct,
				ajaxEditIfAllowed:canEditProduct,
				save:saveItemNumber,
				trimContent:true,
				hoverInWhenEditable:showEditProduct,
				hoverInWhenNotEditable:hideEditProduct
			}
		);
		jQuery('#retail_price').inlineTextEdit
		(
			{
				ajaxCanEdit:canEditProduct,
				ajaxEditIfAllowed:canEditProduct,
				save:saveRetailPrice,
				trimContent:true,
				hoverInWhenEditable:showEditProduct,
				hoverInWhenNotEditable:hideEditProduct
			}
		);
		jQuery('#your_cost').inlineTextEdit
		(
			{
				ajaxCanEdit:canEditProduct,
				ajaxEditIfAllowed:canEditProduct,
				save:saveYourCost,
				trimContent:true,
				hoverInWhenEditable:showEditProduct,
				hoverInWhenNotEditable:hideEditProduct
			}
		);
		jQuery('#ostrm_product_details_form').submit(submitProductDetailsForm);
	}
);
