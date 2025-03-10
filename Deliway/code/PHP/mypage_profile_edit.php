<?php

session_start();
include "../../config/db.php";

$user_name = $_POST['user_name'];
$user_intro = $_POST['user_intro'];

$files = $_FILES["upfile"];
	$count = count($files["name"]);
			
	$upload_dir = '../upload/';
    
    // 다중
	for ($i=0; $i<$count; $i++)
	{
		$upfile_name[$i]     = $files["name"][$i];
		$upfile_tmp_name[$i] = $files["tmp_name"][$i];
		$upfile_type[$i]     = $files["type"][$i];

		
		$upfile_size[$i]     = $files["size"][$i];
		$upfile_error[$i]    = $files["error"][$i];
      
	
		$file = explode(".", $upfile_name[$i]);
		$file_name = $file[0]; // 파일명
		$file_ext  = $file[1]; // 확장자명

		if (!$upfile_error[$i])
		{
			$new_file_name = date("Y_m_d_H_i_s");
			$new_file_name = $new_file_name."_".$i;
			$copied_file_name[$i] = $new_file_name.".".$file_ext;
			$uploaded_file[$i] = $upload_dir.$copied_file_name[$i];

			if( $upfile_size[$i]  > 51200000 ) {
				echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(5MB)을 초과합니다!<br>파일 크기를 확인해주세요.');
				history.go(-1)
				</script>
				");
				exit;
			}

			if ( ($upfile_type[$i] != "image/gif") &&
				($upfile_type[$i] != "image/jpg") &&
				($upfile_type[$i] != "image/png") &&
				($upfile_type[$i] != "image/bmp") &&
				// ($upfile_type[$i] != "application/pdf") &&
				// ($upfile_type[$i] != "application/hwp") &&
				// ($upfile_type[$i] != "application/octet-stream") &&
				($upfile_type[$i] != "image/jpeg") )
			{
				echo("
					<script>
						alert('업로드가 불가능한 확장자입니다.');
						history.go(-1)
					</script>
					");
				exit;
			}

			if (!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i]) )
			{
				echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
				exit;
			}
		}
	}

    $sql = "update member set user_name = '".$user_name."', user_intro = '".$user_intro."', file_name_0 = '".$upfile_name[0]."', file_copied_0 = '".$copied_file_name[0]."'
    where user_id = '".$_COOKIE['user_id']."'";

    mysqli_query($con,$sql);

?>

<script>
	alert('프로필 수정이 완료되었습니다');
	location.href = "../mypage.html"
</script>