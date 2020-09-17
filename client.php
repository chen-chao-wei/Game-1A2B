<?php
//TCP/IP Connection;

header('content-type:text/html;charset=utf-8');
error_reporting(E_ALL);
set_time_limit(0);

$port = 8085;

$ip = "127.0.0.1";

$in = 'Hello!I am client'; //input, transfer msg to server side

$out = ''; //output, recive service msg

//socket_create
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

if ($socket < 0) {
    echo "---Failed: socket_create() failed! Reason: " . socket_strerror($socket) . "<br>";
}

//socket_connect
$result = socket_connect($socket, $ip, $port);

if ($result < 0) {
    echo "---Failed: socket_connect() failed! Reason: " . socket_strerror($result) . "<br>";
}

//socket_write
if (!socket_write($socket, $in, strlen($in))) {
    echo "---Failed: socket_write() failed! Reason: " . socket_strerror($socket) . "\n";
}

while ($out = socket_read($socket, 8192)) {

    echo "<h1>Recive Success! Get Msg:" . $out . "</h1>";

}

//Close
socket_close($socket);
