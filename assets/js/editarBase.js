
$(document).ready(function(){
	
	
	var editarBase = $("#editarBase");
	
	var validator = editarBase.validate({
		
		rules:{
			nombre :{ required : true },
		},
		messages:{
			nombre :{ required : "Campo requerido" },
		}
	});
});
