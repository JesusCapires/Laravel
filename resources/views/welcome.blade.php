<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <title>Document</title>
        <style>
            label.error {
                color: red;
            }
        </style>
    </head>
    <body>
        <h1>Registro de clientes</h1>
          <!-- Botón que activa el modal -->
          <a href=""></a>
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
                        <td> {{$cliente->name}} </td>
                        <td> {{$cliente->last_name}}</td>
                        <td> {{$cliente->email}}</td>
                        <td>
                            {{-- onclick="actualizarRegistro(${cliente->id})" --}}
                            <button class="btn btn-primary btn-sm" onclick="addContent({{$cliente->id}})">
                                {{-- {{$cliente->id}} --}}
                                ActualizarCambio
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>



        <!-- El modal -->
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="miModalLabel">Título del modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="contenido-dinamico" class="contenido-inicial">
                            ...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
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
                <label>Fecha Registro:</label>
                <input type="date" name="fecha_registro" class="form-control" id="fecha_registro>
                </div>
            </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="validateForm()">Registrar Cliente</button>
            </div>
            </form>`;


        const addContent = (id) => {
            console.log(id);
            $('#contenido-dinamico').removeClass('contenido-inicial').addClass('contenido-agregado').html(contenidoAgregado);
            if(id != 0){
                seeCustomer(id).then(respuesta => {
                    const data = JSON.parse(response);
                    $('#formCustomersEC').fromJSON(data);
                });
            }
        };

        const seeCustomer = async(id) => {
            let response = await $.ajax({
            url: "/actualizaClientes",
            type: 'GET',
            data: {id}
            });
        }

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

        const generaTabla = () => {
            $('#tableCustomers').DataTable({
                "language": idiomaSpanish,
                "pageLength":10
                // "lengthMenu":[10,15,25]
            });
        }

        $(document).ready(function (){
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
                    let _token = '{{csrf_token()}}';
                    let data =  $(form).serialize();
                    let daniel = 0;
                    console.log(data);

                    $.ajax({
                        url: "{{ route('creaClientes')}}",
                        type: 'POST',
                        data:  $(form).serialize(),
                        dataType: "json",
                        success: function(response) {
                            let {error, id_last, lastName, name} = response;
                            if(error){
                                console.log("Error true");
                            }else{
                            console.log(response);
                            console.log(id_last);
                            $('#tableCustomers').DataTable().destroy();
                                $('#registerCustomers').append(`
                                    <tr>
                                        <td>${name}</td>
                                        <td>${lastName}</td>
                                        <td>GMAIL</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" onclick="createOrUpdate(${id_last})">
                                                Actualizar
                                            </button>
                                        </td>
                                    </tr>
                                `);generaTabla();
                            }
                        }
                    });
                }
            });
        }
    </script>
</html>
