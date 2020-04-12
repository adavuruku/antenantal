<?php
 require_once 'connection.php';
//  $opr = urldecode($_POST['opr']);
 $opr = "loadContacts";
 $err=null;
 
 $two = $one =$outResponse= array();
 if ($opr == "login"){
    //  $userID = urldecode($_POST['userID']);
    $userID = "ABUTH42639249";
    $row_one =$row_two ="";
     $stmt_inAll = $conn->prepare("SELECT * from users  where HID=? Limit 1");
     $stmt_inAll->execute(array($userID));
     $affected_rows_inAll = $stmt_inAll->rowCount();
     if($affected_rows_inAll >= 1) 
     {
        $row_one = $stmt_inAll->fetch(PDO::FETCH_ASSOC);
        array_push($outResponse,$row_one);
       
     }

     $stmt_inAllTwo = $conn->prepare("SELECT * from userpreginfo where HID=? Limit 1");
     $stmt_inAllTwo->execute(array($userID));
     $affected_rows_inAllTwo = $stmt_inAllTwo->rowCount();
     if($affected_rows_inAllTwo >=1) 
     {
        $row_two = $stmt_inAllTwo->fetch(PDO::FETCH_ASSOC);
        array_push($outResponse,$row_two);
     }

     $outResponse =  json_encode($outResponse);
     print $outResponse;           
 }


 if ($opr == "loadnews"){
    $outResponse = $one = array();
    $stmt_inAll = $conn->prepare("SELECT *,hospitalnotice.id as noticeid, hospitaldocsinfo.docname as author, hospitaldocsinfo.docId from hospitalnotice
    INNER JOIN hospitaldocsinfo ON  hospitalnotice.byId = hospitaldocsinfo.docId where hospitalnotice.delStatus=? order by hospitalnotice.id desc");
    $stmt_inAll->execute(array("0"));
    $affected_rows_inAll = $stmt_inAll->rowCount();
    
    if($affected_rows_inAll >= 1)
    {
        
        while ($row_two = $stmt_inAll->fetch(PDO::FETCH_ASSOC)){
            $NoticeDescription = htmlspecialchars_decode($row_two['NoticeDescription']);
            $NoticeDescription = strip_tags($NoticeDescription);

            // $subj_two = substr($NoticeDescription,0,300)."...";

            $title = htmlspecialchars_decode($row_two['title']);
            $title = strip_tags($title);
            
            $date500_two = new DateTime($row_two['noticeDate']);
            $J = date_format($date500_two,'l');
            $Q = date_format($date500_two,'d F, Y  h:i:s A');
            $date_two = $J.', '.$Q;

            $one =  array(
                "noticeid"=> $row_two['noticeid'],
                "author"=> $row_two['author'],
                "NoticeDescription"=> $NoticeDescription,
                "delStatus"=> $row_two['delStatus'],
                "title"=> $title,
                "noticeDate"=> $date_two
            );
            array_push($outResponse,$one);
        }
    }
    print json_encode($outResponse);
}


if ($opr == "loadDoctors"){
    $userID = "ABUTH42639249";
    // $userID = urldecode($_POST['userID']);
    $outResponse = $one = array();
    $stmt_in = $conn->prepare("SELECT *, userdoctorinfo.id as recId FROM userdoctorinfo INNER JOIN hospitaldocsinfo
                                            ON userdoctorinfo.docid = hospitaldocsinfo.docId where userdoctorinfo.HID = ? ORDER BY userdoctorinfo.id DESC ");                 
    $stmt_in->execute(array($userID));
    $affected_rows_in = $stmt_in->rowCount();
    if($affected_rows_in >= 1)
    {
        while($row_two = $stmt_in->fetch(PDO::FETCH_ASSOC)){
            array_push($outResponse,$row_two);
        }
        
    }
    print json_encode($outResponse);
}

if ($opr == "loadContacts"){
    $userID = "ABUTH42639249";
    // $userID = urldecode($_POST['userID']);
    $outResponse = $one = array();
    $stmt_in = $conn->prepare("SELECT * FROM contactinfo where HID = ? ORDER BY id DESC");
    $stmt_in->execute(array($userID));
    $affected_rows_in = $stmt_in->rowCount();
    if($affected_rows_in >= 1)
    {
        while($row_two = $stmt_in->fetch(PDO::FETCH_ASSOC)){
            array_push($outResponse,$row_two);
        }
        
    }
    print json_encode($outResponse);
}
?>