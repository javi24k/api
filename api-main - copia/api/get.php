<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../config/Database.php';
    include_once '../models/Producto.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $database = new Database();
        $db = $database->connect();

        $product = new Product($db);

        // No necesitamos decodificar el contenido de la solicitud GET
        // En su lugar, podemos obtener los parámetros directamente de $_GET
        if(isset($_GET['id'])) {
            $product->id = $_GET['id'];

            if($product->fetchOne()) {
                echo json_encode(array(
                    'id' => $product->id,
                    'nombre' => $product->nombre,
                    'descripcion' => $product->descripcion,
                    'precio' => $product->precio,
                    'stock' => $product->stock,
                    'categoria' => $product->categoria
                ));
            } else {
                echo json_encode(array('message' => "No records found!"));
            }

        } else {
            echo json_encode(array('message' => "Error: Product ID is missing!"));
        }
    } else {
        echo json_encode(array('message' => "Error: incorrect Method!"));
    }
?>
