
<?php
session_start();
require_once 'connection.php';
$txtreg =$txtemail=$errPL="";
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$txtemail =trim($_POST['txtemail']); 
	$txtreg =trim($_POST['txtreg']);
	if($txtemail!="" && $txtreg!=""){
		$stmt_in = $conn->prepare("SELECT * FROM hospitaldocsinfo where docId=? and email=? Limit 1");
		$stmt_in->execute(array($txtreg,$txtemail));
		$affected_rows_in = $stmt_in->rowCount();
		if($affected_rows_in < 1) 
		{	
			$errPL="Error: The RegNo or Password does not exist . Contact ICT !!!";
		}else{
			//check if application form is filled
				$row_two = $stmt_in->fetch(PDO::FETCH_ASSOC);
				$_SESSION['docID'] = $row_two['docId'];
				$_SESSION['logName'] = $row_two['docname'];
				header("location: adminHome.php");
				
			}
	}else{
		$errPL="Error: Empty or Invalid Data's Provided !!!";
	}									
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <?php include 'header.php'?>
    <link rel="stylesheet" type="text/css" href="css/mystyle.css">
    <body>
        <nav role="navigation"  class="navbar  navbar-fixed-top navbar-inverse">
            <h2 style="text-align: center;color:white">ANTENANTAL INFORMATION MANAGEMENT SYSTEM</h2>
        </nav>
        <div class="container">
            <div class="login">
                    <form role="form"  name="reg_form"  id="form" class="form-vertical" action="" enctype="multipart/form-data" method="POST">
                            <h4 style="margin-bottom:20px;padding:10px">Please Login - Staff</h4>
                        <hr/>
                            <div class="form-group">
                                <label for="txtreg">Hospital ID N<u>o</u> : </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="text" class="form-control" id="txtreg" name="txtreg" value="" required="true" placeholder="Enter Matriculation / Registration No"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtemail">Email ADD: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span> 
                                    <input type="email" class="form-control" id="txtemail" name="txtemail" required="true" placeholder="Enter Email ID"/>
                                </div>
                                <span class="help-block" id="result4" style="color:brown;text-weight:bold;text-align:center;"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Continue" class="btn btn-primary btn-md"></input>
                                    <?php echo  $errPL; ?>
                                </div>
                        </div>
                    </form>
            </div>
            
        </div>
        <?php require_once 'footer.php'?>
    </body>
</html> 