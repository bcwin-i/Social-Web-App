<?php
session_start();
include 'database_of.php';

$name = mysqli_real_escape_string($connect, $_POST['name']);
$index = mysqli_real_escape_string($connect, $_POST['index']);

//$low = strtolower($name);

if(empty($name) || empty($index)){
	echo "empty user input!";	
}
else
{
	$sql = "SELECT * FROM log WHERE name=? AND dob=?;";
	//$result = mysqli_query($connect, $sql);
			
	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "ss", $name, $index);
	mysqli_stmt_execute($st);

	$result = mysqli_stmt_get_result($st);

	$reultcheck = mysqli_num_rows($result);
			
	if($reultcheck < 1)
	{
		echo "login error!";
	}
	else
	{
		if($row = mysqli_fetch_assoc($result)){
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['user_name'] = $row['name'];
			$_SESSION['user_dob'] = $row['dob'];
			$_SESSION['unique_id']	= $row['uid'];
			$_SESSION['password']	= $row['password'];

			$sqld = "SELECT * FROM login_details WHERE user_id='".$row['id']."'";
            $resultd = mysqli_query($connect, $sqld);
            $reultcheckd = mysqli_num_rows($resultd);

            if($reultcheckd < 1){
				$sqll = "INSERT INTO login_details (user_id) VALUES ('".$row['id']."')";
              	$resultl = mysqli_query($connect, $sqll);

              	$sqlv = "SELECT * FROM login_details WHERE user_id = '".$_SESSION['user_id']."'";
             	$resultv = mysqli_query($connect, $sqlv);

	            if($rowl = mysqli_fetch_assoc($resultv)){
	                $_SESSION['login_details_id'] = $rowl['login_details_id'];
	            }
						
				if(!empty($_SESSION['unique_id']) &&  !empty($_SESSION['password']))
				{
					echo "rep";
				}	
				else{
					echo "index.php?login=sucess";
				}
			}
			else
			{
				$sqlv = "SELECT * FROM login_details WHERE user_id = '".$_SESSION['user_id']."'";
             	$resultv = mysqli_query($connect, $sqlv);

	            if($rowl = mysqli_fetch_assoc($resultv)){
	                $_SESSION['login_details_id'] = $rowl['login_details_id'];
	            }

				if(!empty($_SESSION['unique_id']) &&  !empty($_SESSION['password']))
				{
					echo "rep";
				}	
				else{
						echo "index.php?login=sucess";
				}
			}
		}
	}
		
}

?>
