<?php

if (isset($_POST['upload_excel'])) {
    
    // Soo qabashada faylka la soo doortay
    $filename = $_FILES['excel_file']['tmp_name'];
    $file_extension = pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION);

    // Xaqiijin: Ma yahay faylku CSV?
    if ($file_extension != 'csv') {
        echo "<div class='alert alert-danger'>Fadlan soo dooro fayl noociisu yahay .csv oo kaliya sxb!</div>";
    } else {
        // Fur faylkii CSV-ga ahaa
        $file = fopen($filename, "r");
        
        // Khadka ugu horreeya ee Excel-ka (Header-ka) waa inaan iska dhaafno
        fgetcsv($file);
        
        $success_count = 0;

        // Mid mid u akhri safafka faylka Excel-ka dhexdiisa ah
        while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
            // $row[0] = Magaca Ardayga, $row[1] = RollId, $row[2] = Email, $row[3] = ClassId
            $studentname = mysqli_real_escape_string($con, $row[0]);
            $rollid      = mysqli_real_escape_string($con, $row[1]);
            $email       = mysqli_real_escape_string($con, $row[2]);
            $classid     = mysqli_real_escape_string($con, $row[3]);

            // Amarka SQL-ka ee mid mid u dhex gelinaya database-ka
            $query = "INSERT INTO tblstudents (StudentName, RollId, StudentEmail, ClassId) 
                      VALUES ('$studentname', '$rollid', '$email', '$classid')";
            
            if (mysqli_query($con, $query)) {
                $success_count++;
            }
        }
        
        fclose($file);
        echo "<div class='alert alert-success'>Masha'Allah! Waxaa si guul leh loo upload-gareeyey $success_count Arday sxb!</div>";
    }
}
?>

<div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Bulk Upload Students via Excel (CSV)</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow border-0 p-4">
            <h5 class="mb-3 fw-bold text-muted">Dooro faylka Excel-ka ee habaysan</h5>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold">Dooro CSV File (.csv)</label>
                    <input type="file" name="excel_file" class="form-control" accept=".csv" required>
                </div>
                
                <div class="mb-3 text-muted small">
                    <p class="mb-1"><strong>Qaabka loo diyaarinayo Excel-ka:</strong></p>
                    <ul>
                        <li>Khadka 1aad: StudentName, RollId, StudentEmail, ClassId</li>
                        <li>Markaad kaydinayso Excel-ka u dooro <strong>Save As -> CSV (Comma delimited)</strong></li>
                    </ul>
                </div>

                <button type="submit" name="upload_excel" class="btn btn-success w-100 fw-bold">
                    <i class="fa fa-file-upload me-2"></i> Upload & Import Students
                </button>
            </form>
        </div>
    </div>
</div>