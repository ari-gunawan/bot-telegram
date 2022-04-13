<?php 
require_once 'database/configDB.php';


function insertDataCatatan($user, $pn, $nama, $nomor_uker, $nomor_hp){

    $queryInsertKomplain = "INSERT INTO tb_catatan_mk (pn, nama, nomor_uker, nomor_hp) VALUES ('$pn', '$nama', '$nomor_uker', '$nomor_hp')";
    $resultQueryInsert  = mysqli_query(connDB(), $queryInsertKomplain);
    $firstname = $user->getFirstName();

    if ($resultQueryInsert) {
    	$message = "halo $firstname anda sukses melakukan register";
    }
    else{
    	$message = "Data Gagal Disimpan, Cek Kembali 😱";
    }
    
    return $message;
}
