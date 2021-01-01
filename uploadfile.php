<html>
	<head>
		<title>Tải Lên Tập Tin</title>
		<meta charset="utf8">
		<link rel="stylesheet" type="text/css" href="./View/index.css">
	</head>
	<body>
		<div id="content">
			<?php include 'view/header.html'; ?>
			<div class="up">
				<div class="upload">
					<h1>Tải lên tập tin</h1>
					<form action="xulyfile.php" method="POST" enctype="multipart/form-data">
						<input id="uploadfile" type="file" name="txt"><br/>
						<input type="submit" value="Gửi">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
