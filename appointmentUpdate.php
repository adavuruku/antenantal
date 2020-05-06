<?php
    session_start();
    if(!isset($_SESSION['docID']) || !isset($_SESSION['logName'])){
    header("location: index.php?out=out");
}
    $notice_msg=$hospitalId = $appid =$txtpurpose="";
    require_once 'connection.php';
    if (!isset($_GET['hospitalid']) || $_GET['hospitalid'] == "" || !isset($_GET['appid']) || $_GET['appid'] == ""){
        if($_SERVER['REQUEST_METHOD'] != "POST"){
            header("location: index.php?out=out");
        }
        $appid = $_POST['appid'];
        
    }else{
        $stmt_in = $conn->prepare("SELECT * FROM users where HID = ? limit 1 ");
        $stmt_in->execute(array($_GET['hospitalid']));
        $affected_rows_in = $stmt_in->rowCount();
        if($affected_rows_in < 1){
            header("location: index.php?out=out");
        }
        $hospitalId = $_GET['hospitalid'];

        $appid = $_GET['appid'];
    }

    $notice_msg='';



    $stmt_inSchedule = $conn->prepare("SELECT *, userschedule.id as recid FROM userschedule INNER JOIN hospitaldocsinfo 
    ON userschedule.docid = hospitaldocsinfo.docId where userschedule.id = ? and userschedule.valid = ? Limit 1");
    $stmt_inSchedule->execute(array($appid, "0"));
    $affected_rows_inSchedule = $stmt_inSchedule->rowCount();
    if($affected_rows_inSchedule < 1){
        header("location: ?out=out");
    }

    $row_two_in = $stmt_inSchedule->fetch(PDO::FETCH_ASSOC);
    $txtpurpose=$row_two_in['outcome'];
    $date500_two = new DateTime($row_two_in['dateSchedule']);
    $date_two = date_format($date500_two,'d F, Y');
    $time500_two = new DateTime($row_two_in['timeSchedule']);
    $time_two = date_format($time500_two,'h:i:s A');


    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
        $txtpurpose=trim($_POST['txtpurpose']);
        $hospitalId = $_POST['hospitalid'];
        $appid = $_POST['appid'];
        if( $txtpurpose=="")
            {
                $err = $errPL = "Unable to Update Pregnancy Application.. Please Verify Your Entries to Ensure they are all Provided !!";
                $notice_msg='<div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" 
                              aria-hidden="true">
                              &times;
                           </button>'.$errPL.' </div>';
            }else{
                    
                    $sth = $conn->prepare("UPDATE userschedule SET outcome=?, valid=? WHERE id=?");
                    $sth->bindValue (1, $txtpurpose);
                    $sth->bindValue (2, "1");
                    $sth->bindValue (3, $appid);

                    if($sth->execute()){
                        $err = $errPL = "Success: Appointment Information Updated Successfully!!";
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
    <link rel="stylesheet" type="text/css" href="plugins/css/bootstrap-datepicker.css"/>
    <link rel="stylesheet" type="text/css" href="plugins/css/bootstrap-datepicker3.min.css"/>
    <script type="text/javascript" src="plugins/js/select2.js"></script>
    <script type="text/javascript" src="plugins/js/select2.min.js"></script>
    <script type="text/javascript" src="plugins/js/bootstrap-datepicker.js"></script>
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
                            <h5 style="margin-bottom:20px;font-weight:bolder">PATIENT ACCOUNT HOME - UPDATE APPOINTMENT.</h5>
                            <?php echo  $notice_msg;?>
                            <form role="form"  name="reg_form"  id="form" class="form-vertical" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
                                 <input type="hidden" name="hospitalid" value="<?php echo $hospitalId; ?>" />
                                 <input type="hidden" name="appid" value="<?php echo $appid; ?>" />
                                <div class="form-group">
                                    <label for="txtname">Appointment Date / Time: </label>
                                    <p><?php echo $date_two." / ".$time_two;?></p>
                                </div>
                                <div class="form-group">
                                    <label for="txttype"> Reason For Appointment : </label>
                                    <p><?php echo $row_two_in['purpose'];?></p>
                                </div>
                                <div class="form-group">
                                    <label for="txttype"> Appointment With : </label>
                                    <p><?php echo $row_two_in['docname'];?></p>
                                </div>
                                <div class="form-group">
                                    <label for="txtpurpose">Outcome / Conclusion : </label>
                                    <textarea rows="5" colunms="12" class="form-control" id="txtpurpose" name="txtpurpose" required="true" placeholder="Enter The Outcome Of The Appointment"><?php echo $txtpurpose;?></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="proceed" style="width:100%;margin-bottom:10px;padding:10px 10px 10px 10px" value="UPDATE APPOINTMENT" class="btn btn-primary btn-lg"></input>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once 'footer.php'?>
        </div>
        
    </body>
</html> 