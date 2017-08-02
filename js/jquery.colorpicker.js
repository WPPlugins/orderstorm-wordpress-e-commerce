(function ($) {
	$.fn.colorpicker = function (options) {
		var settings = $.extend(true, {
			limit: 12,
			width: 250,
			css: {
				table: {
					border: "1px solid #B9BAB9",
					background: "#D1D1CE",
					padding: 0,
					display: "none",
					zIndex: "9",
					position: "relative",
					top: "0px",
					left: "0px",
					width: "250px"
				},
				container: {
					width: "16px",
					height: "16px",
					border: "1px solid #000",
					backgroundColor: "",
					position: "relative"
				},
				selected: {
					border: "1px solid #FF9900",
					cursor: "pointer"
				},
				colors: {
					width: "16px",
					height: "16px",
					margin: 0,
					padding: 0,
					border: "1px solid #000"
				},
				mouseout: {
					border: "1px solid #000"
				}
			},
			close: [],
			callback: function (color) {},
			colorList: {},
			feature_group_name_id: undefined
		}, options);
		
		return this.each(function () {
			var self = this;
			$("<div>click here to select color</div>")
			.addClass("colorpicker-start")
			.css(settings.css.container)
			.click(function () {
				var self = this;
				$("div.colorpicker-start").each(function () {
					if (this == self) {
						if ($(this).next().css("display") == "none") {
							$(this).next().show();
						} else {
							$(this).next().hide();
						}
						
					} else {
						$(this)
						.next()
						.hide();
					}
				});
				
				$(this).css("background-color", $(this).data("color") ? $(this).data("color") : "");
			})
			.mouseover(function () {
				$(this)
				.css("cursor", "pointer")
			})
			.appendTo(this);
			
			$("<table></table>")
			.css(settings.css.table)
			.addClass("color-picker-container")
			.append("<thead></thead>")
			.each(function () {
				var html = "";
				var self = this;
				var counter = 0;
				html += "<tr>";
				$.each
				(
					settings.colorList,
					function (index, value)
					{
						if (counter == settings.limit)
						{
							html += "<tr></tr>";
							counter = 0;
						}
						html += "<td class='colorpick-element' title='" + value.feature_name + " -- " + settings.feature_group_name_id + "' id='" + value.feature_product_guid + "'>#" + value.feature_hex + "</td>";
						counter++;
					}
				);
				html += "</tr>";
				$(this).append(html);
			})
			.find("td.colorpick-element")
				.each(function () {
					var self = this;
					$(this)
					.css(settings.css.colors)
					.css("background-color", $(this).html())
					.data("hex", $(this).html())
					.data("guid", $(this).attr('id'))
					.data("name", $(this).attr('title').split(' -- ')[0])
					.data("group_id", $(this).attr('title').split(' -- ')[1])
					.mouseover(function () {
						$(this)
						.css(settings.css.selected)
						.parent()
						.parent()
						.parent()
						.prev()
						.css("background-color", $(this).css("background-color"));
					})
					.mouseout(function () {
						$(this).css(settings.css.mouseout);
					})
					.empty()
					.click(function () {
						var color = $(this).data("hex");
						var guid = $(this).data("guid");
						var group_id = $(this).data("group_id");
						var name = $(this).data("name");
						$(this)
						.parent()
						.parent()
						.parent()
						.prev()
						.data("color", color)
						.css("background-color", color);
						
						$(this)
						.parent()
						.parent()
						.parent()
						.toggle();
						
						settings.callback(color, name, guid, group_id);
					});
				})
			.end()
			.appendTo(this);
		});
	};
})(jQuery);
