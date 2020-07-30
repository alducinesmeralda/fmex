
$(document).ready(function(){
	
	var nuevaTipoHora = $("#nuevaTipoHora");
	
	var validator = nuevaTipoHora.validate({
		
		rules:{
			nombre :{ required : true },
		},
		messages:{
			nombre :{ required : "Campo requerido" },
		}
	});
});
