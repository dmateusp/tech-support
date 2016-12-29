<?php
	//DB Connection-------------------------------------
	$HOST="172.17.0.1";
	$DATABASE_NAME = "support-technique";
	$USERNAME = "root";
	$PASSWORD = "YOURPASSWORD";//

	$link = mysqli_connect($HOST,$USERNAME,$PASSWORD,$DATABASE_NAME) or die("Error " . mysqli_error($link)); 
	mysqli_set_charset($link, 'utf8');	
	try{
		$dbh = new PDO("mysql:host=".$HOST.";dbname=".$DATABASE_NAME, $USERNAME, $PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	}
	catch (PDOException $e) {
	    print "Error !: " . $e->getMessage() . "<br/>";
	    die();
	}

	function connection($dbh){
		if(!isset($_POST['username']))
		{
			$_POST['username']='';
			$_POST['password']='';
		}
		$sql = $dbh->prepare("SELECT idutilisateur FROM utilisateur WHERE login="."'".$_POST["username"]."'"." AND password="."'".sha1($_POST["password"])."'");
		$sql->execute();
		$result =$sql->fetchColumn();
		if($result==false){
			return 0;
		}
		else{
			return $result;
		}

	}

	function getAllHotelitems($link,$dbh){
		if(!isset($_POST['itemNameLike'])||$_POST['itemNameLike']=='')
		{
			$sth = $link->query("SELECT * FROM hotelitem ORDER BY name ASC");
		}
		else{
			$sth = $link->query("SELECT * FROM hotelitem WHERE name LIKE '%".$_POST['itemNameLike']."%'  ORDER BY name ASC");

		}
		$rows=array();
		while($row = mysqli_fetch_assoc($sth)) { 
		  array_push($rows,$row);
 
		} /*
		$rows = array('name');
		while($r = mysqli_fetch_assoc($sth)) {
		    $rows[] = $r;
		}*/


		return $rows;
	}
	function createTicket($dbh){
		$statut = "créé";
		$sth = $dbh->prepare("INSERT INTO ticketsupport(statut,description,lieu,idutilisateurDemande,idhotelitem) VALUES(:statut,:description,:lieu,:idutilisateurDemande,:idhotelitem)");
		$sth->bindParam(':statut',$statut);
		$sth->bindParam(':description',$_POST['description']);
		$sth->bindParam(':lieu',$_POST['lieu']);
		$sth->bindParam(':idutilisateurDemande',$_POST['idutilisateurDemande']);
		$sth->bindParam(':idhotelitem',$_POST['idhotelitem']);

		//ENVOI DE MAIL
		if($sth->execute()){
			//Requete pour récupérer les initiales du demandeur
			$resultats=$dbh->prepare("SELECT DISTINCT u.initiale,h.name FROM utilisateur u JOIN ticketsupport t ON u.idutilisateur=t.idutilisateurDemande JOIN hotelitem h ON h.idhotelitem=t.idhotelitem WHERE t.idutilisateurDemande='".$_POST['idutilisateurDemande']."'");
			$resultats->execute();
			$results = $resultats->fetchAll();
			/*
			include_once('Mail.php');
			include_once('Mail/mime.php');
			$crlf = "\n";
			$from = "Support technique <support_technique@shgeneva.ch>";
			$to = "Service technique <example@gmail.com>"; //CHANGE MAIL HERE
			$subject = "Demande numéro ".$dbh->lastInsertId();
			
			$text = "Initiales demandeur".$results[0]['initiale']."
			\n\nDescription : ".$_POST['description']."
			\n\nLieu : ".$_POST['lieu']."
			\n\nObjet : ".$results[0]['name'];
			$html = '<html>
			<body>
			<p>
			Initiales demandeur : <b>'.$results[0]['initiale'].'</b>
			</p>
			<p>
			Lieu : <b>'.$_POST['lieu'].'</b>
			</p>
			<p>
			Objet : <b>'.$results[0]['name'].'</b>
			</p>
			<p>
			Description : <b>'.$_POST['description'].'</b>
			</p>
			<a href="http://212.243.48.10/support_technique/">Aller à l\'application</a>
			<p><i> Envoyé par l\'application mobile.</i> </p>
			</p>
			</body>
			</html>';
			
			$host = "smtp.fastnet.ch";
			$username = "support_technique@shgeneva.ch";
			$password = "sh_linux2728";

			$mime = new Mail_mime(array('eol' => $crlf,
								"text_charset" => "utf-8",
	                            "html_charset" => "utf-8"));
			$mime->setTXTBody($text);
			$mime->setHTMLBody($html);

			$body = $mime->get();
			$headers = array ('From' => $from,   'To' => $to,   'Subject' => $subject);
			foreach ($headers as $name => $value){
			    $headers[$name] = $mime->encodeHeader($name, $value, "utf-8",
			                                                           "quoted-printable");
			}
			$hdrs = $mime->headers($headers);

			$smtp=Mail::factory('smtp',   array ('host' => $host,     'auth' => true,     'username' => $username, 'password' => $password, 'Content-Type: text/html; charset=UTF-8'));
			$mail = $smtp->send($to, $hdrs, $body);

			if (PEAR::isError($mail)) {
			  echo("<p>" . $mail->getMessage() . "</p>");
			}*/

			return true;
		}
		else{
			return false;
		}
 
	}

	function getTheseTickets($link,$dbh){
		$queryString = "SELECT t.statut,h.name, h.imagesource FROM ticketsupport t 
			JOIN hotelitem h on h.idhotelitem = t.idhotelitem 
			WHERE idutilisateurDemande='".$_POST['idUser']."' ";
		if(isset($_POST['onlyCreated'])){
			if($_POST['onlyCreated']){
				$queryString .= "AND statut = 'créé' ";
			}
		}
		$sth = $link->query($queryString);

		$rows=array();
		while($row = mysqli_fetch_assoc($sth)) { 
		  array_push($rows,$row);
 
		} 
		return $rows;
	}
	function changeAvailable($link){
		$queryString = "UPDATE ligne set available=".$_POST['available']." WHERE id=".$_POST['idligne'];
		$sth = $link->query($queryString);
		return 1;
	}
	function getAvailableLignes($link){
		$queryString = "
			SELECT ligne.id, ligne.name,'0' AS avoid
			FROM ligne
			LEFT JOIN travailinterne t
			ON ligne.id = t.idligne
			WHERE ligne.id NOT IN(
			    SELECT l.id
			    FROM `ligne` l
			    JOIN travailinterne t
			    ON l.id = t.idligne
			    WHERE ((t.dateDebut BETWEEN '".$_POST['dateDebut']."' - INTERVAL 1 DAY AND '".$_POST['dateFin']."' + INTERVAL 1 DAY )
			    OR (t.dateFin BETWEEN '".$_POST['dateDebut']."' - INTERVAL 1 DAY AND '".$_POST['dateFin']."' + INTERVAL 1 DAY )
			    OR (t.dateDebut <= '".$_POST['dateDebut']."' - INTERVAL 1 DAY AND t.dateFin>='".$_POST['dateFin']."' + INTERVAL 1 DAY ))
			    AND (t.idligne<>'".$_POST['id']."')
			)
		";
		$rows=array();
		$sth = $link->query($queryString);
		while($row = mysqli_fetch_assoc($sth)) { 
		  array_push($rows,$row);
		} 
		$queryString = "
			SELECT DISTINCT ligne.id, ligne.name, '1' AS avoid
			FROM ligne
			LEFT JOIN travailinterne t
			ON ligne.id = t.idligne
			WHERE ligne.id IN(
			    SELECT l.id
			    FROM `ligne` l
			    JOIN travailinterne t
			    ON l.id = t.idligne
			    WHERE ((t.dateFin BETWEEN '".$_POST['dateDebut']."' - INTERVAL 1 DAY AND '".$_POST['dateDebut']."')
			    OR (t.dateDebut BETWEEN '".$_POST['dateFin']."' AND '".$_POST['dateFin']."' + INTERVAL 1 DAY )
			))
		";

		$sth2 = $link->query($queryString);
		while($row = mysqli_fetch_assoc($sth2)) { 
		  array_push($rows,$row);
		} 


		return $rows;
	}

?>
