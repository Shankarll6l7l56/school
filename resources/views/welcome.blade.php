<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .welcome-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .portal-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .portal-card:hover {
            transform: translateY(-5px);
            border-color: #667eea;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .student-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .teacher-card {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        .admin-card {
            background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="welcome-card p-5">
                    <div class="text-center mb-5">
                        <h1 class="display-4 fw-bold text-primary mb-3">
                            <i class="fas fa-graduation-cap me-3"></i>
                            School Management System
                        </h1>
                        <p class="lead text-muted">Welcome to our comprehensive school management platform</p>
                    </div>

                    <div class="row g-4">
                        <!-- Student Portal -->
                        <div class="col-md-4">
                            <div class="card portal-card student-card h-100">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-user-graduate fa-4x mb-3"></i>
                                    <h4 class="card-title">Student Portal</h4>
                                    <p class="card-text">Access your academic information, attendance, and exam results</p>
                                    <a href="{{ route('student.dashboard') }}" class="btn btn-light btn-lg w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i>Enter Portal
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Teacher Portal -->
                        <div class="col-md-4">
                            <div class="card portal-card teacher-card h-100">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-chalkboard-teacher fa-4x mb-3"></i>
                                    <h4 class="card-title">Teacher Portal</h4>
                                    <p class="card-text">Manage classes, mark attendance, and view student progress</p>
                                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-light btn-lg w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i>Enter Portal
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Portal -->
                        <div class="col-md-4">
                            <div class="card portal-card admin-card h-100">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-user-shield fa-4x mb-3"></i>
                                    <h4 class="card-title">Admin Portal</h4>
                                    <p class="card-text">Complete system administration and management</p>
                                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i>Enter Portal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <p class="text-muted">
                            <i class="fas fa-info-circle me-2"></i>
                            Please contact your administrator if you need access credentials
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
