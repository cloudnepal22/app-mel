<!DOCTYPE html>
<html>
<head>
    <!-- Load file CSS Bootstrap offline -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <br>
    <h4>Daftar Peserta LKS Cloud Computing</h4>
<?php

    include "koneksi.php";

    //Cek apakah ada nilai dari method GET dengan nama id_anggota
    if (isset($_GET['id_anggota'])) {
        $id_anggota=htmlspecialchars($_GET["id_anggota"]);

        $sql="delete from anggota where id_anggota='$id_anggota' ";
        $hasil=mysqli_query($kon,$sql);

        //Kondisi apakah berhasil atau tidak
            if ($hasil) {
                header("Location:index.php");

            }
            else {
                echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";

            }
        }
?>

	<table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Asal Sekolah</th>
            <th>No HP</th>
            <th>Foto</th>
            <th>Bukti</th>
            <th colspan='2'>Aksi</th>

        </tr>
        </thead>
        <?php
        include "koneksi.php";
        $sql="select * from peserta order by nama_peserta ASC";
        $hasil=mysqli_query($kon,$sql);
		$count = mysqli_num_rows($hasil);
		if($count==0){
            ?>
            <tbody>
            <tr>
                <td colspan="7"><center>Tidak ada data.</center></td>
            </tr>
            </tbody>
            <?php
			
		}else{
        $no=0;
        while ($data = mysqli_fetch_array($hasil)) {
            $no++;

            ?>
            <tbody>
            <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $data["nama_peserta"]; ?></td>
                <td><?php echo $data["asal_sekolah"];   ?></td>
                <td><?php echo $data["no_peserta"];   ?></td>
                <td><a href="efs/foto/<?php echo htmlentities($data['foto_peserta']);?>" target="blank"><img src="efs/foto/<?php echo htmlentities($data['foto_peserta']);?>" width="100"></a></td>
                <td><a href="efs/bukti/<?php echo htmlentities($data['bukti_peserta']);?>" target="blank">Lihat Bukti</a></td>
                <td>
                    <a href="update.php?id_peserta=<?php echo htmlspecialchars($data['id_peserta']); ?>" class="btn btn-warning" role="button">Update</a>
					<a href="delete.php?id_peserta=<?php echo $data['id_peserta'];?>" onclick="return confirm('Apakah anda yakin akan menghapus <?php echo $data['nama_peserta'];?>?')" class="btn btn-danger" role="button">Hapus</a>
                </td>
            </tr>
            </tbody>
            <?php
        }
		}
        ?>
    </table>
    <a href="create.php" class="btn btn-primary" role="button">Tambah Data</a>

</div>
</body>
</html>
