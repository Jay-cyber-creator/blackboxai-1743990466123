<?php
class Appointment {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function bookAppointment($patientId, $doctorId, $dateTime) {
        $this->db->query('INSERT INTO appointments (patient_id, doctor_id, appointment_date) 
                         VALUES (:patient_id, :doctor_id, :appointment_date)');
        $this->db->bind(':patient_id', $patientId);
        $this->db->bind(':doctor_id', $doctorId);
        $this->db->bind(':appointment_date', $dateTime);
        
        return $this->db->execute();
    }

    public function getById($id) {
        $this->db->query('SELECT a.*, p.name AS patient_name, d.name AS doctor_name
                         FROM appointments a
                         JOIN patients p ON a.patient_id = p.id
                         JOIN doctors d ON a.doctor_id = d.id
                         WHERE a.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateStatus($id, $status) {
        $this->db->query('UPDATE appointments SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getPatientAppointments($patientId) {
        $this->db->query('SELECT a.*, d.name AS doctor_name 
                         FROM appointments a
                         JOIN doctors d ON a.doctor_id = d.id
                         WHERE a.patient_id = :patient_id
                         ORDER BY a.appointment_date DESC');
        $this->db->bind(':patient_id', $patientId);
        return $this->db->resultSet();
    }

    public function getDoctorAppointments($doctorId) {
        $this->db->query('SELECT a.*, p.name AS patient_name 
                         FROM appointments a
                         JOIN patients p ON a.patient_id = p.id
                         WHERE a.doctor_id = :doctor_id
                         ORDER BY a.appointment_date ASC');
        $this->db->bind(':doctor_id', $doctorId);
        return $this->db->resultSet();
    }

    public function getAllAppointments() {
        $this->db->query('SELECT a.*, p.name AS patient_name, d.name AS doctor_name
                         FROM appointments a
                         JOIN patients p ON a.patient_id = p.id
                         JOIN doctors d ON a.doctor_id = d.id
                         ORDER BY a.appointment_date DESC');
        return $this->db->resultSet();
    }
}