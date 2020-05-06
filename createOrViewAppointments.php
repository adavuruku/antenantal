<?php
    session_start();
    if(!isset($_SESSION['docID']) || !isset($_SESSION['logName'])){
    header("location: index.php?out=out");
}
    $notice_msg=$hospitalId = $appid ="";
    require_once 'connection.php';
    if (!isset($_GET['hospitalid']) || $_GET['hospitalid'] == ""){
        if($_SERVER['REQUEST_METHOD'] != "POST"){
            header("location: index.php?out=out");
        }
        
    }else{
        $stmt_in = $conn->prepare("SELECT * FROM users where HID = ? limit 1 ");
        $stmt_in->execute(array($_GET['hospitalid']));
        $affected_rows_in = $stmt_in->rowCount();
        if($affected_rows_in < 1){
            header("location: index.php?out=out");
        }
        $hospitalId = $_GET['hospitalid'];
    }

    if (isset($_GET['delete']) && isset($_GET['docid'])){
        $stmt_iny = $conn->prepare("DELETE FROM userschedule where id=? limit 1");
        $stmt_iny->execute(array($_GET['docid']));
        $errPL = "Success: Recoord Deleted!!";
        $notice_msg='<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" 
                        aria-hidden="true">
                        &times;
                    </button>'.$errPL.' </div>';

    }
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
           
		$txttime=trim($_POST['txttime']);
        $txtdate=trim($_POST['txtdate']);$txtwith=trim($_POST['txtwith']);
        $txtpurpose=trim($_POST['txtpurpose']);
        
        $hospitalId = $_POST['hospitalid'];

        if( $txtpurpose=="" || $txtdate=="" || $txtwith=="" ||  $txttime=="")
            {
                $err = $errPL = "Unable to Save and Preview Your Application.. Please Verify Your Entries to Ensure they are all Provided !!";
                $notice_msg='<div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" 
                              aria-hidden="true">
                              &times;
                           </button>'.$errPL.' </div>';
            }else{
                    
                    $sth = $conn->prepare("REPLACE INTO userschedule (HID, dateSchedule, timeSchedule, purpose,docid,byId,valid) VALUES (?,?,?,?,?,?,?)");
                    $sth->bindValue (1, $hospitalId);
                    $sth->bindValue (2, $txtdate);
                    $sth->bindValue (3, $txttime);
                    $sth->bindValue (4, $txtpurpose);
                    $sth->bindValue (5, $txtwith);
                    $sth->bindValue (6, $_SESSION['docID']);
                    $sth->bindValue (7, "0");
                    if($sth->execute()){
                        $err = $errPL = "Success: New Appointment Information Created and Saved Successfully!!";
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
                            <h4 style="margin-bottom:20px;">PATIENT ACCOUNT HOME - CREATE APPOINTMENT.</h4>
                            <?php echo $notice_msg;?>
                            <form role="form"  name="reg_form"  id="form" class="form-vertical" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="hospitalid" value="<?php echo $hospitalId; ?>" />
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="txtname">Appointment Date: </label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" class="form-control" id="txtdate" name="txtdate" value="" required="true" placeholder="YYYY/MM/DD"/>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="txtphone">Appointment Time: </label>
                                            <input type="time" class="form-control" id="txttime" name="txttime" required="true" placeholder="HH:MM PM/AM"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txttype"> Appointment With : </label>
                                    <select class="form-control js-example-basic-single"   id="txtwith" name="txtwith">
                                        <?php
                                            $stmt_in = $conn->prepare("SELECT * FROM userdoctorinfo INNER JOIN hospitaldocsinfo
                                            ON userdoctorinfo.docid = hospitaldocsinfo.docId where userdoctorinfo.HID = ? ORDER BY userdoctorinfo.id DESC ");
                                            
                                            $stmt_in->execute(array($hospitalId));
                                            $affected_rows_in = $stmt_in->rowCount();
                                            if($affected_rows_in >= 1)
                                            {
                                                while($row_two_in = $stmt_in->fetch(PDO::FETCH_ASSOC))
                                                {
                                                    echo '<option value="'.$row_two_in['docId'].'">'.$row_two_in['docname'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="txtpurpose">Purpose: </label>
                                    <textarea rows="2" colunms="12"  class="form-control" id="txtpurpose" name="txtpurpose" required="true" placeholder="Enter The Purpose Of The Appointment"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="proceed" style="width:100%;margin-bottom:10px;padding:10px 10px 10px 10px" value="CREATE APPOINTMENT" class="btn btn-primary btn-lg"></input>
                                </div>
                            </form>
                            
                        </div>
                        <div class="col-xs-12">
                        <h5 style="margin-bottom:20px;font-weight:bolder; text-align:center">PENDING APPOINTMENT LIST.</h5>
                            <?php
                                $stmt_in = $conn->prepare("SELECT *, userschedule.id as recid FROM userschedule INNER JOIN hospitaldocsinfo 
                                ON userschedule.docid = hospitaldocsinfo.docId where userschedule.HID = ? and userschedule.valid = ?  ORDER BY userschedule.id DESC");
                                $stmt_in->execute(array($hospitalId,"0"));
                                $affected_rows_in = $stmt_in->rowCount();
                                if($affected_rows_in >= 1)
                                {
                            ?>
                                    <table class="table table-responsive table-stripped">
                                    <thead style="background-color:grey; color:white">
                                            <tr >
                                                <td>#</td>
                                                <td>Appointment Date / Time</td>
                                                <td>Purpose</td>
                                                <td>With</td>
                                                <td colspan="2">Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                            <?php
                                    $r=0;
                                    while($row_two_in = $stmt_in->fetch(PDO::FETCH_ASSOC))
                                    {
                                    $r+=1;
                                    $date500_two = new DateTime($row_two_in['dateSchedule']);
                                    $date_two = date_format($date500_two,'d F, Y');
                                    $time500_two = new DateTime($row_two_in['timeSchedule']);
                                    $time_two = date_format($time500_two,'h:i:s A');
                                    echo '
                                        <tr>
                                            <td>'.$r.'</td>
                                            <td>'.$date_two.' / '.$time_two.'</td>
                                            <td>'.$row_two_in['purpose'].'</td>
                                            <td>'.$row_two_in['docname'].'</td>
                                            <td><a class="btn btn-danger btn-sm"  href="?delete=delete&docid='.$row_two_in['recid'].'&hospitalid='.$hospitalId.'" ><i class="glyphicon glyphicon-remove"></i></td>
                                            <td><a class="btn btn-primary btn-sm" href="appointmentUpdate.php?appid='.$row_two_in['recid'].'&hospitalid='.$hospitalId.'"><i class="glyphicon glyphicon-open"></i></td>
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
        <script type="text/javascript">
            $(document).ready(function() {
                    $('.date').datepicker({
                        format: 'yyyy/mm/dd',
                        startDate: '0d'
                    });
            });
    </script>
    </body>
</html> 