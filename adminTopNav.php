<?php
    if (isset($_GET['out'])){
        session_start();
        unset($_SESSION['regno']);
        header("location: index.php");
    }
    
?>
<nav role="navigation"  class="navbar  navbar-fixed-top navbar-inverse">
            <div class="navbar-header">
                <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="?out=out" class="navbar-brand" >Antenantal System </a>  - <span><?php echo $_SESSION['logName'];?></span>
            </div>
            <!-- Collection of nav links, forms, and other content for toggling -->
            <div id="navbarCollapse" class="collapse navbar-collapse" style="color:yellow;">
                
                <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="adminNewDoctor.php">New Staff Account</a></li>
                        <li><a href="adminNewPatient.php">Create Patient</a></li>
                        <li><a href="create_work.php">Create Notice</a></li>
                        <li><a href="adminHome.php">View All Patients</a></li>
                        <li><a href="adminListStaff.php">View All Staff</a></li>
                        <li><a href="all_work_list.php">View All Notice</a></li>
                        <li><a href="?out=out">Sign Out</a></li>
                </ul>
                
            </div>
        </nav>