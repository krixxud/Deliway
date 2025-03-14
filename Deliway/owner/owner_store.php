<?php
session_start();
include "../config/db.php"; 

$user_id = $_POST['user_id'];
$store_name = $_POST['store_name'];
$store_memo = $_POST['store_memo'];
$store_address1 = $_POST['store_address1'];
$store_call = $_POST['store_call'];
$store_weekday1 = $_POST['store_weekday1'];
$store_weekday2 = $_POST['store_weekday2'];
$store_weekend1 = $_POST['store_weekend1'];
$store_weekend2 = $_POST['store_weekend2'];
$store_breaktime = $_POST['store_breaktime'];
$store_service = $_POST['store_service'];
$store_reser1 = $_POST['store_reser1'];
$store_reser2 = $_POST['store_reser2'];
$store_pickup = $_POST['store_pickup'];
$store_pickup1 = $_POST['store_pickup1'];
$store_option1_memo = $_POST['store_option1_memo'];
$store_option1 = $_POST['store_option1'];
$store_option2 = $_POST['store_option2'];
$store_option3 = $_POST['store_option3'];
$store_option4 = $_POST['store_option4'];
$store_option4_memo = $_POST['store_option4_memo'];
$store_keyword1 = $_POST['store_keyword1'];
$store_keyword2 = $_POST['store_keyword2'];
$store_keyword3 = $_POST['store_keyword3'];
$store_category = $_POST['store_category'];


$files = $_FILES["upfile"];
	$count = count($files["name"]);
			
	$upload_dir = '../code/upload/';
    
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


$sql = "UPDATE store SET
        store_name = '".$store_name."',
        store_call = '".$store_call."',
        store_memo = '".$store_memo."',
        store_address1 = '".$store_address1."',
        store_weekday1 = '".$store_weekday1."',
        store_weekday2 = '".$store_weekday2."',
        store_weekend1 = '".$store_weekend1."',
        store_weekend2 = '".$store_weekend2."',
        store_breaktime = '".$store_breaktime."',
        store_service = '".$store_service."',
        store_reser1 = '".$store_reser1."',
        store_reser2 = '".$store_reser2."',
        store_pickup = '".$store_pickup."',
        store_pickup1 = '".$store_pickup1."',
        store_option1_memo = '".$store_option1_memo."',
        store_option1 = '".$store_option1."',
        store_option2 = '".$store_option2."',
        store_option3 = '".$store_option3."',
        store_option4 = '".$store_option4."',
        store_option4_memo = '".$store_option4_memo."',
        file_name_2 = '".$upfile_name[0]."',
        file_name_3 = '".$upfile_name[1]."',
        file_name_4 = '".$upfile_name[2]."',
        file_copied_2 = '".$copied_file_name[0]."',
        file_copied_3 = '".$copied_file_name[1]."',
        file_copied_4 = '".$copied_file_name[2]."',
        store_keyword1 = '".$store_keyword1."',
        store_keyword2 = '".$store_keyword2."',
        store_keyword3 = '".$store_keyword3."',
		store_category = '".$store_category."' where user_id='".$_SESSION['user_id']."'";

        mysqli_query($con, $sql);

?>

<script>
    alert("매장정보를 수정하였습니다!");
    location.href="owner_store.html";
</script>