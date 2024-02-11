const createOrUpdate = (id) => {
    console.log(id);
}

const contenidoAgregado =
`<form action="#" id="formCustomersEC">
    @csrf

    <div class="row">

    <div class="col-md-4">
        <div class="mb-3">
        <label>Nombre:</label>
        <input type="text" name="id" class="form-control d-none" id="id">
        <input type="text" name="nombre" class="form-control" id="nombre">
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
        <label>Apellido:</label>
        <input type="text" name="apellido" class="form-control" id="apellido">
        </div>
    </div>

    <div class="col-md-4">
    <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" id="email">
        </div>
    </div>

    </div>

    <div class="row">

    <div class="col-md-4">
        <div class="mb-3">
        <label>Teléfono:</label>
        <input type="text" name="telefono" class="form-control" id="telefono">
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
        <label>Dirección:</label>
        <input type="text" name="direccion" class="form-control" id="direccion">
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
        <label>Ciudad:</label>
        <input type="text" name="ciudad" class="form-control" id="ciudad">
        </div>
    </div>

    </div>

    <div class="row">

    <div class="col-md-4">
        <div class="mb-3">
        <label>País:</label>
        <select name="pais" class="form-control" id="pais">
            <option value="MX">México</option>
            <option value="CO">Colombia</option>
            <option value="AR">Argentina</option>
        </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
        <label>Código Postal:</label>
        <input type="text" name="cp" class="form-control" id="cp">
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
        <label>fecha_registro Registro:</label>
        <input type="date" name="fecha_registro" class="form-control" id="fecha_registro">
        </div>
    </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" onclick="validateForm()">Registrar Cliente</button>
    </div>
</form>`;

const addContent = (id, accion) => {
    openModal(contenidoAgregado);
    $('#miModal').modal('show');
    if (id !== 0) {
        console.log(id);
        const data = seeCustomer(id);
        data.then((customer) => {
            if (customer) {
                console.log(customer);
                $('#id').val(customer.id);
                $('#nombre').val(customer.name);
                $('#apellido').val(customer.last_name);
                $('#email').val(customer.email);
                $('#telefono').val(customer.phone);
                $('#direccion').val(customer.direction);
                $('#ciudad').val(customer.city);
                $('#pais').val(customer.country);
                $('#cp').val(customer.zip_code);
                $('#fecha_registro').val(customer.date_register);

            } else {
            }
        }).catch((error) => {
            console.error('Error:', error);
        });
    }

};

const seeCustomer = async(id) => {
    const editaClientesUrl = "{{ route('editaClientes') }}";
    return await $.ajax({
    url: editaClientesUrl,
    type: 'GET',
    data: {id}
    });
}

const generaTabla = () => {
    $('#tableCustomers').DataTable({
        "language": idiomaSpanish,
        "pageLength":10
        // "lengthMenu":[10,15,25]
    });
}

$(document).ready(function (){
    console.log("Inicio")
    generaTabla();
})

const validateForm = () => {
    console.log("Entrando a validate form");
    $('#formCustomersEC').validate({
        rules: {
            nombre: {
                required: true
            },
            apellido: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            telefono: {
                required: true
            }
        },
        messages: {
            nombre: {
                required: "El nombre es obligatorio"
            },
            apellido: {
                required: "El apellido es obligatorio"
            },
            email: {
                required: "El email es obligatorio",
                email: "Ingrese un email válido"
            },
            telefono: {
                required: "El teléfono es obligatorio"
            }
        },
        submitHandler: function(form){
            console.log("Formulario listo para enviar");
            let id_customer = $('#id').val();
            $.ajax({
                url: "{{ route('creaClientes')}}",
                type: 'POST',
                data:  $(form).serialize(),
                dataType: "json",
                success: function(response) {
                    let {error, id_last, lastName, name} = response;
                    if(error){
                        console.log("Error true");
                    }
                    else{
                        if(id_customer){
                            console.log("Act");
                            $('#name'+id_customer).text($('#nombre').val());
                            $('#last_name'+id_customer).text($('#apellido').val());
                            $('#email'+id_customer).text($('#email').val());
                        }
                        else{
                            $('#tableCustomers').DataTable().destroy();
                                $('#registerCustomers').append(`
                                    <tr>
                                        <td id="name${id_last}">${name}</td>
                                        <td id="last_name${id_last}">${lastName}</td>
                                        <td id="email${id_last}">GMAIL</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" onclick="addContent(${id_last})">
                                                Actualizar
                                            </button>
                                        </td>
                                    </tr>
                            `);generaTabla();
                        }
                    }
                }
            });
        }
    });
}
