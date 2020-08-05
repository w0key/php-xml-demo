<?php
function clear($data){
	$data = htmlspecialchars(trim($data));
	return $data;
}

function checkAuth($login, $password) {
	$xml = simplexml_load_file('files/users.xml');
    foreach($xml->user as $users) {
        $data = json_decode(json_encode($users), true);

        if($data['login'] == $login AND $data['password'] == hashPassword($password)){
            $_SESSION['name'] = $data['name'];
            return true;
        }
    }
    return false;
}

function checkUsers($login, $email) {
	$xml = simplexml_load_file('files/users.xml');
    foreach($xml->user as $users) {
        $data = json_decode(json_encode($users), true);

        if($data['login'] == $login || $data['email'] == $email){
            return false;
        }
    }
    return true;
}

function hashPassword($password) {
    return md5($password);
}