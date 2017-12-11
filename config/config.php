<?php

require_once 'FileManager.php';
$_SESSION['begin_path'] = "E:/Xampp/htdocs/FileManager/File";
//массив продвижения по файлам
if(!isset($_SESSION['route']))
{
	$_SESSION['route']=array();
}
//начальная директория
if(!isset($_SESSION['current_path']))
{
	$_SESSION['current_path'] ="E:/Xampp/htdocs/FileManager/File";
}
//
$fm = new FileManager($_SESSION['current_path']);

if(isset($_GET['p']))
{
	if($_GET['p']=='')
	{	
		$_SESSION['current_path'] = "E:/Xampp/htdocs/FileManager/File";
		$fm->setPath($_SESSION['current_path']);
		unset($_SESSION['route']);
	}
	elseif ($_GET['p']!="")
	{
		$_SESSION['current_path'] = $_SESSION['current_path'] . '/' . $_GET['p'];
		$_SESSION['route'][] = $_GET['p'];
		$fm->setPath($_SESSION['current_path']);
		$fm->setRoute($_SESSION['route']);
	}
}


if(isset($_GET['back']))
{
	$fm->Back($_GET['back']);
	unset($_GET['back']);
}

require_once 'view/index.view.php';