<?php
namespace src\data\repository;
use src\data\repository\Connection;
use app\models\MedicalAppointment;

class MedicalAppointmentRepository {

    private $conn;

    public function __construct() {
        $this->conn = new Connection();
    }

    public function makeAnAppointment($patient_cpf, $genre, $specialty, $date, $time) {
        try {

            $select = "SELECT id FROM doctor WHERE genre = :genre AND specialty = :specialty";

            $stmt = $this->conn->connect()->prepare( $select );

            $stmt->execute(array(
                ':genre' => $genre,
                ':specialty' => $specialty,
            ));

            $doctor = $stmt->fetchAll();

            if($doctor!=null){
                $id_doctor = $doctor[0]['id'];

                $sql = "INSERT INTO medical_appointment (cpf_patient_fk, id_doctor_fk, time, 
                date, realized) 
                    VALUES (:cpf_patient_fk, :id_doctor_fk, :time, :date, :realized)";

                                
                $stmt2 = $this->conn->connect()->prepare( $sql );

                $success = $stmt2->execute( array(
                    ':cpf_patient_fk' => $patient_cpf,
                    ':id_doctor_fk' => $id_doctor,
                    ':time' => $time,
                    ':date' => $date,
                    ':realized' => 0,
                ) );

                if ( $success ) {
                    return $success;
                }

                $response = "Não foi possível marcar a consulta. Tente mais tarde.";

                return $response;
            }

            return "Não há nenhum médico com essa descrição, por isso não foi possível marcar a consulta.";
        } catch(Exception $e){
            return "Exception: $e";
        }
        finally {
            $this->conn  = null;
        }
    }

    public function allMedicalAppointments() {
        try {
            $sql = "SELECT P.full_name, D.name, MA.id, MA.time, 
            MA.date, MA.arrival_time, MA.realized 
            FROM patient AS P
            INNER JOIN medical_appointment AS MA ON (MA.cpf_patient_fk = P.cpf)
            INNER JOIN doctor AS D ON (MA.id_doctor_fk = D.id)";

            $stmt = $this->conn->connect()->prepare( $sql );

            $stmt->execute();

            $result = $stmt->fetchAll();

            if ( $result!=null ) {
                $list = [];

                foreach($result as $row){
                    $id = $row['id'];
                    $patient = $row['full_name'];
                    $doctor = $row['name'];
                    $time = $row['time'];
                    $date = $row['date'];

                    if($row['realized']){
                        $realized = "Sim";
                    }else{
                        $realized = "Não";
                    }

                    if($row['arrival_time']!=null){
                        $arrival_time = $row['arrival_time'];
                    }else{
                        $arrival_time = "-----";
                    }

                    $medical_appointment = new MedicalAppointment ($id, $patient, $doctor, $date, 
                    $time, $arrival_time, $realized);

                    array_push($list, $medical_appointment);
                }

                return $list;
            }

            $response = "Não foi possível trazer a lista de consultas";

            return $response;
        } catch(Exception $e){

            return "Exception: $e";
        }
        finally {
            $this->conn  = null;
        }
    }
}
?>
