<?php
// Tallaabada 1: Marka badhanka la gujiyo, xogta la badbaadiyo
if(isset($_POST['submit'])) {
    $studentname = $_POST['studentname'];
    $rollid = $_POST['rollid'];
    $email = $_POST['email'];
    $classid = $_POST['classid']; // Kani waa ID-ga fasalka laga soo doortay dropdown-ka

    $query = "INSERT INTO tblstudents (StudentName, RollId, StudentEmail, ClassId) VALUES ('$studentname', '$rollid', '$email', '$classid')";
    $result = mysqli_query($con, $query);

    if($result) {
        echo "<div class='alert alert-success'>Ardayga si guul leh ayaa loo kaydiyey sxb!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error ayaa dhacay: " . mysqli_error($con) . "</div>";
    }
}
?>

<div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Register New Student</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow border-0 p-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-bold">Full Name</label>
                    <input type="text" name="studentname" class="form-control" placeholder="Qor magaca rasmiga ah" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Roll ID / Diiwaangalinta</label>
                    <input type="text" name="rollid" class="form-control" placeholder="Tusaale: SRMS-1001" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="student@example.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Select Class (Fasalka)</label>
                    <select name="classid" class="form-select" required>
                        <option value="">-- Dooro Fasal --</option>
                        <?php
                        // HALKAN BAYNU DYNAMIC AHAAN FASSALADA UGA SOO JIIDANAYNAA DATABASE-KA
                        $get_classes = "SELECT * FROM tblclasses";
                        $res_classes = mysqli_query($con, $get_classes);
                        while($row = mysqli_fetch_assoc($res_classes)) {
                            echo "<option value='".$row['id']."'>".$row['ClassName']." (Section: ".$row['Section'].")</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-warning text-dark fw-bold"><i class="fa fa-user-plus me-2"></i> Register Student</button>
            </form>
        </div>
    </div>
</div>