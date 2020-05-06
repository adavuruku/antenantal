<?php
    $notice_msg="";
    require_once 'connection.php';

    $no = 47;
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
		$txtcontentgroup=trim($_POST['txtcontentgroup']);
        $txtcontent=trim($_POST['txtcontent']);
        $txttitle=trim($_POST['txttitle']);
    

        if( $txtcontentgroup=="" || $txtcontent=="" || $txttitle=="")
            {
                $err = $errPL = "Unable to Save and Preview Your Application.. Please Verify Your Entries to Ensure they are all Provided !!";
                $notice_msg='<div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" 
                              aria-hidden="true">
                              &times;
                           </button>'.$errPL.' </div>';
            }else{
                    
                    $sth = $conn->prepare("INSERT INTO ogun_data (title, content, contentgroup) VALUES (?,?,?)");
                    $sth->bindValue (1, $txttitle);
                    $sth->bindValue (2, $txtcontent);
                    $sth->bindValue (3, $txtcontentgroup);
                    if($sth->execute()){
                        //insert to the picture files
                        // Read file to var
                        $file_data = file_get_contents($_FILES["txtfile"]["tmp_name"]);
                        $sth = $conn->prepare("INSERT INTO ogun_file (filedata) VALUES (?)");
                        $sth->bindValue (1, $file_data);
                        if($sth->execute()){
                            $no+=1;
                        }
                            
                    }
            }
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<?php include 'header.php'?>
    <link rel="stylesheet" type="text/css" href="css/content.css">
    <body>
        <div class="container">
            <div class="login">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-12 col-md-8">
                            <h4 style="margin-bottom:20px;">PATIENT ACCOUNT HOME - CREATE APPOINTMENT.</h4>
                            <?php echo $notice_msg;?>
                            <form role="form"  name="reg_form"  id="form" class="form-vertical" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
                                <input type="text" name="hospitalid" disabled="disabled" value="<?php echo $no; ?>" />
                                
                                <div class="form-group">
                                    <label for="txtpurpose">Title : </label>
                                    <textarea rows="2" colunms="12"  class="form-control" id="txttitle" name="txttitle" required="true" placeholder="Enter The Title"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="txtpurpose">Content: </label>
                                    <textarea rows="4" colunms="12"  class="form-control" id="txtcontent" name="txtcontent" required="true" placeholder="Enter The Content"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="txtfile">File Attach: </label>
                                    <input type="file" class="form-control" id="txtfile" name="txtfile" required="true" placeholder="Select File"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="txtcontentgroup"> Group : </label>
                                    <input list="group" name="txtcontentgroup" class="form-control"></input>
                                    <datalist id="group" >
                                        <?php
                                            $stmt_in = $conn->prepare("SELECT distinct (contentgroup) FROM oyo_data ORDER BY contentgroup ASC");
                                            $stmt_in->execute();
                                            $affected_rows_in = $stmt_in->rowCount();
                                            if($affected_rows_in >= 1)
                                            {
                                                while($row_two_in = $stmt_in->fetch(PDO::FETCH_ASSOC))
                                                {
                                                    echo '<option value="'.$row_two_in['contentgroup'].'">'.$row_two_in['contentgroup'].'</option>';
                                                }
                                            }
                                        ?>
                                    </datalist>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="proceed" style="width:100%;margin-bottom:10px;padding:10px 10px 10px 10px" value="SAVE RECORD" class="btn btn-primary btn-lg"></input>
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