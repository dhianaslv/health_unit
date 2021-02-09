<?php

namespace app\controllers;

use src\services\PatientService;

class PatientController
{
    private $patient_service;

    public function __construct()
    {
        $this->patient_service =  new PatientService();
    }

    public function register(
        $cpf,
        $full_name,
        $genre,
        $date_of_birth,
        $mother_name,
        $companion,
        $address,
        $naturalness
    ) {

        $result = $this->patient_service->register(
            $cpf,
            $full_name,
            $genre,
            $date_of_birth,
            $mother_name,
            $companion,
            $address,
            $naturalness
        );

        return $result;
    }

    public function update($patient)
    {

        $result = $this->patient_service->update($patient);

        return $result;
    }


    public function allPatients()
    {
        $result = $this->patient_service->allPatients();

        return $result;
    }

    public function fetchPatient($cpf)
    {

        $result = $this->patient_service->fetchPatient($cpf);

        return $result;
    }
}
