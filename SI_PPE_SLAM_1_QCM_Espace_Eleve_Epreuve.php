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
		
		if(!isset($_POST["BoutonRealiserEpreuve"]))
		{?>
			
			<!DOCTYPE>
			
			<html>
			
				<head>
					
					<meta charset="utf-8" />
					
				</head>
				
				<body>
				
					<?php 
					
						echo "<h1>Bonjour ".$_SESSION["PrenomEleve"]."</h1>";  
					
					?>
					
					<p>
					
						<form method="post" action="SI_PPE_SLAM_1_QCM_Déconnexion.php">
						
							<input type="submit" name="Deconnexion" value="Deconnexion" /><br>
						
						</form>
					
					</p>
					
					<p>
					
					 	<a href="SI_PPE_SLAM_1_QCM_Espace_Eleve_Epreuve.php">Espace Epreuve</a>	<a href="SI_PPE_SLAM_1_QCM_Espace_Note_Eleve.php">Espace Note</a>
						
					</p><br><br>
					
					<form method="post" action="">
					
						<h2>Liste des épreuves :</h2><br>
						
						<p>
						
							<?php
							
								$SqlEpreuveNonRealiser = "SELECT NomEpreuve, IdEpreuve FROM epreuve as Ep, realiser as Re, eleve as El WHERE Re.`#IdEpreuve` = Ep.IdEpreuve AND Re.`#IdEleve` = El.IdEleve AND Re.Note = 21 AND Re.`#IdEleve` = ".$_SESSION["IdEleveDB"];

								$Req = $dbh -> prepare($SqlEpreuveNonRealiser);
								$Req -> execute();
								
								$ResultatSqlEprNonRea = $Req -> fetchAll(PDO::FETCH_ASSOC);
								$ResultatForeach = 0; 
								
								foreach($ResultatSqlEprNonRea as $row)
								{
									$ResultatForeach = 1;
									
									echo '<input type="radio" name="Epreuve" value="'.$row["IdEpreuve"].' '.$row["NomEpreuve"].'" id="'.$row["NomEpreuve"].'" /> <label for="'.$row["NomEpreuve"].'">'.$row["NomEpreuve"].'</label><br>';
									
								}
								
								if ($ResultatForeach == 0)
								{
									echo "Aucune nouvelle épreuve";
								}
								
								$Req = NULL;
								$dbh = NULL;
							?>
							
							<br><br><input type="submit" name="BoutonRealiserEpreuve" value="Realiser Epreuve"/>
							
						</p>
						
					</form>
					
				</body>
				
			</html>
			
		<?php
		}
		else
		{
			if(isset($_POST["BoutonRealiserEpreuve"]))
			{
				if(!empty($_POST["Epreuve"]))
				{?>
					<!DOCTYPE>
			
					<html>
			
						<head>
						
							<meta charset="utf-8" />
						
						</head>
					
						<body>
					
							<?php 
						
								echo "<h1>Bonjour ".$_SESSION["PrenomEleve"]."</h1>";  
						
							?>
						
						
							<form method="post" action="SI_PPE_SLAM_1_QCM_Espace_Eleve_Traitement_Reponse.php">
							
								<p>
								<?php
								
									$l = 0;
									$IdEpreuveEle = $_POST["Epreuve"][$l];
									$l++;
									
									while ($_POST["Epreuve"][$l] != ' ')
									{
										$IdEpreuveEle = $IdEpreuveEle.$_POST["Epreuve"][$l];
										$l++;
									}
									
									$_SESSION["IdEprChoisis"] = $IdEpreuveEle;
									
									$SqlInfoEpreuve = "SELECT IdDateEpreuve, IdClasse, NomEpreuve, NomClasse, DateEpreuve, NomEleve FROM epreuve as Ep, eleve as El, classe as Cl, calendrierepr as Ca, realiser as Re WHERE Ep.IdEpreuve = Re.`#IdEpreuve` AND El.IdEleve = Re.`#IdEleve` AND Ca.IdDateEpreuve = Re.`#IdDateEpreuve` AND Cl.IdClasse = Re.`#IdClasse` AND Re.`#IdEleve` = ".$_SESSION["IdEleveDB"]." AND Re.`#IdEpreuve` = ".$IdEpreuveEle." AND Re.Note = 21"; //Classe date eleve et prof 
									$Req =  $dbh -> prepare($SqlInfoEpreuve); 
									$Req -> execute();
									
									
									$ResultatInfoEpr = $Req -> fetchAll(PDO::FETCH_ASSOC);
									$Req = NULL;
									
									foreach($ResultatInfoEpr as $row)
									{
										$NomDeLaClasse = $row["NomClasse"];
										$DateDeLepreuve = $row["DateEpreuve"];
										$NonEleve = $row["NomEleve"];
										$NomDeLepreuve = $row["NomEpreuve"];
										$_SESSION["IdClasseEpr"] = $row["IdClasse"];
										$_SESSION["IdDateDeLepreuve"] = $row["IdDateEpreuve"];
									}
									
									$_SESSION["IdEpreuveEle"] = $IdEpreuveEle;
									
									echo " Epreuve : ".$IdEpreuveEle."<br>
											Nom de l'épreuve : ".$NomDeLepreuve."<br>
											Date : ".$DateDeLepreuve."  Classe : ".$NomDeLaClasse."<br>
											Nom Eleve : ".$NonEleve."<br><br>";
									
									$SqlQuestionAfficher = "SELECT IntituleQuest, IdQuest FROM constituer as Co, question as Qu WHERE Co.`#IdQuestion` = Qu.IdQuest AND Co.`#IdEpreuve` = ".$IdEpreuveEle;
									
									
									
									$Req = $dbh -> prepare($SqlQuestionAfficher);
									$Req -> execute();
									
									$ResultatAfficherQuestion = $Req -> fetchAll(PDO::FETCH_ASSOC);
									
									$Req = NULL;
									$z = 0;
									foreach($ResultatAfficherQuestion as $row)
									{
										echo $row['IntituleQuest'].'<br>';
										
										$SqlAfficherReponse = "SELECT IdRep, IntituleRep FROM reponse WHERE `#IdQuest` = ".$row['IdQuest'];
										
										$Req = $dbh -> prepare($SqlAfficherReponse);
										$Req -> execute();
										$ResultatSqlAfficherRep = $Req -> fetchAll(PDO::FETCH_ASSOC);
										$Req = NULL;
										
										foreach($ResultatSqlAfficherRep as $row2)
										{
											echo '<input type="radio" name="Reponse'.$z.'" value="'.$row2["IdRep"].'" id="'.$row2["IntituleRep"].'" /> <label for="'.$row2["IntituleRep"].'">'.$row2["IntituleRep"].'</label><br>';
										}
										
										echo"<br><br>";
										$z++;
									}
									
									$_SESSION["iNbRep"] = $z;
									
									echo "<br><br><input type='submit' name='BoutonFinEpreuve' value='Valider le questionnaire'/>";
								
								
								?>
								</p>

							
							</form>
						
						</body>
				
					</html>
			
					<?php
				}
				else
				{
					$dbh = NULL;
					session_write_close();
					header("Location: SI_PPE_SLAM_1_QCM_Espace_Eleve_Epreuve.php");
					exit;
				}
			}
				
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