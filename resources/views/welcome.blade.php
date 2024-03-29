

@extends('layout')

@section('contenido')
    <div id="ruta-crea-clientes" data-route="{{ route('editaClientes') }}"></div>
    <div id="ruta-crea-clientes2" data-route="{{ route('creaClientes') }}"></div>
    <h1>Registro de clientes</h1>
    <button type="button" class="btn btn-primary ms-5 mt-5 mb-5" data-bs-toggle="modal" data-bs-target="#miModal" onclick="addContent()">
        Crear cliente
    </button>
    <table id="tableCustomers">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="registerCustomers">
            @foreach ($clientes as $cliente)
                <tr>
                    <td id="name{{$cliente->id}}"> {{$cliente->name}} </td>
                    <td id="last_name{{$cliente->id}}"> {{$cliente->last_name}}</td>
                    <td id="email{{$cliente->id}}"> {{$cliente->email}}</td>
                    <td id="">
                        {{-- onclick="actualizarRegistro(${cliente->id})" --}}
                        <button class="btn btn-primary btn-sm" onclick="addContent({{$cliente->id}})">
                            {{-- {{$cliente->id}} --}}
                            Actualizar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('librerias')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
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

    </script>


    <script>
        const idiomaSpanish = {
            "search":"Buscar:",
            "emptyTable":"No hay información",
            "info":"Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty":"Mostrando 0 a 0 de 0 Entradas",
            "infoFiltered":"(Filtrado de _MAX_ total entradas)",
            "lengthMenu":"Mostrar _MENU_ Entradas",
            "loadingRecords":"Cargando...",
            "procesing":"Procesando...",
            "zeroRecords":"Sin resultados encontrados",
            "paginate":{
                "first":"Primero",
                "last":"Siguiente",
                "next":"Siguiente",
                "previous":"Anterior"
            }
        }
    </script>
@endsection
