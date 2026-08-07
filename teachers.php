<?php
include('connection.php');
$msg = "";
if (isset($_POST['add_teacher'])) {
    $teacher_name = mysqli_real_escape_string($con, $_POST['teacher_name']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $class = mysqli_real_escape_string($con, $_POST['class']);
    if (!empty($teacher_name) && !empty($subject) && !empty($class)) {
        mysqli_query($con, "INSERT INTO teachers (teacher_name, subject, class) VALUES ('$teacher_name', '$subject', '$class')");
        $msg = "<div class='alert alert-success'>Macallinka si guul leh ayaa loo diiwaangeliyey!</div>";
    }
}
$result = mysqli_query($con, "SELECT * FROM teachers");
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2>Teachers Management</h2>
        <button class="btn btn-primary shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#teacherForm" style="transition: 0.3s; padding: 10px 20px; border-radius: 8px; cursor: pointer;">
            <i class="fa fa-plus-circle me-2"></i> Add New Teacher
        </button>
    </div>

    <?php echo $msg; ?>

    <!-- Foomka oo Qarsoon / Soo Baxaya -->
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

    <!-- Miiska Liiska Macallimiinta -->
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
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                    <tbody>
                        <?php 
                        if ($result && mysqli_num_rows($result) > 0) {
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($row['teacher_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($row['class']); ?></td>
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