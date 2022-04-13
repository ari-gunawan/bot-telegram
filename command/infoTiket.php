<?php
require_once 'database/configDB.php';


function insertDataCatatan($user, $tiket, $tgl, $dispo, $info_dispo, $jd_info)
{

    $queryInsertKomplain = "INSERT INTO tb_catatan_mk (tiket) VALUES ('$tiket', '$tgl', '$dispo', '$info_dispo', '$jd_info')";
    $resultQueryInsert  = mysqli_query(connDB(), $queryInsertKomplain);
    $firstname = $user->getFirstName();

    if ($resultQueryInsert) {
        $message = "
        ID tiket        : $tiket\n
        TGL tiket       : $tgl\n
        tgl             : $dispo\n
        dispo bagian    : $info_dispo\n
        jenis tiket     : $jd_info ";
    } else {
        $message = "Data Gagal Disimpan, Cek Kembali 😱";
    }

    return $message;
}
