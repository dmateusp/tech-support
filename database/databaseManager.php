<?php
	header('Content-Type: application/json');

	include("databaseFunctions.php");

	if($_GET["func"]=="connection"){
		$data=array("success"=>connection($dbh));
	}

	if($_GET["func"]=="getAllHotelitems"){
		$data=getAllHotelitems($link,$dbh);
	}
	if($_GET["func"]=="createTicket"){
		$data=createTicket($dbh);
		if($data){
			$data=1;
		}
		else{
			$data=0;
		}
		$data=array("success"=>$data);
	}
	if($_GET["func"]=="getTheseTickets"){
		$data=getTheseTickets($link,$dbh);
	}
	if($_GET["func"]=="changeAvailable"){
		$data=changeAvailable($link);
	}

	if($_GET["func"]=="getAvailableLignes"){
		$data=getAvailableLignes($link);
	}
	echo json_encode($data);
?>