<?php
if (isset($_GET['sodong'])){
	$sodong = $_GET['sodong'];
	$socot = $_GET['socot'];
	$mang = $_GET['mang'];
	$file = fopen( "input.txt", "w" );
	if( $file == false ) {
		echo ("Error in opening new file");
		exit();
	}  
	fwrite($file, "$sodong $socot\n$mang");
	fclose($file);
	header("location:solve.php");
}
?>
<!Doctype html>
<html>
	<head>
		<title>Nhập Mê Cung</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="./View/index.css">
		
		<script>
			function thongbao(){
				var dong =document.getElementById("dong").value;
				var cot =document.getElementById("cot").value;
				var mang =document.getElementById("mang").value;
				var kiemtradongcot= /^[0-9]{1,2}$/
				var ok = true;
				var ok1 = true;
				if(dong!=="" && kiemtradongcot.test(dong)&& dong>4 && dong<=25){
					document.getElementById("dong").style.display="none";
					ok1 = true;
				} else {
					document.getElementById("thongbaodong").style.color="red";
					document.getElementById("dong").style.border="2px solid red";
					document.getElementById("thongbaodong").style.display="block";
					ok1 = false;
				}
				var ok2 = true;
				if(cot!=="" && kiemtradongcot.test(cot)&& cot>4 && cot<=25){
					document.getElementById("cot").style.display="none";
					ok2 = true;
				} else {
					document.getElementById("thongbaocot").style.display="block";
					document.getElementById("thongbaocot").style.color="red";
					document.getElementById("cot").style.border="2px solid red";
					ok2 = false;
				}
				var ok3 = true;
				if(mang!==""){
					document.getElementById("mang").style.display="none";
					ok3 = true;
				} else {
					document.getElementById("thongbaomang").style.display="block";
					document.getElementById("thongbaomang").style.color="red";
					document.getElementById("mang").style.border="2px solid red";
					ok3 = false;
				}
				
				if(ok1 == true && ok2 == true && ok3 == true){
					ok = true;
					alert("Thao tác thành công!");
				} else {
					ok = false;
				}
				return ok;
				
			}
		</script>
	</head>
	<body>
		<div id="content">
		<?php include 'view/header.html';?>	
		<div class="noidung">
			<div class="sign">
				<div class="headcreate">
				</div>
				<div class="main">
				<b>Số dòng và số cột phải lớn hơn 4, nhỏ hơn 25</b>
					<form action="import.php" method="GET" onsubmit="return thongbao()">
						<input type="text" id="dong" placeholder="Hãy nhập số dòng" name="sodong">
						<p id="thongbaodong">Dòng bạn nhập không hợp lệ!</p>
						<input type="text" id="cot" placeholder="Hãy nhập số cột" name="socot">
						<p id="thongbaocot">Cột bạn nhập không hợp lệ!</p>
						<textarea name="mang" id="mang" placeholder="Hãy nhập mảng..."></textarea>
						<p id="thongbaomang">Mảng bạn nhập không hợp lệ!</p>
						<input type="submit" value="Gửi">
					</form>
				</div>
			</div>
		</div>
		</div>
		
	</body>
</html>