<?php

require 'Sessao.php';
require 'erros.php';
require 'model/User.php';
require 'model/Project.php';
require 'model/Task.php';
require 'model/Requirement.php';
require 'model/TypeRequirement.php';
require 'model/Actor.php';
require 'model/UseCase.php';
require 'model/Diagram.php';
require 'pdf/mpdf.php';
require 'database/CommonFunctions.php';
require 'database/SerDatabaseHandler.php';
require 'controller/AbstractController.php';
require 'session.php';


$sController = ucfirst(strtolower($_GET['controller']) . 'Controller');
$sAction = ucfirst(strtolower($_GET['action']));//var_dump($sAction);die();
if (file_exists('controller/' . $sController . '.php')){
	include 'controller/' . $sController . '.php'; 
	$oController = new $sController();
	$oController->setPostData($_POST);
	$oController->setGetData($_GET);
	$oController->setFilesData($_FILES);
	$oController->setSessionData($_SESSION);

	if (method_exists($sController, $sAction)){
		$oController->$sAction();
	}else{
		echo 'Action not found';
		
	}	
}
else
{
	header ('Location:/ser/login/pagelogin');
}
