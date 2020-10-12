<?php

function hashSHA384(String $string)
{
    return hash("sha384", $string);
}

function encodeURL($url)
{
    return urlencode(base64_encode($url));
}

function decodeURL($url)
{
    return base64_decode(urldecode($url));
}

function adminSession($session)
{
    if ($_SESSION['admin-login'] != true) {
        header("Location: login");
        exit();
    }
}