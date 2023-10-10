<?php
include_once 'process.php';

if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg= 'Members data has been imported succesfully';
            break;
            case 'err':
                $statusType = 'alert-danger';
                $statusMsg= 'Please try again';
                break;
                case 'invalid_file':
                    $statusType = 'alert-danger';
                    $statusMsg= 'Please upload csv file.';
                    break;
                default:
                $statusType='';
                $statusMsg='';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Player Registration</title>
    <script>
        function formToggle(SNo){
            var element = document.getElementById(SNo);
            if(element.style.display==="none"){
                element.style.display = "block";

            }else{
                element.style.display="none";
            }
        }
        </script>
</head>
<body>

<div class="container">
<h2>Members List</h2>
<?php if(!empty($statusMsg)){?>
<div class="alert <?php echo $statusType;?>"><?php echo $statusMsg;?></div>

<?php } ?>
<div class="row">
    <div class="col-md-12 head">
        <div class="float-right">
            <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i>Import</a>
        </div>
    </div>
    <div class="col-md-12" id="importFrm" style="display: none;">
    <form action="process_csv.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" id="file">
        
        <input type="submit" value="Register Players" name="importSubmit" class="btn btn-primary">
    </form>
</div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
            <th>SNO.</th>
            <th>Name</th>
            <th>Gender</th>
            <th>PhoneNo</th>
            <th>City</th>
</tr>
        </thead>
        <tbody>
            <?php
            $result = $db->query("SELECT * FROM csvtt ORDER BY SNo ASC");
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc()){
                    ?>   
                    <tr>
                        <td><?php echo $row['SNo'];?></td>
                        <td><?php echo $row['Name'];?></td>
                        <td><?php echo $row['Gender'];?></td>
                        <td><?php echo $row['PhoneNo'];?></td>
                        <td><?php echo $row['City'];?></td>

                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr><td colspan="5">No Member(s) found...</td></tr>
                <?php
            }
                ?>
           
        </tbody>
    </table>
</div>

</div>
    <!-- <h2>Player Registration</h2>
    <form action="process.php" method="POST" enctype="multipart/form-data">
        <label for="csv_file">Upload CSV File:</label>
        <input type="file" name="csv_file" id="csv_file">
        <br>
        <input type="submit" value="Register Players" name="submit">
    </form> -->
</body>
</html>
