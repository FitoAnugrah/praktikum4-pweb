<?php
class Mahasiswa {
    private $conn;
    private $table_name = "mahasiswa";

    public $id;
    public $nama;
    public $npm;
    public $jurusan;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (npm, nama, jurusan) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->npm, $this->nama, $this->jurusan])) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET npm = ?, nama = ?, jurusan = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->npm, $this->nama, $this->jurusan, $this->id])) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->id])) {
            return true;
        }
        return false;
    }
    // 5. EKSPLORASI: Mencari data mahasiswa berdasarkan keyword
    public function search($keyword) {
        // Query menggunakan operator LIKE untuk pencarian sebagian kata
        $query = "SELECT * FROM " . $this->table_name . " WHERE nama LIKE ? OR npm LIKE ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        
        // Menambahkan wildcard % di awal dan akhir keyword
        $keyword = "%{$keyword}%";
        
        // Eksekusi dengan binding parameter
        $stmt->execute([$keyword, $keyword]);
        return $stmt;
    }
}
?>