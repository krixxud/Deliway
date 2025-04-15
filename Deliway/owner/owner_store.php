<?php
session_start();
include "../config/db.php";

$store_lat = $_POST['find_lat']; // 위도
$store_lng = $_POST['find_lng']; // 경도

// 세션에서 user_id 가져오기
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); history.back();</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// POST 데이터 받기
$store_name = mysqli_real_escape_string($con, $_POST['store_name']);
$store_memo = mysqli_real_escape_string($con, $_POST['store_memo']);
$store_address1 = mysqli_real_escape_string($con, $_POST['store_address1']);
$store_call = mysqli_real_escape_string($con, $_POST['store_call']);
$store_weekday1 = $_POST['store_weekday1'];
$store_weekday2 = $_POST['store_weekday2'];
$store_weekend1 = $_POST['store_weekend1'];
$store_weekend2 = $_POST['store_weekend2'];
$store_breaktime = $_POST['store_breaktime'];
$store_service = isset($_POST['store_service']) ? 1 : 0;
$store_reser1 = $_POST['store_reser1'];
$store_reser2 = $_POST['store_reser2'];
$store_pickup = isset($_POST['store_pickup']) ? 1 : 0;
$store_pickup1 = $_POST['store_pickup1'];
$store_option1_memo = mysqli_real_escape_string($con, $_POST['store_option1_memo']);
$store_option1 = isset($_POST['store_option1']) ? 1 : 0;
$store_option2 = isset($_POST['store_option2']) ? 1 : 0;
$store_option3 = isset($_POST['store_option3']) ? 1 : 0;
$store_option4 = isset($_POST['store_option4']) ? 1 : 0;
$store_option4_memo = mysqli_real_escape_string($con, $_POST['store_option4_memo']);
$store_keyword1 = mysqli_real_escape_string($con, $_POST['store_keyword1']);
$store_keyword2 = mysqli_real_escape_string($con, $_POST['store_keyword2']);
$store_keyword3 = mysqli_real_escape_string($con, $_POST['store_keyword3']);
$store_category = $_POST['store_category'];

// 기존 파일 유지 위한 쿼리 실행
$query = "SELECT file_copied_2, file_copied_3, file_copied_4 FROM store WHERE user_id='$user_id'";
$result = mysqli_query($con, $query);
$existing_files = mysqli_fetch_assoc($result);

$files = $_FILES["upfile"];

	$count = count($files["name"]);
		
	$upload_dir = '../code/upload/';

	for ($i=0; $i<$count; $i++)
	{
		$upfile_name[$i]     = $files["name"][$i];
		
		$upfile_tmp_name[$i] = $files["tmp_name"][$i];
		$upfile_type[$i]     = $files["type"][$i];
		$upfile_size[$i]     = $files["size"][$i];
		$upfile_error[$i]    = $files["error"][$i];
        
		$file = explode(".", $upfile_name[$i]);
		
		
		$file_name = $file[0];
		$file_ext  = $file[1];

		if (!$upfile_error[$i])
		{
			$new_file_name = date("Y_m_d_H_i_s");
			$new_file_name = $new_file_name."_".$i;
			$copied_file_name[$i] = $new_file_name.".".$file_ext;
			$uploaded_file[$i] = $upload_dir.$copied_file_name[$i];

			if( $upfile_size[$i]  > 51200000 ) {
				echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(5MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
				exit;
			}

			if ( ($upfile_type[$i] != "image/gif") &&
				($upfile_type[$i] != "image/jpeg") &&
				($upfile_type[$i] != "image/png") &&
				($upfile_type[$i] != "application/pdf") &&
				($upfile_type[$i] != "application/hwp") &&
				($upfile_type[$i] != "application/gpx") &&
				($upfile_type[$i] != "image/pjpeg") )
			{
				echo("
					<script>
						alert('JPG와 GIF와 PNG 이미지 파일만 업로드 가능합니다!');
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

if ($mode==$_POST["modify"]) {

	$num_checked = isset($_POST['del_file']) ? count($_POST['del_file']) : 0;
	
		$position = $_POST['del_file'];

		for($i=0; $i<$num_checked; $i++)                      // delete checked item
		{
			$index = $position[$i];
			$del_ok[$index] = "y";
		}

		$sql = "select * from store where store_idx='".$store_idx."'";   // get target record
		
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($result);

		for ($i=0; $i<$count; $i++)					// update DB with the value of file input box
		{

			$field_org_name = "file_name_". ($i+2);
			
			$field_real_name = "file_copied_".($i+2);
			

			$org_name_value = $upfile_name[$i];
			
			$org_real_value = $copied_file_name[$i];
			

			if ($del_ok[$i] == "y")
			{
				$delete_field = "file_copied_".$i;
				$delete_name = $row[$delete_field];
				
				// $delete_path = "../code/upload/".$delete_name;

				if (!empty($delete_name)) {
					$delete_path = "../code/upload/".$delete_name;
					if (file_exists($delete_path) && is_file($delete_path)) {
						unlink($delete_path);
					}
				}

				// unlink($delete_path);

				$sql = "UPDATE store SET
                $field_org_name = '$org_name_value',
                $field_real_name = '$org_real_value',
				store_lat = '$store_lat',
        		store_lng = '$store_lng',
                store_name = '$store_name',
                store_call = '$store_call',
                store_memo = '$store_memo',
                store_address1 = '$store_address1',
                store_weekday1 = '$store_weekday1',
                store_weekday2 = '$store_weekday2',
                store_weekend1 = '$store_weekend1',
                store_weekend2 = '$store_weekend2',
                store_breaktime = '$store_breaktime',
                store_service = '$store_service',
                store_reser1 = '$store_reser1',
                store_reser2 = '$store_reser2',
                store_pickup = '$store_pickup',
                store_pickup1 = '$store_pickup1',
                store_option1_memo = '$store_option1_memo',
                store_option1 = '$store_option1',
                store_option2 = '$store_option2',
                store_option3 = '$store_option3',
                store_option4 = '$store_option4',
                store_option4_memo = '$store_option4_memo',
                store_keyword1 = '$store_keyword1',
                store_keyword2 = '$store_keyword2',
                store_keyword3 = '$store_keyword3',
                store_category = '$store_category'
                WHERE user_id = '$user_id'";
				mysqli_query($con,$sql);  // $sql 에 저장된 명령 실행
				
				
			}
			else
			{
				if (!$upfile_error[$i])
				{
					$sql = "UPDATE store SET
                    $field_org_name = '$org_name_value',
                    $field_real_name = '$org_real_value',
					store_lat = '$store_lat',
        			store_lng = '$store_lng',
                    store_name = '$store_name',
                    store_call = '$store_call',
                    store_memo = '$store_memo',
                    store_address1 = '$store_address1',
                    store_weekday1 = '$store_weekday1',
                    store_weekday2 = '$store_weekday2',
                    store_weekend1 = '$store_weekend1',
                    store_weekend2 = '$store_weekend2',
                    store_breaktime = '$store_breaktime',
                    store_service = '$store_service',
                    store_reser1 = '$store_reser1',
                    store_reser2 = '$store_reser2',
                    store_pickup = '$store_pickup',
                    store_pickup1 = '$store_pickup1',
                    store_option1_memo = '$store_option1_memo',
                    store_option1 = '$store_option1',
                    store_option2 = '$store_option2',
                    store_option3 = '$store_option3',
                    store_option4 = '$store_option4',
                    store_option4_memo = '$store_option4_memo',
                    store_keyword1 = '$store_keyword1',
                    store_keyword2 = '$store_keyword2',
                    store_keyword3 = '$store_keyword3',
                    store_category = '$store_category'
                    WHERE user_id = '$user_id'";
					
					mysqli_query($con,$sql);  // $sql 에 저장된 명령 실행
					
				}
			}

		}
		
        // 데이터베이스 업데이트
        $sql = "UPDATE store SET
		store_lat = '$store_lat',
        store_lng = '$store_lng',
        store_name = '$store_name',
        store_call = '$store_call',
        store_memo = '$store_memo',
        store_address1 = '$store_address1',
        store_weekday1 = '$store_weekday1',
        store_weekday2 = '$store_weekday2',
        store_weekend1 = '$store_weekend1',
        store_weekend2 = '$store_weekend2',
        store_breaktime = '$store_breaktime',
        store_service = '$store_service',
        store_reser1 = '$store_reser1',
        store_reser2 = '$store_reser2',
        store_pickup = '$store_pickup',
        store_pickup1 = '$store_pickup1',
        store_option1_memo = '$store_option1_memo',
        store_option1 = '$store_option1',
        store_option2 = '$store_option2',
        store_option3 = '$store_option3',
        store_option4 = '$store_option4',
        store_option4_memo = '$store_option4_memo',
        store_keyword1 = '$store_keyword1',
        store_keyword2 = '$store_keyword2',
        store_keyword3 = '$store_keyword3',
        store_category = '$store_category'
        WHERE user_id = '$user_id'";

mysqli_query($con,$sql);
}

?>

<script>
	alert('매장 정보 수정이 완료되었습니다.');
	location.href="owner_store.html";
</script>