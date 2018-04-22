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
		
		
		$a= $_POST['img'];//需要转换的图片
		
		$image = preg_replace('/\r|\n/', '', $a);//去除特殊字符串
		//输出转换后的字符串
		/**
			*@author sphynx QQ327388905
			*@param 图片换转base64函数
			*@param $images 需要转换的图片
			**/
		
	
	
		//print_r($name);
		//$image = mysqli_real_escape_string($conn,file_get_contents($_FILES['photo']['tmp_name']));  
		//$type = $_FILES['photo']['type'];  
		$sqlstr = "insert into ad_zone(name,image) values('".$name."','".$image."')";  
	  
		@mysqli_query($conn,$sqlstr) or die(mysqli_error());  
	  
		header('location:upload_image_todb.php');  
		exit();  
	  
	// 显示图片  
	}elseif($action=='show'){  
	  
		$id = isset($_GET['id'])? intval($_GET['id']) : 0;  
		$sqlstr = "select * from ad_zone where id=$id";  
		$query = mysqli_query($conn,$sqlstr) or die(mysqli_error());  
		  
		$thread = mysqli_fetch_assoc($query);  
		  
		if($thread){  
			header('content-type:'.$thread['type']);  
			echo $thread['image'];  
			exit();  
		}  
	  
	}else{  
	// 显示图片列表及上传表单  
?>  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">  
<html>  
	 <head>  
	  <meta http-equiv="content-type" content="text/html; charset=utf-8">  
	  <title> upload image to db demo </title> 
	  <script> 
		  window.onload = function(){ 
			var input = document.getElementById("demo_input"); 
			var result= document.getElementById("result"); 
			var img_area = document.getElementById("img_area"); 
			if ( typeof(FileReader) === 'undefined' ){
			  result.innerHTML = "抱歉，你的浏览器不支持 FileReader，请使用现代浏览器操作！"; 
			  input.setAttribute('disabled','disabled'); 
			}else{
			  input.addEventListener('change',readFile,false);
			} 
		  }
		  function readFile(){
			var file = this.files[0]; 
			//这里我们判断下类型如果不是图片就返回 去掉就可以上传任意文件  
			if(!/image\/\w+/.test(file.type)){
			  alert("请确保文件为图像类型"); 
			  return false; 
			}
			var reader = new FileReader(); 
			reader.readAsDataURL(file); 
			console.log();
			reader.onload = function(e){ 
				result.innerHTML = this.result; 
				img_area.innerHTML = '<div class="sitetip">图片img标签展示：</div>![]('+this.result+')'; 
			}
		  } 
		</script> 
		</head>

<body> 
  <form action="upload_image_todb.php" method="post" enctype="multipart/form-data">
		<p>名称：<input type="text" name="name"></p>
	  <input type="file" value="sdgsdg" id="demo_input" /> 
	  <textarea name="img" id="result" rows=30 cols=300></textarea> 
	  <p id="img_area"></p> 
	  <p><input type="hidden" name="action" value="add"><input type="submit" name="b1" value="提交"></p>
	</form>
 
	  
<?php  
	$sqlstr = "select * from ad_zone order by id desc limit 1";  
	$query = mysqli_query($conn,$sqlstr) or die(mysqli_error());  
	//$result = array();  
	$thread=mysqli_fetch_assoc($query);
	//print_r($thread);	
	//foreach($result as $val){  
		echo '<p><img src="upload_image_todb.php?action=show&id='.$thread['id'].'&t='.time().'" width="150"></p>'; 
		echo $thread['name'];
	//}  
?>  
	  
	 </body>  
</html>  
<?php  
	}  
?>  