<?php

$content = 'cari';
$search = '';


if (isset($_POST['content'])) {
    $content = $_POST['content'];
} elseif (isset($_GET['content'])) {
    $content = $_GET['content'];
}
?>


<?php 

session_start();

if (isset($_POST['tambah'])){
   include_once "../crud/create.php";
   TambahDataPegawai($_SESSION['username'],$_POST['nik'] , $_POST['nama'] , $_POST['alamat'] , $_POST['unit'],$_POST['golongan'] , $_POST['jumlah_anak'] , $_POST['hari_masuk'] , $_POST['jam_kerja']);
  
   echo "<script>alert('Data ditambahkan!!')</script>";


   $content = 'tampil';
}

if (isset($_POST['cari'])){

  $table = '';

  include_once "../crud/read.php";

  $arr = CariDataPegawai($_SESSION['username'] , $_POST['nama']);

  if (empty($arr)){
    $table = "<td colspan='8' class='empty-message'>Tidak ada data yang tersedia.</td>";
    
  }else {
    $table = "<tr>";
    foreach ($arr as $data){
      $table .= "<td>$data</td>";
    }
  
    $table .= "</tr>";
  }



  $search = "
  <div class='table-container'>
                                  <table>
                                      <thead>
                                          <tr>
                                              <th>NIK</th>
                                              <th>Nama</th>
                                              <th>Alamat</th>
                                              <th>Unit</th>
                                              <th>Golongan</th>
                                              <th>Jumlah Anak</th>
                                              <th>Hari Masuk</th>
                                              <th>Jam Kerja</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                              $table
                                              
                                      </tbody>
                                  </table>
                              </div>
                            </div>";

  $content = 'cari';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar with Persistent Content</title>
    <link rel="stylesheet" href="../css/dashboard-style.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2 style='margin-top:50px;'>Hallo , <?php echo $_SESSION['username'];?> !!</h2>
        <form method="post" id="sidebar-form" class="sidebar-form">
            <button type="submit" name="content" value="cari" class="<?php echo $content === 'cari' ? 'active' : ''; ?>">Cari Data</button><br>
            <button type="submit" name="content" value="tampil" class="<?php echo $content === 'tampil' ? 'active' : ''; ?>">Tampilkan Data</button> <br>
            <button type="submit" name="content" value="tambah" class="<?php echo $content === 'tambah' ? 'active' : ''; ?>">Tambah Data</button><br>
            <button type="submit" name="content" value="gaji" class="<?php echo $content === 'haji' ? 'active' : ''; ?>">Tampil Gaji</button><br>
            <button type="submit" name="content" value="logout" class="<?php echo $content === 'logout' ? 'active' : ''; ?>">Logout</button><br>

          </form>
    </div>

    <!-- Content Area -->
    <div class="content">
        <?php
        include_once "../crud/read.php";
        $newData = array();
        $oldDat = array();


        if (array_key_exists('simpan' , $_POST)){
           include_once "../crud/update.php";
            $newData = array($_POST['nik'] , $_POST['nama'] , $_POST['alamat'],$_POST['unit'],$_POST['golongan'],$_POST['jumlah_anak'] , $_POST['hari_masuk'],$_POST['jam_kerja']);
            $oldDat = $_SESSION['row_data'];
           updateData($_SESSION['username'] , $oldDat , $newData); //Nggo ngupdate data
           print_r($oldDat);
           echo "<br>";
           print_r($newData);
        }

        if (array_key_exists('delete' , $_POST)){
          include_once "../crud/delete.php";
          $oldDat = $_SESSION['row_data'];
          hapusDataPegawai($_SESSION['username'] , $oldDat[1]);
          $content = 'tampil';
        }


        if ($content === 'cari') {
            include_once "../crud/read.php";
            echo "
                <div class='search-container'>
                <h1 style='text-align:center;'>Pencarian Data Pegawai</h1>
                    <h3>Cari Berdasarkan Nama</h3>
                    <form method='POST'>
                        <input type='text' name='nama' placeholder='Masukkan Nama...' required><br>
                        <input type='submit' name='cari' value='Cari'>
                    </form>
                </div>";

                    echo $search;
        } 
        elseif ($content === 'tampil') {
            echo "
            <h1 style='text-align:center'>Data Pegawai</h1>
            <div class='table-container'>
                <table>
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Unit</th>
                            <th>Golongan</th>
                            <th>Jumlah Anak</th>
                            <th>Hari Masuk</th>
                            <th>Jam Kerja</th>
                            <th colspan='3' style='text-align:center'>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Data -->
                        ";
                        
                        include_once "../crud/read.php";
                        $arr = ReadDataPegawai($_SESSION['username']);
                        foreach ($arr as $data){
                          echo "<tr>";
                          foreach ($data as $var){
                            echo "<td>" .$var . "</td>";
                          }
                          $row = json_encode($data);
                          echo "<td><input type='submit' name='edit' class='edit-btn' id='edit-btn' value='Edit' data-row='".$row."' onclick='populateForm(" . json_encode($data) . ")'></td>";
                          echo "<form method='post'>";
                          echo "<td><input type='submit' value='Hapus' name='delete' id='delete-btn' data-row='".$row."' class='delete-btn'></td>";
                          echo "</form>";
                          echo "</tr>";
                        }

                        echo "
                        <!-- Jika tidak ada data -->
                        <!-- <tr>
                            <td colspan='8' class='empty-message'>Tidak ada data yang tersedia.</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>

            <!-- Edit Form Modal -->
            <div id='edit-modal' style='display:none;'>
                <h2>Edit Data Pegawai</h2>
                <form id='edit-form' method='POST'>
                    <label for='nik'>NIK:</label>
                    <input type='text' name='nik' id='nik' required><br>
                    
                    <label for='nama'>Nama:</label>
                    <input type='text' name='nama' id='nama' required><br>

                    <label for='alamat'>Alamat:</label>
                    <input type='text' name='alamat' id='alamat' required><br>

                    <label for='unit'>Unit:</label>
                    <input type='text' name='unit' id='unit' required><br>

                    <label for='golongan'>Golongan:</label>
                    <select name='golongan' id='golongan'>
                    <option name='iv-a'>IV-A</option>
                    <option name='iv-a'>IV-B</option>
                    <option name='iv-a'>IV-C</option>
                    <option name='iii-a'>III-A</option>
                    <option name='iii-b'>III-B</option>
                    <option name='iii-c'>III-C</option>

                    </select>

                    <label for='jumlah_anak'>Jumlah Anak:</label>
                    <input type='number' name='jumlah_anak' min='0' id='jumlah_anak' required><br>

                    <label for='hari_masuk'>Hari Masuk:</label>
                    <input type='number' name='hari_masuk' min='0' id='hari_masuk' required><br>

                    <label for='jam_kerja'>Jam Kerja:</label>
                    <input type='number' name='jam_kerja' min='0' id='jam_kerja' required><br>

                    <input type='submit' name='simpan' class='simpan-btn' value='Simpan Perubahan'>
                </form>
                <input type='submit' onclick='closeModal()' class='tutup-btn' value='Tutup'>
            </div>

                  <script>

                  document.addEventListener('DOMContentLoaded', () => {
                          const editButtons = document.querySelectorAll('.edit-btn'); 

                          editButtons.forEach(button => {
                              button.addEventListener('click', () => {
                                  const rowData = JSON.parse(button.getAttribute('data-row')); 
                                  
                                  
                                  console.log(rowData);

                                  setData(rowData);
                                  sendRowData(button);
                              });
                          });
                      });

                  document.addEventListener('DOMContentLoaded', () => {
                          const editButtons = document.querySelectorAll('.delete-btn'); 

                          editButtons.forEach(button => {
                              button.addEventListener('click', () => {
                                  const rowData = JSON.parse(button.getAttribute('data-row')); 
                                  
                                  console.log(rowData);
                                  sendRowData(button);
                              });
                          });
                      });

                  function setData(data){
                      document.getElementById('nik').value = data[0];
                      document.getElementById('nama').value = data[1];
                      document.getElementById('alamat').value = data[2];
                      document.getElementById('unit').value = data[3];
                      document.getElementById('golongan').value = data[4];
                      document.getElementById('jumlah_anak').value = data[5];
                      document.getElementById('hari_masuk').value = data[6];
                      document.getElementById('jam_kerja').value = data[7];
                  }

                  function sendRowData(button) {

                      const rowData = button.getAttribute('data-row');

                      // Send the data to the server via a POST request
                      fetch('server.php', {
                          method: 'POST',
                          headers: {
                              'Content-Type': 'application/json',
                          },
                          body: JSON.stringify({ row: rowData }),
                      })
                      .then(response => response.json())
                      .then(data => {
                          console.log('Data received from server:', data);
                          // Perform actions with the server response, if needed
                      })
                      .catch(error => {
                          console.error('Error:', error);
                      });
                  }


                  function populateForm(data) {
                      document.getElementById('edit-modal').style.display = 'block';
                      showEditModal();
                  }

                  function closeModal() {
                      document.getElementById('edit-modal').style.display = 'none';
                  }

                  function showEditModal() {
                      var modal = document.getElementById('edit-modal');
                      modal.classList.add('show');  
                  }

                  function closeEditModal() {
                      var modal = document.getElementById('edit-modal');
                      modal.classList.remove('show');  
                  }

                  document.getElementById('edit-btn').addEventListener('click', showEditModal);
                  document.getElementById('close-modal-button').addEventListener('click', closeEditModal);


                  </script>";
        }
        elseif ($content === 'tambah') {
          echo "<h1>Tambah Data Pegawai</h1>
            <div class='form-container'>
                <form method='POST'>
                    <div class='form-group'>
                        <label for='nik'>NIK</label>
                        <input type='text' id='nik' name='nik' placeholder='Masukkan NIK' required>
                    </div>
                    <div class='form-group'>
                        <label for='nama'>Nama</label>
                        <input type='text' id='nama' name='nama' placeholder='Masukkan Nama' required>
                    </div>
                    <div class='form-group'>
                        <label for='alamat'>Alamat</label>
                        <input type='text' id='alamat' name='alamat' placeholder='Masukkan Alamat' required>
                    </div>
                    <div class='form-group'>
                        <label for='unit'>Unit</label>
                        <input type='text' id='unit' name='unit' placeholder='Masukkan Unit' required>
                    </div>
                    <div class='form-group'>
                        <label for='golongan'>Golongan</label>
                        <select name='golongan'>
                          <option name='iv-a'>IV-A</option>
                          <option name='iv-b'>IV-B</option>
                          <option name='iv-c'>IV-C</option>
                          <option name='iii-a'>III-A</option>
                          <option name='iii-b'>III-B</option>
                          <option name='iii-c'>III-C</option>
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='jumlah_anak'>Jumlah Anak</label>
                        <input type='number' id='jumlah_anak' name='jumlah_anak' placeholder='Masukkan Jumlah Anak' required>
                    </div>
                    <div class='form-group'>
                        <label for='hari_masuk'>Hari Masuk</label>
                        <input type='number' id='hari_masuk' name='hari_masuk' placeholder='Masukkan Jumlah Hari Masuk' required>
                    </div>
                    <div class='form-group'>
                        <label for='jam_kerja'>Jam Kerja</label>
                        <input type='number' id='jam_kerja' name='jam_kerja' placeholder='Masukkan Jam Kerja (Per Minggu)' required>
                    </div>
                    <div class='form-actions'>
                        <input type='submit' name='tambah' class='tambah-data' value='Tambah Data'>
                    </div>
                </form>
            </div>";
        }
        else if ($content === 'gaji'){
          include_once "../hitung_gaji/hitung-gaji.php";
          include_once "../crud/read.php";
          TampilGaji(ReadDataPegawai($_SESSION['username']));
        }
        elseif ($content === 'logout') {
          header("Location:../index.php");
        }
        
        ?>
    </div>
</body>
</html>
