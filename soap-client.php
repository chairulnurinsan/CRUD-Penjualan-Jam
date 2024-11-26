<?php
$client = new SoapClient(null, [
    'location' => 'http://localhost/soap-server.php',
    'uri' => 'http://localhost/soap-server.php',
    'trace' => 1
]);

$action = $_GET['action'];

try {
    switch ($action) {
        case 'createWatch':
            $brand = $_POST['brand'];
            $model = $_POST['model'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $response = $client->createWatch($brand, $model, $price, $stock);
            echo $response;
            break;

        case 'getWatches':
            $watches = $client->getWatches();
            echo json_encode($watches);
            break;

        case 'getWatchById':
            $id = $_POST['id'];
            $watch = $client->getWatchById($id);
            echo json_encode($watch);
            break;

        case 'updateWatch':
            $id = $_POST['id'];
            $brand = $_POST['brand'];
            $model = $_POST['model'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $response = $client->updateWatch($id, $brand, $model, $price, $stock);
            echo $response;
            break;

        case 'deleteWatch':
            $id = $_POST['id'];
            $response = $client->deleteWatch($id);
            echo $response;
            break;
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
