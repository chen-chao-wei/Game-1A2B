<?php
header('content-type:text/html;charset=utf-8');
set_time_limit(0);

$ip = '127.0.0.1';

$port = 8085;

$recive_times = 0; //0 is no limited

//socket_create
if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
    echo "socket_create() Fails Reason is:" . socket_strerror($sock) . "\n";
}
//socket_bind
if (($ret = socket_bind($sock, $ip, $port)) < 0) {
    echo "socket_bind()  Fails Reason is:" . socket_strerror($ret) . "\n";
}
//socket_listen
if (($ret = socket_listen($sock, 4)) < 0) {
    echo "socket_listen()  Fails Reason is:" . socket_strerror($ret) . "\n";
}

//socket_accept
$count = 0;

do {
    if (($msgsock = socket_accept($sock)) < 0) {
        echo "socket_accept() failed: reason: " . socket_strerror($msgsock) . "\n";
        break;
    } else {
        //Transfer msg to client side
        $msg = "Hello! I am server side";
        // sleep(2);
        //socket_write
        socket_write($msgsock, $msg, strlen($msg));
        echo "Test Success\n";
        //socket_read
        $buf = socket_read($msgsock, 8192);
        $talkback = "Recive Message from client:$buf\n";
        echo $talkback;
        if (++$count >= $recive_times && $recive_times != 0) {
            break;
        }
        ;
    }
    //socket_close
    socket_close($msgsock);
} while (true);
socket_close($sock);

