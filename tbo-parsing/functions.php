<?php
include "db.php";


function cek_data($string)
{
	global $db;
	for ($i = 0; $i < count($string); $i++) {
		$data = mysqli_query($db, "SELECT * FROM cnf WHERE body = '$string[$i]'");
		$data = mysqli_fetch_assoc($data);

		if (count($data) == 0) {
			$kata = $string[$i];
			$j = $i + 1;
			while ($data == null) {
				$kata = $kata . ' ' . $string[$j];
				$string[$i] = $kata;
				unset($string[$j]);
				$data = mysqli_query($db, "SELECT * FROM cnf WHERE body = '$kata'");
				$data = mysqli_fetch_assoc($data);
				if ($j > count($string)) {
					$result =  0;
					return $result;
				} else {
					$j++;
				}
			}
			$string = array_values($string);
			$CNF[$i][0] = $data['head'];
			$CNF[$i][1] = $data['body'];
		} else {
			$CNF[$i][0] = $data['head'];
			$CNF[$i][1] = $data['body'];
		}
	}

	$result = hitung_cyk($string, $CNF);
	return $result;
}

function hitung_cyk($string, $cnf)
{
	$CYK = array();
	for ($i = 1; $i <= count($string); $i++) {
		$CYK[1][$i] = baris_pertama($string[$i - 1], $cnf);
	}
	for ($j = 2; $j <= count($string); $j++) {
		for ($i = 1; $i <= count($string) - $j + 1; $i++) {
			for ($k = 1; $k <= $j - 1; $k++) {
				if ($k == 1) {
					$hasil = union($CYK[$k][$i], $CYK[$j - $k][$i + $k]);
					$non_ter = cari_data($hasil);
					$CYK[$j][$i] = array_unique($non_ter);
				} else {
					$hasil = union($CYK[$k][$i], $CYK[$j - $k][$i + $k]);
					$non_ter = cari_data($hasil);
					$gabung = array_merge($CYK[$j][$i], $non_ter);
					$CYK[$j][$i] = array_unique($gabung);
				}
			}
		}
	}
	return $CYK;
}

function baris_pertama($kata, $CNF)
{
	$result = array();
	for ($i = 0; $i < count($CNF); $i++) {
		for ($j = 1; $j < count($CNF); $j++) {
			if ($kata == $CNF[$i][$j]) {
				array_push($result, $CNF[$i][0]);
			}
		}
	}
	return $result;
}

function union($a, $b)
{
	if (count($a) != 0 && count($b) != 0) {
		$result = array();
		for ($i = 0; $i < count($a); $i++) {
			for ($j = 0; $j < count($b); $j++) {
				array_push($result, $a[$i] . ' ' . $b[$j]);
			}
		}
		return $result;
	} elseif (count($a) != 0 && count($b) == 0) {
		return $a;
	} elseif (count($a) == 0 && count($b) != 0) {
		return $b;
	} else {
		return array('&empty;');
	}
}

function cari_data($hasil)
{
	$result = array();
	for ($i = 0; $i < count($hasil); $i++) {
		$data = cari_kata($hasil[$i]);
		$result = array_merge($result, $data);
	}
	return $result;
}

function cari_kata($kata)
{
	global $db;
	$result = array();
	$data = mysqli_query($db, "SELECT * FROM cnf WHERE body = '$kata'");
	$data = mysqli_fetch_assoc($data);
	if ($kata == $data['body']) {
		array_push($result, $data['head']);
	}
	return $result;
}


function cek_valid($cyk)
{
	$akhir = count($cyk);
	$data =  $cyk[$akhir][1];
	if (in_array('K', $data)) {
		$result = "KALIMAT VALID";
	} else {
		$result = "KALIMAT TIDAK VALID";
	}
	return $result;
}
