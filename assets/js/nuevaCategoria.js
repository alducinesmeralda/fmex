

$(document).ready(function(){
	
	var nuevaCategoria = $("#nuevaCategoria");
	
	var validator = nuevaCategoria.validate({
		
		rules:{
			nombre :{ required : true },
		},
		messages:{
			nombre :{ required : "Campo requerido" },
		}
	});
});
