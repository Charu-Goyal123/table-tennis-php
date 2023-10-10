<?php
include_once 'process.php';

if(isset($_POST['importSubmit'])){
    $csvMimes = array('text/x-comma-seperated-values','text/comma-seperated-values','application/octet-stream',
    'text/csv','application/csv','application/excel','appliaction/vnd.msexcel','text/plain'
);

if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
if(is_uploaded_file($_FILES['file']['tmp_name'])){

    $csvFile = fopen($_FILES['file']['tmp_name'],'r');

    fgetcsv($csvFile);
    while(($line = fgetcsv($csvFile))!==FALSE){
        $SNo = $line[0];
        $Name = $line[1];
        $Gender = $line[2];
        $PhoneNo = $line[3];
        $City = $line[4];

        $prevQuery = "SELECT SNo FROM csvtt where Name= '".$line[1]."'";
        $prevResult = $db->query($prevQuery);
        if($prevResult->num_rows>0){
            $db->query("UPDATE csvtt SET Name ='".$Name."', Gender ='".$Gender."',PhoneNo ='".$PhoneNo."',City='".$City."', modified = NOW() WHERE Name = '".$Name."'");
        }else{
        $db->query("INSERT INTO csvtt (Name, Gender, PhoneNo, City) VALUES ('".$Name."', '".$Gender."', '".$PhoneNo."', '".$City."')");
        }

        
    }
        fclose($csvFile);
        $qstring = '?status=succ';

    }else{
        $qstring = '?status=err';
    }
}else{
    $qstring='?status=invalid_file';
}

        }
        header("Location:register.php".$qstring);
?>