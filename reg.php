<?php
	function connect_mysql()
	{
		$conn=@mysql_connect("localhost","root","root")or die ("mysql can not connect!"); 
		@mysql_select_db("lte",$conn) or die ("db can not connect!`".mysql_error()); 
		mysql_query('SET NAMES UTF8')or die ("UTF8 can not work!"); 
	}

	function check_uname($uname)
	{
		connect_mysql();
		$sql="SELECT `id` FROM `userinfo` WHERE `username`='$uname'";
		//echo $sql;
		$result=mysql_query($sql);
		$nubrows=mysql_num_rows($result); 
		if($nubrows==1)
		{
			$data="Username already exist!";
		}
		else
		{
			$data="username ok!";
		}
		return $data;
	}

	function reg_uer($uname,$pwd,$pwd2,$email)
	{
		if($pwd===$pwd2)
		{
			connect_mysql();
			$pwd=md5($pwd);//加密密码
			$sql="INSERT INTO `userinfo`(`username`, `pwd`, `addtime`) VALUES ('$uname','$pwd',now())";
			mysql_query($sql);
			$nubrows= mysql_insert_id();//insert 数据后返回的ID
			if($nubrows>0)
			{
				$data="regist successed!";
			}
			else
			{
				$data="regist fail, please try again!";
			}
		}
		else
		{
			$data="two password is not matched, please try again!";
		}
		
		return $data;
	}
	if(isset($_POST["chk_user"]) && $_POST["chk_user"]==0)
	{
	$uname=$_POST["uname"];
	$pwd=$_POST["pwd"];
	$pwd2=$_POST["pwd2"];
	$email=$_POST["email"];
	echo reg_uer($uname,$pwd,$pwd2,$email);
	}
	if(isset($_POST["chk_user"]) && $_POST["chk_user"]==1) 
	{
		$uname=$_POST["uname"];
		echo check_uname($uname);
	}
?>