<?php
session_start();
include 'database_of.php';

$uid = mysqli_real_escape_string($connect, $_POST['uid']);
$password = mysqli_real_escape_string($connect, $_POST['password']);

//$low = strtolower($name);

if(empty($uid) || empty($password)){
	echo "empty user input!";	
}
else
{
	$sql = "SELECT * FROM log WHERE uid=?";										
	//$result = mysqli_query($connect, $sql);

	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "s", $uid);
	mysqli_stmt_execute($st);

	$result = mysqli_stmt_get_result($st);

	$reultcheck = mysqli_num_rows($result);
											
	if($reultcheck < 1){
		echo "login error!";
	}
	else
	{
		if($row = mysqli_fetch_assoc($result)){
			$hashedPwdCheck = password_verify($password, $row['password']);
					
			if($hashedPwdCheck == false){
				echo "wrong password!";
			}
					
			elseif($hashedPwdCheck == true){					

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

		        if($row = mysqli_fetch_assoc($resultv)){
		            $_SESSION['login_details_id'] = $row['login_details_id'];
		        }

			    echo "index.php";
		        }
		    else
		    {
		        $sqlv = "SELECT * FROM login_details WHERE user_id = '".$_SESSION['user_id']."'";
	            $resultv = mysqli_query($connect, $sqlv);

		        if($row = mysqli_fetch_assoc($resultv))
		        {
		            $_SESSION['login_details_id'] = $row['login_details_id'];
		        }
					echo "index.php";
		    }												
		}
	}
}
}

?>