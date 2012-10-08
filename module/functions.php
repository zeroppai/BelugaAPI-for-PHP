<?php
function table($val){
	if(!$val) echo 'table error';
	if(is_array($val)){
		echo '<table border="1" cellspacing="0" bordercolor="#333333" >';
		_table($val);
		echo '</table>';
	}else{
		echo var_dump($val);
	}
}
function _table($val){
	echo '<tr align="left" valign="top">'.chr(10);
	echo ' <td align="left" valign="top" bgcolor="#33EE33">key</td>'.chr(10);
	echo ' <td align="left" valign="top" bgcolor="#33EE33">value</td>'.chr(10);
	echo '</tr>'.chr(10);
	foreach($val as $key => $_val){
		echo '<tr align="left" valign="top">'.chr(10);
		echo ' <td align="left" valign="top" bgcolor="#FFFFFF">'.$key.'</td>'.chr(10);
		echo ' <td align="left" valign="top" bgcolor="#FFFFFF">'.chr(10);
		if(is_array($_val))	table($_val);
		else echo $_val.'</td>'.chr(10).'</tr>'.chr(10);
	}
}

function g($params){
	$res = array();
	foreach(explode('.', $params) as $val){
		$res[] = $val.'='.$_GET[$val];
	}
	return implode('&', $res);
}

function timeline($val){
	echo '<div><img align="left" src="'.$val['user']['profile_image_sizes']['x50'].'"/>';
	echo '#'.$val['user']['name'].' ['.$val['room']['name'].'] '.$val['room']['hash'].'<br>';
	echo str_replace(chr(10),'<br>',$val['text']).'</div>';
	echo '<br>';
}