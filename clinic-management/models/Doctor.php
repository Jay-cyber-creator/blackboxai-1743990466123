<?php
class Doctor extends User {
    public function createProfile($userId, $data) {
        $this->db->query('INSERT INTO doctors (user_id, name, specialization, qualification) 
                         VALUES (:user_id, :name, :specialization, :qualification)');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':specialization', $data['specialization']);
        $this->db->bind(':qualification', $data['qualification']);
        
        return $this->db->execute();
    }

    public function getAppointments($doctorId) {
        $this->db->query('SELECT a.*, p.name AS patient_name 
                         FROM appointments a
                         JOIN patients p ON a.patient_id = p.id
                         WHERE a.doctor_id = :doctor_id
                         ORDER BY a.appointment_date ASC');
        $this->db->bind(':doctor_id', $doctorId);
        return $this->db->resultSet();
    }

    public function setAvailability($doctorId, $availability) {
        $this->db->query('UPDATE doctors SET availability = :availability WHERE id = :doctor_id');
        $this->db->bind(':availability', json_encode($availability));
        $this->db->bind(':doctor_id', $doctorId);
        return $this->db->execute();
    }

    public function getAvailableSlots($doctorId, $date) {
        $this->db->query('SELECT availability FROM doctors WHERE id = :doctor_id');
        $this->db->bind(':doctor_id', $doctorId);
        $doctor = $this->db->single();
        
        $availability = json_decode($doctor->availability, true);
        $dayOfWeek = strtolower(date('l', strtotime($date)));
        
        return $availability[$dayOfWeek] ?? [];
    }
}