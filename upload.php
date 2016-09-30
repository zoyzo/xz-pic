<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	$img_name = $_FILES["file"]["name"];	//文件名称
	$suffix = substr(strrchr($img_name, '.'), 1);//文件后缀
	$new_name = date('his',time()).rand(1000,9999).'.'.$suffix;		//新的文件名
	$img_type = $_FILES["file"]["type"];	//文件类型
	$img_size = $_FILES["file"]["size"];	//文件大小
	$img_tmp = $_FILES["file"]["tmp_name"];	//临时文件名称
	$img_error = $_FILES["file"]["error"];	//错误代码

	$max_size = 2097152;		//最大上传大小
	$current_time = date('ym',time());	//当前月份
	$dir = 'uploads/'.$current_time;	//完整路径
	$dir_name = $dir.'/'.$new_name;
	

	//判断文件夹是否存在，不存在则创建目录
	if(!file_exists($dir)){
		mkdir($dir,0777,true);
	}
	

	//判断文件类型
	switch ( $img_type )
	{
		case "image/gif":
			$status = 1;
			break;	
		case "image/jpeg":
			$status = 1;
			break;	
		case "image/pjpeg":
			$status = 1;
			break;	
		case "image/png":
			$status = 1;
		break;	
		default:
			$status = 0;
			break;
	}

	//开始上传
	if(($img_size <= $max_size) && ($status == 1)) {
		if ($_FILES["file"]["error"] > 0)
	    {
	    	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	    }
	    else {
		    //如果上传成功
		    if(move_uploaded_file($img_tmp,$dir_name)){
			    $domain = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			    
			    //请在下面设置您自己的域名
			    $img_url = 'http://localhost/'.$dir_name;		//自定义图片路径
			    $img_info = getimagesize($dir_name);
			    $img_width = $img_info['0'];	//图片宽度
			    $img_height = $img_info['1'];	//图片高度
			    $re_data = array("linkurl" => $img_url,width => $img_width,"height" => $img_height,"status" => 'ok');
			    //返回json格式
			    echo json_encode($re_data);
		    }
		    //没有上传成功
		    else{
			    echo '错误';
		    }
	    }
	}
	else{
		$re_data = array("linkurl" => $img_url,width => $img_width,"height" => $img_height,"status" => 'no');
		//返回json格式
		echo json_encode($re_data);
	}
?>