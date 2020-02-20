<?php
    session_start();
    require_once 'connection.php';
    if (!isset($_SESSION['currentUser']) || $_SESSION['currentUser'] == ""){
        header("location: ?out=out");
    }
    $stmt_in = $conn->prepare("SELECT * FROM users where HID = ? limit 1 ");
    $stmt_in->execute(array($_SESSION['currentUser']));
    $affected_rows_in = $stmt_in->rowCount();
    if($affected_rows_in < 1){
        header("location: ?out=out");
    }
    $txtSearch="";
    $txtSearch = "";
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['txtSearch'])){
        $stmt_in = $conn->prepare("SELECT * FROM hospitaldocsinfo where docname like ? or phone like ? or email like ?
        or docId like ?  ORDER BY doctype, id DESC ");
        $txtSearch = trim($_POST['txtSearch']);
        $search = "%".$txtSearch."%";
        $stmt_in->execute(array($search,$search,$search,$search));
        $affected_rows_in = $stmt_in->rowCount();
    }
    if (isset($_GET['add']) && isset($_GET['docid'])){
        $stmt_iny = $conn->prepare("SELECT * FROM userdoctorinfo where docid = ? and HID=? limit 1 ");
        $stmt_iny->execute(array($_GET['docid'], $_SESSION['currentUser']));
        $affected_rowsy= $stmt_iny->rowCount();
        echo $affected_rowsy;
        if($affected_rowsy < 1){
            $sth = $conn->prepare("INSERT INTO userdoctorinfo (HID, docid) VALUES (?,?)");
            $sth->bindValue (1, $_SESSION['currentUser']);
            $sth->bindValue (2, $_GET['docid']);
            $sth->execute();
        }   
    }
    if (isset($_GET['delete']) && isset($_GET['docid'])){
        $stmt_iny = $conn->prepare("DELETE FROM userdoctorinfo where docid  = ? and HID=? limit 1");
        $stmt_iny->execute(array($_GET['docid'], $_SESSION['currentUser']));
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
                            <h3 style="margin-bottom:20px;font-weight:bolder">PATIENT ACCOUNT HOME - ASSIGN DOCTOR OR NURSES.</h3>
                            <form role="form" class="form-horizontal" action="" enctype="multipart/form-data" method="POST">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                            <input type="text" value="<?php echo $txtSearch ?>" name="txtSearch" placeholder="Enter Hospital ID / Part Or Full Name / Phone / Email To Search" class="form-control">
                                    </div>
                                    <div class="col-xs-6">
                                        <input class="btn btn-primary"  style="width:10%;margin-bottom:10px;padding:20px 20px 20px 20px;" name="search" type="submit" Value="Search"></input>
                                    </div>
                                </div>
                            </form>
                            <div class="col-xs-12">
                                <?php
                                    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['txtSearch'])){
                                        if($affected_rows_in >= 1)
                                        {
                                ?>
                                <table class="table table-responsive table-stripped">
                                    <thead style="background-color:grey">
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
                                                <td><a class="btn btn-primary" href="?add=add&docid='.$row_two_in['docId'].'" ><i class="glyphicon glyphicon-plus"></i></td>
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
                                <h3 style="margin-bottom:20px;font-weight:bolder">ADDED DOCTORS OR NURSES.</h3>
                                <?php
                                        $stmt_in = $conn->prepare("SELECT * FROM userdoctorinfo INNER JOIN hospitaldocsinfo
                                        ON userdoctorinfo.docid = hospitaldocsinfo.docId where userdoctorinfo.HID = ? ORDER BY userdoctorinfo.id DESC ");
                                        
                                        $stmt_in->execute(array($_SESSION['currentUser']));
                                        $affected_rows_in = $stmt_in->rowCount();
                                        if($affected_rows_in >= 1)
                                        {
                                ?>
                                <table class="table table-responsive table-stripped">
                                    <thead style="background-color:grey">
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
                                                <td><a class="btn btn-danger" href="?delete=delete&docid='.$row_two_in['docId'].'" ><i class="glyphicon glyphicon-remove"></i></td>
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