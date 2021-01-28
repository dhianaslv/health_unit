<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Unidade de Saúde | Consultas</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../../../public/styles/img/doctors-list.svg" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="../../../public/styles/css/main.css" />
    <link rel="stylesheet" type="text/css" href="../../../public/styles/css/home.css" />
    <link rel="stylesheet" type="text/css" href="../../../public/styles/css/table.css" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;800&display=swap" rel="stylesheet" />
</head>

<body>
    <header>
        <h3 class="logo">Unidade de Saúde</h3>
    </header>
    <main class="container">
        <section class="quick-access">
            <a href="./consultation_page.html" class="home-button">
                <h3>
                    <p>Marcar Consulta</p>
                    <img src="../../../public/styles/img/make-an-appointment.svg" alt="Imagem de marcar consulta" />
                </h3>
            </a>
            <a href="./search_medical_appointment.html" class="home-button">
                <h3>
                    <p>Procurar Consulta</p>
                    <img src="../../../public/styles/img/update-medical-appointment.svg" alt="Imagem de pesquisa" />
                </h3>
            </a> <a href="../home_page.php" class="home-button">
                <h3>
                    <p>Home</p>
                    <img src="../../../public/styles/img/home.svg" alt="Imagem de Home" />
                </h3>
            </a>
        </section>
        <section class="table">
            <h2>Lista de Atendimento</h2>
            <?php
            include_once('../../utils/autoload.php');

            use app\controllers\MedicalAppointmentController;

            $medical_appointment_controller = new MedicalAppointmentController();

            $medical_appointment_list = $medical_appointment_controller->allMedicalAppointments();
            if (
                $medical_appointment_list != null &&
                is_array($medical_appointment_list)
            ) { ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Médico(a)</th>
                        <th>Data e Horário</th>
                        <th>Horário de chegada</th>
                        <th>Consulta Realizada?</th>
                    </tr>
                    <?php
                    foreach ($medical_appointment_list as $medical_appointment) {
                    ?>
                        <tr>
                            <td><?php echo ($medical_appointment->getId()); ?></td>
                            <td><?php echo ($medical_appointment->getPatientCpf()); ?></td>
                            <td><?php echo ($medical_appointment->getIdDoctor()); ?></td>
                            <td>
                                <?php echo ($medical_appointment->getDate() . " às
              " . $medical_appointment->getTime()); ?>
                            </td>
                            <td><?php echo ($medical_appointment->getArrivalTime()); ?></td>
                            <td><?php echo ($medical_appointment->getRealized()); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php
            } else {
            ?>
                <p>A lista de atendimento está vazia.</p>
            <?php
            }
            ?>
        </section>
    </main>
    <footer>
        <p>2021 - Unidade de Saúde</p>
    </footer>
</body>

</html>