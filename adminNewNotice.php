<?php
    session_start();
    require_once 'connection.php';
    $notice_msg = "";
    $txtgender =$txtname =$txttype =$txtphone =$txtemail =$txtemail =$txtcontact =$proceed="";
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
		$txttitle =$_POST['txttitle'];$txtdescription=trim($_POST['txtdescription']);
       
               
        if( $txttitle=="" || $txtdescription=="")
            {
                $err = $errPL = "Unable to Save / Create Notice.. Please Verify Your Entries to Ensure they are all Provided !!";
                $notice_msg='<div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" 
                              aria-hidden="true">
                              &times;
                           </button>'.$errPL.' </div>';
            }else{
                    //generate the staff id
                    $sth = $conn->prepare("REPLACE INTO hospitalnotice (NoticeDescription, delStatus, title,byId,noticeDate) VALUES (?,?,?,?,now())");
                    $sth->bindValue (1, $txtdescription);
                    $sth->bindValue (2, "0");
                    $sth->bindValue (3, $txttitle);
                    $sth->bindValue (4, $_SESSION['logName']);
                    if($sth->execute()){
                        $err = $errPL = "Success: New Notice Created and Saved Successfully!!";
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
    <body>
    <?php include 'adminTopNav.php'?>
        <div class="container">
            <div class="row">
                <div class="content col-xs-12">
                    <div class="col-xs-12 col-md-8">
                            
                            <form role="form"  name="reg_form"  id="form" class="form-vertical" action="" enctype="multipart/form-data" method="POST">
                                <h3>ADD NEW GENERAL NOTICE</h3>
                                <?php echo $notice_msg; ?>
                                <hr/>
                                <div class="form-group">
                                    <label for="txttitle">Notice Title: </label>
                                    <textarea rows="4" style="padding: 30px;font-size: 24px;width: 100%;" colunms="12" class="form-control" id="txttitle" name="txttitle" required="true" placeholder="Enter Notice Title"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="txtdescription">Notice Description: </label>
                                    <textarea rows="11" colunms="25" class="form-control" style="padding: 30px;font-size: 24px;width: 100%;" id="txtdescription" name="txtdescription" required="true" placeholder="Enter Notice Description"></textarea>
                                    
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="proceed" style="width:100%;margin-bottom:10px;padding:10px 20px 10px 20px" value="CREATE NOTICE" class="btn btn-primary btn-md"></input>
                                </div>
                            </form>
                    </div>
                    
                </div>
            </div>
            <?php require_once 'footer.php'?>
        </div>
        
    </body>
</html> 