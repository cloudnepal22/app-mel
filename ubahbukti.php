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
		$maxsize = 2000000;
		$sizebukti =$_FILES['bukti']['size'];
        $bukti=$_FILES["bukti"]["name"];
        $str1 = substr($bukti,-5);
        $bukti2 = date('dmYHis').$str1;

		if($sizefoto>$maxsize){
			echo "<script type='text/javascript'>
					alert('Ukuran file tidak boleh lebih dari 2MB!'); 
					document.location = 'ubahbukti.php?id_peserta=$id'; 
				</script>";
		}else{
			move_uploaded_file($_FILES["bukti"]["tmp_name"],"efs/bukti/".$bukti2);
			//Query update data pada tabel anggota
			$sql="UPDATE peserta set 
				bukti_peserta='$bukti2'
				where id_peserta=$id";

			//Mengeksekusi atau menjalankan query diatas
			$hasil=mysqli_query($kon,$sql);

			//Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
			if ($hasil) {
				echo "<script type='text/javascript'>
						alert('Bukti berhasil diubah!.'); 
						document.location = 'update.php?id_peserta=$id'; 
					</script>";
			}
			else {
				echo "<script type='text/javascript'>
						alert('Terjadi kesalahan, silahkan coba lagi!.'); 
						document.location = 'ubahbukti.php?id_peserta=$id'; 
					</script>";
			}
		}
    }

    ?>
    <h2>Ubah Bukti</h2>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" value="<?php echo $data['nama_peserta']; ?>" placeholder="Masukan Nama" readonly/>
        </div>
        <div class="form-group">
            <label>Asal Sekolah:</label>
            <input type="text" name="asal" class="form-control" value="<?php echo $data['asal_sekolah']; ?>" placeholder="Masukan Asal Sekolah" readonly/>
        </div>
        <div class="form-group">
            <label>No HP:</label>
            <input type="number" name="nohp" class="form-control" value="<?php echo $data['no_peserta']; ?>" placeholder="Masukan No. HP" readonly/>

        </div>
        <div class="form-group">
            <input type="file" name="bukti" required="required" accept="Application/Pdf" required>
			<p style="color: black">Ekstensi yang diperbolehkan .pdf </p>
        </div>
        <input type="hidden" name="id" value="<?php echo $data['id_peserta']; ?>" />
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
		<a href="update.php?id_peserta=<?php echo $data['id_peserta'];?>" class="btn btn-warning">Cancel</a>
    </form>
</div>
</body>
</html>
