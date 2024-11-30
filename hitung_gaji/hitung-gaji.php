<?php 

$gaji = array(

    "IV-A" => 3250000 ,
    "IV-B" => 3000000 ,
    "IV-C" => 2750000 ,
    "III-A" => 2500000 ,
    "III-B" => 2250000 , 
    "III-C" => 2000000
);

function TampilGaji($dataPegawai){
    echo "
<html> 

<head> </head>

<body>

<div class='table-container'>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Gaji Pokok</th>
                            <th>Lembur</th>
                            <th>Tunjangan Anak</th>
                            <th>Uang Makan</th>
                            <th>Total Gaji</th>
                        </tr>
                    </thead>
                    <tbody>

                    ";


foreach ($dataPegawai as $data){
    echo "<tr>";
    //Hitung Gaji Pokok 
    $gajiPokok = $GLOBALS['gaji'][$data[4]];
    //Hitung Tambahan Lembur
    $lembur = 0;
    if ((int)$data[7] > 40){
        $jam = (int)$data[7];
        $jam_lembur = $jam - 40;
        $lembur = 35000 * $jam_lembur;
    }

    //Hitung tunjangan anak 
    $tun_anak =  0;
    if ((int)$data[5] > 2){
        $tun_anak = 250000 * 2;
    }
    else {
        $tun_anak = 250000 * (int)$data[5];
    }

    //Hitung uang makan per hari 
    $uang_makan = (int)$data[6] * 25000;

    //hitung total gaji
    $total = $gajiPokok + $lembur + $tun_anak + $uang_makan;
    
    //Simpan ke array 
    $list = array($data[1] , $gajiPokok ,$lembur ,$tun_anak , $uang_makan , $total);

    //Output 
    for ($i = 0; $i < count($list); $i++){
        if (is_numeric($list[$i])){
            echo "<td>Rp".number_format((float)$list[$i] , 2 , "," , ".")."</td>";
        }else {
            echo "<td>".$list[$i]."</td>";
        }
    }
    echo "</tr>";
}
                    
                    
echo "
                    
                    </tbody>
</div>

</body>

</html>";


}

?>
