$(document).ready(function () {
    let edit = false;

    $('#product-result').hide();
    listarProductos();

    // Función para listar productos
    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function (response) {
                const productos = JSON.parse(response);
                if (Object.keys(productos).length > 0) {
                    let template = '';
                    productos.forEach(producto => {
                        let descripcion = '';
                        descripcion += '<li>precio: ' + producto.precio + '</li>';
                        descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                        descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                        descripcion += '<li>marca: ' + producto.marca + '</li>';
                        descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto(${producto.id})">
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

    // Función para validar campos
    function validarCampos() {
        let valido = true;

        // Validar nombre
        if ($('#name').val().trim() === '') {
            $('#name').addClass('is-invalid');
            valido = false;
        } else {
            $('#name').removeClass('is-invalid');
        }

        // Validar precio
        if ($('#precio').val().trim() === '' || parseFloat($('#precio').val()) <= 0) {
            $('#precio').addClass('is-invalid');
            valido = false;
        } else {
            $('#precio').removeClass('is-invalid');
        }

        // Validar unidades
        if ($('#unidades').val().trim() === '' || parseInt($('#unidades').val()) < 1) {
            $('#unidades').addClass('is-invalid');
            valido = false;
        } else {
            $('#unidades').removeClass('is-invalid');
        }

        // Validar marca
        if ($('#marca').val() === null || $('#marca').val() === '') {
            $('#marca').addClass('is-invalid');
            valido = false;
        } else {
            $('#marca').removeClass('is-invalid');
        }

        $('button.btn-primary').prop('disabled', !valido);
    }

    // Validar campos al perder el foco
    $('#product-form input').blur(validarCampos);
    $('#marca').blur(validarCampos);

    // Validar nombre único
    $('#name').on('input', function () {
        let nombre = $(this).val().trim();
        if (nombre.length > 0) {
            $.post('./backend/validate-name.php', { nombre }, function (response) {
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

    // Enviar formulario
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

    // Editar producto
    $(document).on('click', '.product-item', (e) => {
        const element = $(e.target).closest('tr');
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', { id }, (response) => {
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

    // Eliminar producto
    window.eliminarProducto = function (id) {
        if (confirm('¿Estás seguro de eliminar este producto?')) {
            $.post('./backend/product-delete.php', { id }, (response) => {
                let respuesta = JSON.parse(response);
                let template_bar = '';
                template_bar += `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $('#product-result').show();
                $('#container').html(template_bar);
                listarProductos();
            });
        }
    };
});