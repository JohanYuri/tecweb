// App Modificar Producto

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
                        let descripcion = `
                            <li>precio: ${producto.precio}</li>
                            <li>unidades: ${producto.unidades}</li>
                            <li>modelo: ${producto.modelo}</li>
                            <li>marca: ${producto.marca}</li>
                            <li>detalles: ${producto.detalles}</li>
                        `;
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

    // Validar campos al perder el foco
    function validarCampo(campo) {
        if ($(campo).val().trim() === "") {
            $(campo).addClass("is-invalid");
            return false;
        } else {
            $(campo).removeClass("is-invalid");
            return true;
        }
    }

    $('#name, #precio, #unidades, #modelo, #marca, #detalles, #imagen').blur(function() {
        validarCampo(this);
    });

    $('#product-form').submit(e => {
        e.preventDefault();

        let valid = true;
        $('#name, #precio, #unidades, #modelo, #marca, #detalles, #imagen').each(function() {
            if (!validarCampo(this)) valid = false;
        });

        if (!valid) {
            alert("Por favor, completa todos los campos antes de agregar el producto.");
            return;
        }

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

        const url = edit ? './backend/product-edit.php' : './backend/product-add.php';

        $.post(url, postData, (response) => {
            let respuesta = JSON.parse(response);
            let template_bar = `
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
});
