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
                <a href="?out=out" class="navbar-brand" >Antenantal System </a>  - <span></span>
            </div>
            <!-- Collection of nav links, forms, and other content for toggling -->
            <div id="navbarCollapse" class="collapse navbar-collapse" style="color:yellow;">
                
                <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="adminNewDoctor.php">New Staff Account</a></li>
                        <li><a href="adminNewPatient.php">Create Patient</a></li>
                        <li><a href="adminNewNotice.php">Create Notice</a></li>
                        <li><a href="adminHome.php">View All Patients</a></li>
                        <li><a href="adminListStaff.php">View All Staff</a></li>
                        <li><a href="adminViewNotice.php">View All Notice</a></li>
                        <li><a href="?out=out">Sign Out</a></li>
                </ul>
                
            </div>
        </nav>

        <div style="font-family:due;color:brown;padding-bottom:5px;padding-top:5px;margin-bottom:0px; background-color:beige" class="jumbotron">
            <h1 style="font-family:due;color:brown;padding:20px;padding-bottom:5px">Antenatal Management System </h1>
            <p style="font-family:due;color:blue;padding-left:20px">Welcome - <?php echo $_SESSION['logName'];?> - To Administartive Home!!! </p>
        </div>