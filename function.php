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

function adminAdministrator($session)
{
    if ($_SESSION['admin-login'] != true) {
        header("Location: login");
        exit();
    }
}

function adminOrganization($session)
{
    if ($_SESSION['organization-login'] != true) {
        header("Location: login");
        exit();
    }
}

function votersOrganization($session)
{
    if ($_SESSION['voters-login'] != true) {
        header("Location: ./");
        exit();
    }
}

function message_success($message)
{
    $_SESSION['message'] = '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="text-secondary">' . $message . '</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    return $_SESSION['message'];
}

function message_failed($message)
{
    $_SESSION['message'] = '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <span class="text-secondary">' . $message . '</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    return $_SESSION['message'];
}

function message_check()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function urlTrack()
{
    return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
    );
}