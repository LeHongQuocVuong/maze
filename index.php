<?php
if(isset($_POST['action'])){
	$action = $_POST['action'];
}
else {
	$action = 'home';
}

if ($action == 'home'){
	$solve = 0;
	include('homepage.php');
}
else if ($action == 'solve'){
	$solve = 1;
	include('solve.php');
}

?>
<html>
	<head>
		<title>Vương B1706555</title>
		<link rel="stylesheet" type="text/css" href="./View/index.css">
	</head>
	<body>
		<div id="content">
			<div class="index1">
				<div class="index">
					<h2>Sinh Viên Thực Hiện</h2>
					<table>
						<tr>
							<td>Lê Hồng Quốc Vương</td>
							<td>B1706555</td>
						</tr>			
					</table>
				</div>
			</div>
		</div>
		
	</body>
</html>