<?php
	header("Content-Type: text/html; charset=utf8");
	// 连接数据库  
	$conn=@mysqli_connect("59.110.232.36","njt","njt123")  or die(mysql_error());  
	@mysqli_select_db($conn,'cAuth') or die(mysqli_error()); 
	mysqli_query($conn,"set names 'utf8'");
	  
	// 判断action  
	$action = isset($_REQUEST['action'])? $_REQUEST['action'] : '';  
	  
	  
	// 上传图片  
	if($action=='add'){  
	  
		$name = $_POST['name'];
		$award = $_POST['award'];
		$address = $_POST['address'];
		$a= trim($_POST['img']);//需要转换的图片
		
		//echo '<p><img src="'.$thread['id'].'" width="150"></p>';
		//print_r($a);
		$image = preg_replace('/\r|\n/', '', $a);//去除特殊字符串
		//输出转换后的字符串
		
		//print_r($image);
		 
		$sqlstr = "insert into ad_zone(name,award,address,image) values('".$name."','".$award."','".$address."','".$image."')";  
	  
		@mysqli_query($conn,$sqlstr) or die(mysqli_error());  
	  
		//echo '<p><img src="'.$image.'" width="150"></p>';
		echo "添加成功！";
		header('location:index.html');  
		exit();  
	  
	// 显示图片  
	}else{
		echo "未知错误！";
	} 
?> 