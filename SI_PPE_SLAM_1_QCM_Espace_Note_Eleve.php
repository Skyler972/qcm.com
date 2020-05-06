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
		
		?>
			
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
					
					
					<h2>Notes :</h2><br>
					
					<p>
						
						<table border="1px">
						
							<tfoot>
							
								<thead>
								
									<tr>
									
										<th>Nom Epreuve</th>
										<th>Date Epreuve</th>
										<th>Note</th>
									
									</tr>
								
								</thead>
							
							</tfoot>
							
							<tbody>
							
								<?php
						
									$SqlAfficherNote = "SELECT NomEpreuve, DateEpreuve, Note FROM epreuve as Ep, calendrierepr as Ca, realiser as Re WHERE Ep.IdEpreuve = Re.`#IdEpreuve` AND Ca.IdDateEpreuve = Re.`#IdDateEpreuve` AND Re.Note <> 21 AND Re.`#IdEleve` = ".$_SESSION["IdEleveDB"];
									
									$Req = $dbh -> prepare($SqlAfficherNote);
									$Req -> execute();
									
									$ResultatSqlAfficherNote = $Req -> fetchAll(PDO::FETCH_ASSOC);
									$Moy = 0;
									
									foreach($ResultatSqlAfficherNote as $row)
									{
										echo "<tr>
									
													<td>".$row["NomEpreuve"]."</td>
													<td>".$row["DateEpreuve"]."</td>
													<td>".$row["Note"]."</td>
													
												</tr>"; 
												
												$Moy = $Moy + $row["Note"];
												
												
									}
									
									echo "<tr>
									
												<td colspan='3' align='center'>Moyenne : ".$Moy."/20</td>
												
											</tr>";
											
											//<tr>
											
												//<td colspan='3'>Moyenne Classe: ".
									
									$Req = NULL;
									
									/*$SqlMoyenneClasse = 'SELECT
																IdEleve, MOY(Note)	
														 FROM
																eleve as El, realiser as Re
														 WHERE
																El.IdEleve = Re.`#IdEleve`
														 AND
																El.IdEleve IN (SELECT 
																						`#IdEleve`
																				FROM	
																						realiser
																				WHERE
																						Note <> 21)
																			';*/
									$dbh = NULL;
									
								?>
							
							</tbody>
							
						</table>
						
					</p>
					
				</body>
				
			</html>
	<?php
	}
	else
	{
		$dbh = NULL;
		session_destroy();
		header("Location: SI_PPE_SLAM_1_QCM_Index.php");
		exit;
	}
	
?>