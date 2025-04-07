<?php
$title = 'Admin Dashboard';
ob_start();
?>
<div class="dashboard-header">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></h1>
    <p class="lead">Manage clinic operations and users</p>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card dashboard-card text-center">
            <div class="card-body">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="card-title">Total Users</h5>
                <p class="display-6"><?= $totalUsers ?? 0 ?></p>
                <a href="/admin/users" class="btn btn-sm btn-outline-primary">Manage</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card dashboard-card text-center">
            <div class="card-body">
                <div class="card-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <h5 class="card-title">Doctors</h5>
                <p class="display-6"><?= $doctorCount ?? 0 ?></p>
                <a href="/admin/doctors" class="btn btn-sm btn-outline-primary">Manage</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card dashboard-card text-center">
            <div class="card-body">
                <div class="card-icon">
                    <i class="fas fa-procedures"></i>
                </div>
                <h5 class="card-title">Patients</h5>
                <p class="display-6"><?= $patientCount ?? 0 ?></p>
                <a href="/admin/patients" class="btn btn-sm btn-outline-primary">Manage</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card dashboard-card text-center">
            <div class="card-body">
                <div class="card-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h5 class="card-title">Appointments</h5>
                <p class="display-6"><?= $appointmentCount ?? 0 ?></p>
                <a href="/admin/appointments" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Recent Users</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recentUsers as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user->name) ?></td>
                                <td><?= htmlspecialchars($user->email) ?></td>
                                <td><span class="badge bg-info"><?= ucfirst($user->role) ?></span></td>
                                <td><?= date('M j, Y', strtotime($user->created_at)) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Recent Appointments</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recentAppointments as $appt): ?>
                            <tr>
                                <td><?= date('M j', strtotime($appt->appointment_date)) ?></td>
                                <td><?= htmlspecialchars($appt->patient_name) ?></td>
                                <td>Dr. <?= htmlspecialchars($appt->doctor_name) ?></td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $appt->status === 'confirmed' ? 'success' : 
                                        ($appt->status === 'pending' ? 'warning' : 'secondary')
                                    ?>">
                                        <?= ucfirst($appt->status) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php';
?>