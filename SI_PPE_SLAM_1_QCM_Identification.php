<?php

	session_start();			// Debut de session
	
	$_SESSION["UserBdd"] = "QCM";
	$_SESSION["PasswordBdd"] = "Mt140796//";
	$_SESSION["dsn"] = "mysql:host=localhost;dbname=ppe_qcm_1";    //Creer Data Source name
	
	if ( isset($_POST["BoutonConnexionProf"]) )
	{	
		if ( !empty($_POST["NomProf"]) AND !empty($_POST["PassWProf"])  )
		{
			$ResultatConnxion = True;
			$_SESSION["MDPConfirme"] = ""; //Variable qui va recuperer le mot de passe du professuer qui se connecte
			$_SESSION["NomProfesseur"] = $_POST["NomProf"];
			$_SESSION["PassWProfesseur"] = $_POST["PassWProf"];
			
			try
			{
				$dbh = new PDO($_SESSION["dsn"], $_SESSION["UserBdd"], $_SESSION["PasswordBdd"]); //Ouvre la connexion avec la base de 
			}
			Catch (PDOExeption $e)
			{
				$ResultatConnxion = False;
				print "erreur :".$e->getMessage()."<br>";
				die();
				//session_write_close();
				//header("Location: SI_PPE_SLAM_1_QCM_Index.php");
				//exit;
				
			}
		
			if($dbh != NULL AND $ResultatConnxion != False)
			{
				$Sql = "SELECT MotDePasse, IdProf FROM professeur WHERE NomProf = :NomProf";
				$Req = $dbh->prepare($Sql); 
				
				if ($Req != NULL)
				{
					$Req->bindValue(':NomProf', $_SESSION["NomProfesseur"]);
					$Req->execute();							
								
					$ResultatSql = $Req->fetchAll(PDO::FETCH_ASSOC);
					
					foreach ($ResultatSql as $row)
					{
						$_SESSION["MDPConfirme"] = $row['MotDePasse'];
						$_SESSION["IdProfesseur"] = $row["IdProf"];
						
						if ($row['MotDePasse'] != $_SESSION["PassWProfesseur"])
						{
							$_SESSION["MDPConfirme"] = "";
							$_SESSION["IdProfesseur"] = "";
						}
						else
						{
							break;
						}
					}	
					
					$Req = NULL;
					
					if ($_SESSION["MDPConfirme"] != "")
					{
						$dbh = NULL;
						session_write_close();
						header("Location: SI_PPE_SLAM_1_QCM_Espace_Creation_Professeur.php");
						exit;
					}
					else
					{
						$dbh = NULL;
						session_destroy();
						header("Location: SI_PPE_SLAM_1_QCM_Index.php");
						exit;
					}
				}
				else
				{
					$dbh = NULL;
					session_destroy();
					header("Location: SI_PPE_SLAM_1_QCM_Index.php");
					exit;
				}
			}
			else
			{
				$dbh = NULL;
				session_destroy();
				header("Location: SI_PPE_SLAM_1_QCM_Index.php");
				exit;
			}
		}
		else
		{
			$dbh = NULL;
			session_destroy();
			header("Location: SI_PPE_SLAM_1_QCM_Index.php");
			exit;
		}
	}
	elseif(isset($_POST["BoutonConnexionEleve"]))
	{
		$ResultatConnxion = 1;
		try
		{
			$dbh = new PDO($_SESSION["dsn"], $_SESSION["UserBdd"], $_SESSION["PasswordBdd"]); //Ouvre la connexion avec la base de 
		}
		Catch (PDOExeption $e)
		{
			$ResultatConnxion = 0;
			print "erreur :".$e->getMessage()."<br>";
			die();
		}
		
		if($dbh != NULL AND $ResultatConnxion != 0)
		{
			$_SESSION["PseudoDeLeleve"] = $_POST["NomEleve"];
			$_SESSION["DateNEntrer"] = $_POST["DateJourEleve"]." ".$_POST["DateMoisEleve"]." ".$_POST["DateAnneeEleve"];
			
			$_SESSION["DateNConfirme"] = "";
			
			$SqlConnexionEle = "SELECT PrenomEleve, IdEleve, JourNaissance, MoisNaissance, AnneeNaissance FROM eleve WHERE PseudoEle = '".$_SESSION["PseudoDeLeleve"]."'";
			
			$Req = $dbh -> prepare($SqlConnexionEle);
			$Req -> execute();
			
			$ResultatSqlConEle = $Req -> fetchAll(PDO::FETCH_ASSOC);
			$Req = NULL;
			
			foreach($ResultatSqlConEle as $row)
			{
				$_SESSION["DateNConfirme"] = $row["JourNaissance"]." ".$row["MoisNaissance"]." ".$row["AnneeNaissance"];
				$_SESSION["IdEleveDB"] = $row["IdEleve"];
				$_SESSION["PrenomEleve"] = $row["PrenomEleve"];

				if($_SESSION["DateNConfirme"] != $_SESSION["DateNEntrer"])
				{
					$_SESSION["DateNConfirme"] = "";
					$_SESSION["IdEleveDB"] = "";
					$_SESSION["PrenomEleve"] = "";
				}
				else
				{
					break;
				}
			}
			
			if ($_SESSION["DateNConfirme"] != "")
			{
				$dbh = NULL;
				session_write_close();
				header("Location: SI_PPE_SLAM_1_QCM_Espace_Eleve_Epreuve.php");
				exit;
			}
			else
			{
				$dbh = NULL;
				session_destroy();
				header("Location: SI_PPE_SLAM_1_QCM_Index.php");
				exit;
				
			}
		}	
		else
		{
			$dbh = NULL;
			session_destroy();
			header("Location: SI_PPE_SLAM_1_QCM_Index.php");
			exit;
			
		}
	}
	else
	{
		$dbh = NULL;
		session_destroy();
		header("Location: SI_PPE_SLAM_1_QCM_Index.php");
		exit;
	}
?>