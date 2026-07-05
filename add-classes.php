<?php
// Tallaabada 1: Hubinta haddii badhanka Submit la gujiyey
if(isset($_POST['submit'])) {
    // Soo qabashada xogta uu isticmaalahu foomka ku qoray
    $classname = $_POST['classname'];
    $section = $_POST['section'];

    // Amarka SQL-ka ee xogta lagu dhex tuurayo database-ka
    $query = "INSERT INTO tblclasses (ClassName, Section) VALUES ('$classname', '$section')";
    $result = mysqli_query($con, $query);

    if($result) {
        echo "<div class='alert alert-success mt-2'>Fasalka si guul leh ayaa loo kaydiyey sxb!</div>";
    } else {
        echo "<div class='alert alert-danger mt-2'>Error ayaa dhacay: " . mysqli_error($con) . "</div>";
    }
}
?>

<div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Student Class</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow border-0 p-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-bold">Class Name (e.g., Form 1, Grade 6)</label>
                    <input type="text" name="classname" class="form-control" placeholder="Qor magaca fasalka" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Section (e.g., A, B, Subax, Galab)</label>
                    <input type="text" name="section" class="form-control" placeholder="Qor qaybta uu yahay" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-plus-circle me-2"></i> Save Class</button>
            </form>
        </div>
    </div>
</div>