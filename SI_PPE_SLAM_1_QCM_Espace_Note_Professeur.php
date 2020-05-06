<?php

	session_start();			// Debut de session
	
	
	if ($_SESSION["MDPConfirme"] != "")
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
		
		if (!isset($_POST["BoutonNoteClasse"]))
		{?>
			<!DOCTYPE>
			
			<html>
			
				<head>
					
					<meta charset="utf-8" />
					
				</head>
				
				<body>
				
					<?php 
					
						$NomProfConnecté  = $_SESSION["NomProfesseur"]; //Recuperer Valeur dans la base de donnée
						echo "<h1>Bonjour profésseur ".$NomProfConnecté."</h1>";  
					
					?>
					
					<p>
					
						<a href="SI_PPE_SLAM_1_QCM_Espace_Creation_Professeur.php">Espace Création</a>	<a href="SI_PPE_SLAM_1_QCM_Espace_Note_Professeur.php">Espace Note</a> 	<a href="SI_PPE_SLAM_1_QCM_Espace_Attribution_Epreuve_Professeur.php">Espace Epreuve</a>
						
					</p><br><br>
					
					<form method="post" action="">
					
						<h2>Note des élèves</h2><br>
					
						<p>
						
							Sélectionner une classe :
						
							<select name="ClassesNotes">
							
								<?php
					
									$SqlNomClasse = "SELECT NomClasse, IdClasse FROM classe WHERE AnneeScolaire = '".$_SESSION["AnnéeScolaireEnCour"]."'";
									
									$Req = $dbh -> prepare($SqlNomClasse);
									$Req -> execute();
									$ResultatSqlClasse = $Req ->fetchAll(PDO::FETCH_ASSOC);
									
									foreach($ResultatSqlClasse as $row)
									{
										$NomDesClasses = $row["NomClasse"]; 
										$IdDesClasses = $row["IdClasse"];
										
										echo "<option value='".$IdDesClasses." ".$NomDesClasses."'>".$NomDesClasses."</option>";
									}
									
								?>
							
							</select>
							
							<br><br><input type="submit" name="BoutonNoteClasse" value="Voir Notes"/>
							
						</p>

					</form>
					
				</body>
				
			</html>
			
		<?php
		}
		else
		{
			$SqlNoteClasseEleve = "SELECT NomEleve, Note FROM eleve as El, realiser as Re WHERE Re.Note <> 21 ORDER BY Re.Note DESC LIMIT 3";
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