<?php
/**
 * Created by PhpStorm.
 * User: aaronm
 * Date: 6/20/14
 * Time: 11:01 AM
 */

session_start();


require('../config.php');
require('fotam.php');
echo 'Config:'.$GLOBALS['fotam_request_token_url'].'<br>'.$GLOBALS['fotam_login_url'].'<br>'.$GLOBALS['fotam_access_token_url'].'<br>'.$GLOBALS['fotam_info_url'].'<br>'.$GLOBALS['auth_callback_url'];


function setAccess($a){
    $_SESSION['access_token'] = $a;
    unset($_SESSION['request_token']);
    //var_dump($_SESSION);
}

function setRequest($r){
    $_SESSION['request_token'] = $r;
    //var_dump($_SESSION);
}

function setSession($fotam){
    $_SESSION['access_token'] = $fotam->accessToken;
    $_SESSION['profile_pic_link'] = $fotam->profilePic;
    $_SESSION['email'] = $fotam->email;
    $_SESSION['username'] = $fotam->username;
    $_SESSION['userId'] = $fotam->fotamId;
    $_SESSION['facebookId'] = $fotam->facebookId;
    $_SESSION['userInfo'] = $fotam->userInfo;
    $_SESSION['gender'] = $fotam->gender;
    $_SESSION['firstName'] = $fotam->firstName;
    $_SESSION['lastName'] = $fotam->lastName;
    $_SESSION['full_name'] = $fotam->firstName . " " . $fotam->lastName;
    $_SESSION['role'] = 'user';
    if(in_array($_SESSION['userId'],$GLOBALS['admins'])){
        $_SESSION['role'] = 'admin';
    }
}

//global $fotam;
$fotam = new fotamUser();
$fotam->initialize($GLOBALS['fotam_request_token_url'],$GLOBALS['fotam_login_url'],$GLOBALS['fotam_access_token_url'],$GLOBALS['fotam_info_url'],$GLOBALS['auth_callback_url']);

if(isset($_GET['request_token'])){
    // continue login process
    $fotam->requestToken = $_GET['request_token'];
    echo 'Using request token: '.$fotam->requestToken.'</br>';
    setRequest($fotam->requestToken);
    echo '...fetching access token url:'.$fotam->accessTokenUrl.'</br>';
    $u = $fotam->accessTokenUrl.'?request_token='.$fotam->requestToken;
    $fotam->accessTokenUrl = $u;
    echo '</br>appended the request token param: <a href = "'.$fotam->accessTokenUrl.'">'.$fotam->accessTokenUrl.'</a></br>';

    try {
        if($fotam->createAccessToken()){
            //echo 'Created access token: '.$fotam->accessToken.'</br>';
            setAccess($fotam->accessToken);
            $fotam->retrieveUserInfo();
            //echo '<hr>user_info: '.var_dump($fotam->userInfo).'<hr>';
            $fotam->parseUserInfo();
            //echo 'Fotam object results:<hr>';
            //$fotam->displaySummary();
            setSession($fotam);
            //var_dump($_SESSION);
            //echo '<hr><a href="index.php">index.php</a>';
            $url = 'index.php';
            header("Location: ". $server_name . $url);
        }
    } catch (Exception $e) {
        echo 'error: '.$e;
        header("Location: " . $auth_callback_url);
    }


} else { //startup the login process
    //echo '<br>Using request token URL: '.$fotam->requestTokenUrl.'</br>';

    $fotam->createRequestToken();
    //echo 'Received a request token and stored it: '.$fotam->requestToken.'</br>';

    $fotam->callbackUrl = $GLOBALS['auth_callback_url'].'?request_token='.$fotam->requestToken;
    //echo 'Updated the callback with this: '.$fotam->callbackUrl.'</br>';

    $fotam->setLoginUrl();
    //echo 'Login Url: <a href="'.$fotam->loginUrl.'">'.$fotam->loginUrl.'</a></br>';
    header('location:'.$fotam->loginUrl);
}
