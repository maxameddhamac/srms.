<?php
$q_classes = "SELECT id FROM tblclasses";
$r_classes = mysqli_query($con, $q_classes);
$total_classes = $r_classes ? mysqli_num_rows($r_classes) : 0;

$q_subjects = "SELECT id FROM tblsubjects";
$r_subjects = mysqli_query($con, $q_subjects);
$total_subjects = $r_subjects ? mysqli_num_rows($r_subjects) : 0;

$q_students = "SELECT StudentId FROM tblstudents";
$r_students = mysqli_query($con, $q_students);
$total_students = $r_students ? mysqli_num_rows($r_students) : 0;

$total_teachers_query = mysqli_query($con, "SELECT COUNT(*) as total FROM teachers");
if ($total_teachers_query) {
    $teacher_data = mysqli_fetch_assoc($total_teachers_query);
    $count_teachers = $teacher_data['total'];
} else {
    $count_teachers = 0;
}
?>

<div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Overview</h1>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow border-0">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <div>
                    <h3 class="display-6 fw-bold m-0"><?php echo $total_classes; ?></h3>
                    <p class="card-text m-0 fs-5">Total Classes</p>
                </div>
                <i class="fa fa-folder-open fa-3x opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white shadow border-0">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <div>
                    <h3 class="display-6 fw-bold m-0"><?php echo $total_subjects; ?></h3>
                    <p class="card-text m-0 fs-5">Total Subjects</p>
                </div>
                <i class="fa fa-book fa-3x opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-warning text-dark shadow border-0">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <div>
                    <h3 class="display-6 fw-bold m-0"><?php echo $total_students; ?></h3>
                    <p class="card-text m-0 fs-5">Total Students</p>
                </div>
                <i class="fa fa-users fa-3x opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4 mt-4">
        <div class="card text-white bg-info p-3 shadow border-0">
            <div class="card-body d-flex justify-content-between align-items-center p-1">
                <div>
                    <h3 class="display-6 fw-bold m-0"><?php echo $count_teachers; ?></h3>
                    <p class="card-text m-0 fs-5">Total Teachers</p>
                </div>
                <div>
                    <i class="fa fa-chalkboard-teacher fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>