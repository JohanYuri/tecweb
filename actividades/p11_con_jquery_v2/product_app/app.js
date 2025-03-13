$(document).ready(function(){
    let edit = false;
    let validInputs = false;
    let validName = false;
    $('.btn-primary').attr('disabled', true);
    $('#product-result').hide();
    $('#product-result2').hide();
    listarProductos();

    // Definir las marcas permitidas
    const marcasPermitidas = ["Puma", "Nike", "Under Armour", "Jordan", "Adidas"];

    function validarFormulario() {
        if (validInputs && validName) {
            $('.btn-primary').attr('disabled', false);
        } else {
            $('.btn-primary').attr('disabled', true);
        }
    }

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

    $(document).on('click', '.form-control', (e) => {
        let valid = true;
        let errorTemplate = '';
    
        if ($('#name').val().trim() == ''){
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
        if ($('#marca').val() == null || !marcasPermitidas.includes($('#marca').val())) {
            valid = false;
            errorTemplate += '<li>Marca del producto es requerida y debe ser una de las siguientes: Puma, Nike, Under Armour, Jordan, Adidas</li>';
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
        
        if(valid == false){
            $('#product-result2').show();
            $('#container').html(errorTemplate);
        }
        else{
            $('#product-result2').hide();
            $('#container').html('');
        }

        validInputs = valid;
        validarFormulario();
    });

    $('#name').keyup(function() {
        let errorTemplate = '';
        let name = $('#name').val().trim();

        $.post('./backend/product-get-by-name.php', {name: name}, (response) => {
            if (response === "true" || response === true) {
                validName = false;
                errorTemplate += '<li>El nombre del producto ya existe</li>';
                $('#product-result').show();
                $('#containerNombre').html(errorTemplate);
            } else {
                validName = true;
                $('#product-result').hide();
                $('#containerNombre').html('');
            }
            validarFormulario();
        });
    });

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search='+$('#search').val(),
                data: {search},
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        const productos = JSON.parse(response);
                        if(Object.keys(productos).length > 0) {
                            let template = '';
                            let template_bar = '';

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
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            $('#product-result').show();
                            $('#container').html(template_bar);
                            $('#products').html(template);    
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();

        let postData = {};
        postData['nombre'] = $('#name').val();
        postData['id'] = $('#productId').val();
        postData['precio'] = $('#precio').val();
        postData['unidades'] = $('#unidades').val();
        postData['modelo'] = $('#modelo').val();
        postData['marca'] = $('#marca').val();
        postData['detalles'] = $('#detalles').val();
        postData['imagen'] = $('#imagen').val();

        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
        
        $.post(url, postData, (response) => {
            let respuesta = JSON.parse(response);
            let template_bar = '';
            template_bar += `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            
            $('#name').val('');
            $('#precio').val('');
            $('#unidades').val('');
            $('#modelo').val('');
            $('#marca').val('');
            $('#detalles').val('');
            $('#imagen').val('img/default.jpg');
            $('#productId').val('');
            $('#product-result2').show();
            $('#container').html(template_bar);
            listarProductos();
            edit = false;
        });
        $('button.btn-primary').text('Agregar Producto');
    });

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', {id}, (response) => {
                $('#product-result').hide();
                $('#product-result2').hide();
                listarProductos();
            });
        }
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
            validName = true;
        });
        validarFormulario();
        $('button.btn-primary').text('Modificar Producto');
        e.preventDefault();
    });    
});