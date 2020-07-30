$(document).ready(function(){

	var editarTipoHora = $("#editarTipoHora");
	
	var validator = editarTipoHora.validate({
		
		rules:{
			nombre :{ required : true },
		},
		messages:{
			nombre :{ required : "Campo requerido" },
		}
	});


});