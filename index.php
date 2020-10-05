<?php
    //Koneksi Database
    $server = "localhost";
    $user  = "root";
    $pass = "";
    $database = "test_crud_2020";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

      //jika tombol simpan di klik
      if(isset($_POST['bsimpan']))
      {
        //pengujian apakaha data akan di edit atau di simpan baru
        if($_GET['hal'] == "edit")
        {
          //data akan di edit
          $edit = mysqli_query($koneksi, " UPDATE test set
                                            Nik = '$_POST[nik]',
                                            Nama = '$_POST[tnama]',
                                            NamaTim = '$_POST[Ttim]',
                                            Pemimpin = '$_POST[tLeader]',
                                            WHERE idKaryawan = '$_GET[id]'
          ");
          if($edit) //jika edit sukses
          {
            echo "<script>
            alert('Edit data sukses!');
            document.location='index.php';
            </script>";
          }
          else
          {
            echo " <script>
                        alert('Edit data GAGSL!!');
                        document.location='index.php';
                        </script>";
          }
        }else {
          // data akan di simpan baru

                  $simpan = mysqli_query($koneksi, "INSERT INTO test  ( Nik, Nama, NamaTim, Pemimpin)
                                                    VALUES ('$_POST[tnik]',
                                                            '$_POST[tnama]',
                                                            '$_POST[Ttim]',
                                                            '$_POST[tLeader]')
                  ");
                  if($simpan) //jika simpan sukses
                  {
                    echo "<script>
                    alert('Simpan data sukses!');
                    document.location='index.php';
                    </script>";
                  }
                  else
                  {
                    echo " <script>
                                alert('Simpan data GAGSL!!');
                                document.location='index.php';
                                </script>";
                  }
        }

      }

      //jika pengujian tombol edit/ hapus di klik
      if(isset($_GET['hal']))
      {
        //Pengujian jika edit Data
        if($_GET['hal'] == "edit")
        {
        //Tampilkan data yang akan di edit
        $tampil = mysqli_query($koneksi, "SELECT * FROM test WHERE idKaryawan = '$_GET[id]' ");

        $data = mysqli_fetch_array($tampil);
        if($data)
        {
            //Jika data di temukan di tampung dulu ke variabel
            $vnik = $data['Nik'];
            $vnama = $data['Nama'];
            $vTim = $data['NamaTim'];
            $vpemimpin = $data['Pemimpin'];

          }
        }
        elseif ($_GET['hal'] == "hapus") {
          // Persiapan hapus data
          $hapus = mysqli_query($koneksi, "DELETE FROM test WHERE idKaryawan= '$_GET[id]'");
          if($hapus){
            echo "<script>
            alert('Hapus data sukses!');
            document.location='index.php';
            </script>";
          }
        }


      }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CRUD 2020 Test</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  </head>
  <body>

<div class="container">
    <h1 class="text-center">PT HashMicro Solusi Indonesia</h1>
    <h2 class="text-center">Test</h2>


      <!-- Awal-Card-Form -->
      <div class="card mt-3">
        <div class="card-header bg-primary text-white">
          Form Input Data Karyawan
        </div>
        <div class="card-body">
          <form method="post" action="">
            <div class="form-group">
              <label>Nik</label>
              <input type="text" name="tnik" value="<?=@$vnik?> "class="form-control" placeholder="Input Nik anda di sini" required>
            </div>

            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="tnama" value="<?=@$vnama?> " class="form-control" placeholder="Input Nama anda di sini" required>
            </div>

            <div class="form-group">
              <label>Nama Tim</label>
            <textarea class="form-control" name="Ttim" value="<?=@$vTim?>" placeholder="Input Nama Tim Anda Di Sini" ></textarea>
            </div>

          </form>

        </div>
        <div class="card-body">
          <form class="" action="index.html" method="post">
            <div class="form-group">
              <label>Team Leader</label>
              <select class="form-control" name="tLeader" >
                <option value= "<?=@$vpemimpin?>"><?=@$vpemimpin?></option>
                <option value="Tim-1">Tim-1</option>
                <option value="Tim-2">Tim-2</option>
                <option value="Tim-3">Tim-3</option>

              </select>

            </div>

            <button type="submit"  class="btn btn-success" name="bsimpan">Simpan</button>
            <button type="reset"  class="btn btn-danger" name="breset">Kosongkan</button>
          </form>
        </div>
      </div>
      <!-- Akhir-Card-Form -->

      <!-- Awal-Card-Table -->
      <div class="card mt-3">
        <div class="card-header bg-success text-white">
          Daftar Pesanan
        </div>
        <div class="card-body">

          <table class="table table-border table-striped">
            <tr>
              <th>No.</th>
              <th>Nik</th>
              <th>Nama</th>
              <th>Nama Tim</th>
              <th>Pemimpin</th>
              <th>Aksi</th>
            </tr>

            <?php
            $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * from test order by idKaryawan desc");
                while($data = mysqli_fetch_array($tampil)) :
                ?>
            <tr>
              <td><?=$no++;?></td>
              <td><?=$data['Nik']?></td>
              <td><?=$data['Nama']?></td>
              <td><?=$data['NamaTim']?></td>
              <td><?=$data['Pemimpin']?></td>
              <td>
                <a href="index.php?hal=edit&id=<?=$data['idKaryawan']?>" class="btn btn-warning">Edit</a>
                <a href="index.php?hal=hapus&id=<?=$data['idKaryawan']?>"
                   onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
              </td>
            </tr>
          <?php endwhile; //penutup pengulangan while ?>
          </table>

        </div>
      </div>
      <!-- Akhir-Card-Table -->

</div>
<script type="text/javascript" src="js/bootstrap.min.js">

</script>
  </body>
</html>
