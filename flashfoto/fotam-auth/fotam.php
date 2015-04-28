<?php
/**
 * Created by PhpStorm.
 * User: aaronm
 * Date: 6/19/14
 * Time: 5:47 PM
 */

class fotamUser {

    public $requestToken = null;
    public $accessToken = null;

    public $callbackUrl;
    public $requestTokenUrl;
    public $accessTokenUrl;
    public $loginUrl;
    public $infoUrl;

    public $name;
    public $username;
    public $fotamId;
    public $email;
    public $appType;
    public $userInfo;
    public $profilePic;
    public $facebookId;
    public $gender;
    public $firstName;

    public function initialize($request_token_url,$login_url,$access_token_url,$info_url,$callback_url){
        //echo 'Initialize Config:'.$request_token_url.'<br>'.$login_url.'<br>'.$access_token_url.'<br>'.$info_url.'<br>'.$callback_url;
        $this->requestTokenUrl = $request_token_url;
        $this->loginUrl = $login_url;
        $this->accessTokenUrl = $access_token_url;
        $this->infoUrl = $info_url;
        $this->callbackUrl = $callback_url;
    }

    public function getRequestToken(){
        return $this->requestToken;
    }

    public function createRequestToken(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->requestTokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        echo 'attempted curl call for request token....using this URL...'.$this->requestTokenUrl.' and got this result '.$result;
        curl_close($ch);
        $this->requestToken = str_replace('"', "", $result);
    }

    public function setLoginUrl(){
        $this->loginUrl = $this->loginUrl.'?request_token='.$this->requestToken.'&callback_url='.$this->callbackUrl;
    }

    public function createAccessToken(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->accessTokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        //echo 'accessToken request: '.$result;
        curl_close($ch);
        if(strrpos($result, 'Request token not valid')>0){
            throw new Exception('Request token not valid');
        } else {
            $this->accessToken = str_replace('"', "", $result);
            return true;
        }
    }

    public function retrieveUserInfo(){
        echo '</br>fetching user info using '.$this->accessToken.'</br>';
        $access_url = $GLOBALS['fotam_info_url'].'?access_token='.$this->accessToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $access_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $this->userInfo = json_decode($result, true);
        return $this->userInfo;
    }

    public function parseUserInfo(){
        //$additional_data = (array)json_decode($this->userInfo['User']['UserAccount'][0]['additional_info']);
        $additional_data = (array)$this->userInfo['User']['UserAccount'][0]['additional_info'];
        $this->fotamId = $this->userInfo['User']['User']['id'];
        $this->username = $this->userInfo['User']['User']['username'];
        $this->email = $this->userInfo['User']['User']['email'];
        $this->profilePic = "";
        $this->appType = $this->userInfo['User']['UserAccount'][0]['application_type'];
        echo '<hr>app type: '.$this->appType.'<hr>';
        switch($this->appType) {

            case 'Facebook':
                $this->email = isset($additional_data['email']) ? $additional_data['email'] : '';
                $this->username = isset($additional_data['username']) ? $additional_data['username'] : 'n/a';
                $this->name = isset($additional_data['name']) ? $additional_data['name'] : '';
                $this->profilePic = isset($additional_data['id']) ? 'http://graph.facebook.com/' . $additional_data['id'] . '/picture' : '';
                $this->facebookId = isset($additional_data['id']) ? $additional_data['id'] : '';
                $this->gender = isset($additional_data['gender']) ? $additional_data['gender'] : '';
                $this->firstName = isset($additional_data['first_name']) ? $additional_data['first_name'] : '';
                $this->lastName = isset($additional_data['last_name']) ? $additional_data['last_name'] : '';
                // collect other stuff here...
                break;

            case 'Twitter':
                $this->email = ''; //no email from twitter :(
                $this->username = isset($additional_data['screen_name']) ? $additional_data['screen_name'] : '';
                $this->name = isset($additional_data['name']) ? $additional_data['name'] : '';
                $this->profilePic = '';
                break;

            case 'Email':
                $this->email = isset($this->userInfo['User']['User']['email']) ? $this->userInfo['User']['User']['email'] : '';
                $this->username = '';
                $this->name = '';
                $this->profilePic = '';
                break;

            default:
                echo "app type not known! </br>";
                break;
        }
    }

    public function getUserInfo(){
        return print_r($this->userInfo);
    }

    public function getFotamId(){
        return $this->fotamId;
    }

    public function getProfilePic(){
        return $this->profilePic;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($n){
        $this->name = $n;
    }

    public function getUserName(){
        return $this->username;
    }

    public function setUserName($n){
        $this->username = $n;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($n){
        $this->email = $n;
    }

    public function getAppType(){
        return $this->appType;
    }

    public function setAppType($n){
        $this->appType = $n;
    }

    public function displaySummary(){
        echo'<div class = "row">
                     <div>FotamID: ' . $this->getFotamId() . '</div>
                     <div>Name: ' . $this->getName() . '</div>
                     <div>Username: ' . $this->getUserName() . '</div>
                     <div>eMail: ' . $this->getEmail() . '</div>
                     <div>Profile Pic: <img src="' . $this->getProfilePic() . '"/></div>
                     <div>Facebook ID:' . $this->facebookId . '</div>
                </div>';
    }

}
