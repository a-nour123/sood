<?php

$to = "mdhahir.c@ksu.edu.sa";
$subject = "test";
$message = "test";
$headers = "From: test@gmail.com\r\nn";
print_r(mail($to, $subject, $message, $headers));
