<?php
include('module/beluga.php');
include('module/functions.php');

if(isset($_GET['user_id']) && isset($_GET['user_token'])){
	$user_id = $_GET['user_id'];
	$user_token = $_GET['user_token'];
}else{
	// input your user info
	$_GET['user_id'] = $user_id = '';
	$_GET['user_token'] = $user_token = '';
}
$api = new Beluga($user_id,$user_token);
function beluga(){
	global $api;
	return $api;
}

//header
echo '<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />';
echo '<h2>Beluga API Sample</h2>';

// simple controller
if(!isset($_GET['action'])) $_GET['action'] = 'default';
$action = $_GET['action'].'Action';

if(function_exists($action)){
	$action();
}else{
	defaultAction();
}

function defaultAction(){
	if(!beluga()->isConnect()){
		echo 'ドキュメントルート以下に/belugaというフォルダを作成し、このファイルを配置してください。<br>';
		echo '<a href="http://beluga.fm/authorize?app_id=52" style="text-size:24px;">API認証</a>';
	}else{
		echo '<span style="color:009900">認証済み</span>';
		$sample_list = array(
			array('api' => 'statuses/home','url'=>'./?action=home&'.g('user_id.user_token'),'exp'=>'ホーム取得'),
			array('api' => 'statuses/update','url'=>'./?action=update&'.g('user_id.user_token'),'exp'=>'投稿'),
			array('api' => 'statuses/mentions','url'=>'./?action=mentions&'.g('user_id.user_token'),'exp'=>'返信取得'),
			array('api' => 'statuses/room','url'=>'./?action=room&'.g('user_id.user_token'),'exp'=>'ルーム投稿取得'),
			array('api' => 'account/following','url'=>'./?action=following&'.g('user_id.user_token'),'exp'=>'フォローしてるルーム取得')
			);
		echo '<h4>API Sample List</h4>';
		foreach ($sample_list as $val) {
			echo '<a href="'.$val['url'].'">'.$val['api'].'</a> '.$val['exp'].'<br>';
		}
	}
}

function homeAction(){
	foreach (beluga()->home() as $val) {
		echo '#'.$val['user']['name'].' ['.$val['room']['name'].']<br>';
		echo str_replace(chr(10),'<br>',$val['text']).'<br>';
		echo '<br>';
	}
}

?>