<?php

$dataArray = array();

function ReadData($username, $password) {
    $filePath = "../database/pengguna.txt";
    $result = [];

    if (file_exists($filePath)) {
        // Open the file
        $file = fopen($filePath, "r");
        if ($file) {
            
            while (($line = fgets($file)) !== false) {
                $line = trim($line); 
                if (!empty($line)) {
                    $data = explode(",", $line);
                    if (count($data) === 2) { 
                        $result[] = $data[0] . "," . $data[1];

                        if ($username == $data[0] && $password == $data[1]){
                            return true;
                        }

                    }
                }
            }
            $GLOBALS['dataArray'] = $result;
            fclose($file);
        } else {
            echo "Failed to open the file.";
        }
    } else {
        echo "File does not exist.";
    }

    return false;
}


function CheckUsernameExist($username){
    $filePath = "../database/pengguna.txt";
    $result = [];

    if (file_exists($filePath)) {
        // Open the file
        $file = fopen($filePath, "r");
        if ($file) {
            
            while (($line = fgets($file)) !== false) {
                $line = trim($line); 
                if (!empty($line)) {
                    $data = explode(",", $line);
                    if (count($data) === 2) { 
                        $result[] = $data[0] . "," . $data[1];

                        if ($username == $data[0]){
                            return true;
                        }

                    }
                }
            }
            fclose($file);
        } else {
            echo "Failed to open the file.";
        }
    } else {
        echo "File does not exist.";
    }

    return false;
}


function ReadDataPegawai($username){
    $file = fopen("../database/pegawai.txt" , "r");
    $res = "";
    $data = array();
    if ($file){
        while (($line = fgets($file)) !== false) {
            $line = trim($line); 
            if (!empty($line)) {
                $line = trim($line , "[]");
                $dataNew = explode(",", $line);
                if (in_array($username , $dataNew)){
                    $line = trim($line , $username); // Hapus username
                    $newArr = explode(",",$line);
                    array_shift($newArr); // Hapus element username 
                    $data[] = $newArr;
                }
            }
        }
        return $data;
    }
    else {
        return array();
    }

}

function CariDataPegawai($username , $nama){
    $file = fopen("../database/pegawai.txt" , "r");
    $res = "";
    $data = array();
    if ($file){
        while (($line = fgets($file)) !== false) {
            $line = trim($line); 
            if (!empty($line)) {
                $line = trim($line , "[]");
                $dataNew = explode(",", $line);
                if (in_array($username , $dataNew)){
                    $newArr = explode(",",$line);
                    $data[] = $newArr;
                }
            }
        }
        
        foreach ($data as $arr){
            if (in_array($nama , $arr) && in_array($username , $arr)){
                array_shift($arr);
                return $arr;
            }
        }

    }
    
    return array();
}

?>