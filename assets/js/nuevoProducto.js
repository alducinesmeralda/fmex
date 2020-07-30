
$(document).ready(function(){
	
	var nuevoProducto = $("#nuevoProducto");
	
	var validator = nuevoProducto.validate({
		
		rules:{
			nombre :{ required : true },
			cantidad :{ required : true },
			costo :{ required : true },
		},
		messages:{
			nombre :{ required : "Campo requerido" },
			cantidad :{ required : "Campo requerido" },
			costo :{ required : "Campo requerido" },
		}
	});
});
