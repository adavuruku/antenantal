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


    $dateOne =$dateTwo = $nobabay = $description = "";


    $stmt_inSchedule = $conn->prepare("SELECT * from userpreginfo where HID = ? Limit 1");
    $stmt_inSchedule->execute(array($hospitalId));
    $affected_rows_inSchedule = $stmt_inSchedule->rowCount();
    if($affected_rows_inSchedule >= 1){
        $row_two_in = $stmt_inSchedule->fetch(PDO::FETCH_ASSOC);
        $description=$row_two_in['babyGenderDescription'];
        $nobabay=$row_two_in['NoOfBaby'];

        $date500_two = new DateTime($row_two_in['pregStart']);
        $dateOne = date_format($date500_two,'Y-d-m');

        $time500_two = new DateTime($row_two_in['pregExpectedEndDate']);
        $dateTwo= date_format($date500_two,'d F, Y');

    }

    


    
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
           
        $txtdate=trim($_POST['txtdate']);$txtnobaby=trim($_POST['txtnobaby']);
        $txtpurpose=trim($_POST['txtpurpose']);
        
        $hospitalId = $_POST['hospitalid'];

        if( $txtdate=="")
            {
                $err = $errPL = "Unable to Save Pregnancy Information.. Please Verify Your Entries to Ensure they are all Provided !!";
                $notice_msg='<div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" 
                              aria-hidden="true">
                              &times;
                           </button>'.$errPL.' </div>';
            }else{

                    $txtendDate = date('Y-m-d',strtotime('+ 40 weeks', strtotime($txtdate)));
                    
                    $sth = $conn->prepare("REPLACE INTO  userpreginfo (HID, pregExpectedEndDate, pregStart, NoOfBaby,babyGenderDescription,byId) VALUES (?,?,?,?,?,?)");
                    $sth->bindValue (1, $hospitalId);
                    $sth->bindValue (2, $txtendDate);
                    $sth->bindValue (3, $txtdate);
                    $sth->bindValue (4, $txtnobaby);
                    $sth->bindValue (5, $txtpurpose);
                    $sth->bindValue (6, $_SESSION['docID']);
                    if($sth->execute()){
                        $err = $errPL = "Success: PrengNancy Information Created / Updated Successfully!!";
                                $notice_msg='<div class="alert alert-success alert-dismissable">
                                           <button type="button" class="close" data-dismiss="alert" 
                                              aria-hidden="true">
                                              &times;
                                           </button>'.$errPL.$txtdate.' </div>';

                        $description=$txtpurpose;
                        $nobabay=$txtnobaby;
                
                        $date500_two = new DateTime($txtdate);
                        $dateOne = date_format($date500_two,'Y-d-m');
                
                        $time500_two = new DateTime($txtendDate);
                        $dateTwo= date_format($date500_two,'d F, Y');
        
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
                                    <label for="txtname">Last Menstrual Period (LMP). Date: <span style="color:red">*</span></label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control" id="txtdate" name="txtdate" value="<?php echo $dateOne;?>" required="true" placeholder="YYYY/MM/DD"/>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txtname">Expected End Date: </label>
                                    <div class="input-group">
                                       <p><?php echo $dateTwo;?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txttype"> No Of Baby : </label>
                                    <select class="form-control js-example-basic-single"   id="txtnobaby" name="txtnobaby">
                                        <option value="<?php echo $nobabay;?>"><?php echo $nobabay;?></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="txtpurpose">Baby Gender Description: </label>
                                    <textarea rows="5" colunms="12"  class="form-control" id="txtpurpose" name="txtpurpose" placeholder="Enter The Baby Gender Description and Other Information If Availlable"><?php echo $description;?></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="proceed" style="width:100%;margin-bottom:10px;padding:10px 10px 10px 10px" value="CREATE APPOINTMENT" class="btn btn-primary btn-lg"></input>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once 'footer.php'?>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                    $('.date').datepicker({
                        format: 'yyyy-mm-dd'
                    });
            });
        </script>
    </body>
</html> 