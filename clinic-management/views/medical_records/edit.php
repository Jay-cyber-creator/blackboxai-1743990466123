<?php
$title = 'Edit Medical Record';
ob_start();
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Edit Medical Record</h4>
            </div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST" action="/medicalRecords/edit/<?= $record->id ?>">
                    <div class="mb-3">
                        <label class="form-label">Diagnosis</label>
                        <textarea name="diagnosis" class="form-control" rows="3" required><?= 
                            htmlspecialchars($record->diagnosis) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prescription</label>
                        <textarea name="prescription" class="form-control" rows="3" required><?= 
                            htmlspecialchars($record->prescription) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Additional Notes</label>
                        <textarea name="notes" class="form-control" rows="2"><?= 
                            htmlspecialchars($record->notes) ?></textarea>
                    </div>
                    <div class="text-end">
                        <a href="/medicalRecords/view/<?= $record->id ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php';
?>