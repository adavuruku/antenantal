<?php
    session_start();
    require_once 'connection.php';
    $stmt_ina = $conn->prepare("SELECT * FROM hospitalnotice");
    $stmt_ina->execute(array());
    $affected_rows_ina = $stmt_ina->rowCount();
    $current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $total_count = $affected_rows_ina;
    $per_page = 1;//26
    $total_pages = ceil($total_count/$per_page);
    $offset = ($current_page - 1) * $per_page;
    $previous_page = $current_page - 1;	
    $next_page = $current_page + 1;
    $has_previous_page =  $previous_page >= 1 ? true : false;
    $has_next_page = $next_page <= $total_pages ? true : false;
    $stmt_in = $conn->prepare("SELECT * FROM hospitalnotice INNER JOIN hospitaldocsinfo ON
    hospitalnotice.byId = hospitaldocsinfo.docId  Where delStatus=0 ORDER BY hospitalnotice.noticeDate, hospitalnotice.id DESC Limit {$per_page} OFFSET {$offset}");
    $stmt_in->execute();
    $affected_rows_in = $stmt_in->rowCount();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<?php include 'header.php'?>
    <link rel="stylesheet" type="text/css" href="css/content.css">
    <script type="text/javascript" src="js/state_change_localgov.js"></script>
    <body>
    <?php include 'adminTopNav.php'?>
        <div class="container">
            <div class="row">
                <div class="content col-xs-12">
                    <div class="col-xs-12 col-md-12">
                        <h3>EXISTING PREGNANCY ARTICLES</h3>
                        <hr/>
                        <?php 
                                if($affected_rows_in >= 1)
                                {
                                    while($row_two_in = $stmt_in->fetch(PDO::FETCH_ASSOC))
                                    {
                                        $date500_two = new DateTime($row_two_in['noticeDate']);
                                        $date_two = date_format($date500_two,'d F, Y  h:i:s A');
                                       echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                       <h3 style="color:black;">Title : <strong>'.$row_two_in['title'].'</strong></h3>
                                       <p style="color:red;">'.$date_two.'</p>
                                       <p style="color:black;"> Posted By :'.$row_two_in['docname'].'</p>
                                       <p style="color:black;">'.substr($row_two_in['NoticeDescription'],0,350).'... 
                                               <a class="btn btn-danger" href="" ><i class="glyphicon glyphicon-remove"></i></a>
                                               <a class="btn btn-primary" href=""><i class="glyphicon glyphicon-open"></i></a>
                                       </p>
                                       <hr/>
                                   </div>';
                                    }
                                }
                            ?>
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
            </div>
            
        </div>
        <nav role="navigation"  class="navbar  navbar-fixed-bottom navbar-inverse">
                <h5 style="text-align: center;color:white">Copyright &copy; 2020 - Alright Reserved</h5>
        </nav>
    </body>
</html> 