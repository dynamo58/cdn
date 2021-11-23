<?php
header('Content-Type: text/html; charset=UTF-8');

function InsertMessage($nick, $mess) {
    return "INSERT INTO messages(nickname,message) VALUES ('$nick', '$mess')";
}


$nickname = $_GET['nickname'];
$message = $_GET['message'];

if (!(strlen($nickname) > 0 && strlen($nickname) < 32 && strlen($message) > 0 && strlen($message) < 1024)) {
  http_response_code(400);
  exit;
  return;
}

$dbfile = fgets(fopen(".env", "r"));
$server = fgets($dbfile);
$db = fgets($dbfile);
$username = fgets($dbfile);
$password = fgets($dbfile);

$conn = new mysqli($server, $username, $password, $db);

if ($conn->connect_error) {
  http_response_code(500);
  return;
};

if ($conn->query(InsertMessage($nickname, $message)) === TRUE) {
  http_response_code(200);
} else {
  http_response_code(500);
}

$conn->close();
exit;
?>