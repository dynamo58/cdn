<?php
header('Content-Type: text/html; charset=UTF-8');

# SQL INSERT wrapper
function InsertMessage($nick, $mess) {
    return "INSERT INTO messages(nickname,message) VALUES ('$nick', '$mess')";
}


$nickname = $_GET['nickname'];
$message = $_GET['message'];

# check $nickname and $message lengths
if (!(strlen($nickname) > 0 && strlen($nickname) < 31 && strlen($message) > 0 && strlen($message) < 16383)) {
  http_response_code(400);
  return;
}

$dbfile = fgets(fopen(".env", "r"));
$server = fgets($dbfile);
$db = fgets($dbfile);
$username = fgets($dbfile);
$password = fgets($dbfile);

# connect to the DB
$conn = new mysqli($server, $username, $password, $db);
if ($conn->connect_error) {
  http_response_code(500);
  return;
};

# insert into the db
if ($conn->query(InsertMessage($nickname, $message)) === TRUE)
  http_response_code(200);
else
  http_response_code(500);

$conn->close();
exit;
?>