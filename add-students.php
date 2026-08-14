<?php
include('connection.php');
$msg = "";

// INSERT OPERATION
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['studentname']);
    $roll = mysqli_real_escape_string($con, $_POST['rollid']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $cid = mysqli_real_escape_string($con, $_POST['classid']);

    if (!empty($name) && !empty($roll) && !empty($cid)) {
        $query = "INSERT INTO tblstudents (StudentName, RollId, PhoneNumber, ClassId) VALUES ('$name', '$roll', '$phone', '$cid')";
        if (mysqli_query($con, $query)) {
            echo "<script>window.location.href='index.php?page=students';</script>";
            exit();
        } else {
            $msg = "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
        }
    }
}

// DELETE OPERATION
if (isset($_GET['del'])) {
    $del_id = intval($_GET['del']);
    $del_query = "DELETE FROM tblstudents WHERE StudentId = $del_id";
    if (mysqli_query($con, $del_query)) {
        echo "<script>window.location.href='index.php?page=students';</script>";
        exit();
    } else {
        $msg = "<div class='alert alert-danger'>Error deleting record: " . mysqli_error($con) . "</div>";
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Students Management</h1>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            <i class="fa fa-plus-circle me-2"></i> Add New Student
        </button>
    </div>

    <?php echo $msg; ?>

    <!-- Miiska Ardayda -->
    <div class="card shadow border-0 p-3">
        <input type="text" id="searchInput" class="form-control mb-3 border-radius 80px" placeholder="🔍 Raadi magac ama Roll ID">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="studentTable">
                <thead class="table-dark">
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Roll ID</th>
                        <th>Phone</th>
                        <th>Class</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = "SELECT tblstudents.*, tblclasses.ClassName, tblclasses.Section 
                          FROM tblstudents 
                          LEFT JOIN tblclasses ON tblstudents.ClassId = tblclasses.id 
                          ORDER BY tblstudents.StudentId ASC";
                    $res = mysqli_query($con, $q);
                    $i = 1;
                    if ($res && mysqli_num_rows($res) > 0) {
                        while($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>
                                <td>" . $i++ . "</td>
                                <td>" . htmlspecialchars($row['StudentName']) . "</td>
                                <td>" . htmlspecialchars($row['RollId']) . "</td>
                                <td>" . (!empty($row['PhoneNumber']) ? htmlspecialchars($row['PhoneNumber']) : 'N/A') . "</td>
                                <td>" . htmlspecialchars($row['ClassName']) . " (" . htmlspecialchars($row['Section']) . ")</td>
                                <td class='text-center'>
                                    <a href='index.php?page=edit-student&id=" . $row['StudentId'] . "' class='btn btn-sm btn-warning text-white me-1' title='Edit'>
                                        <i class='fa fa-edit'></i> Edit
                                    </a>
                                    <a href='index.php?page=students&del=" . $row['StudentId'] . "' class='btn btn-sm btn-danger' title='Delete' onclick='return confirm(\"Ma hubtaa inaad delete garynyso ardaygan?\");'>
                                        <i class='fa fa-trash'></i> Delete
                                    </a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center text-muted'>Weli arday lama diiwaangelin.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Foomka lagu daro ardayda -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addStudentModalLabel">Register New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="studentname" class="form-control" placeholder="Qor magaca ardayga oo saddexan ah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Roll ID</label>
                        <input type="text" name="rollid" class="form-control" placeholder="sii ID ardaygan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="Qor lambarka teleefanka o ka herysii furaha" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dooro Fasal (Class)</label>
                        <select name="classid" class="form-select" required>
                            <option value="">-- Dooro Fasal --</option>
                            <?php
                            $res_class = mysqli_query($con, "SELECT * FROM tblclasses");
                            while($r = mysqli_fetch_assoc($res_class)) {
                                echo "<option value='".$r['id']."'>".$r['ClassName']." - ".$r['Section']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Register Student</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Search Script
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#studentTable tbody tr');
    rows.pop ? '' : rows.forEach(row => { 
        row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none'; 
    });
});
</script>