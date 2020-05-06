<!DOCTYPE>

<html>

	<head>
	
		<meta charset="utf-8">
	
	</head>
	
	<body>
	
		<form method="post" action="SI_PPE_SLAM_1_QCM_Identification.php">
			
			<h1>Espace Professeur</h1><br>
			
			<p>
			
				Nom : <input type="text" name="NomProf" /><br>
				Mot de passe : <input type="password" name="PassWProf" /><br>
				<input type="submit" name="BoutonConnexionProf" value="Valider"/>
			
			</p>
			
		
		</form>
		
		<br><br>
		
		<form method="post" action="SI_PPE_SLAM_1_QCM_Identification.php">
		
			<h1>Espace Eleve</h1><br>
			
			<p>
			
				Pseudo : <input type="text" name="NomEleve" /><br>
				Date de naissance : <select name="DateJourEleve">
				
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
									<select name="DateMoisEleve">
									
										<option value="Janvier">Janvier</option>
										<option value="Fevrier">Fevrier</option>
										<option value="Mars">Mars</option>
										<option value="Avril">Avril</option>
										<option value="Mai">Mai</option>
										<option value="Juin">Juin</option>
										<option value="Juillet">Juillet</option>
										<option value="Aout">Aout</option>
										<option value="Septembre">Septembre</option>
										<option value="Octobre">Octobre</option>
										<option value="Novembre">Novembre</option>
										<option value="Decembre">Decembre</option>
									
									</select> / <input type="text" name="DateAnneeEleve" /><br>
									
				<input type="submit" name="BoutonConnexionEleve" value="Valider" />
			
			</p>
		
		</form>
	
	</body>

</html>