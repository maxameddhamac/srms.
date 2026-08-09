<?php
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eeg Natiijada Imtixaanka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-4">
            <h2 class="fw-bold text-dark">Student Result Portal</h2>
            <p class="text-muted">FADLAN Geli Roll ID-gaaga si aad u aragto warqadda dhibcahaaga.</p>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="card shadow border-0 p-4">
                <form method="GET" action="">
                    <div class="input-group">
                        <input type="text" name="rollid" class="form-control form-control-lg" placeholder="Qor Roll ID-gaaga (Tusaale: SRMS-1001)" value="<?php echo isset($_GET['rollid']) ? htmlspecialchars($_GET['rollid']) : ''; ?>" required>
                        <button type="submit" class="btn btn-primary btn-lg fw-bold">Raadi Natiijada</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    if (isset($_GET['rollid']) && !empty(trim($_GET['rollid']))) {
        $rollid = mysqli_real_escape_string($con, $_GET['rollid']);

        $student_q = "SELECT tblstudents.*, tblclasses.ClassName, tblclasses.Section 
                      FROM tblstudents 
                      INNER JOIN tblclasses ON tblstudents.ClassId = tblclasses.id 
                      WHERE tblstudents.RollId = '$rollid'";
        
        $student_res = mysqli_query($con, $student_q);

        if ($student_res && mysqli_num_rows($student_res) > 0) {
            $student = mysqli_fetch_assoc($student_res);
            $student_id = $student['StudentId'];
            ?>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow border-0 p-5 bg-white">
                        <div class="text-center border-bottom pb-3 mb-4">
                            <h4 class="fw-bold m-0 text-primary">PRIMARY SCHOOL</h4>
                            <small class="text-muted">Official Student Report Card</small>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-6">
                                <p class="mb-1"><strong>Magaca:</strong> <?php echo htmlspecialchars($student['StudentName']); ?></p>
                                <p class="mb-0"><strong>Roll ID:</strong> <?php echo htmlspecialchars($student['RollId']); ?></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-1"><strong>Fasalka:</strong> <?php echo htmlspecialchars($student['ClassName']); ?></p>
                                <p class="mb-0"><strong>Qaybta:</strong> <?php echo htmlspecialchars($student['Section']); ?></p>
                            </div>
                        </div>

                        <table class="table table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Subject Name</th>
                                    <th class="text-center">Marks Obtained</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $results_q = "SELECT tblsubjects.SubjectName, tblresults.marks 
                                              FROM tblresults 
                                              INNER JOIN tblsubjects ON tblresults.SubjectId = tblsubjects.id 
                                              WHERE tblresults.StudentId = '$student_id'";
                                $results_res = mysqli_query($con, $results_q);
                                
                                $total_marks = 0;
                                $subject_count = 0;

                                if ($results_res && mysqli_num_rows($results_res) > 0) {
                                    while ($row = mysqli_fetch_assoc($results_res)) {
                                        $total_marks += $row['marks'];
                                        $subject_count++;
                                        $status = ($row['marks'] >= 50) ? "<span class='badge bg-success'>Gudbay</span>" : "<span class='badge bg-danger'>Hadhay</span>";
                                        echo "<tr>
                                                <td>" . htmlspecialchars($row['SubjectName']) . "</td>
                                                <td class='text-center fw-bold'>" . htmlspecialchars($row['marks']) . "</td>
                                                <td class='text-center'>$status</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center text-muted'>Weli dhibco looma gelin ardaygan.</td></tr>";
                                }
                                ?>
                                <tr class="table-secondary fw-bold">
                                    <td>Total Marks (Tirada Guud)</td>
                                    <td class="text-center"><?php echo $total_marks; ?></td>
                                    <td class="text-center">Avg: <?php echo ($subject_count > 0) ? round($total_marks / $subject_count, 1) : 0; ?>%</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="text-center mt-4">
                            <button onclick="window.print()" class="btn btn-outline-secondary"><i class="fa fa-print"></i> Daabaco Report Card-ka</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo "<div class='row justify-content-center'><div class='col-md-6 alert alert-danger text-center'>Roll ID-gan nidaamka kuma jiro. Hubi nambarka fadlan.</div></div>";
        }
    }
    ?>
</div>
</body>
</html>