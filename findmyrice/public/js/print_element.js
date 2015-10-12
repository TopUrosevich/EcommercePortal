$('document').ready(function(){
	window.printElementById =  function(id) {
		var printContents = document.getElementById(id).innerHTML;
		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
});