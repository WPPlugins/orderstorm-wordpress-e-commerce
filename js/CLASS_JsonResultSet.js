/*
This class requires ./JavaScript_Compatibility.js to be included
previously, for it to work on some browsers with older versions
of JavaScript implementation.

It also requires jQuery.
*/
JsonResultSet.prototype = 
{
	fieldNames: undefined,
	rowData: undefined,
	metaData: undefined,
	rowCount:	function ()
				{
					return this.rowData.length;
				},
	fieldValue:	function (rowIndex, fieldName)
				{
					var returnValue = undefined;
					
					if (Object.keys(this.fieldNames).length > 0)
					{
						returnValue = this.rowData[rowIndex][this.fieldNames[fieldName]];
					}
					
					return returnValue;
				},
	row:	function (rowIndex)
			{
				var returnValue = {};
				
				if (rowIndex >= 0 && rowIndex < this.rowData.length)
				{
					for (var key in this.fieldNames)
					{
						returnValue[key] = this.rowData[rowIndex][this.fieldNames[key]];
					}
				}
				
				return returnValue;
			},
	getMetaData:	function ()
					{
						return this.metaData;
					},
	hasFieldName:	function (fieldName)
					{
						if (this.fieldNames.hasOwnProperty(fieldName) !== -1)
						{
							return true;
						}
						else
						{
							return false;
						}
					}
}

function JsonResultSet(jsonResponse)
{
	this.fieldNames = {};
	this.rowData = [];
	this.metaData = [];
	if (jQuery.isArray(jsonResponse))
	{
		if (jsonResponse.length > 0)
		{
			if (jQuery.isArray(jsonResponse[0]) && jQuery.isArray(jsonResponse[1]))
			{
				for (var intColumnsCount = 0; intColumnsCount <= jsonResponse[0].length - 1; intColumnsCount++)
				{
					this.fieldNames[jsonResponse[0][intColumnsCount]] = intColumnsCount;
				}
				this.rowData = jsonResponse[1];
				if (jQuery.isPlainObject(jsonResponse[2]) || jQuery.isArray(jsonResponse[2]))
				{
					this.metaData = jsonResponse[2];
				}
			}
		}
	}
}
