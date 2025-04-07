<?php
$title = 'Patient Dashboard';
ob_start();
?>
<div class="dashboard-header">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Patient') ?></h1>
    <p class="lead">Manage your appointments and health records</p>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card dashboard-card text-center">
            <div class="card-body">
                <div class="card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h5 class="card-title">Upcoming Appointments</h5>
                <p class="display-6"><?= $upcomingCount ?? 0 ?></p>
                <a href="/patient/appointments" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card dashboard-card text-center">
            <div class="card-body">
                <div class="card-icon">
                    <i class="fas fa-file-medical"></i>
                </div>
                <h5 class="card-title">Medical Records</h5>
                <p class="display-6"><?= $recordCount ?? 0 ?></p>
                <a href="/patient/records" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card dashboard-card text-center">
            <div class="card-body">
                <div class="card-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <h5 class="card-title">My Doctors</h5>
                <p class="display-6"><?= $doctorCount ?? 0 ?></p>
                <a href="/patient/doctors" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
        </div>
    </div>
</div>

<div class="card appointment-table mt-4">
    <div class="card-header">
        <h5>Recent Appointments</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Doctor</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($recentAppointments as $appt): ?>
                    <tr>
                        <td><?= date('M j, Y g:i A', strtotime($appt->appointment_date)) ?></td>
                        <td>Dr. <?= htmlspecialchars($appt->doctor_name) ?></td>
                        <td>
                            <span class="badge bg-<?= 
                                $appt->status === 'confirmed' ? 'success' : 
                                ($appt->status === 'pending' ? 'warning' : 'secondary')
                            ?>">
                                <?= ucfirst($appt->status) ?>
                            </span>
                        </td>
                        <td>
                            <a href="/appointments/view/<?= $appt->id ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php';
?>