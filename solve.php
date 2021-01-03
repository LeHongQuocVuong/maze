<!DOCTYPE html> 
<html lang='en'>
	<head>
		<meta charset="utf-8" />
		<title>Giải mê cung</title>
		<link rel="stylesheet" type="text/css" href="./View/index.css">
	</head>
	<body>
		<div id="content">
			
			<?php include 'view/header.html'; ?>
			<div class="centermaze">
				<div class="maze">
					<div class="main">
						<?php 
						$check=0;	//dem loi
						$maze = array();
						$n=$m=0;
						$file = fopen('input.txt',"r");
						// Kiem tra file co duoc mo thanh cong hay khong??
						if(!$file) {
							echo 'Mo file khong thanh cong !';
						}
						else {
							$loop=0; // dem vong lap
							
							$data = @file('input.txt');
							
							foreach ($data as $value){
								$a = explode(' ', $value);
								if($loop==0){
									$n = (int)$a[0];
									$m = (int)$a[1];
								}
								else if (!isset($a)){
									$check++;
									break;
								}
								else{
									for($i=0;$i<$m;$i++){
										if((int)$a[$i] <0 || (int)$a[$i] >3){
											$check++;
											break;
										}
										else $maze[$i+($loop-1)*$m] = (int)$a[$i];
									}
								}
								$loop++;
							}
						}
						if($check != 0) {
							echo "Ma trận nhập không hợp lệ!";
							
						}
						else{
							
								// chay chuong trinh C.
								exec("maze.exe", $out);
								$output= fopen("output.txt","r");
								if(!$output) {
									echo 'Mo file khong thanh cong !';
								}
								else {
									echo "<script>";
									echo "var wtgg = ["; // way to get goal
									$data1 = @file('output.txt');
									foreach($data1 as $value1){
										echo $value1.",";
									}
									echo "-1];";
									echo "</script>";
								}
							// ------------- table ----------------- 
							echo "<table id='myTable' style='border-spacing:0px;padding:10px;'>";
							for ($i=0;$i<$n; $i++){
								echo "<tr>";
								for($j=0;$j<$m;$j++){
									if ($maze[$i*$m + $j] == 1){
										echo "<td style='background-color:Orange'>1</td>";
									}
									else if ($maze[$i*$m + $j] == 0 ){
										echo "<td id='".($i*$m+$j)."' style='background-color:White'>0</td>";
									}
									else if ($maze[$i*$m + $j] == 4 ){
										echo "<td id='".($i*$m+$j)."' class='action' style='background-color:#a6dfff'>0</td>";
									}
									else if ($maze[$i*$m + $j] == 2){
										echo "<td id='".($i*$m+$j)."' style='background-color:Tomato'>s</td>";
									}
									else {
										echo "<td id='".($i*$m+$j)."' style='background-color:DodgerBlue'>g</td>";
									}
								}
								echo "</tr>";
							}
							echo "</table>";
							
							// ------------- /table ----------------- 
							echo "<button id=\"solvebutton\" onclick=\"myFunction()\">Giải</button>";
						}
						
						?>						
						
						<script>						
						var index = 0;
						var goalway = 0;
						
						function myFunction() {        				//  tạo hàm lập
							setTimeout(function() {   				//  gọi hàm mỗi 50ms
								var id = wtgg[index];	   
								document.getElementById(id).style = "background-color:LightSkyBlue";
								
								index ++;
								if (index < wtgg.length -1){           
									myFunction();             		//  gọi hàm
								}
							}, 50)									// thời gian nghỉ
						}
						</script>
					</div>
				</div>
			</div>
		</div>
		
</body>
</html>