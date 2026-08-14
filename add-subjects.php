<?php
include('connection.php');
$msg = "";

if (isset($_POST['submit'])) {
    $subjectname = mysqli_real_escape_string($con, $_POST['subjectname']);
    $subjectcode = mysqli_real_escape_string($con, $_POST['subjectcode']);

    if (!empty($subjectname) && !empty($subjectcode)) {
        // Hubi in maadada ama koodhkeedu uu hore u jiray
        $check_q = mysqli_query($con, "SELECT * FROM tblsubjects WHERE SubjectName='$subjectname' OR SubjectCode='$subjectcode'");
        
        if (mysqli_num_rows($check_q) > 0) {
            $msg = "<div class='alert alert-danger mt-2'>Maaddadan ama koodhkan hore ayuu u diiwaangashanaa!</div>";
        } else {
            // Haddii aysan jirin, gali database-ka
            $query = "INSERT INTO tblsubjects (SubjectName, SubjectCode) VALUES ('$subjectname', '$subjectcode')";
            $result = mysqli_query($con, $query);

            if ($result) {
                $msg = "<div class='alert alert-success mt-2'>Subject saved successfully</div>";
            } else {
                $msg = "<div class='alert alert-danger mt-2'>Error ayaa dhacay: " . mysqli_error($con) . "</div>";
            }
        }
    }
}

// Soo qaado dhammaan maadooyinka si loogu soo bandhigo miiska
$subjects_result = mysqli_query($con, "SELECT * FROM tblsubjects ORDER BY id ASC");
?>

<div class="container-fluid">
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create & Manage Subjects</h1>
    </div>

    <?php echo $msg; ?>

    <div class="row">
        <!-- Foomka lagu darayo maadada -->
        <div class="col-md-5 mb-4">
            <div class="card shadow border-0 p-4">
                <h5 class="card-title text-success mb-3">Add New Subject</h5>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Subject Name</label>
                        <input type="text" name="subjectname" class="form-control" placeholder="Qor magaca maadada" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Subject Code</label>
                        <input type="text" name="subjectcode" class="form-control" placeholder="Qor koodhka maadada" required>
                    </div>

                    <button type="submit" name="submit" class="btn btn-success w-100"><i class="fa fa-plus-circle me-2"></i> Save Subject</button>
                </form>
            </div>
        </div>

        <!-- Liiska Maadooyinka (Subjects List) -->
        <div class="col-md-7">
            <div class="card shadow border-0">
                <div class="card-header bg-secondary text-white fw-bold">Subjects List</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Subject Name</th>
                                    <th>Subject Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if ($subjects_result && mysqli_num_rows($subjects_result) > 0) {
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($subjects_result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo htmlspecialchars($row['SubjectName']); ?></td>
                                            <td><?php echo htmlspecialchars($row['SubjectCode']); ?></td>
                                        </tr>
                                        <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center text-muted'>Weli maadooyin lama diiwaangelin.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>