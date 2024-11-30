<?php 


function hapusDataPegawai($username, $nama){
    $file = fopen("../database/pegawai.txt", "r"); 
    $tempFile = fopen("../database/temp_pegawai.txt", "w"); 

    if ($file && $tempFile) {
        while (($line = fgets($file)) !== false) {
            $line = trim($line); 
            $line = trim($line, "[]");

            if (!empty($line)) {
                $data = explode(',', $line);
                if (!in_array($username , $data))return;
                if (!in_array($nama, $data)) {
                    $str = '['.implode(',',$data) .']';
                    fwrite($tempFile, $str . "\n");
                }

            }

        }

        
        fclose($file);
        fclose($tempFile);

        rename("../database/temp_pegawai.txt", "../database/pegawai.txt");
    } else {
        echo "File not found or unable to open files.";
    }
}



?>