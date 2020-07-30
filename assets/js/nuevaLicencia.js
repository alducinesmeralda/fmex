
$(document).ready(function(){
	
	var nuevaLicencia = $("#nuevaLicencia");
	
	var validator = nuevaLicencia.validate({
		
		rules:{
			nombre :{ required : true },
		},
		messages:{
			nombre :{ required : "Campo requerido" },
		}
	});
});
