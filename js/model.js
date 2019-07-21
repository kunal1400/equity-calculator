function round(number, decimals) {
	return Math.round(number * Math.pow(10, decimals)) / Math.pow(10, decimals);
};

function formatNumbers(x, tag){
	var numberType = tag.data('numbertype');
	var decimals = tag.data('decimals');

	function numberWithCommas(y) {
		var parts = y.toString().split(".");
		parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		return parts.join(".");
	};

	function padZeros(z, dec) {
		var parts = z.split(".")
		
		if (parts.length === 1)
			parts.push("");

		var dec_length = parts[1].length;
		
		if (dec_length === dec)
			return z;

		for (var i = 0; i < (dec - dec_length); i++)
			parts[1] += "0";

		return parts.join(".");
	}

	switch(numberType) {
		case "dollar":
			if (!x) return '$0';
			else {
				var val = String(numberWithCommas(round(x, decimals)));

				return "$" + padZeros(val, decimals)
			}
			break;
		case "bigdollar":
			if (!x) return '$0';
			else {
				if(x>=1000000&x<1000000000){
					return "$" + String(numberWithCommas(round(x/1000000, 0))) + "m"
				}
				else if (x>=1000000000){
					return "$" + String(numberWithCommas(round(x/1000000000, 2))) + "bn"
				}
				else return "$" + String(numberWithCommas(round(x, decimals)))
			}
			break;				
		case "percent":
			if (!x) return '0%';
			else {
				return String(numberWithCommas(round(x, decimals))) + "%";
			}
			break;
		case "regular":
			if (!x) return '0';
			else {
				return numberWithCommas(round(x, decimals))
			}
			break;
		default:
			return x;

	}
};


function logSlider(slider){
	var mini = parseFloat(slider.data('min'));
	var maxi = parseFloat(slider.data('max'));
	var pos = slider.val();
			
	if (slider.data('type')==='log'){
		if (pos<=10) {
			return pos*10000000;
		} else if (pos<=19) {
			return (pos-9)*100000000;
		} else if (pos<=28) {
			return (pos-18)*1000000000;	
		} else if (pos<=37) {
			return (pos-27)*10000000000;
		}
	}
	else {
		return slider.val();
	}
}

function updateModel() {
	var options = parseFloat(jQuery('#options').val().replace(/,/g, ''));
	var valuation = logSlider(jQuery('#valuation'));
	var dilution = logSlider(jQuery('#dilution'));
	var salary = parseFloat(jQuery('#salary').val().replace(/,/g, ''));
	var strikePrice = parseFloat(jQuery('#strike-price').val().replace(/,/g, ''));
	strikePrice = isFinite(strikePrice) ? strikePrice : 0.0;
	var nbOfShares = parseFloat(jQuery('#nb-of-shares').val().replace(/,/g, ''));


	var finalShareValue = (1-(dilution/100))*valuation/nbOfShares;
	finalShareValue = isFinite(finalShareValue) ? finalShareValue : 0.0;
	var spread = finalShareValue-strikePrice

	jQuery('#final-share-value').text(formatNumbers(finalShareValue, jQuery('#final-share-value')));
	jQuery('#spread').text(formatNumbers(spread, jQuery('#spread')));

	var outputYearlyStock = options*Math.max(finalShareValue-strikePrice,0)/4;
	var outputYearlySalary = salary;
	var outputYearlyBoth = outputYearlyStock+outputYearlySalary;

	var outputOverallStock = options*Math.max(finalShareValue-strikePrice,0);
	var outputOverallSalary = salary*4;
	var outputOverallBoth = outputOverallStock+outputOverallSalary;


	jQuery('#output-yearly-stock').text( formatNumbers( outputYearlyStock, jQuery('#output-yearly-stock') ) );
	jQuery('#output-yearly-salary').text( formatNumbers( outputYearlySalary, jQuery('#output-yearly-salary') ) );
	jQuery('#output-yearly-both').text( formatNumbers( outputYearlyBoth, jQuery('#output-yearly-both') ) );
	jQuery('#output-overall-stock').text( formatNumbers( outputOverallStock, jQuery('#output-overall-stock') ) );
	jQuery('#output-overall-salary').text( formatNumbers( outputOverallSalary, jQuery('#output-overall-salary') ) );
	jQuery('#output-overall-both').text( formatNumbers( outputOverallBoth, jQuery('#output-overall-both') ) );


};

function reverse(s){
	return s.split("").reverse().join("");
}

function formatInt(str) {
	if (!str)
		return ("").toLocaleString("en-US");
	var leadingZeros = 0;
	while (leadingZeros < str.replace(/\D/g,'').length & parseInt(str.replace(/\D/g,''),10) === parseInt(str.replace(/\D/g,'').substr(1,1+leadingZeros),10)) {
		leadingZeros+= 1;
	};
	if ( leadingZeros > 0){
		return(reverse(reverse(str).replace(/\D/g,'')).match(/.{1,3}/g).join(","))
	}
	else return (parseInt(str.replace(/\D/g,''),10) ||  0).toLocaleString("en-US");
};

function init() {
	jQuery('#salary').val(("").toLocaleString("en-US"));
	jQuery('#options').val(("").toLocaleString("en-US"));
	jQuery('#strike-price').val(("").toLocaleString("en-US"));
	jQuery('#nb-of-shares').val(("").toLocaleString("en-US"));

};