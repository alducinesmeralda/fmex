$(document).ready(function(){
	var editarCapacidad = $("#editarCapacidad");
	
	var validator = editarCapacidad.validate({
		
		rules:{
			nombre :{ required : true },
		},
		messages:{
			nombre :{ required : "Campo requerido" },
		}
	});


});