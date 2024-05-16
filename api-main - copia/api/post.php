<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../config/Database.php';
    include_once '../models/Product.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $database = new Database();
      $db = $database->connect();

      $product = new Product($db);

      $data = json_decode(file_get_contents("php://input"));

      // Asigna los valores de la solicitud JSON a las propiedades del producto
      $product->nombre = $data->nombre;
      $product->descripcion = $data->descripcion;
      $product->precio = $data->precio;
      $product->stock = $data->stock;
      $product->categoria = $data->categoria; 

      // Intenta agregar el producto a la base de datos
      if($product->postData()) {
        echo json_encode(array('message' => 'Product added'));
      } else {
        echo json_encode(array('message' => 'Product Not added, try again!'));
      }
    } else {
        echo json_encode(array('message' => "Error: incorrect Method!"));
    }
?>
