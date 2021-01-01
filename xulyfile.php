<?php
	// unlink('input.txt');
	// $path = 'test.txt';
		////Những loại file được phép upload
		$types    = array('txt');
        // Nếu người dùng có chọn file để upload
        if (isset($_FILES['txt']))
        {
            // Nếu file upload không bị lỗi,
            // Tức là thuộc tính error > 0
            if ($_FILES['txt']['error'] > 0)
            {
                echo 'File Upload Bị Lỗi';
            }
			// else if(!in_array(pathinfo($_FILES['txt']['tmp_name'], PATHINFO_EXTENSION),$types))
				// echo pathinfo($_FILES['txt']['name'], PATHINFO_EXTENSION);
            else{
                // Upload file
				move_uploaded_file($_FILES['txt']['tmp_name'], $_FILES['txt']['name']);
                if(!in_array(pathinfo($_FILES['txt']['name'], PATHINFO_EXTENSION),$types))
				{
					echo 'Phai nhap file txt';
					unlink($_FILES['txt']['name']);
					header("location:uploadfile.php");
				}else{
                echo 'File Uploaded';
				rename($_FILES['txt']['name'], 'input.txt');
				header("location:solve.php");
				}
            }
        }
        else{
            echo 'Bạn chưa chọn file upload';
        }
    
	
	
	
?>