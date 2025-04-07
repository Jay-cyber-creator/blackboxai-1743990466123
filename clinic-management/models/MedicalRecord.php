<?php
class MedicalRecord {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($patientId, $doctorId, $data, $appointmentId = null) {
        $this->db->query('INSERT INTO medical_records 
                         (patient_id, doctor_id, appointment_id, diagnosis, prescription, notes)
                         VALUES (:patient_id, :doctor_id, :appointment_id, :diagnosis, :prescription, :notes)');
        
        $this->db->bind(':patient_id', $patientId);
        $this->db->bind(':doctor_id', $doctorId);
        $this->db->bind(':appointment_id', $appointmentId);
        $this->db->bind(':diagnosis', $data['diagnosis']);
        $this->db->bind(':prescription', $data['prescription']);
        $this->db->bind(':notes', $data['notes']);
        
        return $this->db->execute();
    }

    public function getByPatient($patientId) {
        $this->db->query('SELECT m.*, d.name AS doctor_name
                         FROM medical_records m
                         JOIN doctors d ON m.doctor_id = d.id
                         WHERE m.patient_id = :patient_id
                         ORDER BY m.record_date DESC');
        $this->db->bind(':patient_id', $patientId);
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query('SELECT m.*, p.name AS patient_name, d.name AS doctor_name
                         FROM medical_records m
                         JOIN patients p ON m.patient_id = p.id
                         JOIN doctors d ON m.doctor_id = d.id
                         WHERE m.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function update($id, $data) {
        $this->db->query('UPDATE medical_records 
                         SET diagnosis = :diagnosis, 
                             prescription = :prescription,
                             notes = :notes
                         WHERE id = :id');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':diagnosis', $data['diagnosis']);
        $this->db->bind(':prescription', $data['prescription']);
        $this->db->bind(':notes', $data['notes']);
        
        return $this->db->execute();
    }
}