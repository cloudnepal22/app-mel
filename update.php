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
    //Cek apakah ada nilai yang dikirim menggunakan methos GET dengan nama id_anggota
    if (isset($_GET['id_peserta'])) {
        $id=input($_GET["id_peserta"]);

        $sql="select * from peserta where id_peserta=$id";
        $hasil=mysqli_query($kon,$sql);
        $data = mysqli_fetch_assoc($hasil);
    }

    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id=htmlspecialchars($_POST["id"]);
        $nama=input($_POST["nama"]);
        $asal=input($_POST["asal"]);
        $nohp=input($_POST["nohp"]);
        $foto=input($_POST["foto"]);
        $bukti=input($_POST["bukti"]);



        //Query update data pada tabel anggota
        $sql="UPDATE peserta set
			nama_peserta='$nama',
			asal_sekolah='$asal',
			no_peserta='$nohp'
			where id_peserta=$id";

        //Mengeksekusi atau menjalankan query diatas
        $hasil=mysqli_query($kon,$sql);

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:index.php");
        }
        else {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan, silahkan coba lagi!.'); 
					document.location = 'update.php?id_peserta=$id'; 
				</script>";

        }

    }

    ?>
    <h2>Update Data</h2>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" value="<?php echo $data['nama_peserta']; ?>" placeholder="Masukan Nama" required/>
        </div>
        <div class="form-group">
            <label>Asal Sekolah:</label>
            <input type="text" name="asal" class="form-control" value="<?php echo $data['asal_sekolah']; ?>" placeholder="Masukan Asal Sekolah" required/>
        </div>
        <div class="form-group">
            <label>No HP:</label>
            <input type="number" name="nohp" class="form-control" value="<?php echo $data['no_peserta']; ?>" placeholder="Masukan No. HP" required/>

        </div>
        <div class="form-group">
			<a href="efs/foto/<?php echo htmlentities($data['foto_peserta']);?>" target="blank"><img src="efs/foto/<?php echo htmlentities($data['foto_peserta']);?>" width="100"></a>
			<a href="ubahfoto.php?id_peserta=<?php echo $data['id_peserta']; ?>" class="btn btn-danger">Ubah Foto</a>
        </div>
        <div class="form-group">
			<a href="efs/bukti/<?php echo htmlentities($data['bukti_peserta']);?>" target="blank">Lihat Bukti</a>
			<a href="ubahbukti.php?id_peserta=<?php echo $data['id_peserta']; ?>" class="btn btn-danger">Ubah Bukti</a>
        </div>
        <input type="hidden" name="id" value="<?php echo $data['id_peserta']; ?>" />
        <input type="hidden" name="foto" value="<?php echo $data['foto_peserta']; ?>" />
        <input type="hidden" name="bukti" value="<?php echo $data['bukti_peserta']; ?>" />
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
		<a href="index.php" class="btn btn-warning">Cancel</a>
    </form>
</div>
</body>
</html>
