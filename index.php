<?php
session_start();
include('connection.php');

// maskaxda koodka; waxay eegaysaa bogga aad taabto
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
        .sidebar { background-color: #364554; min-height: 100vh; color: #fff; }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 12px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background-color: #495057; color: #fff; border-left: 4px solid #007bff; }
        .main-content { padding: 30px; }
    </style>
</head>
<body>
    
   <nav class="navbar navbar-custom sticky-top shadow p-2"> 
        <div class="container-fluid">
            <button class="btn text-white border-0 fs-5" id="sidebarToggle" type="button">
                <i class="fa fa-bars"></i>
            </button>
            <span class="navbar-brand mb-0 h1 text-white fs-5 me-auto ms-2">SRMS Admin</span>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-2 d-md-block sidebar p-0 shadow collapse show">
                <div class="p-3 text-center border-bottom border-secondary">
                    <h5 class="m-0 text-white">Administrator</h5>
                </div>
                <div class="pt-2">
                    <a href="index.php?page=dashboard" class="<?php echo $page == 'dashboard' ? 'active' : ''; ?>"><i class="fa fa-tachometer-alt me-2"></i> Dashboard</a>
                    <a href="index.php?page=classes" class="<?php echo $page == 'classes' ? 'active' : ''; ?>"><i class="fa fa-folder-plus me-2"></i> Classes</a>
                    <a href="index.php?page=subjects" class="<?php echo $page == 'subjects' ? 'active' : ''; ?>"><i class="fa fa-book me-2"></i> Subjects</a>
                    <a href="index.php?page=students" class="<?php echo ($page == 'students' || $page == 'edit-student') ? 'active' : ''; ?>"><i class="fa fa-users me-2"></i> Students</a>
                    <a href="index.php?page=results" class="<?php echo $page == 'results' ? 'active' : ''; ?>"><i class="fa fa-file-invoice me-2"></i> Results</a>
                    <a href="index.php?page=upload" class="<?php echo $page == 'upload' ? 'active' : ''; ?>"><i class="fa fa-file-excel me-2"></i> Excel Upload</a>
                    <a href="index.php?page=teachers" class="<?php echo $page == 'teachers' ? 'active' : ''; ?>"><i class="fa fa-chalkboard-teacher me-2"></i> Teachers</a>
                </div>
            </nav>

            <main class="col-md-10 ms-sm-auto main-content">
                <?php 
                    // dynnamic routing system based on the 'page' parameter in the URL
                    switch($page) {
                        case 'dashboard':   include('dashboard.php'); break;
                        case 'classes':     include('add-classes.php'); break;
                        case 'subjects':    include('add-subjects.php'); break;
                        case 'students':    include('add-students.php'); break;
                        case 'edit-student': include('edit-student.php'); break; 
                        case 'results':     include('results.php'); break;
                        case 'upload':      include('upload-excel.php'); break;
                        case 'teachers':    include('teachers.php'); break;
                        default:
                            echo "<h2 class='mt-4'>Kusoo Dhawaada SRMS Dashboard</h2><p>Dooro mid ka mid ah menu-yada bidix si aad shaqada u bilowdo.</p>";
                            break;
                    }
                ?>
            </main>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        var sidebar = document.getElementById('sidebarMenu');
        var bsCollapse = new bootstrap.Collapse(sidebar, {
            toggle: true
        });
    });
</script>
</body>
</html>