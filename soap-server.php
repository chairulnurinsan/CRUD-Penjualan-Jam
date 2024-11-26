<?php
class WatchService {
    private $db;

    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'penjualan_jam_tangan');
        if ($this->db->connect_error) {
            die('Koneksi gagal: ' . $this->db->connect_error);
        }
    }

    public function createWatch($brand, $model, $price, $stock) {
        $stmt = $this->db->prepare("INSERT INTO watches (brand, model, price, stock) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $brand, $model, $price, $stock);
        if ($stmt->execute()) {
            return "Success";
        } else {
            return "Error: " . $stmt->error;
        }
    }

    public function getWatches() {
        $result = $this->db->query("SELECT * FROM watches");
        $watches = [];
        while ($row = $result->fetch_assoc()) {
            $watches[] = $row;
        }
        return $watches;
    }

    public function getWatchById($id) {
        $stmt = $this->db->prepare("SELECT * FROM watches WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateWatch($id, $brand, $model, $price, $stock) {
        $stmt = $this->db->prepare("UPDATE watches SET brand = ?, model = ?, price = ?, stock = ? WHERE id = ?");
        $stmt->bind_param("ssdii", $brand, $model, $price, $stock, $id);
        if ($stmt->execute()) {
            return "Success";
        } else {
            return "Error: " . $stmt->error;
        }
    }

    public function deleteWatch($id) {
        $stmt = $this->db->prepare("DELETE FROM watches WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Success";
        } else {
            return "Error: " . $stmt->error;
        }
    }
}

$options = ['uri' => 'http://localhost/soap-server.php'];
$server = new SoapServer(null, $options);
$server->setClass('WatchService');
$server->handle();
?>
