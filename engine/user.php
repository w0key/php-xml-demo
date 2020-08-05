<?php
include_once ('functions.php');
ob_start();
session_start();

$xml_file = simplexml_load_file('files/users.xml');
$login = clear(@$_POST['login']);
$password = clear(@$_POST['password']);
$password2 = clear(@$_POST['password2']);
$email = clear(@$_POST['email']);
$name = clear(@$_POST['username']);

switch(@$_GET['m']) {
    default: break;
    case 'login':

        if(!$login || !$password) {
            echo json_encode([ 'status' => false, 'result' => 'Заполните необходимые данные!']);
        } else {
            if(checkAuth($login, $password)) {
                echo json_encode([ 'status' => true, 'name' => $_SESSION['name']]);
                $hash = md5(time().$login.$password);
                $_SESSION['login']	= $login;
                $_SESSION['hash']	= $hash;
            } else {
                echo json_encode([ 'status' => false, 'result' => 'Неверный логин или пароль!']);
            }
        }

        break;

    case 'reg':
        $xml = new DOMDocument("1.0", "UTF-8");
        $xml->load('files/users.xml');
        if(!$login || !$password || !$password2 || !$email || !$name) {
            echo json_encode([ 'status' => false, 'result' => 'Заполните необходимые данные!']);
        } else {
            if($password != $password2) {
                echo json_encode([ 'status' => false, 'result' => 'Неверный пароль подтверждения!']);
            } else {
                if(checkUsers($login, $email)) {
                    $usersTag = $xml->getElementsByTagName("root")->item(0);
                    $userTag = $xml->createElement("user");
                    $loginTag = $xml->createElement("login", $login);
                    $passwordTag = $xml->createElement("password", hashPassword($password));
                    $emailTag = $xml->createElement("email", $email);
                    $nameTag = $xml->createElement("name", $name);
                    $userTag->appendChild($loginTag);
                    $userTag->appendChild($passwordTag);
                    $userTag->appendChild($emailTag);
                    $userTag->appendChild($nameTag);
                    $usersTag->appendChild($userTag);
                    $xml->formatOutput = true;
                    $xml->save('files/users.xml');
                    echo json_encode([ 'status' => true]);
                } else {
                    echo json_encode([ 'status' => false, 'result' => 'Пользователь с таким логином или почтой уже зарегистрирован!']);
                }
            }
        }

        break;
}