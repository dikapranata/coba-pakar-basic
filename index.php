<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "dbtest";
mysql_connect($server,$username,$password) or die ("Gagal");
mysql_select_db($database) or die ("Database tidak ditemukan");
	$answer	= $_GET['answer'];
	$pilih  = $_GET['pilih'];
	if ($answer != ''){
	mysql_query("INSERT INTO rule_temporary (username, pilihan, jawaban)
										VALUES ('Dika_Pranata','$answer','$_GET[pilihan]')");
	}elseif($pilih == ''){
		mysql_query("TRUNCATE TABLE rule_temporary");
	}
	if(!$answer) $answer = 1;
	$sql2=mysql_query("SELECT * FROM hasil where id_hasil='{$answer}'");
    $s = mysql_fetch_array($sql2);
	$hasil = nl2br($s['hasil']);
	
	$result = mysql_query("SELECT * FROM masalah where id='{$answer}'");
	if(mysql_num_rows($result)){
		$row 		= mysql_fetch_array($result);
		$pertanyaan = nl2br($row['pertanyaan']);
		echo("");
		echo("<br/><span style=' font-size:20px; color: #000;'>".$pertanyaan."</span>");
		echo("<br/><br/>");
		if($row['ifyes'] != "0" && $row['ifno'] != "0"){
		
			echo("<a class='jawab' href=\"?pilih=tanya&pilihan=Y&answer={$row['ifyes']}\">Ya</a>&nbsp;
				  <a class='jawab' href=\"?pilih=tanya&pilihan=N&answer={$row['ifno']}\">Tidak</a>");
		}else{
			echo "";
		}
	}

	if($s['ifyes'] == "0" && $s['ifno'] == "0"){			
	echo "<br/><span style=' font-size:20px; color: #000;'><b>Hasil Konsultasi :</b><br> ".$hasil."<br><br>
				<b>Rule yang Di lewati :</b><ol>";
				$rule=mysql_query("SELECT * FROM rule_temporary 
												left join masalah on rule_temporary.pilihan=masalah.id 
													where username='Dika_Pranata' AND pilihan NOT LIKE 'P%'");
				while ($o = mysql_fetch_array($rule)){
					if ($o[jawaban] == 'Y'){
						$jawaban = "<span style='color:green'>Yes</span>";
					}else{
						$jawaban = "<span style='color:red'>No</span>";
					}
					echo " <li>$o[pertanyaan] $jawaban</li>";

				}
				echo "</ol><a href='index.php'>Coba Konsultasi Lagi</a></span>";
	}else{
		echo "";
	}
?>