<?php
require_once "src/services/UserService.php";

class UserController
{
    public static function register()
    {
        $cpf = $_POST["cpf"];
        $name = $_POST["name"];
        $genre = $_POST["genre"];
        $date_of_birth = $_POST["date_of_birth"];
        $address = $_POST["address"];
        $naturalness = $_POST["naturalness"];
        $responsibility = $_POST["responsibility"];

        if (
            !isset($cpf) || !isset($name)
            || !isset($genre) || !isset($date_of_birth)
            || !isset($responsibility)
            || !isset($address) || !isset($naturalness)
        ) {
            $_SESSION['errorMessage'] =  "Você precisa preencher todos os campos para realizar esta operação!";
            require_once "app/pages/user/register/index.php";
        } else {

            $result = UserService::register(
                $cpf,
                $name,
                $genre,
                $date_of_birth,
                $naturalness,
                $address,
                $responsibility
            );

            if (!is_bool($result)) {
                $_SESSION['errorMessage'] =  $result;
                require_once "app/pages/user/register/index.php";
            } else {
                $_SESSION['successMessage'] =  "O cadastro do funcionário foi realizado com sucesso!";
                require_once "app/pages/user/register/index.php";
            }
        }
    }

    public static function update()
    {
        $cpf = $_POST["cpf"];
        $name = $_POST["name"];
        $date_of_birth = $_POST["date_of_birth"];
        $genre = $_POST["genre"];
        $naturalness = $_POST["naturalness"];
        $address = $_POST["address"];
        $responsibility = $_POST["responsibility"];
        $active = $_POST["active"];

        if (
            isset($cpf) && isset($name) && isset($genre) && isset($date_of_birth)
            && isset($responsibility) && isset($address)
            && isset($naturalness)  && isset($active)
        ) {

            $data = UserService::fetchUser($cpf);

            if ($data != null && is_object($data)) {
                $username = $data->getUsername();
                $password = $data->getPassword();

                $user = new User(
                    $cpf,
                    $name,
                    $genre,
                    $date_of_birth,
                    $naturalness,
                    $address,
                    $responsibility,
                    $username,
                    $password,
                    $active
                );

                $result = UserService::update($user);

                if ($result == null || !is_bool($result)) {
                    $_SESSION['errorMessage'] = $result;
                    require_once "app/pages/user/update/index.php";
                } else {
                    $_SESSION['successMessage'] = "As atualizações foram realizadas com sucesso!";
                    require_once "app/pages/user/update/index.php";
                }
            }
        } else {
            $_SESSION['errorMessage'] = "Você precisa alterar alguma informação para que a operação seja realizada.";
            require_once "app/pages/user/update/index.php";
        }
    }

    public static function allUsers($start, $total_records)
    {
        $result = UserService::allUsers($start, $total_records);

        return $result;
    }

    public static function fetchUser()
    {
        $cpf = $_POST["cpf"];

        if (isset($cpf)) {
            $user = UserService::fetchUser($cpf);
            if ($user == null || !is_object($user)) {
                $_SESSION['errorMessage'] = "Não há nenhum funcionário com o CPF: $cpf";
                require_once "app/pages/user/search/index.php";
            } else {
                require_once "app/pages/user/update/index.php";
            }
        } else {
            $_SESSION['errorMessage'] =  "Você precisa inserir um CPF!";
            require_once "app/pages/user/search/index.php";
        }
    }

    public static function signIn()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (isset($username) && isset($password)) {
            $result = UserService::signIn($username, $password);

            if ($result == null || !is_object($result)) {
                $_SESSION["errorMessage"] = "O usuário inserido não possui permissão para acessar a plataforma.";
                header("Location: ./");
            } else {
                $_SESSION["loggedUser"] = $result->getResponsibility();

                header("Location: ./");
            }
        } else {
            $_SESSION["errorMessage"] = "Você precisa inserir o username e a senha para acessar a plataforma!";

            header("Location: ./");
        }
    }

    public static function save()
    {
        $cpf = $_POST["cpf"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        if (
            isset($username) && isset($password) &&
            isset($cpf) && isset($confirm_password)
        ) {
            $user = UserService::fetchUser($cpf);

            if ($user == null || !is_object($user)) {
                $_SESSION["errorMessage"]  = "Você não pode realizar o cadastro porque você não é um funcionário dessa Unidade de Saúde";
                require_once "app/pages/user/register_on_platform/index.php";
            } else {
                if ($password != $confirm_password) {
                    $_SESSION["errorMessage"] = "O campo SENHA está diferente do campo CONFIRMAR SENHA";
                    require_once "app/pages/user/register_on_platform/index.php";
                } else {
                    $result = UserService::save($cpf, $username, $password);

                    if ($result == null || !is_bool($result)) {
                        $_SESSION["errorMessage"] = $result;
                        require_once "app/pages/user/register_on_platform/index.php";
                    } else {
                        $_SESSION["successMessage"] = "O cadastro foi realizado com sucesso! Você já pode acessar a plataforma.";
                        require_once "app/pages/user/register_on_platform/index.php";
                    }
                }
            }
        } else {
            $_SESSION["errorMessage"] = "Você precisa preencher todos os campos parar cadastrar o usuário na plataforma!";
            require_once "app/pages/user/register_on_platform/index.php";
        }
    }

    public static function logout()
    {
        $_SESSION["loggedUser"] = null;

        header("Location: ./");
    }
}
