<?php
include('connection.php');
$msg = "";


if (isset($_GET['id'])) {
    $sid = intval($_GET['id']);
    
    // Soo saar xogta ardayga hadda la joogo
    $fetch_q = mysqli_query($con, "SELECT * FROM tblstudents WHERE StudentId = $sid");
    if ($fetch_q && mysqli_num_rows($fetch_q) > 0) {
        $student = mysqli_fetch_assoc($fetch_q);
    } else {
        echo "<script>window.location.href='index.php?page=students';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='index.php?page=students';</script>";
    exit();
}


if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($con, $_POST['studentname']);
    $roll = mysqli_real_escape_string($con, $_POST['rollid']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $cid = mysqli_real_escape_string($con, $_POST['classid']);

    if (!empty($name) && !empty($roll) && !empty($cid)) {
        $update_q = "UPDATE tblstudents SET StudentName='$name', RollId='$roll', PhoneNumber='$phone', ClassId='$cid' WHERE StudentId=$sid";
        if (mysqli_query($con, $update_q)) {
            echo "<script>window.location.href='index.php?page=students';</script>";
            exit();
        } else {
            $msg = "<div class='alert alert-danger'>Error updating record: " . mysqli_error($con) . "</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>Fadlan buuxi meelaha banaan.</div>";
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Student Information</h1>
        <a href="index.php?page=students" class="btn btn-secondary shadow-sm">
            <i class="fa fa-arrow-left me-2"></i> Back to Students
        </a>
    </div>

    <?php echo $msg; ?>

    <div class="card shadow border-0 p-4 col-md-8 mx-auto">
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label fw-bold">Full Name</label>
                <input type="text" name="studentname" class="form-control" value="<?php echo htmlspecialchars($student['StudentName']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Roll ID</label>
                <input type="text" name="rollid" class="form-control" value="<?php echo htmlspecialchars($student['RollId']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Phone Number</label>
                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($student['PhoneNumber']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Dooro Fasal (Class)</label>
                <select name="classid" class="form-select" required>
                    <option value="">-- Dooro Fasal --</option>
                    <?php
                    $res_class = mysqli_query($con, "SELECT * FROM tblclasses");
                    while($r = mysqli_fetch_assoc($res_class)) {
                        $selected = ($r['id'] == $student['ClassId']) ? 'selected' : '';
                        echo "<option value='".$r['id']."' $selected>".$r['ClassName']." - ".$r['Section']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?page=students" class="btn btn-secondary">Cancel</a>
                <button type="submit" name="update" class="btn btn-success">Update Changes</button>
            </div>
        </form>
    </div>
</div>