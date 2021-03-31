$(function(){
	$('#insurance_premium_determination_sumInsured').on('change', function() {
		let value = $(this).val();
		$('#insurance_premium_determination_sumInsuredVs').val(Math.ceil(value * 10.313 / 100) * 100);
	});

	$('#insurance_premium_determination_currentValue').on('change', function() {
		let value = $(this).val();
		$('#insurance_premium_determination_currentValueVs').val(Math.ceil(value / 1000 * 657.6 / 100) * 100);
	});

	$('#insurance_premium_determination_total').on('change', function() {
		let value = $(this).val();
		$('#insurance_premium_determination_totalVs').val(Math.ceil(value * 1.550));
	});

});
