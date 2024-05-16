<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');

    include_once '../config/Database.php';
    include_once '../models/Product.php';

    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

        $database = new Database();
        $db = $database->connect();

        $product = new Product($db);

        $data = json_decode(file_get_contents("php://input"));

        // Asigna los valores de la solicitud JSON a las propiedades del producto
        $product->id = isset($data->id) ? $data->id : NULL;
        $product->nombre = $data->nombre;
        $product->descripcion = $data->descripcion;
        $product->precio = $data->precio;
        $product->stock = $data->stock;
        $product->categoria = $data->categoria; // Agrega la categoría

        // Verifica si el ID del producto no es nulo
        if (!is_null($product->id)) {

            // Intenta actualizar el producto en la base de datos
            if ($product->putData()) {
                echo json_encode(array('message' => 'Producto actualizado'));
            } else {
                echo json_encode(array('message' => 'Producto no actualizado, intente de nuevo!'));
            }
        } else {
            echo json_encode(array('message' => "Error: Product ID is missing!"));
        }
    } else {
        echo json_encode(array('message' => "Error: incorrect Method!"));
    }
?>
