<?php
if (!isset($_SESSION["loggedUser"])) {
  header("Location: ./");
}
?>
<html>

<head>
  <title>Unidade de Saúde | Dados do Paciente</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="./public/styles/img/doctors-list.svg" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="./public/styles/css/main.css" />
  <link rel="stylesheet" type="text/css" href="./public/styles/css/home.css" />
  <link rel="stylesheet" type="text/css" href="./public/styles/css/buttons.css" />
  <link rel="stylesheet" type="text/css" href="./public/styles/css/form.css" />
  <link rel="stylesheet" type="text/css" href="./public/styles/css/card.css" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;800&display=swap" rel="stylesheet" />
</head>
<script src="./public/scripts/toggle.js"></script>

<body>

  <header>
    <h3 class="logo">Unidade de Saúde</h3>
  </header>
  <main class="container">
    <section class="quick-access">
      <a href="?page=patient/search" class="home-button">
        <h3>
          <p>Procurar Paciente</p>
          <img src="./public/styles/img/update-patient.svg" alt="Imagem de pesquisa">
        </h3>
      </a>
      <a href="?page=patient/register" class="home-button">
        <h3>
          <p>Cadastrar Paciente</p>
          <img src="./public/styles/img/plus.svg" alt="Imagem de adicionar" />
        </h3>
      </a>
      <a href="?page=patient/list" class="home-button">
        <h3>
          <p>Lista de Pacientes</p>
          <img src="./public/styles/img/list.svg">
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
    require_once "app/components/MessageContainer.php";

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

          <h2>Dados do Paciente</h2>
          <form method="POST" action="?class=Patient&action=update">
            <div class="input-block">
              <label for="cpf">CPF</label>
              <input id="cpf" value="<?php echo ($patient->getCpf()) ?>" disabled />
              <input type="hidden" name="cpf" value="<?php echo ($patient->getCpf()) ?>" required />
            </div>
            <div class="input-block">
              <label for="full_name">Nome</label>
              <input id="full_name" name="full_name" value="<?php echo ($patient->getName()) ?>" required />
            </div>
            <div class="input-block">
              <label for="date_of_birth">Data de Nascimento</label>
              <input id="date_of_birth" type="date" name="date_of_birth" value="<?php echo ($patient->getDateOfBirth()) ?>" required />
            </div>
            <div class="input-block">
              <label for="mother_name">nome da Mãe</label>
              <input id="mother_name" name="mother_name" value="<?php echo ($patient->getMotherName()) ?>" required />
            </div>
            <div class="input-block">
              <label for="genre">Gênero</label>
              <input type="hidden" name="genre" id="genre" value="<?php echo ($patient->getGenre()) ?>" required />

              <div class="button-select">
                <button data-value="Feminino" onclick="toggleGenre(event)" type="button" <?php
                                                                                          if ($patient->getGenre() == "Feminino") {
                                                                                          ?> class="active-genre" <?php
                                                                                                                }
                                                                                                                  ?>>
                  Feminino
                </button>
                <button data-value="Masculino" onclick="toggleGenre(event)" type="button" <?php
                                                                                          if ($patient->getGenre() == "Masculino") {
                                                                                          ?> class="active-genre" <?php
                                                                                                                }
                                                                                                                  ?>>
                  Masculino
                </button>
              </div>
            </div>

            <div class="input-block">
              <label for="naturalness">Naturalidade</label>
              <input type="hidden" name="naturalness" id="naturalness" value="<?php echo ($patient->getNaturalness()) ?>" required />

              <div class="button-select">
                <button data-value="Brasileiro" onclick="toggleNaturalness(event)" type="button" <?php
                                                                                                  if ($patient->getNaturalness() == "Brasileiro(a)") {
                                                                                                  ?> class="active-naturalness" <?php
                                                                                                                              }
                                                                                                                                ?>>
                  Brasileiro(a)
                </button>
                <button data-value="Estrangeiro" onclick="toggleNaturalness(event)" type="button" <?php
                                                                                                  if ($patient->getNaturalness() == "Estrangeiro(a)") {
                                                                                                  ?> class="active-naturalness" <?php
                                                                                                                              }
                                                                                                                                ?>>
                  Estrangeiro(a)
                </button>
              </div>
            </div>

            <div class="input-block">
              <label for="companion"> Acompanhante</label>
              <input id="companion" name="companion" value="<?php echo ($patient->getCompanion()) ?>" required />
            </div>
            <div class="input-block">
              <label for="address"> Endereço </label>
              <input id="address" name="address" value="<?php echo ($patient->getAddress()) ?>" required />
            </div>







            <div class="input-block">
              <label for="active">Status</label>
              <input type="hidden" name="active" id="active" value="<?php echo ($patient->getActive()) ?>" required />

              <div class="button-select">
                <button data-value=1 onclick="toggleActive(event)" type="button" <?php
                                                                                  if ($patient->getActive() == 1) {
                                                                                  ?> class="active" <?php
                                                                                                  }
                                                                                                    ?>>
                  Ativo
                </button>
                <button data-value=0 onclick="toggleActive(event)" type="button" <?php
                                                                                  if ($patient->getActive() == 0) {
                                                                                  ?> class="active" <?php
                                                                                                  }
                                                                                                    ?>>
                  Inativo
                </button>
              </div>
            </div>

            <button type="submit" class="primary-button">Salvar Alterações</button>
          </form>
        </div>

      </section>
    <?php
    }
    ?>
  </main>
  <footer>
    <p>2021 - Unidade de Saúde</p>
  </footer>

</body>

</html>