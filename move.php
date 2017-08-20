<?php
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
* Project: Tic Tac Toe Game						 *
* File: move.php											 *
* Author: GK (gaurangkumarp@gmail.com) *
* Created: 2017-08-19									 *
*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
session_start();
include("function.php");
$i='00';
// Set New Game
if(isset($_POST['newGame']) && $_POST['newGame']==true)
	$_SESSION['game'] = ['gamedata'=>[$i,$i,$i,$i,$i,$i,$i,$i,$i], 'player'=>'01', 'move'=>0, 'over'=>false, 'msg'=>"1st Player's Turn"];

// Set Current Game Data
if(isset($_POST['cell'])){
	$cell = $_POST['cell'];

	// Set Next Player
	$_SESSION['game']['gamedata'][$cell] = $_SESSION['game']['player'];
	$msg="";
	if($_SESSION['game']['player']=='01'){
		$_SESSION['game']['player']='10';
		$_SESSION['game']['msg'] = "2nd Player's Turn";
		$p='1st';
	}
	else{
		$_SESSION['game']['player']='01';
		$_SESSION['game']['msg'] = "1st Player's Turn";
		$p='2nd';
	}
	$_SESSION['game']['move']++;

	// Check wheater Game Is Over / Tie
	$over = isOver($_SESSION['game']['gamedata'],$_SESSION['game']['move'],$p);
	if(isset($over) && $over=='tie'){
		$msg.="@tie@";
		$_SESSION['game']['over']=true;
		$_SESSION['game']['msg']='Game Tie !';
	}
	if(isset($over[0])){
		$msg.="@over@{$over[0]}@{$over[1]}@{$over[2]}@{$over[3]}@";
		$_SESSION['game']['over']=true;
		$_SESSION['game']['msg']="{$over[3]} Player Won !";
	}
	echo $msg;
}
?>