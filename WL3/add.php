<?php
//设置页面内容是html编码格式是utf-8

header("Content-Type: text/plain;charset=utf-8"); 
header("Content-Type: application/json;charset=utf-8"); 
//header("Content-Type: text/xml;charset=utf-8"); 
//header("Content-Type: text/html;charset=utf-8"); 
//header("Content-Type: application/javascript;charset=utf-8"); 

//定义一个多维数组，包含员工的信息，每条员工信息为一个数组


//判断如果是get请求，则进行搜索；如果是POST请求，则进行新建
//$_SERVER是一个超全局变量，在一个脚本的全部作用域中都可用，不用使用global关键字
//$_SERVER["REQUEST_METHOD"]返回访问页面使用的请求方法
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	search();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
	create();
}

//通过员工编号搜索员工
function search(){
	require_once('../connect.php');
	//检查是否有员工编号的参数
	//isset检测变量是否设置；empty判断值为否为空
	//超全局变量 $_GET 和 $_POST 用于收集表单数据
	/*if (!isset($_GET["number"]) || empty($_GET["number"])) {
		echo '{"success":false,"msg":"参数错误"}';
		return;
	}*/
	
	$wm= $_GET["wm"];
	$name= $_GET["name"];
	$link= $_GET["link"];
	$dian= $_GET["dian"];
	if(is_numeric($wm)){
		if($dian=="a"){$link_a="搜索：https://uniqlo.tmall.com/search.htm?";}else{$link_a="搜索：http://www.uniqlo.cn/search.htm?";}
		echo'{"success":true,"xianding":true,"text":"' . $wm. '","msg":"' . $link_a. '"}';
	}else{
			if(strpos($wm, "限定")){
				
				
				$mysqli->select_db("tl");
				if($link=="undefined"){
					$sql="SELECT `link` FROM `{$wm}` WHERE name='{$wm}' and dian='{$dian}'";
					$msg= $wm +$name+":";
					$text=$name;
					$link="";
				}else{
					$sql="SELECT `link` FROM `{$wm}` WHERE name='{$name}' and dian='{$dian}'";
					$text=$link;}
			
				if($result = $mysqli->query($sql)){
					$row=$result->fetch_row();
					if($dian=="a"){$fu="?";}else{$fu="&";}
					echo'{"success":true,"xianding":true,"text":"' . $text. '","msg":"' . $wm. '' . $name. '' . $link. ':' . $row[0]. '' . $fu. '"}';
				}else{
					echo '{"success":false,"msg":"失败"}';}
			
			}else{
		$mysqli->select_db("$wm");
		if($link=="undefined"){
		$sql="SELECT `link` FROM `{$name}` WHERE name='{$name}' and dian='{$dian}'";
		$link="";
		}else{
		$sql="SELECT `link` FROM `{$name}` WHERE name='{$link}' and dian='{$dian}'";}
		
		if($result = $mysqli->query($sql)){
		$row=$result->fetch_row();
			echo'{"success":true,"xianding":false,"msg":"' . $wm. '' . $name. '' . $link. ':' . $row[0]. '"}';
		}else{
			echo '{"success":false,"msg":"失败"}';};
	}
	
	}
	
	
	
	



	
	
}

//创建员工
function create(){
	require_once('../connect.php');
	$dian=$_POST["dian"];
	$wm=$_POST["wm"];
	$biao=$_POST["biao"];
	$name=$_POST["name"];
	$link=$_POST["link"];
	$sql="INSERT INTO `$biao`(`dian`,`name`, `link`) VALUES ('$dian','$name','$link')";
	//判断信息是否填写完全
	if (!isset($name) || empty($name)
		|| !isset($link) || empty($link)) {
		echo '{"success":false,"msg":"参数错误，信息填写不全"}';
		return;
	}
	//TODO: 获取POST表单数据并保存到数据库
	$mysqli->select_db($wm);
	if($mysqli->query($sql)){
	echo '{"success":true,"msg":"' . $dian. '' . $wm. '' . $biao. '' . $name. ' 信息保存成功！"}';
}else{
	echo '{"success":false,"msg":"失败"}';}
}


