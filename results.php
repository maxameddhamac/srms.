<?php
include('connection.php');
$msg = "";

// Marka la doonayo in la kaydiyo dhibcaha dhammaan maadooyinka
if (isset($_POST['save_all_results'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);
    $class_id = mysqli_real_escape_string($con, $_POST['class_id']);
    $marks_array = $_POST['marks']; // Waa array ay ku jiraan dhibcaha maado kasta

    if (!empty($student_id)) {
        // Marka hore tirtir wixii dhibco ah ee uu ardaygan hore u lahaa si uusan laba jibaar u noqon
        mysqli_query($con, "DELETE FROM tblresults WHERE StudentId='$student_id'");

        // Geli dhibcaha maado kasta
        foreach ($marks_array as $subject_id => $mark) {
            if ($mark !== '') {
                $mark = mysqli_real_escape_string($con, $mark);
                mysqli_query($con, "INSERT INTO tblresults (StudentId, ClassId, SubjectId, marks) VALUES ('$student_id', '$class_id', '$subject_id', '$mark')");
            }
        }
        $msg = "<div class='alert alert-success'>saved!</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Fadlan dooro arday sax ah!</div>";
    }
}

// Soo qaado dhammaan maadooyinka
$subjects_query = mysqli_query($con, "SELECT * FROM tblsubjects");
$subjects = [];
while ($sub = mysqli_fetch_assoc($subjects_query)) {
    $subjects[] = $sub;
}
?>

<!-- Ku dar CSS-ka iyo JS-ka Select2 si uu search-ku u noqdo mid casri ah oo raadin kara -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<div class="container-fluid">
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h2>Manage Examination Results</h2>
    </div>

    <?php echo $msg; ?>

    <div class="card shadow p-4" style="max-width: 700px;">
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label fw-bold">Search and Select Student</label>
                <!-- Waxaan ka dhignay Select oo leh class-ka select2 si uu u noqdo mid la raadin karo -->
                <select name="student_id" class="form-select select2-student" id="studentSelect" required onchange="fetchStudentClass(this)">
                    <option value="">-- Raadi magaca ama Roll ID-ga ardayga --</option>
                    <?php 
                    $students_query = mysqli_query($con, "SELECT tblstudents.*, tblclasses.ClassName, tblclasses.Section FROM tblstudents LEFT JOIN tblclasses ON tblstudents.ClassId = tblclasses.id");
                    while ($std = mysqli_fetch_assoc($students_query)) {
                        echo "<option value='".$std['StudentId']."' data-class='".$std['ClassId']."'>".$std['StudentName']." (Roll: ".$std['RollId'].") - Class: ".$std['ClassName']."</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Qaybtan waxaa ku jira ClassId-ga qarsan oo la soconaya ardayga -->
            <input type="hidden" name="class_id" id="classIdInput" value="">

            <h5 class="mt-4 mb-3 text-primary">Geli Dhibcaha Maadooyinka</h5>
            
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Maadada (Subject)</th>
                            <th style="width: 150px;">Dhibcaha (Marks)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($subjects) > 0): ?>
                            <?php foreach ($subjects as $sub): ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo htmlspecialchars($sub['SubjectName']); ?></td>
                                    <td>
                                        <input type="number" name="marks[<?php echo $sub['id']; ?>]" class="form-control" placeholder="0 - 100" min="0" max="100">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center">lama diwaan gelin weli maadooyinka </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <button type="submit" name="save_all_results" class="btn btn-primary w-100 mt-3 py-2 fw-bold">Save All Results</button>
        </form>
    </div>
</div>

<!-- jQuery iyo Select2 JS si uu search-ku u shaqeeyo -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2-student').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Raadi magaca ama Roll ID-ga ardayga --',
        allowClear: true
    });
});

function fetchStudentClass(select) {
    var selectedOption = select.options[select.selectedIndex];
    var classId = selectedOption ? selectedOption.getAttribute('data-class') : '';
    document.getElementById('classIdInput').value = classId ? classId : '';
}
</script>