<?php
// Tallaabada 1: Waxaan bilaabaynaa Session-ka si system-ku u xasuusto qofka soo galay
session_start();

// Tallaabada 2: Waxaan u yeeranaynaa faylkii iskuxirka database-ka ee aynu hadda samaynay
include('connection.php');

// Tallaabada 3: Dynamic Page Routing (Soo qabashada bogga la gujiyey)
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f9; }
        .navbar-custom { background-color: #007bff; color: white; }
        .sidebar { background-color: #343a40; min-height: 100vh; color: #fff; }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 12px 20px; display: block; }
        .sidebar a:hover, .sidebar a.active { background-color: #495057; color: #fff; border-left: 4px solid #007bff; }
        .main-content { padding: 30px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom sticky-top shadow p-2">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 text-white fs-5"><i class="fa fa-bars me-3"></i> SRMS Admin</span>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar p-0 shadow">
                <div class="p-3 text-center border-bottom border-secondary">
                    <h5 class="m-0 text-white">Administrator</h5>
                </div>
                <div class="pt-2">
                    <a href="index.php?page=dashboard" class="<?php echo $page == 'dashboard' ? 'active' : ''; ?>"><i class="fa fa-tachometer-alt me-2"></i> Dashboard</a>
<a href="index.php?page=add-classes" class="<?php echo $page == 'add-classes' ? 'active' : ''; ?>"><i class="fa fa-folder-plus me-2"></i> Classes</a>
<a href="index.php?page=add-subjects" class="<?php echo $page == 'add-subjects' ? 'active' : ''; ?>"><i class="fa fa-book me-2"></i> Subjects</a>
<a href="index.php?page=add-students" class="<?php echo $page == 'add-students' ? 'active' : ''; ?>"><i class="fa fa-users me-2"></i> Students</a>
<a href="index.php?page=results" class="<?php echo $page == 'results' ? 'active' : ''; ?>"><i class="fa fa-file-invoice me-2"></i> Results</a>
<a href="index.php?page=upload-excel" class="<?php echo $page == 'upload-excel' ? 'active' : ''; ?>"><i class="fa fa-file-excel me-2"></i> Excel Upload</a>
                </div>
            </nav>

            <main class="col-md-10 ms-sm-auto main-content">
                <?php 
                    // Nidaamku wuxuu hubinayaa haddii file-ka la codsaday uu jiro, markaas ayuu soo dhex gelinayaa
                    if (file_exists($page . '.php')) {
                        include($page . '.php');
                    } else {
                        echo "<h2 class='mt-4'>Kusoo Dhawaada SRMS Dashboard</h2><p>Dooro mid ka mid ah menu-yada bidix si aad shaqada u bilowdo sxb.</p>";
                    }
                ?>
            </main>
        </div>
    </div>

</body>
</html>