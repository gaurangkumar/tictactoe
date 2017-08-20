<?php
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
* Project: Tic Tac Toe Game						 *
* File: function.php											 *
* Author: GK (gaurangkumarp@gmail.com) *
* Created: 2017-08-19									 *
*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
function isOver($g,$m,$p){
		//top row
		if ($g[0] != '00' && $g[0] == $g[1] && $g[1] == $g[2])
			return $over=['cell0','cell1','cell2',$p];//
			
		//middle row
		if ($g[3] != '00' && $g[3] == $g[4] && $g[4] == $g[5])
			return $over=['cell3','cell4','cell5',$p];
			
		//bottom row
		if ($g[6] != '00' && $g[6] == $g[7] && $g[7] == $g[8])
			return $over=['cell6','cell7','cell8',$p];
			
		//first column
		if ($g[0] != '00' && $g[0] == $g[3] && $g[3] == $g[6])
			return $over=['cell0','cell3','cell6',$p];
			
		//second column
		if ($g[1] != '00' && $g[1] == $g[4] && $g[4] == $g[7])
			return $over=['cell1','cell4','cell7',$p];
			
		//third column
		if ($g[2] != '00' && $g[2] == $g[5] && $g[5] == $g[8])
			return $over=['cell2','cell5','cell8',$p];
			
		//diagonal 1
		if ($g[0] != '00' && $g[0] == $g[4] && $g[4] == $g[8])
			return $over=['cell0','cell4','cell8',$p];
			
		//diagonal 2
		if ($g[2] != '00' && $g[2] == $g[4] && $g[4] == $g[6])
			return $over=['cell2','cell4','cell6',$p];
			
		if ($m >= 9)
			return $over['Tie']='tie';
		return $over=false;
	}
?>