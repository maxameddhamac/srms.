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
            // Sida aad rabtay: $row[0] = Student ID (RollId), $row[1] = Student Name, $row[2] = Marks
            $rollid       = mysqli_real_escape_string($con, $row[0]);
            $studentname  = mysqli_real_escape_string($con, $row[1]);
            $marks        = mysqli_real_escape_string($con, $row[2]);

            // 1. Marka koowaad, soo hel StudentId-ga dhabta ah iyo ClassId-ga uu ardaygu ku leeyahay miiska tblstudents adigoo adeegsanaya RollId
            $std_query = mysqli_query($con, "SELECT StudentId, ClassId FROM tblstudents WHERE RollId = '$rollid'");
            
            if ($std_query && mysqli_num_rows($std_query) > 0) {
                $std_data = mysqli_fetch_assoc($std_query);
                $student_id = $std_data['StudentId'];
                $class_id = $std_data['ClassId'];

                // 2. Hubi inuu ardaygu leeyahay maadooyin ama dhibco horey u diiwaangashanaa, haddii kalena ku dar ama update garee
                // Halkan waxaan u qaadaneynaa in Excel-kani uu yahay hal maadada ama guud ahaan, laakiin haddii aad rabto inaad geliso miiska tblresults:
                
                // Hubi inuu natiijadii maadadaas ama ardaygani ay horey u jirtay
                $check_res = mysqli_query($con, "SELECT id FROM tblresults WHERE StudentId = '$student_id'");
                
                if (mysqli_num_rows($check_res) > 0) {
                    // Haddii ay jirto,update garee ama halkii ka sii wad
                    $query = "UPDATE tblresults SET marks = '$marks' WHERE StudentId = '$student_id'";
                } else {
                    // Haddii aysan jirin, gali cusub (Fiiro gaar ah: haddii Excel-kaagu u baahan yahay SubjectId, waxaad ku dari kartaa tiirka 4-aad)
                    $query = "INSERT INTO tblresults (StudentId, ClassId, marks) VALUES ('$student_id', '$class_id', '$marks')";
                }

                if (mysqli_query($con, $query)) {
                    $success_count++;
                }
            }
        }
        
        fclose($file);
        echo "<div class='alert alert-success'>uploaded $success_count Arday sxb!</div>";
    }
}
?>

<div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Bulk Upload Student Marks via Excel (CSV)</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow border-0 p-4">
            <h5 class="mb-3 fw-bold text-muted">Dooro faylka Excel-ka ee dhibcaha</h5>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold">Dooro CSV File (.csv)</label>
                    <input type="file" name="excel_file" class="form-control" accept=".csv" required>
                </div>
                
                <div class="mb-3 text-muted small">
                    <p class="mb-1"><strong>Qaabka loo diyaarinayo Excel-ka (laynka 1aad):</strong></p>
                    <ul>
                        <li><strong>StudentId/RollId, StudentName, Marks</strong></li>
                        <li>Markaad kaydinayso Excel-ka u dooro <strong>Save As -> CSV (Comma delimited)</strong></li>
                    </ul>
                </div>

                <button type="submit" name="upload_excel" class="btn btn-success w-100 fw-bold">
                    <i class="fa fa-file-upload me-2"></i> Upload & Import Marks
                </button>
            </form>
        </div>
    </div>
</div>