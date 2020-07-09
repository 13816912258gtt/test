<?php
/**新闻分类信息操作文件**/
require_once 'common.php';
//添加新闻分类
function addActivitiesClass($classname,$classdesc){
	$link=get_connect();
	$classname=mysql_dataCheck($classname);
	$classdesc=mysql_dataCheck($classdesc);	
	$sql = "insert into `tbl_activitiesclass` (`classname`,`classdesc`) values ('$classname','$classdesc')";			
	$rs= execUpdate($sql,$link);
	return $rs; 
}
//编辑新闻分类
function updateActivitiesClass($classid,$classname,$classdesc){
    $link=get_connect();
	$classname=mysql_dataCheck($classname);
	$classdesc=mysql_dataCheck($classdesc);	 
	$sql = "update `tbl_activitiesclass` set `classname`='$classname',`classdesc`='$classdesc' where `classid`=$classid";	
    $rs=execUpdate($sql,$link);   
    return $rs;
}
//删除新闻分类
function deleteActivitiesClass($classid){
     $sql="delete from `tbl_activitiesclass` where `classid`=$classid";
	 $link=get_connect();
     $rs=execUpdate($sql,$link);   
     return $rs;
}
//根据编号查找新闻分类
function findActivitiesClassById($classid){
   $sql = "select * from `tbl_activitiesclass` where `classid`=$classid";  
   $link=get_connect();
   $rs=execQuery($sql,$link);
   if(count($rs)>0){return $rs[0];}
   return $rs;
}
//查找新闻分类信息
function findActivitiesClass(){
  $link=get_connect();
  $sql = "select * from `tbl_activitiesclass` ";  
  $rs=execQuery($sql,$link);   
  return $rs;
}
?>