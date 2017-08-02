/*
This class requires:

- ./JavaScript_Compatibility.js
- ./CLASS_JsonResultSet.js
- ./OrderStormWebServiceUtilities.js
- jQuery
- jquery.topzindex.min.js
*/
OrderStormSSK.prototype = 
{
	wsURL: undefined,
	floatingMessageFadeDelay: 1000,
	initializeFloatingMessage: function (floatingMessageFadeDelay)
	{
		var msie6 = ((jQuery.browser == 'msie') && (jQuery.browser.version < 7));
		
		jQuery('#OrderStormFloatingMessageWrapper').remove();
		jQuery('body').prepend('<div id="OrderStormFloatingMessageWrapper"><div id="OrderStormFloatingMessage"><center><span></span></center></div></div>');
		
		if (!msie6)
		{
			if ((typeof floatingMessageFadeDelay) !== 'undefined')
			{
				this.floatingMessageFadeDelay = floatingMessageFadeDelay;
			}
			
			var top = jQuery('#OrderStormFloatingMessage').offset().top - parseFloat(jQuery('#OrderStormFloatingMessage').css('margin-top').replace(/auto/, 0));
			
			jQuery(window).scroll
			(
				function (event)
				{
					var y = jQuery(this).scrollTop();								// what the y position of the scroll is
					
					if (y >= top)													// whether that's below the form
					{
						jQuery('#OrderStormFloatingMessage').addClass('fixed');		// if so, ad the fixed class
					}
					else
					{
						jQuery('#OrderStormFloatingMessage').removeClass('fixed');	// otherwise remove it
					}
				}
			);
		}
	},
	showFloatingMessage: function (strMessage)
	{
		jQuery('#OrderStormFloatingMessage').find('span').first().html(strMessage);
		jQuery('#OrderStormFloatingMessageWrapper')
			.topZIndex()
			.fadeToggle(this.floatingMessageFadeDelay, 'swing')
			.delay(this.floatingMessageFadeDelay * 3)
			.fadeToggle(this.floatingMessageFadeDelay, 'swing');
	},
	requestSSKservice: function
	(
		service,
		serviceArguments,
		resultSetHolderProperty,
		processResultSet,
		successRequestingService,
		completedRequestingService,
		errorRequestingService
	)
	{
		var	self = this,
			settings =	{
							"scurf":null,
							"scurg":null,
							"scurl":null,
							"scurpw":null,
							"scurt":null,
							"scuru":null,
							"service":service,
							"arguments":serviceArguments
						};
		
		self.getCookies
		(
			function (data, textStatus, jqXHR)		// successCallback
			{
				settings.scurf = self.cookies.scurf;
				settings.scurg = self.cookies.scurg;
				settings.scurl = self.cookies.scurl;
				settings.scurpw = self.cookies.scurpw;
				settings.scurt = self.cookies.scurt;
				settings.scuru = self.cookies.scuru;
				
				delete self.cookies;
			},
			function (jqXHR, textStatus)			// completeCallback
			{
				if (typeof window.cartGlobals !== 'undefined') {
					if (typeof window.cartGlobals.ckp !== 'undefined') {
						if (isWellFormedGUID(window.cartGlobals.ckp)) {
							settings.arguments['ckp'] = window.cartGlobals.ckp;
						}
					}
				}
				performAJAXrequest
				(
					settings,
					self.wsURL,
					self, 
					function (data, textStatus, jqXHR)
					{
						self.getSSKresponseData(data, resultSetHolderProperty);
						
						var response = self[resultSetHolderProperty];
						if (response.rowCount() > 0)
						{
							if ((typeof processResultSet) === 'function')
							{
								processResultSet(response);
							};
						}
						delete self[resultSetHolderProperty];
						
						if ((typeof successRequestingService) === 'function')
						{
							successRequestingService(data, textStatus, jqXHR);
						}
						self.updateCookies
						(
							self.cookies.scurf,
							self.cookies.scurg,
							self.cookies.scurl,
							self.cookies.scurpw,
							self.cookies.scurt,
							self.cookies.scuru,
							function ()			// cookiesUpdated
							{
								delete self.cookies;
							},
							function ()			// cookiesNotUpdated
							{
								delete self.cookies;
								
								throw "cookiesNotUpdated"
							}
						);
					},
					function (jqXHR, textStatus)
					{
						if ((typeof completedRequestingService) === 'function')
						{
							completedRequestingService(jqXHR, textStatus);
						}
					},
					function (jqXHR, textStatus, errorThrown)
					{
						if ((typeof errorRequestingService) === 'function')
						{
							errorRequestingService(jqXHR, textStatus, errorThrown);
						}
					}
				);
			},
			function (jqXHR, textStatus, errorThrown)	// errorCallback
			{
				if ((typeof errorRequestingService) === 'function')
				{
					errorRequestingService(jqXHR, textStatus, errorThrown);
				}
			}
		);
	},
	getCookies: function (successCallback, completeCallback, errorCallback)
	{
		jQuery.ajax
		(
			{
				async:true,
				cache:false,
				contentType:"application/x-www-form-urlencoded",
				context:this,
				data:{},
				crossDomain:true,
				dataType:"jsonp",
				processData:true,
				timeout:15000,
				type:"POST",
				url:this.sagcURL,
				success:function (data, textStatus, jqXHR)
				{
					this.cookies = {}
					this.cookies.scurf = data.scurf;
					this.cookies.scurg = data.scurg;
					this.cookies.scurl = data.scurl;
					this.cookies.scurpw = data.scurpw;
					this.cookies.scurt = data.scurt;
					this.cookies.scuru = data.scuru;
					if (this.cookies.scurf !== null
						&& this.cookies.scurg !== null
						&& this.cookies.scurl !== null
						&& this.cookies.scurpw !== null
						&& this.cookies.scurt !== null
						&& this.cookies.scuru !== null
						&& ((typeof successCallback) === 'function'))
					{
						successCallback(data, textStatus, jqXHR);
					}
				},
				complete: function (jqXHR, textStatus)
				{
					if ((typeof completeCallback) === 'function')
					{
						completeCallback(jqXHR, textStatus);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					if ((typeof errorCallback) === 'function')
					{
						errorCallback(jqXHR, textStatus, errorThrown);
					}
				}
			}
		);
	},
	updateCookies: function
	(
		scurf,
		scurg,
		scurl,
		scurpw,
		scurt,
		scuru,
		cookiesUpdated,
		cookiesNotUpdated
	)
	{
		jQuery.ajax
		(
			{
				async:true,
				cache:false,
				contentType:"application/x-www-form-urlencoded",
				context:this,
				data:
				{
					"scurf":scurf,
					"scurg":scurg,
					"scurl":scurl,
					"scurpw":scurpw,
					"scurt":scurt,
					"scuru":scuru
				},
				crossDomain:true,
				dataType:"jsonp",
				processData:true,
				timeout:15000,
				type:"POST",
				url:this.saucURL,
				success:function (data, textStatus, jqXHR)
				{
					if (data.cookiesUpdated === true)
					{
						if ((typeof cookiesUpdated) === 'function')
						{
							cookiesUpdated();
						}
					}
					else
					{
						if ((typeof cookiesNotUpdated) === 'function')
						{
							cookiesNotUpdated();
						}
					}
				}
			}
		);
	},
	getCookieDataFromJsonResultSet: function (resultSet, cookie)
	{
		var metaData = resultSet.metaData;
		
		if (!this.hasOwnProperty('cookies')) this.cookies = {};
		if (metaData.hasOwnProperty(cookie))
		{
			this.cookies[cookie] = metaData[cookie];
			delete metaData[cookie];
		}
	},
	getSSKresponseData: function (data, property)
	{
		var resultSet = new JsonResultSet(data);
		if ((typeof property) !== 'undefined' && property !== null)
		{
			this[property] = resultSet;
		}
		this.getCookieDataFromJsonResultSet(resultSet, 'scurf');
		this.getCookieDataFromJsonResultSet(resultSet, 'scurg');
		this.getCookieDataFromJsonResultSet(resultSet, 'scurl');
		this.getCookieDataFromJsonResultSet(resultSet, 'scurpw');
		this.getCookieDataFromJsonResultSet(resultSet, 'scurt');
		this.getCookieDataFromJsonResultSet(resultSet, 'scuru');
	}
}

function OrderStormSSK(wsURL, sagcURL, saucURL)
{
	this.wsURL = wsURL;
	this.sagcURL = sagcURL;
	this.saucURL = saucURL;
}
