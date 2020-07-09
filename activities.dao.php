<?php
/**新闻信息操作文件**/
require_once 'common.php';
//添加新闻
function addActivities($title,$content,$uid,$classid){
	$link=get_connect();
	$title=mysql_dataCheck($title);
	$content=mysql_dataCheck($content);	
	$format="%Y-%m-%d %H:%M:%S";//设置时间格式
	$publishtime=strftime($format); //获取系统时间	
	$sql = "insert into `tbl_activities` (`title`,`content`,`uid`,`classid`,`publishtime`) values ('$title','$content',$uid,$classid,'$publishtime')";			
	$rs= execUpdate($sql,$link);
	return $rs; 
}
//编辑新闻
function updateActivities($activitiesid,$title,$content,$uid,$classid){
    $link=get_connect();
    $title=mysql_dataCheck($title);
    $content =mysql_dataCheck($content);    
    $sql = "update `tbl_activities`  set`title`='$title',`content`='$content',`uid`=$uid,`classid`=$classid  where `activitiesid`=$activitiesid";   
    $rs=execUpdate($sql,$link);   
    return $rs;
}
//置顶新闻,根据新闻编号置顶新闻
function updateTopActivities($activitiesid){
  $link=get_connect();
  $sql="update `tbl_activities` set `istop`=1 where `activitiesid`=$activitiesid ";
  $rs=execUpdate($sql,$link);   
  return $rs;	
}
//置热点新闻,根据新闻编号置热点新闻
function updateHotActivities($activitiesid){
  $link=get_connect();
  $sql="update `tbl_activities` set `ishot`=1 where `activitiesid`=$activitiesid ";
  $rs=execUpdate($sql,$link);   
  return $rs;	
}
//根据新闻编号修改点赞计数
function updateLikeCount($activitiesid){
  $link=get_connect();
  $sql="update `tbl_activities` set `likecount`=`likecount`+1 where `activitiesid`=$activitiesid ";
  $rs=execUpdate($sql,$link);   
  return $rs;	
}
//根据新闻编号修改阅读计数
function updateViewCount($activitiesid,$viewcount){
  $link=get_connect();
  $sql="update `tbl_activities` set `viewcount`=$viewcount where `activitiesid`=$activitiesid ";
  $rs=execUpdate($sql,$link);   
  return $rs;	
}

//删除新闻
function deleteActivities($activitiesid){
     $sql="delete from `tbl_activities` where `activitiesid`=$activitiesid";
	 $link=get_connect();
     $rs=execUpdate($sql,$link);   
     return $rs;
}

//取消新闻置顶,根据新闻编号取消新闻置顶
function cancelTopActivities($activitiesid){
  $link=get_connect();
  $sql="update `tbl_activities` set `istop`=0 where `activitiesid`=$activitiesid ";
  $rs=execUpdate($sql,$link);   
  return $rs;	
}

//取消热点新闻,根据新闻编号取消热点新闻
function cancelHotActivities($activitiesid){
  $link=get_connect();
  $sql="update `tbl_activities` set `ishot`=0 where `activitiesid`=$activitiesid ";
  $rs=execUpdate($sql,$link);   
  return $rs;	
}

//根据用户编号查找新闻
function findActivitiesByUid($uid){
   $sql = "select * from `tbl_activities` where `uid`=$uid";  
   $link=get_connect();
   $rs=execQuery($sql,$link);   
   return $rs;
}

//按照发布时间倒序查询所有新闻信息
function findActivities(){
   $sql = "select * from `tbl_activities` order by `publishtime` desc ";  
   $link=get_connect();
   $rs=execQuery($sql,$link);
   return $rs;
}

//根据新闻类别显示相应类别新闻
function findActivitiesByClassid($classid){
   $sql = "select * from `tbl_activities` where `classid`=$classid order by `publishtime` desc ";  
   $link=get_connect();
   $rs=execQuery($sql,$link);
   return $rs;
}
//根据编号查找新闻
function findActivitiesById($activitiesid){
   $sql = "select * from `tbl_activities` where `activitiesid`=$activitiesid";  
   $link=get_connect();
   $rs=execQuery($sql,$link);
   if(count($rs)>0){return $rs[0];}
   return $rs;
}
//按照指定字段，指定关键词模糊查询新闻信息，若$search_field没有设置，则默认对新闻标题和内容字段都进行查找
function findActivitiesByName($keyword,$search_field="all"){
 if($search_field=="all"){	
     $sql = "select * from `tbl_activities` where `title` like '%$keyword%' or `content` like '%$keyword%'  order by `publishtime` desc ";
  }else{
     $sql = "select * from `tbl_activities` where `$search_field` like '%$keyword%' order by `publishtime` desc "; 
  }  
   $link=get_connect();
   $rs=execQuery($sql,$link);
   return $rs;
}
//显示热点新闻 若缺省参数，则显示所有的热点新闻，否则显示指定条数的热点新闻
function findHotActivities($countlimit=0){	
  $sql="select * from `tbl_activities` where `ishot`=1 ";
  if($countlimit!=0){
      $sql=$sql." limit $countlimit";
   }
   $link=get_connect();
   $rs=execQuery($sql,$link);
   return $rs;
}
//显示置顶新闻 若缺省参数，则显示所有的推荐新闻，否则显示指定条数的置顶新闻
function findTopActivities($countlimit=0){	
  $sql="select * from `tbl_activities` where `istop`=1 ";
  if($countlimit!=0){
      $sql=$sql." limit $countlimit";
   }
   $link=get_connect();
   $rs=execQuery($sql,$link);
   return $rs;
}

///////////////////////////////////////
//加入分页后的新闻查询函数
//////////////////////////////////////
/**
  获取全部新闻分页后的最大页码 
* @param int $pagesize 每页显示最大记录数 默认为10条记录
*/
function maxpage_findActivities($pagesize=10){
  $link=get_connect();
  $sql="select count(*) as num from `tbl_activities` order by `publishtime` desc"; 
  $rs=execQuery($sql,$link);
  $count= $rs[0];   
  //取出查询结果中的num列的值
  $count = $count['num'];
  //取得最大页码值
  $max_page = ceil($count/$pagesize);
  return $max_page; 
}

/**
  分页查询所有新闻信息，按照发布时间倒序 
* @param int $page 当前page值
* @param int $pagesize 每页显示最大记录数 默认为10条记录
*/
function findActivities_page($page,$pagesize=10){
  $max_page=maxpage_findActivities($pagesize); 
  $page= $page>$max_page? $max_page:$page; 
   //拼接查询语句并执行，获取查询数据
  $lim = ($page -1) * $pagesize;
  $sql = "select * from `tbl_activities` order by `publishtime` desc limit $lim, $pagesize";  
  $link=get_connect();
  $rs=execQuery($sql,$link);
  return $rs;
}

/**
  获取分类新闻查询分页后的最大页码
* @param int $classid 新闻类别编号 
* @param int $pagesize 每页显示最大记录数 默认为10条记录
*/
function maxpage_findActivitiesByClassid($classid,$pagesize=10){
  $link=get_connect();
  $sql="select count(*) as num from `tbl_activities` where `classid`=$classid order by `publishtime` desc"; 
  $rs=execQuery($sql,$link);
  $count= $rs[0];   
  //取出查询结果中的num列的值
  $count = $count['num'];
  //取得最大页码值
  $max_page = ceil($count/$pagesize);
  return $max_page; 
}

/**
  分页查询选定类别的新闻信息，按照发布时间倒序
* @param int $classid 新闻类别编号  
* @param int $page 当前page值
* @param int $pagesize 每页显示最大记录数 默认为10条记录
*/
function findActivitiesByClassid_page($classid,$page,$pagesize=10){
  $max_page = maxpage_findActivitiesByClassid($pagesize);   
   //拼接查询语句并执行，获取查询数据
   $page= $page>$max_page? $max_page:$page;
   $lim = ($page -1) * $pagesize;  	
   $sql = "select * from `tbl_activities` where `classid`=$classid order by `publishtime` desc limit $lim,$pagesize";  
   $link=get_connect();
   $rs=execQuery($sql,$link);
   return $rs;
}

/**
  获取模糊新闻查询分页后的最大页码
* @param string $keyword 查询内容
* @param string $search_field 查询字段 
* @param int $pagesize 每页显示最大记录数 默认为10条记录
*/
function maxpage_findActivitiesByName($keyword,$search_field="all",$pagesize=10){
  $link=get_connect();
if($search_field=="all"){	
     $sql = "select count(*) as num from `tbl_activities` where `title` like '%$keyword%' or `content` like '%$keyword%'  order by `publishtime` desc ";
  }else{
     $sql = "select count(*) as num from `tbl_activities` where `$search_field` like '%$keyword%' order by `publishtime` desc "; 
  }      $rs=execQuery($sql,$link);
  $count= $rs[0];   
  //取出查询结果中的num列的值
  $count = $count['num'];
  //取得最大页码值
  $max_page = ceil($count/$pagesize);
  return $max_page; 
}
/**
  分页查询选定模糊查询的新闻信息，按照发布时间倒序
* @param string $keyword 查询内容
* @param string $search_field 查询字号  
* @param int $page 当前page值
* @param int $pagesize 每页显示最大记录数 默认为10条记录
*/
function findActivitiesByName_page($keyword,$page,$search_field="all",$pagesize=10){
  //取得最大页码值
  $max_page = maxpage_findActivitiesByName($keyword,$search_field,$pagesize); 
  $page= $page>$max_page? $max_page:$page; 
   //拼接查询语句并执行，获取查询数据
  $lim = ($page -1) * $pagesize;
  if($search_field=="all"){	
      $sql = "select * from `tbl_activities` where `title` like '%$keyword%' or `content` like '%$keyword%'  order by `publishtime` desc limit $lim, $pagesize";
  }else{
     $sql = "select * from `tbl_activities` where `$search_field` like '%$keyword%' order by `publishtime` desc limit $lim,$pagesize"; 
  } 
   $link=get_connect(); 
   $rs=execQuery($sql,$link);
   return $rs;
}

/**
 
  获取置顶新闻分页后的最大页码 
 
* @param int $pagesize 每页显示最大记录数默认为10条记录
 
*/
 
function maxpage_findRecommendActivities($pagesize=10){
 
  $link=get_connect();
 
  $sql="select  count(*) as num from `tbl_activities` where istop=1 order by `publishtime`  desc"; 
 
   $rs=execQuery($sql,$link);
 
  $count= $rs[0];   
 
  //取出查询结果中的num列的值
 
  $count = $count['num'];
 
  //取得最大页码值
 
  $max_page =  ceil($count/$pagesize);
 
  return $max_page; 
 
}
 
 
 
/**
 
  分页查询置顶新闻信息，按照发布时间倒序 
 
* @param int $page 当前page值
 
* @param int $pagesize 每页显示最大记录数默认为10条记录
 
*/
 
function findRecommendActivities_page($page,$pagesize=10){
 
   $max_page=maxpage_findActivities($pagesize);   
 
   //拼接查询语句并执行，获取查询数据
 
  $lim = ($page -1) *  $pagesize;
 
  $sql = "select *  from `tbl_activities` where istop=1 order by `publishtime` desc limit $lim,$pagesize";  
 
  $link=get_connect();
 
   $rs=execQuery($sql,$link);
 
  return $rs;
 
}

/**
 
  获取热点新闻分页后的最大页码 
 
* @param int $pagesize 每页显示最大记录数默认为10条记录
 
*/
 
function maxpage_findHotActivities($pagesize=10){
 
  $link=get_connect();
 
  $sql="select  count(*) as num from `tbl_activities` where ishot=1 order by `publishtime`  desc"; 
 
   $rs=execQuery($sql,$link);
 
  $count= $rs[0];   
 
  //取出查询结果中的num列的值
 
  $count = $count['num'];
 
  //取得最大页码值
 
  $max_page =  ceil($count/$pagesize);
 
  return $max_page; 
 
}
 
 
 
/**
 
  分页查询热点新闻信息，按照发布时间倒序 
 
* @param int $page 当前page值
 
* @param int $pagesize 每页显示最大记录数默认为10条记录
 
*/
 
function findHotActivities_page($page,$pagesize=10){
 
   $max_page=maxpage_findActivities($pagesize);   
 
   //拼接查询语句并执行，获取查询数据
 
  $lim = ($page -1) *  $pagesize;
 
  $sql = "select *  from `tbl_activities` where ishot=1 order by `publishtime` desc limit $lim,$pagesize";  
 
  $link=get_connect();
 
   $rs=execQuery($sql,$link);
 
  return $rs;
 
}
 

?>