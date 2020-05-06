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
		
		if(!isset($_POST["CreerEpreuve"]) AND  !isset($_POST["CreerQuestions"]))
		{	
		?>
			
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
					
						<form method="post" action="SI_PPE_SLAM_1_QCM_Déconnexion.php">
						
						<input type="submit" name="Deconnexion" value="Deconnexion" /><br>
						
						</form>
					
					</p>
					
					<p>
					
						<a href="SI_PPE_SLAM_1_QCM_Espace_Creation_Professeur.php">Espace Création</a> 	<a href="SI_PPE_SLAM_1_QCM_Espace_Attribution_Epreuve_Professeur.php">Espace Epreuve</a>
						
					
					</p>
				
					<br><br><form method="post" action="">
					
						<h2>Création Epreuve</h2><br>
					
						<p>
							
							<input type="text" name="NomEpreuve" value="NomEpreuve" onFocus="javascript:this.value=''"/><br>
							
							<h3>Questions : </h3>
							
							<?php
							
								if ($dbh != NULL)											
								{
									$Sql = "SELECT * FROM question";
									$Req = $dbh -> prepare($Sql);
									$Req -> execute();
									$ResultatSql = $Req ->fetchAll(PDO::FETCH_ASSOC);
									
									
									$NomCheckbox = "CaseChoixQuestion";
									$_SESSION["iQuestionEpreuve"]=0;
									
									foreach($ResultatSql as $row)
									{	
										if ($_SESSION["iQuestionEpreuve"]%2 == 0)
										{	
											echo "<br><br>";
										}
										$NomCheckbox = $NomCheckbox.$_SESSION["iQuestionEpreuve"]; // Modifier : Nom + IdQuest
										$IDQuest = $row['IdQuest'];
										$Question = $row['IntituleQuest'];	
										
										echo "<input type='checkbox' name='".$NomCheckbox."' id='".$NomCheckbox."' value='".$IDQuest.' '.$Question."'/> <label for='".$NomCheckbox."'>".$Question."</label>";											
										$NomCheckbox = "CaseChoixQuestion";
										$_SESSION["iQuestionEpreuve"] = $_SESSION["iQuestionEpreuve"] + 1;
									}
								}				
							?>
							
							<br><br><br><input type="submit" name="CreerEpreuve" value="Créer Epreuve"/><br>			
						
						</p>
						
					
					</form><br><br>
					
					<form method="post" action="">
					
						<h2>Création Question</h2><br>
						
						<p>
						
							<p>
								
								<input type="text" name="CreationQuestion1" value="Taper votre question" onFocus="javascript:this.value=''"/>		
								<input type="checkbox" name="CaseReponse1" /> <input type="text" name="CreationReponse1" value="Reponse 1" onFocus="javascript:this.value=''"/>
								<input type="checkbox" name="CaseReponse2" /> <input type="text" name="CreationReponse2" value="Reponse 2" onFocus="javascript:this.value=''"/>
								<input type="checkbox" name="CaseReponse3" /> <input type="text" name="CreationReponse3" value="Reponse 3" onFocus="javascript:this.value=''"/>
								<input type="checkbox" name="CaseReponse4" /> <input type="text" name="CreationReponse4" value="Reponse 4" onFocus="javascript:this.value=''"/>				
							
							</p><br>
							
							<p>
								
								<input type="text" name="CreationQuestion2" value="Taper votre question" onFocus="javascript:this.value=''"/>		
								<input type="checkbox" name="CaseReponse5" /> <input type="text" name="CreationReponse5" value="Reponse 1" onFocus="javascript:this.value=''"/>
								<input type="checkbox" name="CaseReponse6" /> <input type="text" name="CreationReponse6" value="Reponse 2" onFocus="javascript:this.value=''"/>
								<input type="checkbox" name="CaseReponse7" /> <input type="text" name="CreationReponse7" value="Reponse 3" onFocus="javascript:this.value=''"/>
								<input type="checkbox" name="CaseReponse8" /> <input type="text" name="CreationReponse8" value="Reponse 4" onFocus="javascript:this.value=''"/>				
							
							</p><br>
							
							<p>
								
								<input type="text" name="CreationQuestion3" value="Taper votre question" onFocus="javascript:this.value=''"/>		
								<input type="checkbox" name="CaseReponse9" /> <input type="text" name="CreationReponse9" value="Reponse 1" onFocus="javascript:this.value=''"/>
								<input type="checkbox" name="CaseReponse10" /> <input type="text" name="CreationReponse10" value="Reponse 2" onFocus="javascript:this.value=''"/>
								<input type="checkbox" name="CaseReponse11" /> <input type="text" name="CreationReponse11" value="Reponse 3" onFocus="javascript:this.value=''"/>
								<input type="checkbox" name="CaseReponse12" /> <input type="text" name="CreationReponse12" value="Reponse 4" onFocus="javascript:this.value=''"/>				
							
							</p><br>
							<p>*Si une ligne n'est pas remplie entièrement, elle ne sera pas enregistrée</p>
							<br><br> <p>**Cocher la case réponse qui est solution de la question</p><br><br>
							
							<input type="submit" name="CreerQuestions" value="Créer Questions"/>
						
						</p>
					
					</form>
				
				</body>

			</html>
					
			<?php
			$Req= NULL;
			$dbh = NULL;
	
		} 
		else
		{				
			if (isset($_POST["CreerEpreuve"])) //Ajouter une épreuve dans la base de donnée
			{
				$CaseNonCocher = 0;
				$NomCheckbox = "CaseChoixQuestion";
				$k=0;
				for($j=0; $j < $_SESSION["iQuestionEpreuve"]; $j++)
				{
					if (isset($_POST["CaseChoixQuestion".$j]))
					{
						$l=0;
						$TabIdEpreuve[$k] = $_POST["CaseChoixQuestion".$j][$l];
						$l++;
						
						while ($_POST["CaseChoixQuestion".$j][$l] != ' ')
						{
							$TabIdEpreuve[$k] = $TabIdEpreuve[$k].$_POST["CaseChoixQuestion".$j][$l];
							$l = $l + 1;
						}
						
						 
						$k = $k + 1;
						$CaseNonCocher = 1;
					}
				}
				if ($CaseNonCocher == 1) 
				{
					if(!empty($_POST["NomEpreuve"]))
					{
						$SqlAjoutEpreuve = 'INSERT INTO epreuve(NomEpreuve, `#IdProfesseur`) VALUE ("'.$_POST["NomEpreuve"].'", '.$_SESSION["IdProfesseur"].')';
						$Req = $dbh -> prepare($SqlAjoutEpreuve);
						$Req -> execute();
						$IdCreationEpreuve = $dbh -> lastInsertId(); 
						$Req = NULL;
						$SqlEprevQuest = 'INSERT INTO constituer(`#IdEpreuve`, `#IdQuestion`, RangQuest) VALUES ';
						
						for($j = 0; $j < $k; $j++)
						{
							if ($j!=0)
							{
								$SqlEprevQuest = $SqlEprevQuest.', ';
							}
							
							$SqlEprevQuest = $SqlEprevQuest.'('.$IdCreationEpreuve.', '.$TabIdEpreuve[$j].', '.($j+1).')';

						}
						$Req = $dbh -> prepare($SqlEprevQuest);
						$Req -> execute();
						$Req = NULL;
						$dbh = NULL;
						session_write_close();
						header("Location: SI_PPE_SLAM_1_QCM_Espace_Creation_Professeur.php");
						exit;
					}
					else
					{
						$dbh = NULL;
						session_write_close();
						header("Location: SI_PPE_SLAM_1_QCM_Espace_Creation_Professeur.php");
						exit;
					}
				}
				else
				{
					$dbh = NULL;
					session_write_close();
					header("Location: SI_PPE_SLAM_1_QCM_Espace_Creation_Professeur.php");
					exit;
				}
			}
			else
			{	
				for ($j = 1; $j < 4; $j++)
				{
					$ResultatVideQuestion = 1;
					
					if(!empty($_POST["CreationQuestion".$j]) )
					{
						$ResultatVideReponse = 1;
						
						if ($j == 1)
						{
							$rep = 1;
							$repp = 1;
						}
						elseif ($j == 2)
						{
							$rep = 5;
							$repp = 5;
						}
						else
						{
							$rep = 9;
							$repp = 9;
						}
						
						for($l = 1; $l < 5; $l++)
						{
							if(empty($_POST["CreationReponse".$rep]) OR $_POST["CreationReponse".$rep] == ("Reponse ".$l))
							{
								$ResultatVideReponse = 0;
								break;								
							}
							
							$rep = $rep + 1;
						}
						
						$ResultatVideCase = 0;
						for($l = 1; $l < 5; $l++)
						{
							
							if( isset($_POST["CaseReponse".$repp]))
							{
								if($ResultatVideCase == 0)
								{
									$ResultatVideCase = 1;
								}
								else
								{
									$ResultatVideCase = 2;
								}
								
							}
							$repp = $repp + 1;
						}
						
						
						if($ResultatVideReponse == 0 OR $ResultatVideCase == 0 OR $ResultatVideCase == 2)
						{
							$ResultatVideQuestion = 0;
						}
					}
					else
					{
						$ResultatVideQuestion = 0;
						
					}
					
					if($ResultatVideQuestion == 0)
					{
						
						$dbh = NULL;
						session_write_close();
						header("Location: SI_PPE_SLAM_1_QCM_Espace_Creation_Professeur.php");
						exit;
					}
					else
					{
						
						$SqlCreationQuestion = 'INSERT INTO question(IntituleQuest) VALUE ("'.$_POST["CreationQuestion".$j].'")';

						$Req = NULL;
						$Req = $dbh -> prepare($SqlCreationQuestion);
						$Req -> execute();
						

						$idCreationQuest = $dbh -> lastInsertId();
						$Req = NULL;

						
						if ($j == 1)
						{
							$rep = 1;
						}
						elseif ($j == 2)
						{
							$rep = 5;
						}
						else
						{
							$rep = 9;
						}
						$SqlCreationReponse = 'INSERT INTO reponse(IntituleRep, vrai, `#IdQuest`) VALUES ';
						for($l = 0; $l < 4; $l++)
						{
							if ($l != 0)
							{
								$SqlCreationReponse = $SqlCreationReponse.', ';
							}
							
							$SqlCreationReponse = $SqlCreationReponse.'("'.$_POST["CreationReponse".$rep];
							
							if (isset($_POST["CaseReponse".$rep]))
							{
								$SqlCreationReponse = $SqlCreationReponse.'", 1, ';
								
							}
							else
							{
								$SqlCreationReponse = $SqlCreationReponse.'", 0, ';
								
							}
							$SqlCreationReponse = $SqlCreationReponse.$idCreationQuest.')';

							$rep = $rep + 1;
						}
						
						$Req = $dbh -> prepare($SqlCreationReponse);
							
						$Req -> execute();
						$Req = NULL;
						
					}

				}
				$dbh = NULL;
				session_write_close();
				header("Location: SI_PPE_SLAM_1_QCM_Espace_Creation_Professeur.php");
				exit;
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