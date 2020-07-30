$(document).ready(function(){

	var editarLicencia = $("#editarLicencia");
	
	var validator = editarLicencia.validate({
		
		rules:{
			nombre :{ required : true },
		},
		messages:{
			nombre :{ required : "Campo requerido" },
		}
	});


});