<?php 
include "koneksi.php";
if(isset($_GET['id_peserta'])){
	$id	= $_GET['id_peserta'];
	$mySql	= "DELETE FROM peserta WHERE id_peserta='$id'";
	$myQry	= mysqli_query($kon,$mySql);
	echo "<script type='text/javascript'>
			alert('Data berhasil dihapus.'); 
			document.location = 'index.php'; 
		</script>";
}else {
	echo "<script type='text/javascript'>
			alert('Terjadi kesalahan, silahkan coba lagi!.'); 
			document.location = 'index.php'; 
		</script>";
}
?>