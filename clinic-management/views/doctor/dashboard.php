<?php
$title = 'Doctor Dashboard';
ob_start();
?>
<div class="dashboard-header">
    <h1>Welcome, Dr. <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></h1>
    <p class="lead">Manage your appointments and patients</p>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card dashboard-card text-center">
            <div class="card-body">
                <div class="card-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <h5 class="card-title">Today's Appointments</h5>
                <p class="display-6"><?= $todaysAppointmentsCount ?? 0 ?></p>
                <a href="/doctor/appointments" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card dashboard-card text-center">
            <div class="card-body">
                <div class="card-icon">
                    <i class="fas fa-user-injured"></i>
                </div>
                <h5 class="card-title">Active Patients</h5>
                <p class="display-6"><?= $activePatientsCount ?? 0 ?></p>
                <a href="/doctor/patients" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card dashboard-card text-center">
            <div class="card-body">
                <div class="card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h5 class="card-title">Availability</h5>
                <p class="display-6"><?= $availableSlots ?? 0 ?></p>
                <a href="/doctor/availability" class="btn btn-sm btn-outline-primary">Manage</a>
            </div>
        </div>
    </div>
</div>

<div class="card appointment-table mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Upcoming Appointments</h5>
        <a href="/appointments/new" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Patient</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($upcomingAppointments as $appt): ?>
                    <tr>
                        <td><?= date('M j, Y g:i A', strtotime($appt->appointment_date)) ?></td>
                        <td><?= htmlspecialchars($appt->patient_name) ?></td>
                        <td>
                            <span class="badge bg-<?= 
                                $appt->status === 'confirmed' ? 'success' : 
                                ($appt->status === 'pending' ? 'warning' : 'secondary')
                            ?>">
                                <?= ucfirst($appt->status) ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="/appointments/view/<?= $appt->id ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="/appointments/update/<?= $appt->id ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
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