<?php
class AppointmentController {
    private $db;
    private $appointmentModel;
    private $patientModel;
    private $doctorModel;

    public function __construct($db) {
        $this->db = $db;
        $this->appointmentModel = new Appointment($db);
        $this->patientModel = new Patient($db);
        $this->doctorModel = new Doctor($db);
    }

    public function index() {
        // Show appointment dashboard based on user role
        $role = $_SESSION['user_role'] ?? '';
        header("Location: /$role/appointments");
        exit();
    }

    public function book() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patientId = $_SESSION['user_id'];
            $doctorId = $_POST['doctor_id'];
            $dateTime = $_POST['appointment_date'];
            
            if ($this->appointmentModel->bookAppointment($patientId, $doctorId, $dateTime)) {
                $_SESSION['success'] = 'Appointment booked successfully!';
                header('Location: /patient/dashboard');
                exit();
            } else {
                $error = "Failed to book appointment";
                $doctors = $this->doctorModel->getAllDoctors();
                require_once 'views/appointments/book.php';
            }
        } else {
            $doctors = $this->doctorModel->getAllDoctors();
            require_once 'views/appointments/book.php';
        }
    }

    public function view($id) {
        $appointment = $this->appointmentModel->getById($id);
        if (!$appointment) {
            require_once 'views/errors/404.php';
            return;
        }
        
        // Verify ownership (patient or doctor)
        if ($_SESSION['user_role'] === 'patient' && $appointment->patient_id != $_SESSION['user_id']) {
            require_once 'views/errors/403.php';
            return;
        }
        
        if ($_SESSION['user_role'] === 'doctor' && $appointment->doctor_id != $_SESSION['user_id']) {
            require_once 'views/errors/403.php';
            return;
        }

        require_once 'views/appointments/view.php';
    }

    public function updateStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['user_role'] === 'doctor') {
            $status = $_POST['status'];
            if ($this->appointmentModel->updateStatus($id, $status)) {
                $_SESSION['success'] = 'Appointment status updated';
            } else {
                $_SESSION['error'] = 'Failed to update status';
            }
            header("Location: /appointments/view/$id");
            exit();
        }
    }

    public function getAvailability() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $doctorId = $_GET['doctor_id'] ?? 0;
            $date = $_GET['date'] ?? date('Y-m-d');
            
            $slots = $this->doctorModel->getAvailableSlots($doctorId, $date);
            header('Content-Type: application/json');
            echo json_encode($slots);
            exit();
        }
    }
}