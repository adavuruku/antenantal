<?php
session_start();
require_once 'connection.php';
 $txtname =$txtphone =$txtemail =$txtpregdescription =$cmbstate =$cmblgov =$txtcontact =$txtofficeadd=$notice_msg="";
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
        $txtname =$_POST['txtname']; $txtphone =$_POST['txtphone']; $txtemail =$_POST['txtemail'];
        $txtpregdescription =$_POST['txtpregdescription'];
        $cmbstate =$_POST['cmbstate']; $cmblgov =$_POST['cmblgov'];$txtcontact =$_POST['txtcontact'];
        $txtofficeadd=$_POST['txtofficeadd'];
        
               
        if( $txtphone=="" || $txtname=="" || $txtcontact=="" || 
            $txtemail=="" ||
            $txtpregdescription=="" || $cmbstate =="" || $cmblgov =="" ||
            $txtcontact =="" || $txtofficeadd=="")
            {
                $err = $errPL = "Unable to Save and Preview Your Application.. Please Verify Your Entries to Ensure they are all Provided !!";
                $notice_msg='<div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" 
                              aria-hidden="true">
                              &times;
                           </button>'.$errPL.' </div>';
            }else{
                    //generate the staff id
                    $numL=mt_rand(10000000,99999999);
				    $patience_id = "ABUTH".$numL;
                    $sth = $conn->prepare("REPLACE INTO users (patientName, patientPhone, patientEmail, HID,contactAddress,officeAddress,
                    illnesDescription,patientState, patientLocalGovt, createdBy, dateReg) VALUES (?,?,?,?,?,?,?,?,?,?,now())");
                    $sth->bindValue (1, $txtname);
                    $sth->bindValue (2, $txtphone);
                    $sth->bindValue (3, $txtemail);
                    $sth->bindValue (4, $patience_id);
                    $sth->bindValue (5, $txtcontact);
                    $sth->bindValue (6, $txtofficeadd);
                    $sth->bindValue (7, $txtpregdescription);
                    $sth->bindValue (8, $cmbstate);
                    $sth->bindValue (9, $cmblgov);
                    $sth->bindValue (10,  $_SESSION['docID']);
                    if($sth->execute()){
                        $err = $errPL = "Success: New Staff Record Created and Saved Successfully!!";
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
    <script type="text/javascript" src="js/state_change_localgov.js"></script>
    <link rel="stylesheet" type="text/css" href="plugins/css/select2.css"/>
    <script type="text/javascript" src="plugins/js/select2.js"></script>
    <script type="text/javascript" src="plugins/js/select2.min.js"></script>
    <body>
    <?php include 'adminTopNav.php'?>
        <div class="container">
            <div class="row">
                <div class="content col-xs-12">
                    <form role="form"  name="reg_form"  id="form" class="form-vertical" action="" enctype="multipart/form-data" method="POST">
                    <div class="col-xs-12 col-md-6">
                            <h4>ADD NEW PATIENT (PREGNANCY INFORMATION)</h4>
                            <?php echo  $notice_msg;?>
                            <hr/>
                        <div class="form-group">
                            <label for="txtname">Full Name: </label>
                            <input type="text" class="form-control" id="txtname" name="txtname" value="<?php echo $txtname; ?>" required="true" placeholder="First Name Middle Name Last Name"/>
                        </div>
                        <div class="form-group">
                            <label for="txtphone">Phone Number: </label>
                            <input type="phone" class="form-control"  onkeydown="return noNumbers(event,this)" id="txtphone" value="<?php echo $txtphone; ?>" name="txtphone" required="true" placeholder="Enter Phone Number"/>
                        </div>
                        <div class="form-group">
                            <label for="txtemail">Email Address: </label>
                            <input type="email" class="form-control" id="txtemail" 
                            value="<?php echo $txtemail; ?>" name="txtemail" required="true" placeholder="Enter Email Address"/>
                        </div>
                        <div class="form-group">
                            <label for="txtofficeadd">Pregnancy State Description : </label>
                            <textarea class="form-control" rows="8"  id="txtpregdescription" name="txtpregdescription" required="true" placeholder="Enter Current State Of Pregnancy - Date Started - The Child State And Others Neccessary information About The Pregnant Woman"><?php echo $txtpregdescription; ?></textarea>
                        </div>
                        
                    </div>
                    <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                    <label for="cmbstate"> State: </label>
                                    <select class="form-control js-example-basic-single"  id="cmbstate" name="cmbstate" onchange="stateComboChange();">
                                        
                                        <option value="Abuja" title="Abuja">Abuja</option>
                                        <option value="Abia" title="Abia">Abia</option>
                                        <option value="Adamawa" title="Adamawa">Adamawa</option>
                                        <option value="Akwa Ibom" title="Akwa Ibom">Akwa Ibom</option>
                                        <option value="Anambra" title="Anambra">Anambra</option>
                                        <option value="Bauchi" title="Bauchi">Bauchi</option>
                                        <option value="Bayelsa" title="Bayelsa">Bayelsa</option>
                                        <option value="Benue" title="Benue">Benue</option>
                                        <option value="Bornu" title="Bornu">Bornu</option>
                                        <option value="Cross River" title="Cross River">Cross River</option>
                                        <option value="Delta" title="Delta">Delta</option>
                                        <option value="Ebonyi" title="Ebonyi">Ebonyi</option>
                                        <option value="Edo" title="Edo">Edo</option>
                                        <option value="Ekiti" title="Ekiti">Ekiti</option>
                                        <option value="Enugu" title="Enugu">Enugu</option>
                                        <option value="Gombe" title="Gombe">Gombe</option>
                                        <option value="Imo" title="Imo">Imo</option>
                                        <option value="Jigawa" title="Jigawa">Jigawa</option>
                                        <option value="Kaduna" title="Kaduna">Kaduna</option>
                                        <option value="Kano" title="Kano">Kano</option>
                                        <option value="Katsina" title="Katsina">Katsina</option>
                                        <option value="Kebbi" title="Kebbi">Kebbi</option>
                                        <option  value="Kogi" title="Kogi">Kogi</option>
                                        <option value="Kwara" title="Kwara">Kwara</option>
                                        <option value="Lagos" title="Lagos">Lagos</option>
                                        <option value="Nassarawa" title="Nassarawa">Nassarawa</option>
                                        <option value="Niger" title="Niger">Niger</option>
                                        <option value="Ogun" title="Ogun">Ogun</option>
                                        <option value="Ondo" title="Ondo">Ondo</option>
                                        <option value="Osun" title="Osun">Osun</option>
                                        <option value="Oyo" title="Oyo">Oyo</option>
                                        <option value="Plateau" title="Plateau">Plateau</option>
                                        <option value="Rivers" title="Rivers">Rivers</option>
                                        <option value="Sokoto" title="Sokoto">Sokoto</option>
                                        <option value="Taraba" title="Taraba">Taraba</option>
                                        <option value="Yobe" title="Yobe">Yobe</option>
                                        <option value="Zamfara" title="Zamfara">Zamfara</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cmblgov"> Local Government: </label>
                                    <select class="form-control js-example-basic-single"  id="cmblgov" name="cmblgov">
                                    </select>
                                </div>
                        <div class="form-group">
                            <label for="txtcontact">Contact Address: </label>
                            <textarea rows="6" colunms="12" class="form-control" id="txtcontact" name="txtcontact" required="true" placeholder="Enter Contact Address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="samedetails"></label>
                            <label class="checkbox-inline">
                                    <input type="checkbox" style="padding: 5px;font-size: 24px;" id="samedetails"  onclick="marksame();"> Click here if Contact and Office Address is thesame.
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="txtofficeadd">Office Address : </label>
                            <textarea class="form-control" rows="6"  name="txtofficeadd" required="true" placeholder="Enter Office Address"></textarea>
                        </div>
                        <div class="form-group">
                                <input type="submit" name="proceed"  style="width:100%" value="CREATE ACCOUNT" class="btn btn-primary btn-lg"></input>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            
        </div>
        <?php require_once 'footer.php'?>
    </body>
</html> 