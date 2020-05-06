<?php

	session_start();			// Debut de session
	
	if ($_SESSION["DateNConfirme"] != "")
	{
		try
		{
			$dbh = new PDO($_SESSION["dsn"], $_SESSION["UserBdd"], $_SESSION["PasswordBdd"]); //Ouvre la connexion avec la base de 
		}
		Catch (PDOExeption $e)
		{
			$ResultatConnxion = False;
			print "erreur :".$e->getMessage()."<br>";
			die();
			session_destroy();
			header("Location: SI_PPE_SLAM_1_QCM_Index.php");
			exit;
			
		}
		
		if(isset($_POST["BoutonFinEpreuve"]))
		{
			$NbPoint = 0;
			
			for($i = 0; $i < $_SESSION["iNbRep"]; $i++)
			{
				$SqlVerifierRep = "SELECT vrai FROM reponse WHERE IdRep = ".$_POST["Reponse".$i];
				
				$Req = $dbh -> prepare($SqlVerifierRep);
				$Req -> execute();
				
				$ResultatVerifRep = $Req -> fetchAll(PDO::FETCH_ASSOC);
				$Req = NULL;
				
				foreach($ResultatVerifRep as $row)
				{
					if ($row["vrai"] == 1)
					{
						$NbPoint = $NbPoint + 1;
					}
				}
			}
			
			$Note = ($NbPoint * 20) / $_SESSION["iNbRep"];
			
			$SqlNoter = "UPDATE realiser SET  Note = ".$Note." WHERE `#IdClasse` = ".$_SESSION["IdClasseEpr"]." AND `#IdEpreuve` = ".$_SESSION["IdEprChoisis"]." AND `#IdEleve` = ".$_SESSION["IdEleveDB"]." AND `#IdDateEpreuve` = ".$_SESSION["IdDateDeLepreuve"];
			$Req = $dbh -> prepare($SqlNoter);
			$Req -> execute();
			$Req = NULL;
			
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
?>