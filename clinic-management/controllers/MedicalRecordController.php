<?php
class MedicalRecordController {
    private $db;
    private $recordModel;
    private $patientModel;
    private $doctorModel;

    public function __construct($db) {
        $this->db = $db;
        $this->recordModel = new MedicalRecord($db);
        $this->patientModel = new Patient($db);
        $this->doctorModel = new Doctor($db);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'diagnosis' => $_POST['diagnosis'],
                'prescription' => $_POST['prescription'],
                'notes' => $_POST['notes'] ?? null
            ];

            $patientId = $_POST['patient_id'] ?? $_SESSION['user_id'];
            $doctorId = $_SESSION['user_id'];
            $appointmentId = $_POST['appointment_id'] ?? null;

            if ($this->recordModel->create($patientId, $doctorId, $data, $appointmentId)) {
                $_SESSION['success'] = 'Medical record created successfully';
                header('Location: ' . ($appointmentId ? "/appointments/view/$appointmentId" : "/patients/view/$patientId"));
                exit();
            } else {
                $error = "Failed to create medical record";
                require_once 'views/medical_records/create.php';
            }
        }
    }

    public function view($id) {
        $record = $this->recordModel->getById($id);
        if (!$record) {
            require_once 'views/errors/404.php';
            return;
        }

        // Verify access permissions
        if ($_SESSION['user_role'] === 'patient' && $record->patient_id != $_SESSION['user_id']) {
            require_once 'views/errors/403.php';
            return;
        }

        require_once 'views/medical_records/view.php';
    }

    public function edit($id) {
        if ($_SESSION['user_role'] !== 'doctor') {
            require_once 'views/errors/403.php';
            return;
        }

        $record = $this->recordModel->getById($id);
        if (!$record) {
            require_once 'views/errors/404.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'diagnosis' => $_POST['diagnosis'],
                'prescription' => $_POST['prescription'],
                'notes' => $_POST['notes'] ?? null
            ];

            if ($this->recordModel->update($id, $data)) {
                $_SESSION['success'] = 'Medical record updated successfully';
                header("Location: /medicalRecords/view/$id");
                exit();
            } else {
                $error = "Failed to update medical record";
            }
        }

        require_once 'views/medical_records/edit.php';
    }

    public function patientRecords($patientId) {
        if ($_SESSION['user_role'] === 'patient' && $patientId != $_SESSION['user_id']) {
            require_once 'views/errors/403.php';
            return;
        }

        $records = $this->recordModel->getByPatient($patientId);
        $patient = $this->patientModel->getById($patientId);
        
        require_once 'views/medical_records/list.php';
    }
}