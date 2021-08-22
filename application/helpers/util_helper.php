<?php

function checkToken()
{
    $ci = &get_instance();

    $token = $ci->input->get_request_header("token");

    $query = "select token_user,token_expired_user from user where token_user = '$token'";
    $admin = $ci->db->query($query)->row();
    $hariIni = date("Y-m-d");

    //Cek Token sudah expired atau belum?
    if ($admin != NULL) {
        if ($hariIni > $admin->token_expired_user)
            //Token sudah Expired
            return false;
    } else {
        return false;
    }
    return true;
}

function randomToken($length)
{
    $strToken = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $tempToken = "";
    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($strToken) - 1);
        $tempToken .= $strToken[$index];
    }
    return $tempToken;
}

//Buat field tahun, bulan itu bukan tanggal_transaksi
function getLastNomor($table)
{
    $CI = &get_instance();
    $query = "select max(nomor) as nomor from $table where year(created_at) = year(now()) ";
    $query .= "AND month(created_at) = month(now()) ";
    $nomor = $CI->db->query($query)->row();
    return $nomor;
}

function autoCreate($prefix, $delimeter, $nomor)
{
    $s = "";
    foreach ($prefix as $value) {
        $s .= $value . $delimeter;
    }
    return $s . date("Y")
        . $delimeter
        . date("m")
        . $delimeter
        . str_pad($nomor, 4, "0", STR_PAD_LEFT);
}
