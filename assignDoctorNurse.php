<?php
    session_start();
    require_once 'connection.php';
    $notice_msg=$hospitalId = $appid ="";
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


    $txtSearch="";
    $txtSearch = "";
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['txtSearch'])){
        $stmt_in = $conn->prepare("SELECT * FROM hospitaldocsinfo where docname like ? or phone like ? or email like ?
        or docId like ?  ORDER BY doctype, id DESC ");
        $txtSearch = trim($_POST['txtSearch']);
        $hospitalId = $_POST['hospitalid'];
        $search = "%".$txtSearch."%";
        $stmt_in->execute(array($search,$search,$search,$search));
        $affected_rows_in = $stmt_in->rowCount();

    }
    if (isset($_GET['add']) && isset($_GET['docid'])){
        $hospitalId = $_GET['hospitalid'];
        $stmt_iny = $conn->prepare("SELECT * FROM userdoctorinfo where docid = ? and HID=? limit 1 ");
        $stmt_iny->execute(array($_GET['docid'], $hospitalId));
        $affected_rowsy= $stmt_iny->rowCount();
        echo $affected_rowsy;
        if($affected_rowsy < 1){
            $sth = $conn->prepare("INSERT INTO userdoctorinfo (HID, docid) VALUES (?,?)");
            $sth->bindValue (1, $hospitalId);
            $sth->bindValue (2, $_GET['docid']);
            $sth->execute();
            
        }

        $errPL = "Success: Doctor Added !!";
            $notice_msg='<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" 
                        aria-hidden="true">
                        &times;
                    </button>'.$errPL.' </div>';

    }
    if (isset($_GET['delete']) && isset($_GET['docid'])){
        $hospitalId = $_GET['hospitalid'];
        $stmt_iny = $conn->prepare("DELETE FROM userdoctorinfo where docid  = ? and HID=? limit 1");
        $stmt_iny->execute(array($_GET['docid'], $hospitalId));

        $errPL = "Success: Recoord Deleted!!";
        $notice_msg='<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" 
                        aria-hidden="true">
                        &times;
                    </button>'.$errPL.' </div>';
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
                            <h5 style="margin-bottom:20px;font-weight:bolder">PATIENT ACCOUNT HOME - ASSIGN DOCTOR OR NURSES.</h5>
                            <form role="form" class="form-horizontal" action="" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="hospitalid" value="<?php echo $hospitalId; ?>" />
                                <div class="form-group">
                                    <div class="col-xs-6">
                                            <input type="text" value="<?php echo $txtSearch ?>" name="txtSearch" placeholder="Enter Hospital ID / Part Or Full Name / Phone / Email To Search" class="form-control">
                                    </div>
                                    <div class="col-xs-2">
                                        <input class="btn btn-primary"   name="search" type="submit" Value="Search"></input>
                                    </div>
                                </div>
                            </form>
                            <div class="col-xs-12">
                                <?php echo $notice_msg;?>
                                <?php
                                    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['txtSearch'])){
                                        if($affected_rows_in >= 1)
                                        {
                                ?>
                                <table class="table table-responsive table-stripped">
                                    <thead style="background-color:grey; color:white">
                                        <tr >
                                            <td>#</td>
                                            <td>Name</td>
                                            <td>Phone / Email</td>
                                            <td>Type</td>
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
                                                <td>'.$row_two_in['docname'].'</td>
                                                <td>'.$row_two_in['phone'].' / '.$row_two_in['email'].'</td>
                                                <td>'.$row_two_in['doctype'].'</td>
                                                <td>'.$row_two_in['contactAdd'].'</td>
                                                <td><a class="btn btn-primary btn-sm" href="?add=add&docid='.$row_two_in['docId'].'&hospitalid='.$hospitalId.'" ><i class="glyphicon glyphicon-plus"></i></td>
                                            </tr>
                                        ';
                                        }
                                    }
                                }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12">
                                <h5 style="margin-bottom:20px;font-weight:bolder">ADDED DOCTORS OR NURSES.</h5>
                                <?php
                                        $stmt_in = $conn->prepare("SELECT *, userdoctorinfo.id as recId FROM userdoctorinfo INNER JOIN hospitaldocsinfo
                                        ON userdoctorinfo.docid = hospitaldocsinfo.docId where userdoctorinfo.HID = ? ORDER BY userdoctorinfo.id DESC ");
                                        
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
                                            <td>Type</td>
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
                                                <td>'.$row_two_in['docname'].'</td>
                                                <td>'.$row_two_in['phone'].' / '.$row_two_in['email'].'</td>
                                                <td>'.$row_two_in['doctype'].'</td>
                                                <td>'.$row_two_in['contactAdd'].'</td>
                                                <td><a class="btn btn-danger btn-sm"  href="?delete=delete&docid='.$row_two_in['recId'].'&hospitalid='.$hospitalId.'" ><i class="glyphicon glyphicon-remove"></i></td>
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
            </div>
            <?php require_once 'footer.php'?>
        </div>
    </body>
</html> 