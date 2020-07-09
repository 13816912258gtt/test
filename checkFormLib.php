<?php

//输入过滤
function test_input($data) {
   $data = trim($data); //去除左右两端的空白字符
   $data = stripslashes($data); //去除输入中的反斜杠
   $data = htmlspecialchars($data); //将特殊字符转换为实体引用
   return $data;
}

//验证用户名不能为空
function checkUsername($username){
  if(strlen($username)<=0){
	  return '用户名不能为空';
 }
 return true;	
}

//验证密码（长度6~16位，只允许英文字母，数字，下划线）
function checkPassword($password){
	if(!preg_match('/^\w{6,16}$/',$password)){
		return '密码格式不符合要求';
	}
	return true;
}

//验证密码和重复密码必须一致
function checkConfirmPassword($password,$password1){
  if($password!=$password1){
	 return '密码和重复密码不一致';  
  }
  return true;	
}

//验证邮箱（不超过40位）
function checkEmail($email){
	if(strlen($email) > 40){
		return '邮箱长度不符合要求';
	}elseif(!preg_match('/^[a-z0-9]+@([a-z0-9]+\.)+[a-z]{2,4}$/i',$email)){
		return '邮箱格式不符合要求';
	}
	return true;
}

//验证QQ号（5~20位）
function checkQQ($qq){
	if(!preg_match('/^[1-9][0-9]{4,20}$/',$qq)){
		return 'QQ号码格式不符合要求';
	}
	return true;
}

//验证电话号码（11位-12位）
function checkPhone($num){
	if(!preg_match('/^^\d{3}-\d{8}|\d{4}-\d{7,8}$/',$num)){
		return '电话号码不符合要求';
	}
	return true;
}

?>