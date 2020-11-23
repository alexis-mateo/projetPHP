<?php
require_once File::build_path(array('controller','controllerUtilisateur.php'));
require_once File::build_path(array('controller','controllerBook.php'));
require_once File::build_path(array('controller','controllerAuteur.php'));
require_once File::build_path(array('controller','controllerCategorie.php'));
require_once File::build_path(array('controller','controllerEditeur.php'));
require_once File::build_path(array('controller','controllerCommande.php'));
require_once File::build_path(array('controller','controllerListeEnvie.php'));
require_once File::build_path(array('controller','controllerPanier.php'));


if (!isset($_GET['controller']))
	$controller = 'book';
else
	$controller = $_GET['controller'];

if(!isset($_GET['action']) && !isset($_POST['action']))
{
	$action = 'readAll';
} else if(isset($_GET['action']))
{
	$action = $_GET['action'];
} else {
	$action = $_POST['action'];
	if (in_array($action, get_class_methods('controllerUtilisateur'))) $controller = 'utilisateur';
}

$controller_class = 'controller'. ucfirst($controller);
$controller_class::$action();

?> 
