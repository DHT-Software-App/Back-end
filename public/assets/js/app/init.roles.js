//Open to modal
function openModalRol(cod) {
    //resetform($("#divresultRol"));
   
    if (cod != 0) {
      
         href = "/roles/"+cod;
    } else {
         href = "/roles/create";
    }
    openModal("idmodaleditrol", 'Roles', href, 3,'rol','formrols','divresultRol')
   
}
//load datatable 
var table = $('#tableroles');

//function for delete clients
$(document).on('click', '.rol-delete',  function(){
    Swal.fire({
        title: alertuser,
        text: questiondelete,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
      }).then((result) => {
        if (result.isConfirmed) {
            let rsID =$(this).attr('rol-id'); 
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax(
            {
                url: "roles/"+rsID,
                type: 'DELETE',
                data: {
                    "id": rsID,
                    "_token": token,
                },
                success: function (){
                    table.DataTable().ajax.reload(); 
                }
            })
        }    
    })
    
    
})

//load register datatable

$(function() {

    table.DataTable({
        searching: true,
        processing: true,
        serverSide: true,
        ajax: urldatatable,
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('#datatableclients tbody').on('dblclick', 'tr', function() {
        var table = $('#datatableclients').DataTable();
        var data = table.row(this).data();
        openModalRol(data.id);
    });


    $(document).on('click', '.rol-modal',  function(){
        let rsID =$(this).attr('rol-id'); 
        openModalRol(rsID);    
    });
});

//this function no permit closes de modal when save recivied


//validate form
//validateClientForm();
function validateClientForm()
{
$.validator.setDefaults( {
    submitHandler: function () {
      
        $('#idmodaleditrol').modal('hide');
        $('#idmodaleditrol').on('hidden.bs.modal', function() {
            table.DataTable().ajax.reload(); 
        });
    }
} );
    $( "#formrols" ).validate( {
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            
            name: {
                required: required
            }
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "help-block" );

            // Add `has-feedback` class to the parent div.form-group
            // in order to add icons to inputs
            element.parents( ".col-sm-5" ).addClass( "has-feedback" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
            } else {
                error.insertAfter( element );
            }

            // Add the span element, if doesn't exists, and apply the icon classes to it.
            if ( !element.next( "span" )[ 0 ] ) {
                $( "<span class='icon-warning-empty form-control-feedback'></span>" ).insertAfter( element );
            }
        },
        success: function ( label, element ) {
            // Add the span element, if doesn't exists, and apply the icon classes to it.
            if ( !$( element ).next( "span" )[ 0 ] ) {
                $( "<span class=' icon-ok'></span>" ).insertAfter( $( element ) );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).next( "span" ).addClass( "icon-warning-empty" ).removeClass( "icon-ok" );
        },
        unhighlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).next( "span" ).addClass( "icon-ok" ).removeClass( "icon-warning-empty" );
        }
    });
}