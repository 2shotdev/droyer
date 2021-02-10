var vendor = {
	styles:[],
	products:[],
	styleids:[],
	stylecount:0,
	variationcount: 0,
	insertcount: 0,
	message1: "Fetching the Styles",
	init: function() {
		jQuery(".api-go").bind("click",function() {
			jQuery(".overlay-message").text(vendor.message1);
			jQuery(".overlay").fadeIn();
			setTimeout("vendor.getstyles()",500);
		});
		jQuery(".api-goprod").bind("click", function() {
			vendor.getproducts();
		});
	},
	getstyles: function() {
		jQuery.ajax({
			type: "GET",
    		contentType: "application/json;charset=utf-8",
			url: directory+"get-styles.php",
			dataType: "json",
			data: {
				url: jQuery(".api-url").val(),
				un: jQuery(".api-username").val(),
				pwd: jQuery(".api-password").val(),
				stydir: jQuery(".api-styledir").val()
			},
			 success: function(data) {
			 	vendor.styles = data;
			 	var ctr = 0
				jQuery('.overlay').fadeOut();
				jQuery(".api-content").fadeIn();
			 	jQuery.each(vendor.styles, function(key, value) {
			 		ctr++;
			 		if(ctr < 2) {
			 			vendor.stylecount = ctr;
			 			vendor.insertstyle(value);
			 		}
				 	jQuery(".all-styles").text(vendor.stylecount+" styles have been added to WooCommerce").delay(100);
			 	});
			 	jQuery(".now-products").show();
			 },
			async: false
		});
	},
	showstyles: function() {
		jQuery(".overlay-message").text(vendor.message2);
		jQuery(".api-content").fadeIn();
		jQuery.each(vendor.styles, function(key,value) {
			var tmp = vendor.base;
			jQuery.each(value, function(key,value){
				switch (key) {
					case "styleID":
						tmp = tmp.replace(/~id~/g, value);
						break;
					case "title":
						tmp = tmp.replace(/~title~/g, value);
						break;
					case "brandName":
						tmp = tmp.replace(/~brandName~/g, value);
						break;
					case "styleImage":
						tmp = tmp.replace(/~styleImage~/g, value);
						break;
					case "description":
						tmp = tmp.replace(/~description~/g, value);
						break;
					case "baseCategory":
						tmp = tmp.replace(/~baseCategory~/g, value);
						break;
				}
			});
			jQuery(".all-styles").append(tmp);
		});
		setTimeout("jQuery('.overlay').fadeOut()",500);
	},
	getproducts: function() {
		vendor.insertcount = 0;
		jQuery.each(vendor.styles, function(key, value) {
			if(vendor.insertcount < 1) {
				jQuery.ajax({
					type: "GET",
		    		contentType: "application/json;charset=utf-8",
					url: directory+"get-product.php",
					dataType: "json",
					data: {
						url: jQuery(".api-url").val(),
						un: jQuery(".api-username").val(),
						pwd: jQuery(".api-password").val(),
						prdddir: jQuery(".api-productdir").val(),
						sty: value.styleID
					},
					 success: function(data) {
					 	vendor.products = data;
					 	jQuery.each(vendor.products, function(ky, val) {
					 		vendor.insertproduct(vendor.styleids[vendor.insertcount],val);
					 	});
					 },
					async: false
				});
				vendor.insertcount++;
			}
		});
		jQuery(".complete").text("The import is now complete.  Please feel free to run it again if needed.");
		vendor.insertcount=0;
		vendor.stylecount=0;
		variationcount=0;
	},
	insertstyle: function(style) {
		jQuery(".overlay-message").hide();
		jQuery.ajax({
			type: "GET",
    		contentType: "application/json;charset=utf-8",
			url: directory+"insert-style.php",
			dataType: "json",
			data: {
				title: style.title,
				description: style.description,
				sku: style.styleID,
				category: style.baseCategory,
				image: jQuery(".api-productimageurl").val()+style.styleImage
			},
			 success: function(data) {
			 	vendor.styleids.push(data.d.ProductID);
			 	jQuery(".all-styles").text(vendor.stylecount+" styles have been added to WooCommerce");
			 },
			async: false
		});
	},
	insertproduct: function(styleid, product) {
		jQuery.ajax({
			type: "GET",
    		contentType: "application/json;charset=utf-8",
			url: directory+"insert-variation.php",
			dataType: "json",
			data: {
				pid: styleid,
				color: product.colorName,
				size: product.sizeName,
				sku: product.sku,
				image: jQuery(".api-productimageurl").val()+product.colorFrontImage
			},
			 success: function(data) {
			 	vendor.variationcount++;
			 	jQuery(".all-variations").text(vendor.variationcount+" variations have been added to WooCommerce");
			 },
			async: false
		});
	}
}
jQuery(document).ready(function() {
	vendor.init();
});