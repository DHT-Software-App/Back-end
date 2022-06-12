//Open to modal
function openModalCustomer(cod) {
    //resetform($("#divresultRol"));
   
    if (cod != 0) {
      
         href = "/customers/"+cod;
    } else {
         href = "/customers/create";
    }
    openModal("idmodaleditCustomer", 'Customers', href, 1,'Customer','formcustomers','divresultCustomer')
   
}
//load datatable 
var table = $('#tablecustomers');

//function for delete clients
$(document).on('click', '.customer-delete',  function(){
    Swal.fire({
        title: alertCustomer,
        text: questiondelete,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
      }).then((result) => {
        if (result.isConfirmed) {
            let rsID =$(this).attr('customer-id'); 
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax(
            {
                url: "Customers/"+rsID,
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
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('#datatablecustomers tbody').on('dblclick', 'tr', function() {
        var table = $('#datatablecustomers').DataTable();
        var data = table.row(this).data();
        openModalCustomer(data.id);
    });
    $(document).on('click', '.customer-modal',  function(){
        let rsID =$(this).attr('customer-id'); 
        openModalCustomer(rsID);    
    });


});

//this function no permit closes de modal when save recivied

//validate form
function validateCustomerForm()
{
$.validator.setDefaults( {
    submitHandler: function () {
      
        $('#idmodaleditCustomer').modal('hide');
        $('#idmodaleditCustomer').on('hidden.bs.modal', function() {
            table.DataTable().ajax.reload(); 
        });
    }
} );
    $( "#formCustomers" ).validate( {
        rules: {
            first_name: {
                required: true,
            }
        },
        messages: {
            
            first_name: {
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

//Add the email
$(document).on('click', '.customer-email-add',  function(){

    destino = document.getElementById("tablecustomersemaildetails");
    num = destino.childNodes.length;
    tr = document.createElement('tr');
    
    text = document.createElement('input');
    text.type='text';
    text.setAttribute('class','form-control');
    text.setAttribute('placeholder',"The customers's email");
    text.name = 'txtCantidad[]';
    text.id = 'txtCantidad'+num;
    td = document.createElement('td');
    td.appendChild(text);
    tr.appendChild(td);
    
    text = document.createElement('a');
    text.href='javascript:void(0)';
    text.setAttribute('class','btn btn-danger');    
    text.setAttribute('onclick','deleteRow(this)');
    i = document.createElement('i');
    i.setAttribute('class','las la-trash size-25');
    td = document.createElement('td');
    td.setAttribute('style','float: right;')
    text.appendChild(i);
    td.appendChild(text);		
    tr.appendChild(td);
    
    destino.appendChild(tr);
});

//Add the contact
$(document).on('click', '.customer-contact-add',  function(){

    destino = document.getElementById("tablecustomerscontactdetails");
    num = destino.childNodes.length;
    tr = document.createElement('tr');
    
    text = document.createElement('input');
    text.type='text';
    text.setAttribute('class','form-control');
    text.setAttribute('placeholder',"The customers's contact");
    text.name = 'txtCantidad[]';
    text.id = 'txtCantidad'+num;
    td = document.createElement('td');
    td.appendChild(text);
    tr.appendChild(td);
    
    text = document.createElement('a');
    text.href='javascript:void(0)';
    text.setAttribute('class','btn btn-danger');   
    text.setAttribute('onclick','deleteRow(this)');
    i = document.createElement('i');
    i.setAttribute('class','las la-trash size-25');
    td = document.createElement('td');
    td.setAttribute('style','float: right;')
    text.appendChild(i);
    td.appendChild(text);		
    tr.appendChild(td);
    
    destino.appendChild(tr);
});

function deleteRow(obj)
{
    obj.parentNode.parentNode.parentNode.removeChild(obj.parentNode.parentNode);   
}