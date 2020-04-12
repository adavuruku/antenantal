<?php
    session_start();
    require_once 'connection.php';
    $notice_msg=$hospitalId = $appid ="";
    require_once 'connection.php';
    if (!isset($_GET['hospitalid']) || $_GET['hospitalid'] == ""){
        header("location: ?out=out");
    }else{
        $stmt_in = $conn->prepare("SELECT * FROM users where HID = ? limit 1 ");
        $stmt_in->execute(array($_GET['hospitalid']));
        $affected_rows_in = $stmt_in->rowCount();
        if($affected_rows_in < 1){
            header("location: ?out=out");
        }
        $hospitalId = $_GET['hospitalid'];
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<?php include 'header.php'?>
    <link rel="stylesheet" type="text/css" href="css/content.css">
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
                            <h4 style="margin-bottom:20px;font-weight:bolder">PATIENT ACCOUNT HOME</h4>
                            <?php 
                                while($row_two_in = $stmt_in->fetch(PDO::FETCH_ASSOC))
                                {
                                    echo '<table class="table table-responsive">

                                            <tr >
                                                <td><h5>Name</h5></td>
                                                <td><h5>'.$row_two_in['patientName'].'<h5></td>
                                            </tr>
                                            <tr>
                                                <td><h5>Phone / Email</h5></td>
                                                <td><h5>'.$row_two_in['patientPhone'].' / '.$row_two_in['patientEmail'].'</h5></td>
                                            </tr>
                                            <tr>
                                                <td><h5>Contact Add</h5></td>
                                                <td><h5>'.$row_two_in['contactAddress'].' - '.$row_two_in['patientState'].' / '.$row_two_in['patientLocalGovt'].'</h5></td>
                                            </tr>
                                            <tr>
                                                <td><h5>Office Address</h5></td>
                                                <td><h5>'.$row_two_in['officeAddress'].'</h5></td>
                                            </tr>
                                        </table>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once 'footer.php'?>
        </div>
    </body>
</html> 