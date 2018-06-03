<?php
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
* Project: Tic Tac Toe Game						 *
* File: index.php											 *
* Author: GK (gaurangkumarp@gmail.com) *
* Created: 2017-08-19									 *
*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
session_start();
include("function.php");
// Variable initiated for new game
$i='00';
if (!isset($_SESSION['game']['gamedata']))
	$_SESSION['game'] = ['gamedata'=>[$i,$i,$i,$i,$i,$i,$i,$i,$i], 'player'=>'01', 'move'=>0, 'over'=>false, 'msg'=>"1st Player's Turn"];
$game = $_SESSION['game'];
// Check wheather game is over or not
$over = isOver($game['gamedata'],$game['move'],$game['player']);
$game_won = [0,0,0,0,0,0,0,0,0];
if(isset($over[0])){
	$game_won[str_replace('cell','',$over[0])] = 1;
	$game_won[str_replace('cell','',$over[1])] = 1;
	$game_won[str_replace('cell','',$over[2])] = 1;
}
?>
<!doctype html>
<html>
<head>
	<title>Tic Tac Toe - Human vs Human</title>
  <meta name="description" content="Tic Tac Toe Game In PHP  - Human vs Human - 2 Player Game">
  <meta name="author" content="gaurangkumarp@gmail.com">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="inc/style.css" />
  <style>
	.well-active {
		background-color:#427BFF
	}
	.game-msg {
		background-color:#FF5454;
		color:#FFFFFF
	}
	</style>
</head>
<body>
<div class="container">
	<header>
		<h1 class="page-header text-center">Tic Tac Toe<br><small>Human vs Human</small></h1>
	</header>
  <div class="row">
  	<div class="col-lg-2">
			<div id="p1" class="well well-sm <?=$game['player']=='01'?'well-active':''?>">
        	<i class="fa fa-4x fa-close"> P1</i>
			</div>
    </div>
  	<div class="col-lg-8">
			<div id="content">
    <div id="board">
		<?php
		$i=0;
		// Game Board
		for ($x = 0; $x < 3; $x++){
			for ($y = 0; $y < 3; $y++){
				// Cell Of Board ?>
				<div class="board_cell bg-danger btn <?php echo ($game_won[$i]==0)?'btn-danger':'btn-info';?> <?php echo ($game['gamedata'][$i]!='00' || $game['over'])?'disabled':'';?>" id="cell<?php echo $i;?>" data-id="<?php echo $game['gamedata'][$i];?>" data-i="<?php echo $i;?>">
				<?php
				// Set O / X From Session Data
				if($game['gamedata'][$i]=='00')
        	echo '<i class="fa fa-4x"></i>';
				elseif($game['gamedata'][$i]=='01')
        	echo '<i class="fa fa-4x fa-close"></i>';
				elseif($game['gamedata'][$i]=='10')
        	echo '<i class="fa fa-4x fa-circle-o"></i>';
				?>
				</div>
        <?php
				$i++;
			}?>
			<div class="break"></div>
		<?php
    }?>
				<input type="hidden" id="player" value="<?php echo ($game['player']=='01')?'1st':'2nd';?>">
        <h4>
        	<div class="alert alert-info text-center">
						<span id="move"><?php echo $game['move'];?></span> Moves
        	</div>
        </h4>
        <h4>
        	<div class="alert alert-success text-center game-msg" id="msg">
						<?php echo $game['msg'];?>
        	</div>
        </h4>
        <button class="btn btn-block btn-primary" id="reset">New Game</button>
    	</div>
		</div>
		</div>
  	<div class="col-lg-2">
			<div id="p2" class="well well-sm <?=$game['player']=='01'?'':'well-active'?>">
        	<i class="fa fa-4x fa-circle-o"> P2</i>
			</div>
    </div>
	</div>
  <footer>
  	<hr>
  	<p class="text-center">
			<b>Made By GK</b>
      <a class="btn btn-sm btn-success" href="mailto:gaurankumarp@gmail.com"><i class="fa fa-envelope"></i></a>
      <a class="btn btn-sm btn-primary" href="https://www.facebook.com/Gaurang-Kumar-216891588644805/"><i class="fa fa-facebook"></i></a>
		</p>
  </footer>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(function(){
	// Set New Game
	$('#reset').click(function(e) {
		$.ajax({
			url: "move.php",
			type: "POST",
			data: {
				newGame: true
			},
			cache: false,
			success: function(data,status) {
				$('.board_cell').html('<i class="fa fa-4x"></i>');
				$('.board_cell').removeClass('disabled');
				$('.board_cell').removeClass('btn-info');
				$('.board_cell').addClass('btn-danger');
				$('#msg').text("1st Player's Turn");
				$('#move').text(0);
				$('#player').val('1st');
				$('#p1').addClass('well-active');
				$('#p2').removeClass('well-active');
			},
			error: function() {
			},
		});
  });
	// Send Board Data To move.php
	$(".board_cell").click(function(e) {
		var cell_value=$(this).attr('id');
		var data_id=$(this).attr('data-id');
		var cell_id=$(this).attr('data-i');
		var isDisabled=$(this).hasClass('disabled');
		var move=$('#move').text();
		move++;
		var player = $('#player').val();
		if(move<=9 && isDisabled==false){
			$(this).addClass('disabled');
			if(player=='1st'){
				$(this).html('<i class="fa fa-4x fa-close"></i>');
				$('#player').val('2nd');
				$('#msg').text("2nd Player's Turn");
				$('#p1').removeClass('well-active');
				$('#p2').addClass('well-active');
			}
			else{
				$(this).html('<i class="fa fa-4x fa-circle-o"></i>');
				$('#player').val('1st');
				$('#msg').text("1st Player's Turn");
				$('#p1').addClass('well-active');
				$('#p2').removeClass('well-active');
			}
			$('#move').text(move);
			$.ajax({
				url: "move.php",
				type: "POST",
				data: {
					cell: cell_id
				},
				cache: false,
				success: function(data,status) {
					var none=data.split('@',1);
					data1=data.replace(none+"@","");
					// msg = over / tie
					var msg=data1.split('@',1);
					data1=data1.replace(msg+"@","");
					if(msg=='over'){
						// c1, c2, c3 are cell to show result
						var c1=data1.split('@',1);
						data1=data1.replace(c1+"@","");
						var c2=data1.split('@',1);
						data1=data1.replace(c2+"@","");
						var c3=data1.split('@',1);
						data1=data1.replace(c3+"@","");
						var player=data1.split('@',1);
						data1=data1.replace(player+"@","");
						//$('#'+c1).removeClass('btn-danger');
						//$('#'+c2).removeClass('btn-danger');
						//$('#'+c3).removeClass('btn-danger');
						//$('#'+c1).addClass('btn-info');
						//$('#'+c2).addClass('btn-info');
						//$('#'+c3).addClass('btn-info');
						
						$('#'+c1+',#'+c2+',#'+c3).removeClass('btn-danger');
						//$('#'+c1+',#'+c2+',#'+c3).addClass('btn-info');
						$('.board_cell').addClass('disabled');
						$('#msg').text(player+' Player Won !');
						$('#p1').removeClass('well-active');
						$('#p2').removeClass('well-active');
					}
					else if(msg=='tie'){
						$('.board_cell').addClass('disabled');
						$("#msg").text('Game Tie !!');
						$('#p1').removeClass('well-active');
						$('#p2').removeClass('well-active');
					}
				},
				error: function() {
				},
		});
		}
  });
});
</script>

</body>
</html>