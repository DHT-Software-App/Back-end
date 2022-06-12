function openModal(id, title, view, vwidth,origin,idform,idreciviedmessages)

{
    size = "";
    if (!$('#' + id).html()) {
        newHTML = document.createElement('div');
        if (vwidth == 1) {
            size = "modal-xl";
        }
        if (vwidth == 2) {
            size = "modal-sm";
        }
        if (vwidth == 3) {
            size = "modal-lg";
        }
        newHTML.innerHTML = '<div class="modal fade " style="100%" id="' + id + '" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"><div class="modal-dialog ' + size + '"><!-- Modal content--><div class="modal-content rounded"><div class="modal-header border-0 pb-0" ><h5 class="modal-title" >' + title + '</h5><div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"><span class="svg-icon svg-icon-1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000"><rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" /><rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" /></g></svg></span></div></div><div class="modal-body" id="dCs' + id + '"></div></div></div></div>';
        document.body.appendChild(newHTML);
    }
    $('#' + id).modal('show');
    loadView('dCs' + id, view,origin,idform,idreciviedmessages);

    

}

function loadView(id, pagina,origin,idform,idreciviedmessages) {
    $.ajax({
        type: 'GET',
        url: pagina,
        beforeSend: function(objeto) {
            $("#" + id).html("");
        },
        success: function(data) {
            $("#" + id).html(data);
            switch (origin) {
                case 'rol':
                    formulariosubmit($("#"+idform), $("#"+idreciviedmessages));
                    validateClientForm();
                break;
            }
        }
    });
}

function formulariosubmit(formulario, receptor) {

    formulario.bind("submit", function(e) {
        mensaje = "Faltan campos necesarios para continuar: \n";
        mostrarMSG = false;
        if (typeof filters == 'undefined') return;
        $(this).find("input, textarea, select").each(function(x, el) {
            if ($(el).attr("className") != 'undefined') {
                $(el).removeClass("error");
                $.each(new String($(el).attr("className")).split(" "), function(x, klass) {
                    if ($.isFunction(filters[klass]))
                        if (!filters[klass](el)) {
                            $(el).addClass("error");
                            //alert(el.id);
                            if ($(el).attr("title") != "") {
                                mensaje += " - " + $(el).attr("title") + "\n";
                                mostrarMSG = true;
                            }
                        }
                });
            }
        });

        $.ajax({
            type: 'POST',
            url: formulario.attr('action'),
            beforeSend: function(objeto) {

            },
            data: formulario.serialize(),
            success: function(data) {

                receptor.show();
                receptor.html(data);
               // console.log(data);

            },error: function(data){
                // Something went wrong
                // HERE you can handle asynchronously the response 
        
                // Log in the console
                var errors = data.responseJSON;
        
                // or, what you are trying to achieve
                // render the response via js, pushing the error in your 
                // blade page
                 errorsHtml = '<div class="alert alert-danger"><ul>';
                 errorsHtml += '<li>'+  errors.message + '</li>';
                 $.each( errors.errors, function( key, value ) {
                      errorsHtml +='<li>'+ key + '=> '+ value + '</li>'; //showing only the first error.
                 });
                 errorsHtml += '</ul></div>';
                 $( '#form-errors' ).html( errorsHtml ); //appending to a <div id="form-errors"></div> inside form  
                }
        })
        return false;
    });

}

var filters = {
    requerido: function(el) { return ($(el).val() != '' && $(el).val() != -1); },
    email: function(el) { return /^[A-Za-z.+][A-Za-z0-9_.+]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/.test($(el).val()); },
    telefono: function(el) { return /^[0-9]*$/.test($(el).val()); },

    entero: function(el) { return /^[0-9]*$/.test($(el).val()); },
    decimal: function(el) { return /^[-]?([1-9]{1}[0-9]{0,}(\.[0-9]{0,2})?|0(\.[0-9]{0,2})?|\.[0-9]{1,2})$/.test($(el).val()); },
    ceduladom: function(el) { return verificarCedula($(el).val()); },
    fechamysql: function(el) { return validarFecha($(el).val()); }

};

function resetform(receptor) {
    $("form .livesearch").each(function() { $(".livesearch").val(null).trigger('change'); });
    $("form input[type=text] , form textarea , form input[type=email], form em" ).each(function() { this.value = ''; this.innerHTML='' });
    $(".form-errors").html('');
    receptor.hide();
}

function buscarEnTablaHTML(txt, dondeBuscar) {

	var registro=0;
	var totalregistro=0;
	var tableReg = $("#"+dondeBuscar+" table")[0];
	var searchText = txt.value.toLowerCase();
	for (var i = 1; i < tableReg.rows.length; i++) {
		var cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
		var found = false;
		for (var j = 0; j < cellsOfRow.length && !found; j++) {
			var compareWith = cellsOfRow[j].innerHTML.toLowerCase();
			if (searchText.length == 0 || (compareWith.indexOf(searchText) > -1)) {
				found = true;
				
			}
		}
		if (found) {
			tableReg.rows[i].style.display = '';
			console.log(tableReg.rows.length);
			registro+=1;
		//	$("#"+idcheck).hide();
		} else {
			tableReg.rows[i].style.display = 'none';
			
		}
	}
	if(tableReg.rows.length-1==registro)
	{
		//$("#"+idcheck).show();
	}
	//$("#"+idtotalregistro).html(registro);
}


$(document).on('click', '.signout',  function(){
     Swal.fire({
        title: alertuser,
        text: messagesexit,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
      }).then((result) => {
        if (result.isConfirmed) {
            $("#logout").submit();
        }
      })   
});