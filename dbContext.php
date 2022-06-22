<?php
	function GetDbConnection(){
		$db_driver="mysql"; $host = "localhost"; $database = "iteh2lb1var4";
		$dsn = "$db_driver:host=$host; dbname=$database";
		$username = "root"; $password = "";

		$options = array(PDO::ATTR_PERSISTENT => true, PDO::
		MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

		return new PDO ($dsn, $username, $password, $options);
	}

	function GetNurses(){
		$dbh = GetDbConnection();
		
		$query = $dbh->prepare("SELECT id_nurse, name FROM nurse ORDER BY name");

		$query->execute();

		return $query->fetchAll();
	}

	function GetWards(){
		$dbh = GetDbConnection();
		
		$query = $dbh->prepare("SELECT * FROM ward ORDER BY name");

		$query->execute();

		return $query->fetchAll();
	}

	function GetDepartments(){
		$dbh = GetDbConnection();
		
		$query = $dbh->prepare("SELECT Distinct department FROM nurse ORDER BY department");

		$query->execute();

		return $query->fetchAll();
	}

	
	function GetShifts(){
		$dbh = GetDbConnection();
		
		$query = $dbh->prepare("SELECT Distinct shift FROM nurse ORDER BY shift");

		$query->execute();

		return $query->fetchAll();
	}

	function GetWardsByUser($nurseId){
		$dbh = GetDbConnection();

		$query = $dbh->prepare("SELECT Distinct w.name from ward w
								inner join nurse_ward nw on w.id_ward = fid_ward
								inner join nurse n on n.id_nurse = nw.fid_nurse
								where n.id_nurse = " . $nurseId);
		
		$query->execute();

		return $query->fetchAll();
	}

	function GetNursesByDeparment($deparment){
		$dbh = GetDbConnection();

		$query = $dbh->prepare("SELECT Distinct name From nurse 
								WHERE department =". $deparment);
			
		$query->execute();

		return $query->fetchAll();
	}

	function GetDutyByShift($shift){
		$dbh = GetDbConnection();

		$query = $dbh->prepare("SELECT Distinct w.name, n.name as 'nurseName' from ward w
								inner join nurse_ward nw on w.id_ward = fid_ward
								inner join nurse n on n.id_nurse = nw.fid_nurse
								where n.shift ='" . $shift . "'");

		$query->execute();

		return $query->fetchAll();
	}

	function AddNurse($nurseName, $deparment, $shift){
		$dbh = GetDbConnection();

		$date = date('Y/m/d H:i:s');
		$id = rand();
		$queryString = "INSERT INTO nurse(id_nurse, name, date, department, shift)
							VALUES(" . $id . " ,'". $nurseName . "', cast('" . $date . "' as date)," . $deparment . ",'" . $shift . "')";

		$query = $dbh->prepare($queryString);

		$query->execute();
	}

	function AddWard($name){
		$dbh = GetDbConnection();

		$id = rand();

		$query = $dbh->prepare( "INSERT INTO ward(id_ward, name)
							VALUES(:id , :name)");

		$query->bindParam(':name', $name, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_INT);

		$query->execute();
	}

	function ConnectWardWithNurse($idNurse, $idWard){
		$dbh = GetDbConnection();

		$id = rand();

		$query = $dbh->prepare( "INSERT INTO nurse_ward(fid_nurse, fid_ward)
							VALUES(:idNurse , :idWard)");

		$query->bindParam(':idNurse', $idNurse, PDO::PARAM_INT);
		$query->bindParam(':idWard', $idWard, PDO::PARAM_INT);

		$query->execute();
	}
?>