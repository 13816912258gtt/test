<?php
/**新闻评论表操作文件**/
require_once 'common.php';
//添加新闻评论
function addReply($uid,$activitiesid,$content){
	$link=get_connect();
	$uid=mysql_dataCheck($uid);	
	$content=mysql_dataCheck($content);	
	$format="%Y-%m-%d %H:%M:%S";//设置时间格式
	$publishtime=strftime($format); //获取系统时间	
	$sql = "insert into `tbl_reply` (`uid`,`activitiesid`,`content`,`publishtime`) values ($uid,$activitiesid,'$content','$publishtime')";			
	$rs= execUpdate($sql,$link);
	return $rs; 
}
//编辑新闻评论，仅修改评论内容
function updateReply($content,$replyid){
    $link=get_connect();
	$classname=mysql_dataCheck($classname);
	$classdesc=mysql_dataCheck($classdesc);	 
	$sql = "update `tbl_reply` set `content`='$content' where `replyid`=$replyid";	
    $rs=execUpdate($sql,$link);   
    return $rs;
}
//删除新闻评论
function deleteReply($replyid){
     $sql="delete from `tbl_reply` where `replyid`=$replyid";
	 $link=get_connect();
     $rs=execUpdate($sql,$link);   
     return $rs;
}
//按照新闻编号查询所有的新闻评论
function findReplyByActivitiesid($activitiesid){
   $sql = "select * from `tbl_reply`  where `activitiesid`=$activitiesid order by `publishtime` desc";   
   $link=get_connect();
   $rs=execQuery($sql,$link);
   return $rs;
}
//按照用户编号查询所有的新闻评论
function findReplyByUid($uid){
   $sql = "select * from `tbl_reply`  where `uid`=$uid order by `publishtime` desc";  
   $link=get_connect();
   $rs=execQuery($sql,$link);
   return $rs;
}
//查询所有的新闻评论
function findReply(){
   $sql = "select * from `tbl_reply` order by `publishtime` desc ";  
   $link=get_connect();
   $rs=execQuery($sql,$link);
   return $rs;
}
?>