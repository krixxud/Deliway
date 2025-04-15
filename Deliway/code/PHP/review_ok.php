<?php
session_start();
include "../../config/db.php";

$store_idx = $_POST['store_idx'];
$reser_idx = $_POST['reser_idx'];
$user_id = $_POST['user_id'];

$visit_opt1 = $_POST['visit_opt1'];
$visit_opt2 = $_POST['visit_opt2'];
$visit_opt3 = $_POST['visit_opt3'];
$visit_opt4 = $_POST['visit_opt4'];
$visit_opt5 = $_POST['visit_opt5'];

$review_score = $_POST['review_score'];
$review_title = $_POST['review_title'];
$review_memo = $_POST['review_memo'];
$review_wdate = date('Y-m-d H:i:s');

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

    $sql = "INSERT INTO review (reser_idx, user_id, store_idx, 
                                visit_opt1, visit_opt2, visit_opt3, visit_opt4, visit_opt5, 
                                review_score, review_title, review_memo, review_wdate, 
                                file_name_0, file_name_1, file_name_2, file_name_3, file_name_4, 
                                file_copied_0, file_copied_1, file_copied_2, file_copied_3, file_copied_4)
                        VALUES ('".$reser_idx."','".$user_id."','".$store_idx."',
                                '".$visit_opt1."','".$visit_opt2."','".$visit_opt3."','".$visit_opt4."','".$visit_opt5."',
                                '".$review_score."','".$review_title."','".$review_memo."','".$review_wdate."',
                                '".$upfile_name[0]."','".$upfile_name[1]."','".$upfile_name[2]."','".$upfile_name[3]."','".$upfile_name[4]."',
                                '".$copied_file_name[0]."','".$copied_file_name[1]."','".$copied_file_name[2]."','".$copied_file_name[3]."','".$copied_file_name[4]."')";


    echo $sql;

	$result = mysqli_query($con,$sql);
	if ($result) {
		echo "<script> alert('리뷰가 등록되었습니다.'); location.href='../review_detail.html'; </script>";
	} else {
		echo "<script> alert('리뷰 등록에 실패: ".mysqli_error($con)."'); history.back(); </script>";
	}

	?>