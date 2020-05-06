<?php
	//echo "<script>alert('ok');</script>";
	session_start();			// Debut de session
	
	$_SESSION["AnnéeScolaireEnCour"] = "2018/2019";
	
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
		
		if (!isset($_POST["BoutonAttributionEpreuve"]) AND  !isset($_POST["BoutonSuprAttributionEpreuve"]))
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
				
						<form method="post" action="SI_PPE_SLAM_1_QCM_Déconnexion.php">
						
							<input type="submit" name="Deconnexion" value="Deconnexion" /><br>
						
						</form>
					
					</p>
					
					<p>
					
						<a href="SI_PPE_SLAM_1_QCM_Espace_Creation_Professeur.php">Espace Création</a>	 <a href="SI_PPE_SLAM_1_QCM_Espace_Attribution_Epreuve_Professeur.php">Espace Epreuve</a>
						
					</p>
					
					<br><br><form method="post" action="">
					
						<h2>Attribuer Epreuve</h2><br>
						
						<p>
						
							Date de l'épreuve* :  
							
							<select name="DateJourEpreuve">
				
								<option value=""></option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
								
							</select> / 
							<select name="DateMoisEpreuve">
								
								<option value=""></option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								
							</select> / <input type="text" name="DateAnneeEpreuve" value="2019" onFocus="javascript:this.value=''"/><br><br>
							
							Nom Epreuve :
							
							<select name="NomsEpreuves">
							
								<?php
								
									$SqlEpreuve = "SELECT NomEpreuve, IdEpreuve FROM epreuve WHERE `#IdProfesseur` = ".$_SESSION["IdProfesseur"];
									
									$Req = $dbh -> prepare($SqlEpreuve);
									$Req -> execute();
									$ResultatSqlEpreuve = $Req -> fetchAll(PDO::FETCH_ASSOC);
									
									foreach($ResultatSqlEpreuve as $row)
									{
										$NomDeLepreuve = $row["NomEpreuve"];
										$IdDeLepreuve = $row["IdEpreuve"];
										
										echo "<option value='".$IdDeLepreuve." ".$NomDeLepreuve."'>".$NomDeLepreuve."</option>";
									}
									
									$Req = NULL;
								?>
							
							</select><br><br>
		
							Classe :
		
							<select name="NomsClasses">
							
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
							
							</select><br>
							
							<br><p>*jj/mm/aaaa</p>
							<p>**Attribuer une épreuve à une classe</p><br><br>
							
							<input type="submit" name="BoutonAttributionEpreuve" value="Attribuer"/>
					
						</p>
					
					</form>
					
					<br><br><form method="post" action="">
					
						<h2>Supprimer les epreuves attribués</h2><br>
						
						<p>
						
							<table border="1px">
							
								<tfoot>
								
									<thead>
									
										<tr>
										
											<th>Nom Epreuve</th>
											<th>Date Epreuve</th>
											<th>Classe</th>
										
										</tr>
									
									</thead>
								
								</tfoot>
								
								<tbody>
								
									<?php
							
										$SqlSuprEpreuve = "SELECT NomEpreuve, DateEpreuve, NomClasse, IdEpreuve, IdDateEpreuve, IdClasse FROM epreuve as Ep, classe as Cl, calendrierepr as Ca, realiser as Re WHERE Ep.IdEpreuve = Re.`#IdEpreuve` AND Re.`#IdClasse` = Cl.IdClasse AND Re.`#IdDateEpreuve` = Ca.IdDateEpreuve AND Ep.`#IdProfesseur` = ".$_SESSION["IdProfesseur"]." AND Re.Note = 21";
										$Req = $dbh -> prepare($SqlSuprEpreuve);
										$Req -> execute();
										
										$ResultatSqlSupr = $Req -> fetchAll(PDO::FETCH_ASSOC);
										
										$_SESSION['iSuprEprev'] = 0;
										foreach($ResultatSqlSupr as $row)
										{
											if(($DateEpreuveAttr != $row['DateEpreuve'] AND $ClasseEpreuve != $row['NomClasse'] OR $NomEpreuve != $row['NomEpreuve']) OR ($ClasseEpreuve != $row['NomClasse'] AND $DateEpreuveAttr != $row['DateEpreuve'] OR $NomEpreuve != $row['NomEpreuve']) OR ($NomEpreuve != $row['NomEpreuve'] AND $DateEpreuveAttr != $row['DateEpreuve'] OR $ClasseEpreuve != $row['NomClasse']))
											{
												$NomEpreuve = $row['NomEpreuve'];
												$DateEpreuveAttr = $row['DateEpreuve'];
												$ClasseEpreuve = $row['NomClasse'];
												$_SESSION["Epr"][$_SESSION['iSuprEprev']] = $row['IdEpreuve'];
												$_SESSION["Cla"][$_SESSION['iSuprEprev']] = $row['IdClasse'];
												$_SESSION["Dat"][$_SESSION['iSuprEprev']] = $row['IdDateEpreuve'];
												
												echo "<tr>
									
													<td>".$NomEpreuve."</td>
													<td>".$DateEpreuveAttr."</td>
													<td>".$ClasseEpreuve."</td>
													<td><input type='checkbox' name='Suppr".$_SESSION['iSuprEprev']."'/></td>	
											
												</tr>"; 
												
												$_SESSION['iSuprEprev'] = $_SESSION['iSuprEprev'] + 1;
											}	
										}
										
										$Req = NULL;
										$dbh = NULL;
										
									?>
								
								</tbody>
								
							</table>
							
							<br><br><input type="submit" name="BoutonSuprAttributionEpreuve" value="Supprimer"/>
							
						</p>
					
					</form>
					
				</body>
			
			</html>
			
		<?php
		}
		else
		{
			if(isset($_POST["BoutonAttributionEpreuve"]))
			{
				if (!empty($_POST["DateJourEpreuve"]) AND !empty($_POST["DateMoisEpreuve"]) AND !empty($_POST["DateAnneeEpreuve"]) AND !empty($_POST["NomsEpreuves"]))
				{
					$dateAMJ = $_POST["DateAnneeEpreuve"].'-'.$_POST["DateMoisEpreuve"].'-'.$_POST["DateJourEpreuve"];
					$SqlCalendrEpr = "INSERT INTO calendrierepr (DateEpreuve) Value ('".$dateAMJ."')";
					
					$Req = $dbh -> prepare($SqlCalendrEpr);
					$Req -> execute();
					
					$IdDateEpr = $dbh -> lastInsertId();
					
					$Req = NULL;
						
					$i = 0;
					$IdEpr = $_POST["NomsEpreuves"][$i];
					$i++;
					
					while ($_POST["NomsEpreuves"][$i] != ' ')
					{
						$IdEpr = $IdEpr.$_POST["NomsEpreuves"][$i];
						$i = $i + 1;	
					}
					
					$i = 0;
					$IdCla = $_POST["NomsClasses"][$i];
					$i++;
					
					while ($_POST["NomsClasses"][$i] != ' ')
					{
						$IdCla = $IdCla.$_POST["NomsClasses"][$i];
						$i = $i + 1;
					}
					
					$SqlIdEleve = "SELECT IdEleve FROM eleve as El, accueillir as Ac WHERE El.IdEleve = Ac.`#IdEleve` AND Ac.`#IdClasse` = ".$IdCla;
					
					$Req = $dbh -> prepare($SqlIdEleve);
					$Req -> execute();
					$ResultatIdEleSql = $Req ->fetchAll(PDO::FETCH_ASSOC);
					
					$Req = NULL;
					
					$i = 0;
					$SqlRealiserEpr ="";
					foreach($ResultatIdEleSql as $row)
					{
						if ($i != 0)
						{
							$SqlRealiserEpr = $SqlRealiserEpr.", ";
						}
						else 
						{
							$SqlRealiserEpr = "INSERT INTO realiser (`#IdClasse`, `#IdEpreuve`, `#IdDateEpreuve`, `#IdEleve`, Note) Values ";
						}
						
						$SqlRealiserEpr = $SqlRealiserEpr."(".$IdCla.", ".$IdEpr.", ".$IdDateEpr.", ".$row['IdEleve'].", 21)";
						
						$i = $i + 1;
					}
					
					$Req = $dbh -> prepare($SqlRealiserEpr);
					$Req -> execute();
					
					$Req = NULL; 
					
					$dbh = NULL;
					session_write_close();
					header("Location: SI_PPE_SLAM_1_QCM_Espace_Attribution_Epreuve_Professeur.php");
					exit;
				
				}
				else
				{
					$dbh = NULL;
					session_write_close();
					header("Location: SI_PPE_SLAM_1_QCM_Espace_Attribution_Epreuve_Professeur.php");
					exit;
				}
			}
			else
			{	
				for($j = 0; $j < ($_SESSION['iSuprEprev'] + 1); $j++)
				{
					if(isset($_POST['Suppr'.$j]))
					{
						$SqlSuprEprRealiser = 'DELETE FROM realiser WHERE `#IdEpreuve` = '.$_SESSION["Epr"][$j].' AND `#IdClasse` = '.$_SESSION["Cla"][$j].' AND `#IdDateEpreuve` = '.$_SESSION["Dat"][$j];
						$SqlSuprEprDate = 'DELETE FROM calendrierepr WHERE IdDateEpreuve = '.$_SESSION["Dat"][$j];
						
						$Req = $dbh -> prepare($SqlSuprEprRealiser);
						$Req -> execute();
						$Req = NULL;
						
						$Req = $dbh -> prepare($SqlSuprEprDate); 
						$Req -> execute();
						$Req = NULL; 
					}
				}
				
				$dbh = NULL;
				session_write_close();
				header("Location: SI_PPE_SLAM_1_QCM_Espace_Attribution_Epreuve_Professeur.php");
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