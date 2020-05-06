<?php

	if(isset($_SESSION["MDPConfirme"]))
	{
		$_SESSION["MDPConfirme"] = "";
		$_SESSION["NomProfesseur"] = "";
		$_SESSION["PassWProfesseur"] = "";
		$_SESSION["IdProfesseur"] = "";
		$_SESSION["iQuestionEpreuve"] = "";
		$_SESSION['iSuprEprev'] = "";
		$_SESSION["Epr"] = "";
		$_SESSION["Cla"] = "";
		$_SESSION["Dat"] = "";
	}
	elseif(isset($_SESSION["DateNConfirme"]))
	{
		$_SESSION["PseudoDeLeleve"] = "";
		$_SESSION["DateNConfirme"] = "";
		$_SESSION["DateNEntrer"] = "";
		$_SESSION["IdEleveDB"] = "";
		$_SESSION["PrenomEleve"] = "";
	}
	else
	{
		session_destroy();
		header("Location: SI_PPE_SLAM_1_QCM_Index.php");
		exit;
	}
	
	$_SESSION["dsn"] = "";
	$_SESSION["PasswordBdd"] = "";
	$_SESSION["UserBdd"] = "";
	$_SESSION["AnnéeScolaireEnCour"] = "";


	session_destroy();
	header("Location: SI_PPE_SLAM_1_QCM_Index.php");
	exit;
?>