// Configuración inicial
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

let editMode = false;
let currentEditId = null;

// Función para inicializar la aplicación
function init() {
    try {
        document.getElementById("description").value = JSON.stringify(baseJSON, null, 2);
        listarProductos();
    } catch (error) {
        console.error("Error en init:", error);
        showError("Error al inicializar la aplicación");
    }
}

// Función para mostrar errores
function showError(message) {
    $('#container').html(`<div class="alert alert-danger">${message}</div>`);
    $('#product-result').show();
    setTimeout(() => $('#product-result').hide(), 5000);
}

// Función para mostrar éxito
function showSuccess(message) {
    $('#container').html(`<div class="alert alert-success">${message}</div>`);
    $('#product-result').show();
    setTimeout(() => $('#product-result').hide(), 3000);
}

// Función principal para listar productos
function listarProductos() {
    console.log("Iniciando carga de productos...");
    
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        dataType: 'json',
        contentType: 'application/json',
        cache: false,
        beforeSend: function() {
            $('#products').html('<tr><td colspan="5" class="text-center">Cargando productos...</td></tr>');
        },
        success: function(response) {
            console.log("Respuesta recibida:", response);
            
            if (!response) {
                throw new Error("Respuesta vacía del servidor");
            }

            if (response.status === 'error') {
                throw new Error(response.message || "Error del servidor");
            }

            if (!response.data || !Array.isArray(response.data)) {
                throw new Error("Formato de datos inválido");
            }

            renderProductList(response.data);
        },
        error: function(xhr, status, error) {
            console.error("Error en la petición:", status, error);
            console.error("Respuesta completa:", xhr.responseText);
            
            let errorMessage = "Error al cargar productos";
            try {
                const errorResponse = JSON.parse(xhr.responseText);
                errorMessage = errorResponse.message || errorMessage;
            } catch (e) {
                errorMessage += ` - ${xhr.responseText.substring(0, 100)}`;
            }
            
            showError(errorMessage);
            $('#products').html(`<tr><td colspan="5" class="text-center text-danger">${errorMessage}</td></tr>`);
        }
    });
}

// Función para renderizar la lista de productos
function renderProductList(products) {
    try {
        let template = '';
        
        products.forEach(product => {
            template += `
            <tr productId="${product.id}">
                <td>${product.id}</td>
                <td>${product.nombre}</td>
                <td>$${product.precio?.toFixed(2) || '0.00'}</td>
                <td>${product.unidades || 0}</td>
                <td>
                    <button class="btn btn-primary btn-sm product-edit mr-2">Editar</button>
                    <button class="btn btn-danger btn-sm product-delete">Eliminar</button>
                </td>
            </tr>`;
        });

        $('#products').html(template || '<tr><td colspan="5" class="text-center">No hay productos registrados</td></tr>');
    } catch (error) {
        console.error("Error renderizando productos:", error);
        showError("Error al mostrar los productos");
    }
}

// Función para manejar búsqueda
function handleSearch() {
    const searchTerm = $('#search').val().trim();
    
    if (!searchTerm) {
        listarProductos();
        return;
    }

    $.ajax({
        url: './backend/product-search.php',
        type: 'POST',
        data: { search: searchTerm },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success' && response.data) {
                renderProductList(response.data);
            } else {
                showError(response.message || "No se encontraron resultados");
            }
        },
        error: function(xhr) {
            console.error("Error en búsqueda:", xhr.responseText);
            showError("Error al realizar la búsqueda");
        }
    });
}

// Función para resetear formulario
function resetForm() {
    editMode = false;
    currentEditId = null;
    $('#product-form')[0].reset();
    $('#description').val(JSON.stringify(baseJSON, null, 2));
    $('button[type="submit"]').text('Agregar Producto');
}

// Inicialización cuando el DOM está listo
$(document).ready(function() {
    console.log("Documento listo - Inicializando aplicación...");
    
    // Configuración global de AJAX
    $.ajaxSetup({
        accepts: 'application/json',
        contentType: 'application/json',
        cache: false
    });

    // Inicializar aplicación
    init();

    // Evento de búsqueda
    $('#search').keyup(debounce(handleSearch, 300));

    // Evento para eliminar producto
    $(document).on('click', '.product-delete', function() {
        if (!confirm('¿Estás seguro de eliminar este producto?')) return;
        
        const productId = $(this).closest('tr').attr('productId');
        
        $.ajax({
            url: './backend/product-delete.php',
            type: 'GET',
            data: { id: productId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showSuccess('Producto eliminado correctamente');
                    listarProductos();
                } else {
                    showError(response.message || 'Error al eliminar el producto');
                }
            },
            error: function(xhr) {
                showError("Error al eliminar el producto");
                console.error("Error eliminando:", xhr.responseText);
            }
        });
    });

    // Evento para editar producto
    $(document).on('click', '.product-edit', function(e) {
        e.preventDefault();
        const productId = $(this).closest('tr').attr('productId');
        
        $.ajax({
            url: './backend/product-get.php',
            type: 'GET',
            data: { id: productId },
            dataType: 'json',
            success: function(response) {
                if (response && response.id) {
                    editMode = true;
                    currentEditId = response.id;
                    
                    // Preparar datos para el formulario
                    const productData = {
                        ...baseJSON,
                        precio: parseFloat(response.precio) || 0,
                        unidades: parseInt(response.unidades) || 0,
                        modelo: response.modelo || '',
                        marca: response.marca || '',
                        detalles: response.detalles || '',
                        imagen: response.imagen || 'img/default.png'
                    };
                    
                    // Llenar formulario
                    $('#name').val(response.nombre || '');
                    $('#description').val(JSON.stringify(productData, null, 2));
                    $('button[type="submit"]').text('Actualizar Producto');
                    
                    showSuccess('Modo edición activado');
                } else {
                    showError('No se pudo cargar el producto para editar');
                }
            },
            error: function(xhr) {
                showError("Error al cargar el producto");
                console.error("Error cargando producto:", xhr.responseText);
            }
        });
    });

    // Evento para enviar formulario
    $('#product-form').submit(function(e) {
        e.preventDefault();
        
        // Validaciones básicas
        const productName = $('#name').val().trim();
        if (!productName) {
            showError('El nombre del producto es requerido');
            return;
        }
        
        let productData;
        try {
            productData = JSON.parse($('#description').val());
        } catch (error) {
            showError('El formato de los datos del producto es inválido');
            return;
        }
        
        // Validar campos numéricos
        if (isNaN(productData.precio)) {
            showError('El precio debe ser un número válido');
            return;
        }
        
        if (isNaN(productData.unidades) || productData.unidades < 0) {
            showError('Las unidades deben ser un número positivo');
            return;
        }
        
        // Preparar datos finales
        const postData = {
            ...productData,
            nombre: productName
        };
        
        if (editMode) {
            postData.id = currentEditId;
        }
        
        // Determinar URL y método
        const url = editMode ? './backend/product-edit.php' : './backend/product-add.php';
        
        // Enviar datos
        $.ajax({
            url: url,
            type: 'POST',
            data: JSON.stringify(postData),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showSuccess(response.message || (editMode ? 'Producto actualizado' : 'Producto agregado'));
                    resetForm();
                    listarProductos();
                } else {
                    showError(response.message || 'Error al procesar el producto');
                }
            },
            error: function(xhr) {
                showError('Error al comunicarse con el servidor');
                console.error("Error enviando formulario:", xhr.responseText);
            }
        });
    });

    // Función debounce para mejorar performance en búsquedas
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
});