<?php
class Patient extends User {
    public function createProfile($userId, $data) {
        $this->db->query('INSERT INTO patients (user_id, name, phone, address) VALUES (:user_id, :name, :phone, :address)');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':address', $data['address']);
        
        return $this->db->execute();
    }

    public function getAppointments($userId) {
        $this->db->query('SELECT a.*, d.name AS doctor_name 
                         FROM appointments a
                         JOIN doctors d ON a.doctor_id = d.id
                         WHERE a.patient_id = :user_id
                         ORDER BY a.appointment_date DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function bookAppointment($patientId, $doctorId, $dateTime) {
        $this->db->query('INSERT INTO appointments (patient_id, doctor_id, appointment_date, status) 
                         VALUES (:patient_id, :doctor_id, :appointment_date, "pending")');
        $this->db->bind(':patient_id', $patientId);
        $this->db->bind(':doctor_id', $doctorId);
        $this->db->bind(':appointment_date', $dateTime);
        
        return $this->db->execute();
    }
}