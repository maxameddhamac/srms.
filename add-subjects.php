<?php
// Tallaabada 1: Hubinta haddii badhanka Submit la gujiyey
if(isset($_POST['submit'])) {
    // Soo qabashada xogta ka timid foomka maaddooyinka
    $subjectname = $_POST['subjectname'];
    $subjectcode = $_POST['subjectcode'];

    // Amarka SQL-ka ee maadada lagu dhex tuurayo jadwalka tblsubjects
    $query = "INSERT INTO tblsubjects (SubjectName, SubjectCode) VALUES ('$subjectname', '$subjectcode')";
    $result = mysqli_query($con, $query);

    if($result) {
        echo "<div class='alert alert-success'>Maaddada si guul leh ayaa loo kaydiyey sxb!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error ayaa dhacay: " . mysqli_error($con) . "</div>";
    }
}
?>

<div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New Subject</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow border-0 p-4">
            <!-- Foomka xogta maaddooyinka -->
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-bold">Subject Name (e.g., Mathematics, English)</label>
                    <input type="text" name="subjectname" class="form-control" placeholder="Qor magaca maadada" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Subject Code (e.g., MATH101, ENG202)</label>
                    <input type="text" name="subjectcode" class="form-control" placeholder="Qor koodhka maadada" required>
                </div>

                <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-plus-circle me-2"></i> Save Subject</button>
            </form>
        </div>
    </div>
</div>