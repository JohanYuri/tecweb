// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

$(document).ready(function(){
    let edit = false;

    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                const productos = JSON.parse(response);
                if(Object.keys(productos).length > 0) {
                    let template = '';
                    productos.forEach(producto => {
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#products').html(template);
                }
            }
        });
    }

    function validarCampos() {
        let valido = true;
        $('.form-control').each(function() {
            if ($(this).val().trim() === '') {
                $(this).addClass('is-invalid');
                valido = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        $('button.btn-primary').prop('disabled', !valido);
    }

    $('#product-form input').blur(validarCampos);

    $('#name').on('input', function() {
        let nombre = $(this).val().trim();
        if (nombre.length > 0) {
            $.post('./backend/validate-name.php', {nombre}, function(response) {
                if (response === 'exists') {
                    $('#name').addClass('is-invalid');
                    $('#name-status').text('El nombre ya existe en la base de datos.');
                    $('button.btn-primary').prop('disabled', true);
                } else {
                    $('#name').removeClass('is-invalid');
                    $('#name-status').text('');
                    validarCampos();
                }
            });
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();
        let postData = {
            nombre: $('#name').val(),
            id: $('#productId').val(),
            precio: parseFloat($('#precio').val()),
            unidades: parseInt($('#unidades').val()),
            modelo: $('#modelo').val(),
            marca: $('#marca').val(),
            detalles: $('#detalles').val(),
            imagen: $('#imagen').val()
        };
        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
        
        $.post(url, postData, (response) => {
            let respuesta = JSON.parse(response);
            let template_bar = '';
            template_bar += `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            $('#product-form')[0].reset();
            $('#product-result').show();
            $('#container').html(template_bar);
            listarProductos();
            edit = false;
            $('button.btn-primary').text("Agregar Producto");
        });
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', {id}, (response) => {
            let product = JSON.parse(response);
            $('#name').val(product.nombre);
            $('#productId').val(product.id);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#modelo').val(product.modelo);
            $('#marca').val(product.marca);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);
            edit = true;
            $('button.btn-primary').text("Modificar Producto");
        });
        e.preventDefault();
    });

    $(document).on('click', '.form-control', (c) => {
        let valid = true; // Suponemos que es válido hasta encontrar un campo vacío o error
        let errorTemplate = '';

        if ($('#name').val().trim() == '') {
            valid = false;
            errorTemplate += '<li>Nombre del producto es requerido</li>';
        }

        if ($('#precio').val().trim() == '') {
            valid = false;
            errorTemplate += '<li>Precio del producto es requerido</li>';
        } else if (parseFloat($('#precio').val().trim()) <= 99) {
            valid = false;
            errorTemplate += '<li>El precio del producto debe ser mayor a 99</li>';
        }

        if ($('#unidades').val().trim() == '') {
            valid = false;
            errorTemplate += '<li>Unidades del producto son requeridas</li>';
        } else if (parseInt($('#unidades').val().trim()) < 1) {
            valid = false;
            errorTemplate += '<li>Las unidades del producto deben ser mayor o igual a uno</li>';
        }

        if ($('#modelo').val().trim() == '') {
            valid = false;
            errorTemplate += '<li>Modelo del producto es requerido</li>';
        }

        if ($('#marca').val() == null) {
            valid = false;
            errorTemplate += '<li>Marca del producto es requerida</li>';
        }

        if ($('#detalles').val().trim() == '') {
            valid = false;
            errorTemplate += '<li>Detalles del producto son requeridos</li>';
        }

        if ($('#imagen').val().trim() == '') {
            valid = false;
            errorTemplate += '<li>Imagen del producto es requerida</li>';
        } else if (!$('#imagen').val().trim().startsWith('img/')) {
            valid = false;
            errorTemplate += '<li>La ruta de la imagen debe iniciar con "img/"</li>';
        }

        if (!valid) {
            $('#product-result').show();
            $('#container').html(errorTemplate);
            $('.btn-primary').attr('disabled', true);
        } else {
            $('#product-result').hide();
            $('#container').html('');
            $('.btn-primary').attr('disabled', false);
        }
    });
});