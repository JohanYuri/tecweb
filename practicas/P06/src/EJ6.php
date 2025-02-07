<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .vehicle-info, .error-message {
            background-color: #e7e7e7;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: block;
            margin: 0 auto;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Consulta de Vehículos</h1>

    <?php
    $parque_vehicular = [
        "TSJ3099" => [
            "Auto" => [
                "marca" => "VW",
                "modelo" => "2021",
                "tipo" => "Hatchback"
            ],
            "Propietario" => [
                "nombre" => "Ulises Torres",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "C.U., Jardines de San Manuel"
            ]
        ],
        "UBN6338" => [
            "Auto" => [
                "marca" => "HONDA",
                "modelo" => "2020",
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Alfonzo Esparza",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "C.U., Jardines de San Manuel"
            ]
        ],
        "UBN6339" => [
            "Auto" => [
                "marca" => "MAZDA",
                "modelo" => "2019",
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Ma. del Consuelo Molina",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "97 oriente"
            ]
        ],
        "XCD7483" => [
            "Auto" => [
                "marca" => "TOYOTA",
                "modelo" => "2021",
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Juan Pérez",
                "ciudad" => "Cholula, Pue.",
                "direccion" => "Calle 5 de Febrero, No. 100"
            ]
        ],
        "LKH2564" => [
            "Auto" => [
                "marca" => "NISSAN",
                "modelo" => "2018",
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "María García",
                "ciudad" => "Atlixco, Pue.",
                "direccion" => "Avenida Hidalgo 45"
            ]
        ],
        "RUI9876" => [
            "Auto" => [
                "marca" => "FORD",
                "modelo" => "2020",
                "tipo" => "hatchback"
            ],
            "Propietario" => [
                "nombre" => "Carlos Ruiz",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Avenida 16 de Septiembre"
            ]
        ],
        "FGT3322" => [
            "Auto" => [
                "marca" => "CHEVROLET",
                "modelo" => "2022",
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Ana López",
                "ciudad" => "Tehuacán, Pue.",
                "direccion" => "Calle Reforma 56"
            ]
        ],
        "JGH4453" => [
            "Auto" => [
                "marca" => "HONDA",
                "modelo" => "2020",
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Luis Martínez",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Calle 12 Poniente"
            ]
        ],
        "KHL1928" => [
            "Auto" => [
                "marca" => "FORD",
                "modelo" => "2021",
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Rosa Sánchez",
                "ciudad" => "Amozoc, Pue.",
                "direccion" => "Carretera federal 14"
            ]
        ],
        "NJK3829" => [
            "Auto" => [
                "marca" => "TOYOTA",
                "modelo" => "2023",
                "tipo" => "hatchback"
            ],
            "Propietario" => [
                "nombre" => "Juan Hernández",
                "ciudad" => "San Martín Texmelucan, Pue.",
                "direccion" => "Centro, Calle 4"
            ]
        ],
        "VNB2407" => [
            "Auto" => [
                "marca" => "BMW",
                "modelo" => "2022",
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Pedro González",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Boulevard Atlixco"
            ]
        ],
        "PFG3485" => [
            "Auto" => [
                "marca" => "AUDI",
                "modelo" => "2021",
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Karina Díaz",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "Callejón del Reloj"
            ]
        ],
        "MKI1098" => [
            "Auto" => [
                "marca" => "MERCEDES-BENZ",
                "modelo" => "2020",
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "José Ramírez",
                "ciudad" => "Huejotzingo, Pue.",
                "direccion" => "Callejón 2 Norte"
            ]
        ],
        "YFB5220" => [
            "Auto" => [
                "marca" => "KIA",
                "modelo" => "2019",
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Felipe Torres",
                "ciudad" => "Chignahuapan, Pue.",
                "direccion" => "Colonia Centro"
            ]
        ],
        "ZQJ8765" => [
            "Auto" => [
                "marca" => "RENAULT",
                "modelo" => "2021",
                "tipo" => "hatchback"
            ],
            "Propietario" => [
                "nombre" => "Sandra Álvarez",
                "ciudad" => "Atlixco, Pue.",
                "direccion" => "Avenida Las Palmas"
            ]
        ]
    ];

    if (isset($_POST["ver_vehiculos"]) && $_POST["ver_vehiculos"] == "1") {
        echo "<div class='vehicle-info'>";
        echo "<pre>";
        print_r($parque_vehicular);
        echo "</pre>";
        echo "</div>";
    } else {
        if (isset($_POST["matricula"]) && $_POST["matricula"] !== "") {
            $matricula = $_POST["matricula"];
            if (isset($parque_vehicular[$matricula])) {
                echo "<div class='vehicle-info'>";
                echo "<pre>";
                print_r($parque_vehicular[$matricula]);
                echo "</pre>";
                echo "</div>";
            } else {
                echo "<div class='error-message'>ERROR: La matrícula no existe.</div>";
            }
        } else {
            echo "<div class='error-message'>ERROR: Ingrese una matrícula válida o elija ver todos los vehículos.</div>";
        }
    }
    ?>

    
</div>

</body>
</html>
