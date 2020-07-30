
$(document).ready(function(){
	
	var nuevaCapacidad = $("#nuevaCapacidad");
	
	var validator = nuevaCapacidad.validate({
		
		rules:{
			nombre :{ required : true },
		},
		messages:{
			nombre :{ required : "Campo requerido" },
		}
	});
});
