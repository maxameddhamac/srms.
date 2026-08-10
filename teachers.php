<?php
include('connection.php');
$msg = "";

if (isset($_POST['add_teacher'])) {
    $fullname = mysqli_real_escape_string($con, $_POST['teacher_name']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $class = mysqli_real_escape_string($con, $_POST['class']);

    if (!empty($fullname) && !empty($subject) && !empty($class)) {
        $insert = mysqli_query($con, "INSERT INTO teachers (FullName, Email, Password) VALUES ('$fullname', '$subject', '$class')");
        if ($insert) {
            $msg = "<div class='alert alert-success'>teacher registered successfully!</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Cilad ayaa dhacday: " . mysqli_error($con) . "</div>";
        }
    }
}

$result = mysqli_query($con, "SELECT * FROM teachers");
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2>Teachers Management</h2>
        <button class="btn btn-primary shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#teacherForm">
            <i class="fa fa-plus-circle me-2"></i> Add New Teacher
        </button>
    </div>

    <?php echo $msg; ?>

    <div class="collapse mb-4" id="teacherForm">
        <div class="card shadow" style="max-width: 400px;">
            <div class="card-header bg-primary text-white">Add New Teacher</div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Teacher Name</label>
                        <input type="text" name="teacher_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Class</label>
                        <input type="text" name="class" class="form-control" required>
                    </div>
                    <button type="submit" name="add_teacher" class="btn btn-primary w-100">Add Teacher</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-secondary text-white">Teachers List</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Teacher Name</th>
                            <th>Subject</th>
                            <th>Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($result && mysqli_num_rows($result) > 0) {
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($row['FullName']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Password']); ?></td>
                                </tr>
                                <?php 
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>Weli macallin lama diiwaangelin.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>