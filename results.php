<?php
if(isset($_POST['submit'])) {
    $studentid = $_POST['studentid'];
    $subjectid = $_POST['subjectid'];
    $marks = $_POST['marks'];

    $insert_query = "INSERT INTO tblresults (StudentId, SubjectId, marks) VALUES ('$studentid', '$subjectid', '$marks')";
    $insert_res = mysqli_query($con, $insert_query);

    if($insert_res) {
        echo "<div class='alert alert-success'>saved</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Si uu ula jaanqaado Bootstrap 5 Style-kiisa */
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        border: 1px solid #dee2e6 !important;
        border-radius: 6px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>

<div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Examination Results</h1>
</div>

<div class="row g-4">
    <div class="col-md-5">
        <div class="card shadow border-0 p-4">
            <h5 class="mb-3 fw-bold text-primary">Enter Student Marks</h5>
            <form method="POST" action="">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Select Student</label>
                    <select name="studentid" class="form-select searchable-select" required>
                        <option value="">-- Qor Magaca ama ID-ga --</option>
                        <?php
                        $students = mysqli_query($con, "SELECT * FROM tblstudents");
                        while($st = mysqli_fetch_assoc($students)) {
                            echo "<option value='".$st['id']."'>".$st['StudentName']." (ID: ".$st['RollId'].")</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Select Subject</label>
                    <select name="subjectid" class="form-select searchable-select" required>
                        <option value="">-- Qor Maaddada --</option>
                        <?php
                        $subjects = mysqli_query($con, "SELECT * FROM tblsubjects");
                        while($sb = mysqli_fetch_assoc($subjects)) {
                            echo "<option value='".$sb['id']."'>".$sb['SubjectName']." (".$sb['SubjectCode'].")</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Marks (Buundada)</label>
                    <input type="number" name="marks" class="form-control" min="0" max="100" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100 fw-bold">Save Result</button>
            </form>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow border-0 p-4">
            <h5 class="mb-3 fw-bold text-success">Live Results Table</h5>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT tblstudents.StudentName, tblsubjects.SubjectName, tblresults.marks 
                            FROM tblresults 
                            INNER JOIN tblstudents ON tblresults.StudentId = tblstudents.id 
                            INNER JOIN tblsubjects ON tblresults.SubjectId = tblsubjects.id 
                            ORDER BY tblresults.id DESC";
                    $results = mysqli_query($con, $sql);
                    while($row = mysqli_fetch_assoc($results)) {
                        echo "<tr>
                                <td>".$row['StudentName']."</td>
                                <td>".$row['SubjectName']."</td>
                                <td><span class='badge bg-info text-dark'>".$row['marks']."</span></td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Marka boggu uu soo kaco, u beddel dropdown-ka mid la search-gareyn karo
    $(document).ready(function() {
        $('.searchable-select').select2({
            width: '100%'
        });
    });
</script>