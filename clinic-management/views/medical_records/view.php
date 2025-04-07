<?php
$title = 'Medical Record';
ob_start();
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Medical Record</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Patient Information</h5>
                        <p><strong>Name:</strong> <?= htmlspecialchars($record->patient_name) ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Doctor Information</h5>
                        <p><strong>Name:</strong> Dr. <?= htmlspecialchars($record->doctor_name) ?></p>
                        <p><strong>Date:</strong> <?= date('M j, Y', strtotime($record->record_date)) ?></p>
                    </div>
                </div>

                <div class="mb-4">
                    <h5>Diagnosis</h5>
                    <div class="p-3 bg-light rounded">
                        <?= nl2br(htmlspecialchars($record->diagnosis)) ?>
                    </div>
                </div>

                <div class="mb-4">
                    <h5>Prescription</h5>
                    <div class="p-3 bg-light rounded">
                        <?= nl2br(htmlspecialchars($record->prescription)) ?>
                    </div>
                </div>

                <?php if ($record->notes): ?>
                <div class="mb-4">
                    <h5>Additional Notes</h5>
                    <div class="p-3 bg-light rounded">
                        <?= nl2br(htmlspecialchars($record->notes)) ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($_SESSION['user_role'] === 'doctor'): ?>
                    <div class="text-end mt-4">
                        <a href="/medicalRecords/edit/<?= $record->id ?>" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i> Edit Record
                        </a>
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