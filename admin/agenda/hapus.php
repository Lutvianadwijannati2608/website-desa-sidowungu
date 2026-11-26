<?php

session_start();

if (
    !isset($_SESSION['admin_login']) ||
    $_SESSION['admin_login'] !== true
) {
    header('Location: /admin/login.php');
    exit;
}


require_once "../../config/database.php";


/*
|--------------------------------------------------------------------------
| AMBIL ID
|--------------------------------------------------------------------------
*/

$id = isset($_GET['id'])
    ? (int) $_GET['id']
    : 0;


if ($id <= 0) {

    header('Location: index.php');
    exit;

}


/*
|--------------------------------------------------------------------------
| CEK DATA AGENDA
|--------------------------------------------------------------------------
*/

$stmt =
    $conn->prepare(
        "SELECT id
         FROM agenda
         WHERE id = ?
         LIMIT 1"
    );


$stmt->bind_param(
    "i",
    $id
);


$stmt->execute();


$result =
    $stmt->get_result();


if (
    !$result ||
    $result->num_rows === 0
) {

    $stmt->close();

    header('Location: index.php');
    exit;

}


$stmt->close();


/*
|--------------------------------------------------------------------------
| HAPUS AGENDA
|--------------------------------------------------------------------------
*/

$delete =
    $conn->prepare(
        "DELETE FROM agenda
         WHERE id = ?"
    );


if ($delete) {

    $delete->bind_param(
        "i",
        $id
    );


    if (
        $delete->execute()
    ) {

        $delete->close();

        header(
            'Location: index.php?success=hapus'
        );

        exit;

    }


    $delete->close();

}


/*
|--------------------------------------------------------------------------
| JIKA GAGAL
|--------------------------------------------------------------------------
*/

header(
    'Location: index.php?error=hapus'
);

exit;