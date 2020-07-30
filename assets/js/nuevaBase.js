
$(document).ready(function(){
	
	
	var nuevaBase = $("#nuevaBase");
	
	var validator = nuevaBase.validate({
		
		rules:{
			nombre :{ required : true },
		},
		messages:{
			nombre :{ required : "Campo requerido" },
		}
	});
});
