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
		timeline($val);
	}
}

function updateAction(){
	if(!isset($_GET['room'])) $_GET['room']='29Kw_gYAk2RIY';
	if(isset($_GET['text'])){
		beluga()->update($_GET['text'],$_GET['room']);
	}

	echo 'ルーム:<input id="room" value="'.$_GET['room'].'"/>   ';
	echo 'メッセージ:<input id="msg"/>';
	echo '<input type="button" value="投稿" onclick="location.href=\'./?action=update&text=\'+encodeURIComponent(msg.value)+\'&room=\'+encodeURIComponent(room.value)+\'&'.g('user_id.user_token').'\';"/><br>'.chr(10);
	echo '<hr>';
	homeAction();
}

function mentionsAction(){
	foreach (beluga()->mentions() as $val) {
		echo '<div><img align="left" src="'.$val['user']['profile_image_sizes']['x50'].'"/>';
		echo '#'.$val['user']['name'].' ['.$val['room']['name'].'] '.$val['room']['hash'].'<br>';
		echo str_replace(chr(10),'<br>',$val['text']).'</div>';
		echo '<br>';
	}
}

function followingAction(){
	foreach (beluga()->following() as $val) {
		table($val);
	}
}

function roomAction(){
?>
<script>
	function roomHash(elm2) {
		var elm = document.getElementById(elm2);
		return encodeURIComponent(elm.options[elm.selectedIndex].value);
	};
</script>
<?php
	echo '<select id="list">';
	foreach (beluga()->following() as $val) {
		echo '  <option value="'.$val['hash'].'">'.$val['name'].'</option>';
	}
	echo '</select>';
	echo '<input type="button" value="確認" onclick="location.href=\'./?action=room&room=\'+roomHash(\'list\')+\'&'.g('user_id.user_token').'\';"/>';
	echo '<hr>';
	if(!isset($_GET['room'])) $_GET['room']='29Kw_gYAk2RIY';
	foreach (beluga()->room($_GET['room']) as $val) {
		timeline($val);
	}
}

?>