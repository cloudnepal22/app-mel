<!DOCTYPE html>
<html>
<head>
    <title>Form Pendaftaran Peserta LKS</title>
    <!-- Load file CSS Bootstrap offline -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

</head>
<body>
<div class="container">
    <?php
    //Include file koneksi, untuk koneksikan ke database
    include "koneksi.php";
    
    //Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nama=input($_POST["nama"]);
        $asal=input($_POST["asal"]);
        $nohp=input($_POST["nohp"]);

		$maxsize = 2000000;
		$sizefoto =$_FILES['foto']['size'];
        $foto=$_FILES["foto"]["name"];
        $str1 = substr($foto,-5);
        $image = date('dmYHis').$str1;
        
		$sizebukti =$_FILES['bukti']['size'];
        $bukti=$_FILES["bukti"]["name"];
        $str2 = substr($bukti,-5);
        $bukti2 = date('dmYHis').$str2;

		if($sizefoto>$maxsize || $sizebukti>$maxsize){
            echo "<div class='alert alert-danger'> Ukuran Foto/File tidak boleh lebih dari 2MB!.</div>";
		}else{
        move_uploaded_file($_FILES["foto"]["tmp_name"],"efs/foto/".$image);
        move_uploaded_file($_FILES["bukti"]["tmp_name"],"efs/bukti/".$bukti2);
        

        //Query input menginput data kedalam tabel anggota
        $sql="INSERT INTO peserta (nama_peserta,asal_sekolah,no_peserta,foto_peserta,bukti_peserta) values
		('$nama','$asal','$nohp','$image','$bukti2')";

        //Mengeksekusi/menjalankan query diatas
        $hasil=mysqli_query($kon,$sql);

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:index.php");
        }
        else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";

        }
		}

    }
    ?>
    <h2>Input Data</h2>


    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" required/>

        </div>
        <div class="form-group">
            <label>Asal Sekolah:</label>
            <input type="text" name="asal" class="form-control" placeholder="Masukan Asal Sekolah" required/>
        </div>
        <div class="form-group">
            <label>No HP:</label>
            <input type="number" name="nohp" class="form-control" placeholder="Masukan No. HP" required/>

        </div>
        <div class="form-group">
            <label>Upload Foto:</label>
            <input type="file" name="foto" required="required" accept="image/*" required>
			<p style="color: black">Ekstensi yang diperbolehkan .png | .jpg | .jpeg </p>
        </div>
        <div class="form-group">
            <label>Upload Bukti Pendaftaran:</label>
            <input type="file" name="bukti" required="required" accept="Application/Pdf" required>
			<p style="color: black">Ekstensi yang diperbolehkan .pdf </p>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
		<a href="index.php" class="btn btn-warning">Cancel</a>
    </form>
</div>
</body>
</html>
