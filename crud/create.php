<?php

function CreateUser($username , $password){
    $file = fopen("../database/pengguna.txt" , "a+");
    include_once "read.php";

    if (CheckUsernameExist($username))return false; //Check if username already exist

    if ($file){
        $content = $username . "," . $password ."\n";
        fwrite($file , $content);
        fclose($file);
        return true;
    }else {
        echo "The file isn't exist";
    }

    return false;
}

function TambahDataPegawai($username,$nik , $nama , $alamat , $unit , $golongan , $jumlah_anak , $masuk , $jam_kerja){

    $file = fopen("../database/pegawai.txt" , "a+");

    if ($file){
        $content = "[".$username.",".$nik.",".$nama. "," . $alamat . ","  . $unit . "," . $golongan . "," . $jumlah_anak . "," . $masuk . "," . $jam_kerja ."]\n";
        fwrite($file,$content);
        fclose($file);
    }
    else {
        echo "File not Found";
    }
}

?>