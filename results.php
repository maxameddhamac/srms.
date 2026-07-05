<?php
// 1. Marka badhanka badbaadinta buundada la gujiyo
if(isset($_POST['submit'])) {
    $studentid = $_POST['studentid'];
    $subjectid = $_POST['subjectid'];
    $marks = $_POST['marks'];

    $insert_query = "INSERT INTO tblresults (StudentId, SubjectId, marks) VALUES ('$studentid', '$subjectid', '$marks')";
    $insert_res = mysqli_query($con, $insert_query);

    if($insert_res) {
        echo "<div class='alert alert-success'>Buundada si guul leh ayaa loo kaydiyey saaxiib!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error ayaa dhacay: " . mysqli_error($con) . "</div>";
    }
}
?>

<div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Examination Results</h1>
</div>

<div class="row g-4">
    <!-- FOOMKA LOOGU TALAGALAY IN BUUNDADA LAGO GELIYO -->
    <div class="col-md-5">
        <div class="card shadow border-0 p-4">
            <h5 class="mb-3 fw-bold text-primary">Enter Student Marks</h5>
            <form method="POST" action="">
                
                <!-- Dropdown-ka Ardayda -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Select Student</label>
                    <select name="studentid" class="form-select" required>
                        <option value="">-- Dooro Arday --</option>
                        <?php
                        $students = mysqli_query($con, "SELECT * FROM tblstudents");
                        while($st = mysqli_fetch_assoc($students)) {
                            echo "<option value='".$st['id']."'>".$st['StudentName']." (ID: ".$st['RollId'].")</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Dropdown-ka Maaddooyinka -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Select Subject</label>
                    <select name="subjectid" class="form-select" required>
                        <option value="">-- Dooro Maaddo --</option>
                        <?php
                        $subjects = mysqli_query($con, "SELECT * FROM tblsubjects");
                        while($sb = mysqli_fetch_assoc($subjects)) {
                            echo "<option value='".$sb['id']."'>".$sb['SubjectName']." (".$sb['SubjectCode'].")</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Meesha Buundada laga qorayo -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Marks Obtained (Buundada)</label>
                    <input type="number" name="marks" class="form-control" min="0" max="100" placeholder="Tusaale: 85" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100 fw-bold"><i class="fa fa-save me-2"></i> Save Result</button>
            </form>
        </div>
    </div>

    <!-- JADWALKA HOOSE OO SOO BANDHIGAYA NATIIJOOYINKA GASHAN -->
    <div class="col-md-7">
        <div class="card shadow border-0 p-4">
            <h5 class="mb-3 fw-bold text-success">Live Results Table</h5>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Student Name</th>
                            <th>Subject</th>
                            <th>Marks</th>
                            <th>Date Posted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // SQL JOIN: Labada Foreign Key baynu ku soo jiidaynaa magacyadii saxda ahaa
                        $sql = "SELECT tblstudents.StudentName, tblsubjects.SubjectName, tblresults.marks, tblresults.PostingDate 
                                FROM tblresults 
                                INNER JOIN tblstudents ON tblresults.StudentId = tblstudents.id 
                                INNER JOIN tblsubjects ON tblresults.SubjectId = tblsubjects.id 
                                ORDER BY tblresults.id DESC";
                        
                        $results = mysqli_query($con, $sql);
                        
                        if(mysqli_num_rows($results) > 0) {
                            while($row = mysqli_fetch_assoc($results)) {
                                echo "<tr>
                                        <td><i class='fa fa-user text-secondary me-2'></i>".$row['StudentName']."</td>
                                        <td>".$row['SubjectName']."</td>
                                        <td><span class='badge bg-info text-dark fw-bold fs-6'>".$row['marks']."</span></td>
                                        <td>".date('d-M-Y', strtotime($row['PostingDate']))."</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center text-muted'>Hadda wax natiijo ahi kuma jiraan database-ka sxb.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>