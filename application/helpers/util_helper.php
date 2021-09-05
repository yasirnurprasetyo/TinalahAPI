<?php

function apiRequestFlask()
{
    $signed_url = "http://127.0.0.1:5000/";
    $ch = curl_init($signed_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    echo $data;
}

function apiRequest($endPoint, $method, $body = null)
{
    $ci = &get_instance();
    $apiUrl = $ci->config->item("api_url");
    $ci->curl->create($apiUrl . $endPoint);
    $options = array(
        CURLOPT_FAILONERROR => false,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $body,
    );
    $ci->curl->options($options);
    $data = json_decode($ci->curl->execute());
    $info = $ci->curl->info;
    return array(
        "kode" => $info["http_code"],
        "body" => $data
    );
}

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
