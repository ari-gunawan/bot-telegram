<?php 
require_once 'database/configDB.php';


function insertDataCatatan($pn, $jd_komplain, $isi_komplain){

    $queryInsertCatatan = "INSERT INTO tb_catatan_mk (pn, jd_komplain, isi_komplain) VALUES ('$pn', '$jd_komplain', '$isi_komplain')";
    $resultQueryInsert  = mysqli_query(connDB(), $queryInsertCatatan);
    $pn = $user->getFirstName();
    $tiket = $tiket-getTiket();

    if ($resultQueryInsert) {
    	$message = "nomor tiket info adalah $tiket Mohon ditunggu, permasalahan anda sedang kami teruskan ke PIC";
    }
    else{
    	$message = "format komplain ada yang salah, Cek Kembali 😱";
    }
    
    return $message;
}
