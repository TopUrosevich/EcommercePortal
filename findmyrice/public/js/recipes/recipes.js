$('document').ready(function(){
	var ingredients = $('#ingredients_input');
	var addIngredient = $('#add_ingredient');
	var lastIngredient = ingredients.find('div:last input').attr('name');
	var ingredientIndex = parseInt(lastIngredient.charAt(12) + lastIngredient.charAt(13));

	$.ajax('/recipes/getUnitsAjax', {
		type: 'GET',
		success: function(data) {
			var unitsList = JSON.parse(data).response;
			ingredients.find('input[unit-autocomplete]').autocomplete({
				source: unitsList
			});
		}
	});

	$.ajax('/recipes/getIngredientsAjax', {
		type: 'GET',
		success: function(data) {
			var ingredientsList = JSON.parse(data).response;
			ingredients.find('input[ingredient-autocomplete]').autocomplete({
				source: ingredientsList
			});
		}
	});

	addIngredient.click(function(){
		ingredients.append(
			'<div class="col-lg-2 col-md-2">'
			+   '<input name="ingredients['+ingredientIndex+'][qty]" class="form-control form_control" type="text">'
			+'</div>'
			+'<div class="col-lg-3 col-md-3">'
			+   '<input unit-autocomplete name="ingredients['+ingredientIndex+'][unit]" class="form-control form_control" type="text">'
			+'</div>'
			+'<div class="col-lg-7 col-md-7">'
			+   '<input ingredient-autocomplete name="ingredients['+ingredientIndex+'][ingredient]" class="form-control form_control" type="text">'
			+'</div>'
		);
		ingredientIndex++;
	});

	var methods = $('#methods_input');
	var addMethod = $('#add_method');
	var lastMethod = methods.find('div label:last').text();
	var methodIndex = parseInt(lastMethod.charAt(5) + parseInt(lastMethod.charAt(6)));

	addMethod.click(function(){
		methods.append(
			'<div class="col-lg-2 col-md-2"><label>Step '+(methodIndex+1)+'</label></div>'
			+'<div class="col-lg-10 col-md-10">'
			+   '<input class="form-control form_control" name="methods[]" type="text">'
			+'</div>'
		);
		methodIndex++;
	});
});
