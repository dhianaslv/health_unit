<?php
if (!isset($_SESSION["loggedUser"])) {
  header("Location: ./");
}

require_once "app/components/MessageContainer.php";
require_once "app/components/Base.php";
?>
<html>

<head>
  <?php Base::head("Prontuário | Unidade de Saúde") ?>
  <link rel="stylesheet" type="text/css" href="./public/styles/css/form.css" />
</head>

<body>
  <?php Base::header(); ?>
  <main class="container">
    <section class="quick-access">
      <a href="?page=medical_records/search" class="home-button">
        <h3>
          <p>Procurar Prontuário</p>
          <img src="./public/styles/img/file-search.png" alt="Imagem de prontuário" />
        </h3>
      </a>
      <a href="?page=symptom" class="home-button">
        <h3>
          <p>Questionário (Dengue)</p>
          <img src="./public/styles/img/questionnaire.svg" alt="Imagem de questionário" />
        </h3>
      </a>

      <a href="?page=medical_records/most_recurrent_symptom" class="home-button">
        <h3>
          <p>Sintomas mais recorrentes</p>
          <img src="./public/styles/img/search.svg" alt="Imagem da pesquisa por sintomas mais recorrentes" />
        </h3>
      </a>
      <a href="?page=medical_records/list" class="home-button">
        <h3>
          <p>Listar Prontuários</p>
          <img src="./public/styles/img/medical-records-list.svg" alt="Imagem de lista de prontuários" />
        </h3>
      </a>
      <a href="?page=home" class="home-button">
        <h3>
          <p>Home</p>
          <img src="./public/styles/img/home.svg" alt="Imagem de Home" />
        </h3>
      </a>
    </section>
    <?php
    if (isset($_SESSION["errorMessage"])) {
      MessageContainer::errorMessage("Mensagem de Erro", $_SESSION["errorMessage"]);
      $_SESSION["errorMessage"] = null;
    } else if (isset($_SESSION["successMessage"])) {
      MessageContainer::successMessage("Operação realizada", $_SESSION["successMessage"]);
      $_SESSION["successMessage"] = null;
    } else {
    ?>
      <section class="box">
        <div class="form">
          <h2>Dados Pessoais</h2>
          <form method="POST" action="?class=MedicalRecords&action=download">
            <div class="input-block">
              <label for="full_name">Nome</label>
              <input id="full_name" value="<?php echo ($medical_records->getPatientCpf()[1]) ?>" disabled />
              <input type="hidden" name="full_name" value="<?php echo ($medical_records->getPatientCpf()[1]) ?>" />
            </div>
            <div class="input-block">
              <label for="cpf">CPF </label>
              <input id="cpf" value="<?php echo ($medical_records->getPatientCpf()[0]) ?>" disabled />
              <input type="hidden" name="cpf" value="<?php echo ($medical_records->getPatientCpf()[0]) ?>" />
            </div>
            <div class="input-block">
              <label for="date_of_birth">Data de nascimento </label>
              <input id="date_of_birth" value="<?php echo ($medical_records->getPatientCpf()[2]) ?>" disabled />
              <input type="hidden" name="date_of_birth" value="<?php echo ($medical_records->getPatientCpf()[2]) ?>" />
            </div>
            <div class="input-block">
              <label for="genre">Gênero: </label>
              <input id="genre" value="<?php echo ($medical_records->getPatientCpf()[3]) ?>" disabled />
              <input type="hidden" name="genre" value="<?php echo ($medical_records->getPatientCpf()[3]) ?>" />
            </div>
            <div class="input-block">
              <label for="naturalness">Naturalidade: </label>
              <input id="naturalness" value="<?php echo ($medical_records->getPatientCpf()[4]) ?>" disabled />
              <input type="hidden" name="naturalness" value="<?php echo ($medical_records->getPatientCpf()[4]) ?>" />
            </div>
            <div class="input-block">
              <label for="mother_name">Nome da Mãe</label>
              <input id="mother_name" value="<?php echo ($medical_records->getPatientCpf()[6]) ?>" disabled />
              <input type="hidden" name="mother_name" value="<?php echo ($medical_records->getPatientCpf()[6]) ?>" />
            </div>
            <div class="input-block">
              <label for="companion">Acompanhante</label>
              <input id="companion" value="<?php echo ($medical_records->getPatientCpf()[7]) ?>" disabled />
              <input type="hidden" name="companion" value="<?php echo ($medical_records->getPatientCpf()[7]) ?>" />
            </div>
            <div class="input-block">
              <label for="patient_address">Endereço</label>
              <input id="patient_address" value="<?php echo ($medical_records->getPatientCpf()[5]) ?>" disabled />
              <input type="hidden" name="patient_address" value="<?php echo ($medical_records->getPatientCpf()[5]) ?>" />
            </div>
            <h2>Resultados</h2>
            <div class="input-block">
              <label for="start_date">Data de início dos sintomas</label>
              <input id="start_date" value="<?php echo ($medical_records->getStartDate()) ?>" disabled />
              <input type="hidden" name="start_date" value="<?php echo ($medical_records->getStartDate()) ?>" />
            </div>
            <div class="input-block">
              <label for="result">Resultado (%) </label>
              <input id="result" value="<?php echo (number_format($medical_records->getResult(), 2)) ?>" disabled />
              <input type="hidden" name="result" value="<?php echo (number_format($medical_records->getResult(), 2)) ?>" />
            </div>
            <div class="input-block">
              <label for="gravity">Gravidade </label>
              <input id="gravity" value="<?php echo ($medical_records->getGravity()) ?>" disabled />
              <input type="hidden" name="gravity" value="<?php echo ($medical_records->getGravity()) ?>" />
            </div>
            <h2>Sintomas</h2>
            <?php
            if ($medical_records->getPatientCpf()[8] == null) {
            ?>
              <ul>
                <li>Este paciente não possui nenhum sintoma de Dengue.</li>
              </ul>
              <?php
            } else {
              $symptoms = $medical_records->getPatientCpf()[8];
              foreach ($symptoms as $symptom) {
              ?>
                <ul>
                  <li><?php echo ($symptom['name']); ?></li>
                  <input type="hidden" name="symptoms[]" value="<?php echo ($symptom['name']) ?>" />
                </ul>
            <?php
              }
            }
            ?>


            <button type="submit" class="primary-button">Download do Prontuário</button>
          </form>
        </div>

      </section>
    <?php
    }
    ?>
  </main>
  <?php Base::footer(); ?>
</body>

</html>