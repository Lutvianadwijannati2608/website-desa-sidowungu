<?php
require_once __DIR__ . '/../../config/database.php';

// Ambil ID lapak dari URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}


// Ambil data lapak
$query_lapak = mysqli_query(
    $conn,
    "SELECT *
     FROM lapak
     WHERE id = $id
     LIMIT 1"
);

if (!$query_lapak || mysqli_num_rows($query_lapak) === 0) {
    header('Location: index.php');
    exit;
}

$lapak = mysqli_fetch_assoc($query_lapak);


// Lokasi folder foto
$folder_foto = dirname(__DIR__, 2) . '/assets/images/lapak/';


// Ambil semua foto milik lapak
$query_foto = mysqli_query(
    $conn,
    "SELECT nama_file
     FROM lapak_foto
     WHERE lapak_id = $id"
);


// Hapus semua file foto dari folder
if ($query_foto) {

    while ($foto = mysqli_fetch_assoc($query_foto)) {

        $file_foto = $folder_foto . $foto['nama_file'];

        if (file_exists($file_foto)) {
            unlink($file_foto);
        }
    }
}


// Hapus data lapak
// Karena lapak_foto memakai ON DELETE CASCADE,
// data foto di database ikut terhapus.
$hapus = mysqli_query(
    $conn,
    "DELETE FROM lapak
     WHERE id = $id"
);


// Kembali ke daftar
if ($hapus) {

    header('Location: index.php?status=hapus-berhasil');
    exit;

} else {

    header('Location: index.php?status=hapus-gagal');
    exit;
}