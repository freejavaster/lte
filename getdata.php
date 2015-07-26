<?php
session_start();
	
	function connect_mysql()
	{
		$conn=@mysql_connect("localhost","root","root")or die ("mysql can not connect!"); 
		@mysql_select_db("lte",$conn) or die ("db can not connect!`".mysql_error()); 
		mysql_query('SET NAMES UTF8')or die ("UTF8 can not work!"); 
	}

	function login_a($uname,$pwd)
	{
		connect_mysql();
		$pwd=md5($pwd);//加密密码
		$sql="SELECT `id`,`username`,`pwd` FROM `userinfo` WHERE `username`='$uname' and `pwd` ='$pwd'";
		//echo $sql;
		$result=mysql_query($sql);
		
		$nubrows=mysql_num_rows($result); 
		if($nubrows==1)
		{
			$res_arr=mysql_fetch_array($result);

			$_SESSION["uname"]=$uname;
			$_SESSION["timeout"]=time();
			$now_time=time();

			$data= $res_arr;//array('info' =>"login successed" , 'uname' =>$uname ,'timeout' =>$now_time );
			//echo $_SESSION["timeout"]."--".$_SESSION["uname"];
			$data["info"]="login successed";
		}
		else
		{
			$data="username or password wrong, please try again!";
		}
		return json_encode($data);
	}
	if(isset($_REQUEST["action_type"]))
	{
		if($_REQUEST["action_type"]=="login")
		{
			$uname=$_POST["uname"];
			$pwd=$_POST["pwd"];
			echo login_a($uname,$pwd);
		}
		elseif($_REQUEST["action_type"]=="timeout")
		{
			get_session_timeout();
		}
	}

	function get_session_timeout()
	{

		if(isset($_SESSION["uname"]))
		{
			echo "not timeout";
			echo $_SESSION["uname"];
		}
		else
		{
			echo "timeout!!!!!";
		}
	}

?>