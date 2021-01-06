<?php
namespace src\data;
use src\data\repository\PatientRepository;
use src\data\repository\SymptomRepository;
use src\data\repository\MedicalRecordsRepository;
use src\data\repository\MedicalAppointmentRepository;
use src\data\repository\DoctorRepository;

class Facade {

    private $patient_repository;
    private $symptom_repository;
    private $medical_records_repository;
    private $medical_appointment_repository;
    private $doctor_repository;

    public function __construct() {
        $this->patient_repository = new PatientRepository();
        $this->symptom_repository = new SymptomRepository();
        $this->medical_records_repository = new MedicalRecordsRepository();
        $this->medical_appointment_repository = new MedicalAppointmentRepository();
        $this->doctor_repository = new DoctorRepository();
    }

    public function registerPatient( $cpf, $full_name, $genre, $date_of_birth, 
    $mother_name, $companion, $address, $naturalness ) {
        
        $result = $this->patient_repository->register( $cpf, $full_name, $genre, 
        $date_of_birth, $mother_name, $companion, $address, $naturalness );

        return $result;
    }

    public function allPatients() {
        $result = $this->patient_repository->allPatients();

        return $result;
    }

    public function fetchPatient($cpf) {
        $result = $this->patient_repository->fetchPatient($cpf);

        return $result;
    }

    public function addSymptoms($patient_cpf, $symptoms, $start_date){

        $result = $this->symptom_repository->addSymptoms($patient_cpf, $symptoms);

        if(is_bool($result)){
            $response = $this->medical_records_repository->addMedicalRecords($patient_cpf, 
            count($symptoms), $start_date);

            return $response;
        }else{
            return $result;
        }
    }

    public function fetchSymptoms($cpf) {
        $result = $this->symptom_repository->fetchSymptoms($cpf);

        return $result;
    }

    public function registerDoctor($name, $genre, $specialty) {
        
        $result = $this->doctor_repository->register($name, $genre, $specialty);

        return $result;
    }

    public function updateDoctor($doctor){
            
        $result = $this->doctor_repository->update($doctor);
          
        return $result;
    }

    public function allDoctors() {
        $result = $this->doctor_repository->allDoctors();

        return $result;
    }

    public function fetchDoctor($id) {
        $result = $this->doctor_repository->fetchDoctor($id);

        return $result;
    }

    public function fetchMedicalRecords($cpf) {
        $result = $this->medical_records_repository->fetchMedicalRecords($cpf);

        return $result;
    }

    public function makeAnAppointment($patient_cpf, $genre, $specialty, $date, $time){

        $result = $this->medical_appointment_repository->makeAnAppointment($patient_cpf, 
        $genre, $specialty, $date, $time);

        return $result;
    }

    public function allMedicalAppointments() {
        $result = $this->medical_appointment_repository->allMedicalAppointments();

        return $result;
    }
}
?>
