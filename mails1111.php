<?php
session_start();
	
	function connect_mysql()
	{
		$conn=@mysql_connect("localhost","root","root")or die ("mysql can not connect!"); 
		@mysql_select_db("lte",$conn) or die ("db can not connect!`".mysql_error()); 
		mysql_query('SET NAMES UTF8')or die ("UTF8 can not work!"); 
	}

	function mail_box()
	{
		connect_mysql();
		$user_id=12;
		$sql="SELECT `id`, `user_id`, `mail_read`, `mail_to_from_id`, `mail_subject`, `mail_content`, `mail_star`, `mail_datetime`, `mail_recieve_send`, `mail_del`, `mail_draft_id` FROM `mail_box` WHERE user_id= 12";
		echo $sql;
		$result=mysql_query($sql);
		
		$nubrows=mysql_num_rows($result); 
		if($nubrows>0)
		{
			$res_arr=mysql_fetch_array($result);
			$now_time=time();
			$data= $res_arr;
			$data["mail_nub"]=$nubrows;
		}
		else
		{
			$data="username or password wrong, please try again!";
		}
		return json_encode($data);
	}
	if(isset($_REQUEST["action_type"]))
	{
		if($_REQUEST["action_type"]=="mail_box")
		{
			echo mail_box();
		}
	}

?>