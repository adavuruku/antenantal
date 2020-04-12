<?php
    session_start();
    require_once 'connection.php';
    $txtSearch = "";
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['txtSearch'])){
        $stmt_in = $conn->prepare("SELECT * FROM users where patientName like ? or patientPhone like ? or patientEmail like ?
        or HID like ? or patientState like ?  ORDER BY dateReg, id DESC ");
        $txtSearch = trim($_POST['txtSearch']);
        $search = "%".$txtSearch."%";
        $stmt_in->execute(array($search,$search,$search,$search,$search));
        $affected_rows_in = $stmt_in->rowCount();
    }else{
        $stmt_ina = $conn->prepare("SELECT * FROM users");
        $stmt_ina->execute(array());
        $affected_rows_ina = $stmt_ina->rowCount();
        $current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
        $total_count = $affected_rows_ina;
        $per_page = 5;//26
        $total_pages = ceil($total_count/$per_page);
        $offset = ($current_page - 1) * $per_page;
        $previous_page = $current_page - 1;	
        $next_page = $current_page + 1;
        $has_previous_page =  $previous_page >= 1 ? true : false;
        $has_next_page = $next_page <= $total_pages ? true : false;
        $stmt_in = $conn->prepare("SELECT * FROM users ORDER BY dateReg, id DESC Limit {$per_page} OFFSET {$offset}");
        $stmt_in->execute();
        $affected_rows_in = $stmt_in->rowCount();
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<?php include 'header.php'?>
    <link rel="stylesheet" type="text/css" href="css/content.css">
    <script type="text/javascript" src="js/state_change_localgov.js"></script>
    <body>
    <?php include 'adminTopNav.php'?>
        <div class="container">
            <div class="login">
                <div class="content">
                    <h3 style="margin-bottom:20px;font-weight:bolder">LIST OF ALL REGISTERED PATIENT</h3>
                    <form role="form" class="form-horizontal" action="" enctype="multipart/form-data" method="POST">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <input type="text" value="<?php echo $txtSearch ?>" name="txtSearch" placeholder="Enter Hospital ID / Part Or Full Name / Phone / Email To Search" class="form-control">
                            </div>
                            <div class="col-xs-6">
                                <input class="btn btn-primary" style="width:10%;margin-bottom:10px;padding:5px 5px 5px 5px;" name="search" type="submit" Value="Search"></input>
                            </div>
                        </div>
                    </form>
                    <hr/>
                    <table class="table table-responsive table-stripped">
                    <thead style="background-color:grey; color:white">

                            <tr >
                                <td>#</td>
                                <td>Hospital ID</td>
                                <td>Name</td>
                                <td>Phone / Email</td>
                                <td>Contact Add</td>
                                <td>Office Address</td>
                                <td colspan="2">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if($affected_rows_in >= 1)
                                {
                                    $r=0;
                                    while($row_two_in = $stmt_in->fetch(PDO::FETCH_ASSOC))
                                    {
                                       $r+=1;
                                       echo '
                                       <tr>
                                            <td>'.$r.'</td>
                                            <td>'.$row_two_in['HID'].'</td>
                                            <td>'.$row_two_in['patientName'].'</td>
                                            <td>'.$row_two_in['patientPhone'].' / '.$row_two_in['patientEmail'].'</td>
                                            <td>'.$row_two_in['contactAddress'].' - '.$row_two_in['patientState'].' / '.$row_two_in['patientLocalGovt'].'</td>
                                            <td>'.$row_two_in['officeAddress'].'</td>
                                            <td><a class="btn btn-danger" href="" ><i class="glyphicon glyphicon-remove"></i></td>
                                            <td><a class="btn btn-primary" href="useraccountprofile.php?hospitalid='.$row_two_in['HID'].'"><i class="glyphicon glyphicon-open"></i></td>
                                        </tr>
                                       ';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>	
                        <ul class="pagination">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] != "POST"){
                                if ($total_pages > 1)
                                {
                                    if ($has_previous_page)
                                    {
                                        echo '<li><a href=?page='.$previous_page.'>&laquo; </a> </li>';
                                    }
                                    for($i = 1; $i <= $total_pages; $i++)
                                    {
                                        if ($i == $current_page)
                                        {
                                            echo '<li class="active"><span>'. $i.' <span class="sr-only">(current)</span></span></li>';
                                        }
                                        else
                                        {
                                            echo ' <li><a href=?page='.$i.'> '. $i .' </a></li>';
                                        }
                                    }	
                                    if ($has_next_page)
                                    {
                                        echo ' <li><a href=?page='.$next_page.'>&raquo;</a></li> ';
                                    }
                                    
                                }
                            }							
                               
                            ?>
                        </ul>
                </div>
            </div>
            <?php require_once 'footer.php'?>
        </div>
    </body>
</html> 