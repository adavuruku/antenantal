<?php
    session_start();
    require_once 'connection.php';
    $notice_msg = "";
    $txtgender =$txtname =$txttype =$txtphone =$txtemail =$txtemail =$txtcontact =$proceed="";
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
		$txtgender=$_POST['txtgender'];$txtphone=trim($_POST['txtphone']);
        $txtname=trim($_POST['txtname']);$txttype=trim($_POST['txttype']);
        $txtemail=trim($_POST['txtemail']);$txtcontact=trim($_POST['txtcontact']);
        
               
        if( $txtphone=="" || $txtname=="" || $txtcontact=="" || $txtgender=="" ||  $txtemail=="" || $txttype=="")
            {
                $err = $errPL = "Unable to Save and Preview Your Application.. Please Verify Your Entries to Ensure they are all Provided !!";
                $notice_msg='<div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" 
                              aria-hidden="true">
                              &times;
                           </button>'.$errPL.' </div>';
            }else{
                    //generate the staff id
                    $numL=mt_rand(100000,999999);
				    $doc_id = "ABUTH".$numL;
                    $sth = $conn->prepare("REPLACE INTO hospitaldocsinfo (docId, docname, gender, phone,email,contactAdd,active,doctype, dateReg) VALUES (?,?,?,?,?,?,?,?,now())");
                    $sth->bindValue (1, $doc_id);
                    $sth->bindValue (2, $txtname);
                    $sth->bindValue (3, $txtgender);
                    $sth->bindValue (4, $txtphone);
                    $sth->bindValue (5, $txtemail);
                    $sth->bindValue (6, $txtcontact);
                    $sth->bindValue (7, "0");
                    $sth->bindValue (8, $txttype);
                    if($sth->execute()){
                        $err = $errPL = "Success: New Staff Record Created and Saved Successfully!!";
                                $notice_msg='<div class="alert alert-success alert-dismissable">
                                           <button type="button" class="close" data-dismiss="alert" 
                                              aria-hidden="true">
                                              &times;
                                           </button>'.$errPL.' </div>';
                            
                    }else{
                                $err = $errPL = "Unable to Save Your Application.. Please Verify Your Entries to Ensure they are all Provided !!";
                                $notice_msg='<div class="alert alert-danger alert-dismissable">
                                           <button type="button" class="close" data-dismiss="alert" 
                                              aria-hidden="true">
                                              &times;
                                           </button>'.$errPL.' </div>';
                        
                        }
                
            }
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<?php include 'header.php'?>
<link rel="stylesheet" type="text/css" href="css/content.css">
<link rel="stylesheet" type="text/css" href="plugins/css/select2.css"/>
<script type="text/javascript" src="plugins/js/select2.js"></script>
<script type="text/javascript" src="plugins/js/select2.min.js"></script>
    <body>
    <?php include 'adminTopNav.php'?>
        <div class="container">
            <div class="row">
                <div class="content col-xs-12">
                    <div class="col-xs-12 col-md-6">
                        <h3>ADD NEW STAFF (DOCTOR / NURSE)</h3>
                        <?php echo $notice_msg; ?>
                        <hr/>
                        <form role="form"  name="reg_form"  id="form" class="form-vertical" action="" enctype="multipart/form-data" method="POST">
                            <div class="form-group">
                                <label for="txtname">Full Name: </label>
                                <input type="text" class="form-control" id="txtname" name="txtname" value="" required="true" placeholder="First Name Middle Name Last Name"/>
                            </div>
                            <div class="form-group"> 
                                    <label for="txtgender"> Gender: </label>
                                    <select class="form-control js-example-basic-single"  name="txtgender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="txttype"> Type : </label>
                                    <select class="form-control js-example-basic-single" name="txttype">
                                        <option value="Doctor">Doctor</option>
                                        <option value="Nurse">Nurse</option>
                                    </select>
                                </div>
                            <div class="form-group">
                                <label for="txtphone">Phone Number: </label>
                                <input type="phone" class="form-control" id="txtphone" name="txtphone" required="true" placeholder="Enter Phone Number"/>
                                
                            </div>
                            <div class="form-group">
                                <label for="txtemail">Email Address: </label>
                                <input type="email" class="form-control"  id="txtemail" name="txtemail" required="true" placeholder="Enter Email Address"/>
                                
                            </div>
                            <div class="form-group">
                                <label for="txtcontact">Contact Address: </label>
                                <textarea rows="11" colunms="12"  class="form-control" id="txtcontact" name="txtcontact" required="true" placeholder="Enter Contact Address"></textarea>
                                
                                <span class="help-block" id="result4" style="color:brown;text-align:center;"></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="proceed"  style="width:100%" value="CREATE ACCOUNT" class="btn btn-primary btn-lg"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php require_once 'footer.php'?>
        </div>
    </body>
</html> 