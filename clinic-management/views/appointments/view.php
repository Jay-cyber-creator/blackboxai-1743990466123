<?php
$title = 'Appointment Details';
ob_start();
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Appointment Details</h4>
                <?php if ($_SESSION['user_role'] === 'doctor'): ?>
                    <form method="POST" action="/appointments/updateStatus/<?= $appointment->id ?>">
                        <div class="input-group">
                            <select name="status" class="form-select form-select-sm">
                                <option value="pending" <?= $appointment->status === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="confirmed" <?= $appointment->status === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                <option value="cancelled" <?= $appointment->status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                <option value="completed" <?= $appointment->status === 'completed' ? 'selected' : '' ?>>Completed</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Patient Information</h5>
                        <p><strong>Name:</strong> <?= htmlspecialchars($appointment->patient_name) ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Doctor Information</h5>
                        <p><strong>Name:</strong> Dr. <?= htmlspecialchars($appointment->doctor_name) ?></p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Appointment Details</h5>
                        <p><strong>Date & Time:</strong> <?= date('M j, Y g:i A', strtotime($appointment->appointment_date)) ?></p>
                        <p>
                            <strong>Status:</strong> 
                            <span class="badge bg-<?= 
                                $appointment->status === 'confirmed' ? 'success' : 
                                ($appointment->status === 'pending' ? 'warning' : 
                                ($appointment->status === 'cancelled' ? 'danger' : 'secondary'))
                            ?>">
                                <?= ucfirst($appointment->status) ?>
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h5>Notes</h5>
                        <p><?= $appointment->notes ? htmlspecialchars($appointment->notes) : 'No notes available' ?></p>
                    </div>
                </div>

                <?php if ($_SESSION['user_role'] === 'doctor'): ?>
                    <hr>
                    <div class="mb-3">
                        <h5>Add Medical Record</h5>
                        <form method="POST" action="/medicalRecords/create">
                            <input type="hidden" name="appointment_id" value="<?= $appointment->id ?>">
                            <div class="mb-3">
                                <label class="form-label">Diagnosis</label>
                                <textarea name="diagnosis" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Prescription</label>
                                <textarea name="prescription" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Additional Notes</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Record</button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php';
?>