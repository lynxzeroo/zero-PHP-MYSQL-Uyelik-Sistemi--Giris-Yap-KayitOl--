<?php
ob_start();
session_start();


require 'baglan.php';




if (isset($_POST['kayit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password_again = @$_POST['password_again'];

	if (!$username) {
		echo "Lütfen kullanıcı adınızı girin";
	} elseif(!$password || !$password_again) {
		echo "Lüften şifrenizi girin";
	} elseif ($password != $password_again) {
		echo "Girdiğiniz şifreler birbiriyle aynı değil";
	}
	else{
		//veritabanı kayıt işlemi
		$sorgu = $db->prepare('INSERT INTO users SET user_name = ?, users_password = ?');
		$ekle = $sorgu->execute([
			$username, $password
		]);
		if ($ekle) {
			echo "Kayıt Başarıyla Tamamlandı Yönlendiriliyorsunuz...";
			header('Refresh:2; index.php');
		}else{
			echo "Bir hata oluştu tekrar kontrol ediniz";
		}
	}

}

if (isset($_POST['giris'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (!$username) {
		echo "kullanıcı adınızı giriniz";
	}elseif (!$password) {
		echo "şifrenizi giriniz";
	}else{
		$kullanici_sor = $db->prepare('SELECT * FROM users WHERE user_name = ? || users_password = ?');
		$kullanici_sor->execute([
			$username, $password
		]);
		echo $say = $kullanici_sor->rowCount();
		if ($say==1) {
			$_SESSION['username']=$username;
			echo "Başarıyla giriş yaptınız, yönlendiriliyorsunuz...";
			header('Refresh:2; index.php');
		} else{
			echo "Bir Hata oluştu tekrar kontrol edin";
		}

	}
}




?>