
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
    <script type="text/javascript">
        $(document).ready(function(){
            // $("#myModal").modal('show');		
        });
    </script>

<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg modal-sm modal-md">
        <div class="modal-content">
            <div class="modal-header label-primary" >
                <button type="button" style="color:RED;font-family:comic sans ms;font-size:20px;font-weight:bold" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="color:WHITE;font-family:comic sans ms;font-size:25px;font-weight:bold">ABOUT THE PROJECT - ONLINE / MOBILE ANTENANTAL MANAGEMENT SYSTEM</h4>
            </div>
            <div class="modal-body" style="font-family:comic sans ms;font-size:15px;font-weight:bold">
                <p>Afe Babalola University, Ekiti - Ekiti State Nigeria.</p>
				<p>The Project Online / Mobile Antenantal Management System. is Design By :</p>
				<p> Allison Tebrimam Magaji- Registration N<u>o</u> : 16/sci01/024 .</p>
				<br>
				<p >For the Partial Fulfillment of the requirement for the Award of Bachelor Of Science (BSc) in Computer Science - Afe Babalola University, Ekiti - Ekiti State Nigeria - 2020</p><br>
				<p  style="color:red">Supervised By : Dr. Adeyemo O. A.</p>
                <p  class="text-warning"><small >Copyright © 2020</small></p>
            </div>
            <div class="modal-footer label-primary">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        <nav role="navigation"  class="navbar  navbar-fixed-top navbar-inverse">
            <h2 style="text-align: center;color:white">ANTENANTAL INFORMATION MANAGEMENT SYSTEM</h2>
        </nav>
        <div class="container">
            <div class="login">
                    <h2 style="margin-bottom:20px;padding:10px;text-align:center">Please Login - Staff</h2>
                    <hr/>
                    <form role="form"  name="reg_form"  id="form" class="form-vertical" action="" enctype="multipart/form-data" method="POST">
                            
                            <div class="form-group">
                                <label for="txtreg">Hospital ID N<u>o</u> : </label>
                                <div class="input-group">
                                   
                                    <input type="text" class="form-control" id="txtreg" name="txtreg" value="" required="true" placeholder="Enter Hospital ID No"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtemail">Email ADD: </label>
                                <div class="input-group">
                                    <input type="email" class="form-control" id="txtemail" name="txtemail" required="true" placeholder="Enter Email ID"/>
                                </div>
                                <span class="help-block" id="result4" style="color:brown;text-align:center;"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Continue" class="btn btn-primary btn-md"/>
                                    <?php echo  $errPL; ?>
                                </div>
                        </div>
                    </form>
            </div>
            
        </div>
        <?php require_once 'footer.php'?>
    </body>
</html> 