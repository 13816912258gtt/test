<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<?PHP
/**用户信息操作文件**/
require_once 'common.php';
function addUser($uname,$upass,$uemail,$headimg,$gender="1",$power="1"){
	$link=get_connect();
	$uname=mysql_dataCheck($uname);
	$upass=mysql_dataCheck($upass);
	$uemail=mysql_dataCheck($uemail);
	$headimg=mysql_dataCheck($headimg);
	$format="%Y-%m-%d %H:%M:%S";
	$regtime=strftime($format);
	$sql="insert into  `tbl_user` (`uname`,`upass`,`uemail`,`headimg`,`regtime`,`gender`,`power`)  values  ('$uname','$upass','$uemail','$headimg','$regtime',$gender,$power)";
	$rs=execUpdate($sql,$link);
	return $rs;
}
function updateUser($uid,$uname,$upass,$uemail,$headimg,$gender,$power){
	$link=get_connect();
	$uname=mysql_dataCheck($uname);
	$upass=mysql_dataCheck($upass);
	$uemail=mysql_dataCheck($uemail);
	$headimg=mysql_dataCheck($headimg);
	$sql = "update  `tbl_user` set  `uname`='$uname',`upass`='$upass',`uemail`='$uemail',`headimg`='$headimg',`gender`=$gender,`power`=$power  where `uid`=$uid";
	$rs=execUpdate($sql,$link);
	return $rs;
}
function updateUserPass($uname,$upass){
	$link=get_connect();
	$upass=mysql_dataCheck($upass);
	$sql="update  `tbl_user` set `upass`='$upass' where `uname`='$uname'";
	$rs=execUpdate($sql,$link);
	return $rs;
}
function deleteUser($uid){
	$sql="delete from `tbl_user` where  `uid`=$uid";
	$link=get_connect();
	$rs=execUpdate($sql,$link);
	return $rs;
}
function findUserByName($name){
	$link=get_connect();
	$name=mysql_dataCheck($name);
	$sql="select  `uid`,`uname`,
	case
	when gender=1 then '男'
	when gender=2 then '女' end as `gender`,`upass`,`regtime`,`headimg`,`uemail`,
	case
	when power=1 then '普通用户'
	when power=2 then '系统管理员' end as`power` from `tbl_user` where `uname`='$name'";
	$rs=execQuery($sql,$link);
	if(count($rs)>0){
		return $rs[0];
	}
	return $rs;
}
function findUserById($uid){
	$sql="select  `uid`,`uname`,
	case
	when gender=1 then '男'
	when gender=2 then '女' end as `gender`,`upass`,`regtime`,`headimg`,`uemail`,
	case
	when power=1 then '普通用户'
	when power=2 then '系统管理员' end as`power` from `tbl_user` where `uid`=$uid";
	$link=get_connect();
	$rs=execQuery($sql,$link);
	if(count($rs)>0){
		return $rs[0];
	}
	return $rs;
}

?>
</body>
</html>