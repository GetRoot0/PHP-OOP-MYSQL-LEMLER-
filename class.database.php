<?php

class database{

	private $conn;

	public function __construct($host,$dbname,$user,$pass){
		
		$this->conn = new PDO("mysql:host=".$host.";dbname=".$dbname,$user,$pass);
		
	}


	// Veri Çekme
	// Fetching Data
	public function listele($table){
			$komut = "SELECT * FROM $table";
			$sonuc = $this->conn->query($komut) or die("Veri Getirilemedi!");
				if ($sonuc->rowCount()) {
					foreach ($sonuc as $sonuc) {
						$data[] = $sonuc;
					}
					return $data;
				}
	}
	//Veri Güncelleme
	// Data Update
	public function guncelle($id,$table,$col,$ndata){
			$komuts = "UPDATE $table SET $col = $ndata WHERE id =$id";
			$guncel_islem = $this->conn->exec($komuts) or die("Veriler Güncellenmedi!");
	}
	// Tek Veri Çekme
	// Single Data Drawing
	public function tek_veri($id,$table,$col){
		$komuta = "SELECT * FROM $table WHERE id=$id";
		$result = $this->conn->query($komuta)->fetch(PDO::FETCH_ASSOC) or die ("Veri Bulunamadı");
		$data[] = $result; 
		echo $data[0]["$col"];
			
	}
	// Veri Ekleme
	// Adding Data
	public function veri_ekle($table,$ver1,$ver2,$ver3){
		$ins ="insert into $table set kadi=?,sifre=?,onay=?";
		$ekle = $this->conn->prepare($ins);
		$ver2 = md5($ver2);
		$ekle->execute(array($ver1,$ver2,$ver3));
	}

	//Veri Tabanı Kapatma
	//CLOSE A DATABASE
	public function __destruct()
    {
        $this->conn->close();
    }

	
}
// Veri Tabanı Objesi Oluşturma [HOST BİLGİSİ, DATABASE İSMİ, KULLANICI ADI, ŞİFRE]
// Creating a Database Object [HOST INFORMATION, DATABASE NAME, USER NAME, PASSWORD]

$db = new database("localhost","uzem","root","");


// Veri Güncelleme [GÜNCELLENECEK İD, TABLO İSMİ, KOLON İSMİ, VERİ]
// Data Update [ID TO BE UPDATED, TABLE NAME, COLUMN NAME, DATA]

echo $db->guncelle(1,"uye","onay",1);


// Verileri Listeleme [TABLO İSMİ]
// Listing Data [TABLE NAME]

foreach($db->listele("uye") as $value){
		echo $value["id"]."<br/>";
}

//İlk Veriyi Çekme [ARANACAK İD,TABLO İSMİ,GÖSTERİLECEK KOLON İSMİ]
// Pulling First Data [ID, TABLE NAME, COLUMN NAME TO BE SHOWN]
 $db->tek_veri(1,"uye","kadi");


// Veri Ekleme [TABLO İSMİ, 1.KOLON VERİ, 2.KOLON VERİ, 3.KOLON VERİ]
// Adding Data [TABLE NAME, 1. COLUMN DATA, 2. COLUMN DATA, 3. COLUMN DATA]
$db->veri_ekle("uye","KADİ","HBM",4);
?>
