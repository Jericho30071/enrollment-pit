<?php
include 'db_connect.php';
$sy = $conn->query("SELECT * from school_year where is_on = 1 ")->fetch_array();
?>
<div class="container-fluid">
    <div class="alert alert-primary text-center py-3 shadow-sm">
        <h2 class="mb-0"><i class="fas fa-chart-line"></i> Dashboard</h2>
    </div>

    <div class="container text-center my-4">
        <h4 class="font-weight-bold">Academic Year: 
            <span class="text-primary">
                <?php echo isset($sy['school_year']) ? $sy['school_year'] : 'N/A'; ?>
            </span>
        </h4>
    </div>

    <div class="row justify-content-center">
        <!-- Enrolled Students Card -->
        <div class="col-md-3">
            <div class="card dashboard-card border-0 shadow-sm rounded-lg text-center p-4 mb-4 bg-light">
                <div class="card-body">
                    <i class="fas fa-user-graduate fa-3x text-success"></i>
                    <h5 class="mt-3">Enrolled Students</h5>
                    <hr>
                    <h3 class="text-dark font-weight-bold">
                        <?php echo $conn->query("SELECT * from enrollment where status = 1 and school_year = ".$sy['id'])->num_rows ?>
                    </h3>
                </div>
            </div>
        </div>

        <!-- Faculty Card -->
        <div class="col-md-3">
            <div class="card dashboard-card border-0 shadow-sm rounded-lg text-center p-4 mb-4 bg-light">
                <div class="card-body">
                    <i class="fas fa-chalkboard-teacher fa-3x text-info"></i>
                    <h5 class="mt-3">Faculty Members</h5>
                    <hr>
                    <h3 class="text-dark font-weight-bold">
                        <?php echo $conn->query("SELECT * from faculty where status = 1 ")->num_rows ?>
                    </h3>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="col-md-3">
            <div class="card dashboard-card border-0 shadow-sm rounded-lg text-center p-4 mb-4 bg-light">
                <div class="card-body">
                    <i class="fas fa-users fa-3x text-danger"></i>
                    <h5 class="mt-3">Active Users</h5>
                    <hr>
                    <h3 class="text-dark font-weight-bold">
                        <?php echo $conn->query("SELECT * from users where status = 1 ")->num_rows ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Card Effects */
.dashboard-card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s;
    border-radius: 12px;
}
.dashboard-card:hover {
    transform: scale(1.07);
    box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.3);
}

/* Background Styling */
body {
    background: #f4f6f9;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .dashboard-card {
        padding: 2rem;
    }
}
</style>
