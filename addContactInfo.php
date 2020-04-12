<?php
    session_start();
   $notice_msg=$hospitalId = $appid ="";
    require_once 'connection.php';
    if (!isset($_GET['hospitalid']) || $_GET['hospitalid'] == ""){
        if($_SERVER['REQUEST_METHOD'] != "POST"){
            header("location: ?out=out");
        }
        
    }else{
        $stmt_in = $conn->prepare("SELECT * FROM users where HID = ? limit 1 ");
        $stmt_in->execute(array($_GET['hospitalid']));
        $affected_rows_in = $stmt_in->rowCount();
        if($affected_rows_in < 1){
            header("location: ?out=out");
        }
        $hospitalId = $_GET['hospitalid'];
    }
    

    

    if (isset($_GET['delete']) && isset($_GET['docid'])){
        $stmt_iny = $conn->prepare("DELETE FROM contactinfo where id=? limit 1");
        $stmt_iny->execute(array($_GET['docid']));

        $errPL = "Success: Recoord Deleted!!";
        $notice_msg='<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" 
                        aria-hidden="true">
                        &times;
                    </button>'.$errPL.' </div>';
    }
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
		$txtphone=trim($_POST['txtphone']);
        $txtname=trim($_POST['txtname']);$txttype=trim($_POST['txttype']);
        $txtemail=trim($_POST['txtemail']);$txtcontact=trim($_POST['txtcontact']);
        $hospitalId = $_POST['hospitalid'];
        if( $txtphone=="" || $txtname=="" || $txtcontact=="" ||  $txtemail=="" || $txttype=="")
            {
                $err = $errPL = "Unable to Save and Preview Your Application.. Please Verify Your Entries to Ensure they are all Provided !!";
                $notice_msg='<div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" 
                              aria-hidden="true">
                              &times;
                           </button>'.$errPL.' </div>';
            }else{
                    
                    $sth = $conn->prepare("REPLACE INTO contactinfo (HID, contactname, relationship, phone,email,officeAddress) VALUES (?,?,?,?,?,?)");
                    $sth->bindValue (1, $hospitalId);
                    $sth->bindValue (2, $txtname);
                    $sth->bindValue (3, $txttype);
                    $sth->bindValue (4, $txtphone);
                    $sth->bindValue (5, $txtemail);
                    $sth->bindValue (6, $txtcontact);
                    if($sth->execute()){
                        $err = $errPL = "Success: Contact Info Created and Saved Successfully!!";
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
    <script type="text/javascript" src="plugins/js/select2.min.js"></script>`
    <body>
    <?php require_once 'adminTopNav.php'?>
        <div class="container">
            <div class="login">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <?php require_once 'nav_left_staff.php'?>
                        </div>
                        <div class="col-xs-12 col-md-8">
                            <h5 style="margin-bottom:20px;font-weight:bolder">PATIENT ACCOUNT HOME - CONTACT INFORMATION.</h5>
                             <?php echo $notice_msg;?>
                            <form role="form"  name="reg_form"  id="form" class="form-vertical" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="hospitalid" value="<?php echo $hospitalId; ?>" />
                                <div class="form-group">
                                    <label for="txtname">Full Name: </label>
                                    <input type="text" class="form-control" id="txtname" name="txtname" value="" required="true" placeholder="First Name Middle Name Last Name"/>
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
                                    <label for="txttype"> Relationship : </label>
                                    <select class="form-control js-example-basic-single" name="txttype">
                                        <option value="Husban">Husband</option>
                                        <option value="Father">Father</option>
                                        <option value="Mother">Mother</option>
                                        <option value="Brother">Brother</option>
                                        <option value="Sister">Sister</option>
                                        <option value="Uncle">Uncle</option>
                                        <option value="Aunty">Aunty</option>
                                        <option value="Cousin">Cousin</option>
                                        <option value="Friend">Friend</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="txtcontact">Contact Address: </label>
                                    <textarea rows="2" colunms="12"  class="form-control" id="txtcontact" name="txtcontact" required="true" placeholder="Enter Contact Address"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="proceed" style="width:100%;margin-bottom:10px;padding:10px 10px 10px 10px" value="CREATE ACCOUNT" class="btn btn-primary btn-lg"></input>
                                </div>
                            </form>
                            
                        </div>
                        <div class="col-xs-12">
                        <h5 style="margin-bottom:20px;font-weight:bolder; text-align:center">CONTACT INFORMATION LIST.</h5>
                            <?php
                                $stmt_in = $conn->prepare("SELECT * FROM contactinfo where HID = ? ORDER BY id DESC");
                                $stmt_in->execute(array($hospitalId));
                                $affected_rows_in = $stmt_in->rowCount();
                                if($affected_rows_in >= 1)
                                {
                            ?>
                                    <table class="table table-responsive table-stripped">
                                    <thead style="background-color:grey; color:white">
                                            <tr >
                                                <td>#</td>
                                                <td>Name</td>
                                                <td>Phone / Email</td>
                                                <td>Relationship</td>
                                                <td>Contact Address</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                            <?php
                                    $r=0;
                                    while($row_two_in = $stmt_in->fetch(PDO::FETCH_ASSOC))
                                    {
                                    $r+=1;
                                    echo '
                                        <tr>
                                            <td>'.$r.'</td>
                                            <td>'.$row_two_in['contactname'].'</td>
                                            <td>'.$row_two_in['phone'].' / '.$row_two_in['email'].'</td>
                                            <td>'.$row_two_in['relationship'].'</td>
                                            <td>'.$row_two_in['officeAddress'].'</td>
                                            <td><a class="btn btn-danger btn-sm"  href="?delete=delete&docid='.$row_two_in['id'].'&hospitalid='.$hospitalId.'" ><i class="glyphicon glyphicon-remove"></i></td>
                                        </tr>
                                    ';
                                    }
                                }
                            ?>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once 'footer.php'?>
        </div>
    </body>
</html> 