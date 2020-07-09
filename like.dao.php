<?php
/**新闻点赞信息操作文件**/
require_once 'common.php';
//获取客户端ip地址
function getIP(){
  if(!empty($_SERVER["HTTP_CLIENT_IP"])){
     $cip = $_SERVER["HTTP_CLIENT_IP"];
  }elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
     $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
  }elseif(!empty($_SERVER["REMOTE_ADDR"])){
     $cip = $_SERVER["REMOTE_ADDR"];
  }else{
  $cip = "无法获取！";
  }
  return $cip;
}

//添加点赞记录
function addActivitiesLike($activitiesid,$userip){
	$link=get_connect();
	$activitiesid=mysql_dataCheck($activitiesid);
	$userip=mysql_dataCheck($userip);	
	$sql = "insert into `tbl_like` (`activitiesid`,`userip`) values ($activitiesid,'$userip')";			
	$rs= execUpdate($sql,$link);
	return $rs; 
}

//按新闻编号和ip查找点赞记录
function findActivitiesLike($activitiesid,$userip){
   $sql = "select * from `tbl_like` where `activitiesid`=$activitiesid and `userip`='$userip'";  
   $link=get_connect();
   $rs=execQuery($sql,$link);
   if(count($rs)>0){return $rs[0];}else{
	   return false;}

}
?>