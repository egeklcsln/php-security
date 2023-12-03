<?php

	if(!access('user')){

		header("Location: http://localhost/security/public/login");
		die;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Profile</title>
</head>
<body>

	<style type="text/css">
		*{
			font-family: tahoma;
			font-size: 14px;
		}

		.container{
			padding: 10px;
			box-shadow: 0px 0px 10px #aaa;
			margin: auto;
			margin-top: 20px;
			width: 100%;
			max-width: 800px;
			min-height: 100px;

		}

		.post{
			border-bottom: solid thin #ccc;
		}
		.text{
			padding:4px;
			background-color:#eee;
		}
		.timestamp{
			font-size: 12px; 
			color: #aaa;
			float: right;
		}

	</style>
	<center><h1>Profile</h1></center>

	<?php include('header.php')?>

	<div class="container" style="">

		<center><h1 style="color:#f0f;">Profile</h1></center>

		<?php
 			
 			
				//get profile
				$profile = new User();

				if(isset($_GET['id']) || isset($_SESSION['user_id'])){

					$id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'];
					$result = $profile->get_profile($id);

					if($result)
					{
						foreach ($result as $row) {
							// code...

							//display profile
							echo "

								<div class='post'>
									<div>
										<h2>Name:".htmlspecialchars($row['name'])."</h2>
									</div>
									<div>
										<h2>Email: ".htmlspecialchars($row['email'])."</h2>
									</div>
									<div>
										<p class='text'>Rank: ".htmlspecialchars($row['rank'])."</p>
									</div>
									<div>
										<p class='text'>Gender: ".htmlspecialchars($row['gender'])."</p>
									</div>
									<div>
										<p class='text'>Password: ".htmlspecialchars($row['password'])."</p>
									</div>
									
 									<br style='clear: both;'>
								</div>
							";
						}
					}
				}else{
					echo "the profile was not found";
				}
	 

		?>

	</div>
</body>
</html>