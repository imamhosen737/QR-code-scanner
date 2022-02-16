<?php
$con = new mysqli("localhost", "root", "", "myscanner");
if (isset($_POST['text'])) {
        $text = $_POST['text'];
        $insert = $con->query("INSERT INTO `student_scanner`(`student_id`, `time`) VALUES ('$text',NOW())");

        if ($insert) {
                echo "<script>alert('Scanned successfull')</script>";
        } else {
                echo "<script>alert('Scanned failed')</script>";
        }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        
        <!-- CDN for webcam -->
        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>

<body>
        <video src="" width="50%" id="MyCameraOpen"></video> <br />
        <form action="" method="POST">
                <input type="text" readonly hidden name="text" id="text" />
        </form>

      <div class="container">
      <table class="table table-bordered text-center">
                <thead class="thead-dark">
                        <tr>
                                <th>SL</th>
                                <th>Student ID</th>
                                <th>Time</th>
                                <th>Action</th>
                        </tr>
                </thead>
                <tbody>
                 <?php $data = $con->query("SELECT * FROM student_scanner");
                 $i = 0;
                 while($d = $data->fetch_assoc()){ ?>
                <tr>
                        <td><?php echo ++$i; ?></td>
                        <td><?php echo $d['student_id']; ?></td>
                        <td><?php echo $d['time']; ?></td>
                        <td>
                                <a href="" class="btn btn-sm btn-danger">X</a>
                        </td>
                </tr>

                <?php } ?>
                 
                </tbody>
        </table>
      </div>
        <script>
                //Start camera section
                var video = document.getElementById('MyCameraOpen');
                var text = document.getElementById('text');

                var scanner = new Instascan.Scanner({
                        video: video,
                });
                //Start text section
                Instascan.Camera.getCameras()

                        .then(function(Our_Camera) {
                                if (Our_Camera.length > 0) {
                                        scanner.start(Our_Camera[0]);
                                } else {
                                        alert('Camera Failed');
                                }
                        })
                        .catch(function(error) {
                                console.log('There is a problem, please try again');
                        })
                scanner.addListener('scan', function(input_value) {
                        text.value = input_value;
                        document.forms[0].submit();
                });
        </script>
</body>

</html>