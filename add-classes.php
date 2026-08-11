<?php
include('connection.php');
$msg = "";

if (isset($_POST['submit'])) {
    $classname = mysqli_real_escape_string($con, $_POST['classname']);
    $section = mysqli_real_escape_string($con, $_POST['section']);

    if (!empty($classname) && !empty($section)) {
        // Hubi in fasalka iyo section-ku ay horey u jireen
        $check_q = mysqli_query($con, "SELECT * FROM tblclasses WHERE ClassName='$classname' AND Section='$section'");
        
        if (mysqli_num_rows($check_q) > 0) {
            $msg = "<div class='alert alert-danger mt-2'>Fasalkan iyo qaybtan (Section) hore ayay u diiwaangashanaayeen!</div>";
        } else {
            // Haddii uusan jirin, gali database-ka
            $query = "INSERT INTO tblclasses (ClassName, Section) VALUES ('$classname', '$section')";
            $result = mysqli_query($con, $query);

            if ($result) {
                $msg = "<div class='alert alert-success mt-2'>Fasalka si guul leh ayaa loo kaydiyey!</div>";
            } else {
                $msg = "<div class='alert alert-danger mt-2'>Cilad ayaa dhacday: " . mysqli_error($con) . "</div>";
            }
        }
    }
}

// Soo qaado dhammaan fasallada si loogu soo bandhigo miiska
$classes_result = mysqli_query($con, "SELECT * FROM tblclasses");
?>

<div class="container-fluid">
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create & Manage Student Classes</h1>
    </div>

    <?php echo $msg; ?>

    <div class="row">
        <!-- Foomka lagu darayo fasalka -->
        <div class="col-md-5 mb-4">
            <div class="card shadow border-0 p-4">
                <h5 class="card-title text-primary mb-3">Add New Class</h5>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Class Name</label>
                        <input type="text" name="classname" class="form-control" placeholder="Tusaale: Form Four / Grade 8" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Section</label>
                        <input type="text" name="section" class="form-control" placeholder="Tusaale: A, B, ama Blue" required>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary w-100"><i class="fa fa-plus-circle me-2"></i> Save Class</button>
                </form>
            </div>
        </div>

        <!-- Miiska Liiska Fasallada (Classes List) -->
        <div class="col-md-7">
            <div class="card shadow border-0">
                <div class="card-header bg-secondary text-white fw-bold">Classes List</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Class Name</th>
                                    <th>Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if ($classes_result && mysqli_num_rows($classes_result) > 0) {
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($classes_result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo htmlspecialchars($row['ClassName']); ?></td>
                                            <td><?php echo htmlspecialchars($row['Section']); ?></td>
                                        </tr>
                                        <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center text-muted'>Weli fasallo lama diiwaangelin.</td></tr>";
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