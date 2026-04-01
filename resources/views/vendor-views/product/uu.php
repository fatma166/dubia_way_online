;
$('.form_edit .submit_edit').click(function() {
// $('#product_form').on('submit', function (e) {
//           var formData = new FormData(this);
// console.log(formData);
var myEditor = document.querySelector('#snow-editor')
description1= myEditor.children[0].innerHTML
formData.append('description', description1);

name= $('input[name="name"]').val();

summary=$('textarea[name="summary"]').val();
category_id=$('select[name="category_id"]').val();
price=$('input[name="price"]').val();
discount= $('input[name="discount"]').val();
product_quantity= $('input[name="product_quantity"]').val();
status=$('input[name="status"]').val();
// Retrieve selected attribute IDs from the multi-select
var attribute_idValues = $('#choice_attributes').val(); // This will give you an array of selected values

// Check if any attributes are selected
if (attribute_idValues) {
// Append each selected attribute ID to the FormData
attribute_idValues.forEach(function(value) {
formData.append('attribute_id[]', value); // Use 'attribute_id[]' to match your expected format
});
}
// Retrieve all choice_no values
var choiceValues = $('input[name="choice[]"]').map(function() {
return $(this).val();
}).get(); // This will return an array of all choice_no values

// Append each choice_no value as an array
choiceValues.forEach(function(value) {
formData.append('choice[]', value); // Append each value separately
});
// To get all choice_no values
// Retrieve all choice_no values
var choiceNoValues = $('input[name="choice_no[]"]').map(function() {
return $(this).val();
}).get(); // This will return an array of all choice_no values

// Append each choice_no value as an array
choiceNoValues.forEach(function(value) {
formData.append('choice_no[]', value); // Append each value separately
});

// Assuming you already have a choice variable


// Count the number of values
var count= choiceNoValues.length;

// Loop through the array to access each value
/* for (var i = 0; i < count; i++) {
$dataaa_choice_options_="choice_options_"+(i+1);
var $dataaa_choice_options_= $('input[name="choice_options_'+ (i+1)+'[]"]').map(function() {
return $(this).val();
}).get();
console.log($dataaa_choice_options_);
// formData.append("choice_options_"+(i+1), $dataaa_choice_options_);
// Append as an array
$dataaa_choice_options_.forEach(function(value) {
formData.append("choice_options_"+(i+1)+[], value); // Append each value separately

});*/
for (var i = 0; i < count; i++) {
var choiceOptionName = "choice_options_" + (i + 1) + "[]"; // Set the name to indicate it's an array
var choiceOptionsValues = $('input[name="choice_options_' + (i + 1) + '[]"]').map(function() {
return $(this).val();
}).get();

console.log(choiceOptionsValues);

// Append the entire array as a single entry
// formData.append(choiceOptionName, choiceOptionsValues.join(',')); // Join values with a comma

// If you want it as an actual array in PHP, loop and append each value
choiceOptionsValues.forEach(function(value) {
formData.append(choiceOptionName, value); // Append each value separately
});
$dataaa_choice_options_=choiceOptionsValues;

// Explode the string into separate values
var explodedValues = $dataaa_choice_options_[0].split(',');
var explodedValuescount= explodedValues.length;
for (var ei = 0; ei < explodedValuescount; ei++) {
$explode_price =$('input[name="price_'+explodedValues[ei]+'"]').val();
console.log("price_"+explodedValues[ei]+"value"+$explode_price);

formData.append("price_"+explodedValues[ei], $explode_price);
}

/*$dataaa_choice_options_= $('input[name="choice_options_"'+ (i+1)+']').val();
alert($dataaa_choice_options_);
formData.append('choice_options_'+(i+1), $dataaa_choice_options_);
formData.append('price_'+(i+1), $dataaa_choice_options_);
// console.log('Value at index ' + (i+1) + ': ' + [i]);*/
}
//  image=formData;//$('.logo_img').val();

//            alert($('input[name="category_id"]').val());
url="{{route('vendor.product.store')}}";
formData.append('name', name);
formData.append('description', description1);
formData.append('summary', summary);
formData.append('category_id', category_id);
formData.append('price', price);
formData.append('discount', discount);
formData.append('product_quantity', product_quantity);
formData.append('status', status);
// formData.append('attribute_id', attribute_id);

console.log(formData);

/* var data= {id:id,name:name,
description:description1,
summary:summary,
category_id:category_id,
price: price,
discount:discount,
product_quantity:product_quantity,
status:status,
image:image ,
};*/
console.log(url);
$.ajax({
url:url,
type:'POST',
data:formData,
headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
processData: false,
contentType: false,
success: function(data) {
$('.text-danger').empty();
$('is-invalid').removeClass();

// if(data.hasOwnProperty('success')){

var routeUrl = "{{ route('vendor.product.index') }}";
//   window.location.href = routeUrl;
// location.reload(true);
// }else{
// alert("error");
//   console.log(data.error.errors);
//   printErrorMsg(data.error.errors);
// }
},
error :function( data ) {
if (data.status === 422) {
var errors = $.parseJSON(data.responseText);
$.each(errors, function (key, value) {
console.log(key + " " + value);
$('#response').addClass("alert alert-danger");

if ($.isPlainObject(value)) {
$.each(value, function (key, value) {
console.log(key + " " + value);
$('.'+key+'_').append('<span class="text-danger">'+value+'</span>');
$('input[name="'+key+'"]').addClass('is-invalid');
//  $('#response').show().append(value + "<br/>");

});
} else {
$('#response').show().append(value + "<br/>"); //this is my div with messages
}
});
}
}
});

});
