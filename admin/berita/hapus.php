<?php
session_start();

if (
    !isset($_SESSION['admin_login']) ||
    $_SESSION['admin_login'] !== true
) {
    header("Location: ../login.php");
    exit;
}

require_once "../../config/database.php";


$id =
    isset($_GET['id'])
        ? (int) $_GET['id']
        : 0;


if ($id <= 0) {

    header(
        "Location: index.php?error=hapus"
    );

    exit;
}


// =====================================================
// CEK DATA
// =====================================================

$check =
    $conn->prepare(
        "SELECT id
         FROM berita
         WHERE id = ?"
    );


$check->bind_param(
    "i",
    $id
);


$check->execute();


$result =
    $check->get_result();


if (
    $result->num_rows === 0
) {

    header(
        "Location: index.php?error=hapus"
    );

    exit;
}


// =====================================================
// HAPUS
// =====================================================

$delete =
    $conn->prepare(
        "DELETE FROM berita
         WHERE id = ?"
    );


$delete->bind_param(
    "i",
    $id
);


if ($delete->execute()) {

    header(
        "Location: index.php?success=hapus"
    );

    exit;

}


header(
    "Location: index.php?error=hapus"
);

exit;