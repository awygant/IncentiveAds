<?php
/**
 * Created by PhpStorm.
 * User: aaronm
 * Date: 8/13/14
 * Time: 7:27 PM
 */

class fotamAds {
    public $gender;
    public $partnerId;
    public $api_base_url;
    public $dbSettings; //array of settings from config
    public $mysqli;
    public $targetedScenes; //subset of available scenes filter by gender (for now)
    public $scenes; //scene data output of scene layers and mount data
    public $payload; //json encoded scene data output with mount data

    public function initialize($dbSettings, $api_base_url){
        $this->api_base_url = $api_base_url;
        $this->dbSettings['db_host'] = $dbSettings['db_host'];
        $this->dbSettings['db_user'] = $dbSettings['db_user'];
        $this->dbSettings['db_password'] = $dbSettings['db_password'];
        $this->dbSettings['db_database'] = $dbSettings['db_database'];
        $this->dbSettings['db_port'] = $dbSettings['db_port'];
        $this->mysqli = new mysqli($this->dbSettings['db_host'], $this->dbSettings['db_user'], $this->dbSettings['db_password'], $this->dbSettings['db_database'], $this->dbSettings['db_port']);
        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error . "</br>";
        }
    }

    public function sceneSelection($partnerId,$gender){
        if(isset($partnerId)&&isset($gender)&&isset($this->mysqli)){
            $this->gender = $gender;
            $this->$partnerId = $partnerId;
            if(isset($this->dbSettings)){
                //echo 'trying to connect to db';
                if ($this->mysqli->connect_errno) {
                    echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error . "</br>";
                } else {
                    $this->scenes = array();
                    $this->targetedScenes = array();
                    $sql_scene = 'select id from scenes where enabled = 1 and partner_id = ' . $partnerId . ' order by id desc';
                    $result = $this->mysqli->query($sql_scene);
                    if($result->num_rows > 0){
                        while($item = $result->fetch_array())
                        {
                            $sceneId = $item['id'];
                            array_push($this->scenes, $sceneId);
                            //echo '<hr>'.$sceneId. ' was found... checking compatibility...<br>';
                            $sql_targets = 'select * from advertisements where scene_id = ' . $sceneId . ' and (gender = "both" or gender = "'.$gender.'")';
                            //echo 'trying '.$sql_targets.'<br>';
                            if($targets = $this->mysqli->query($sql_targets)){
                                //echo 'targets:<br>';
                                //var_dump($targets);
                                if($targets->num_rows > 0){
                                    while($item = $targets->fetch_array())
                                    {
                                        array_push($this->targetedScenes, $item);
                                        //echo 'adding a new targeted item, <br>'.var_dump($item);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function sceneData(){
        /* Requires that sceneSelection has been run already
         * Example output:
         * [ [ [ "null", "http:\/\/dev.flashfotoapi.com\/api\/get\/22813?version=Layer1" ], [ null ] ], [ [ "http:\/\/dev.flashfotoapi.com\/api\/get\/22811?version=Layer1", "null", "http:\/\/dev.flashfotoapi.com\/api\/get\/22811?version=Layer2" ], [ { "Face": [ { "x": 295, "y": 130, "width": 55, "height": 55, "angle": 0 } ] }, null ] ], [ [ "http:\/\/dev.flashfotoapi.com\/api\/get\/22808?version=Layer1", "null", "http:\/\/dev.flashfotoapi.com\/api\/get\/22808?version=Layer2" ], [ { "Face": [ { "x": 36, "y": 118, "width": 50, "height": 50, "angle": 0 } ] }, null ] ] ]
         */

        if(isset($this->targetedScenes)&&isset($this->mysqli)){
            $this->scenes = array();
            foreach($this->targetedScenes as $scene){
                $sceneId = $scene['scene_id'];
                $title = $scene['title'];
                $body = $scene['body'];
                $url = $scene['url'];
                $headFound = false;
                $ffid = array();
                $layers = array();
                $mount = array();
                $sql_scene = 'select flashfoto_image_id from scenes where id = ' . $sceneId;
                $sql_layers ='SELECT scene_layers.flashfoto_image_version, scene_layers.mount_data FROM scene_layers LEFT JOIN scenes ON scene_layers.scene_id = scenes.id WHERE scenes.id = ' . $sceneId . ' order by scene_layers.order ASC';

                $result = $this->mysqli->query($sql_scene);
                if($result->num_rows > 0){
                    while($item = $result->fetch_array())
                    {
                        $ffid[] = $item;
                    }
                }

                $result = $this->mysqli->query($sql_layers);
                if($result->num_rows > 0){
                    while($item = $result->fetch_array())
                    {
                        //$layers[] = $item;
                        //array_push($layers, $item);
                        if($item['mount_data']==null){
                            array_push($layers,'null');
                            $headFound = true;
                        }
                        $thisFfid = $ffid[0]['flashfoto_image_id'];
                        $url = $this->api_base_url.'get/'.$thisFfid.'?version='.$item['flashfoto_image_version'];
                        array_push($layers,$url);
                        array_push($mount,json_decode($item['mount_data']));
                    }
                    if(!$headFound){
                        array_push($layers, 'null');
                    }

                    //check for calibration opportunity
                    //$calibrateLayer = $this->calibrate($layers[0]);

                    $temp = array();
                    $meta = array(
                        "title" => $title,
                        "body" => $body,
                        "url" => $url
                    );
                    array_push($temp, $layers);
                    array_push($temp, $mount);
                    array_push($temp, $meta);
                    //array_push($temp, $calibrateLayer);
                    array_push($this->scenes, $temp);

                    /* structure of scenes:
                     * two arrays: 1) scene layers, 2) mount data
                     */
                    unset($layers);
                    unset($mount);
                    unset($meta);
                    unset($temp);
                }
            }
            if(isset($this->scenes)){
                $this->payload = json_encode($this->scenes, JSON_PRETTY_PRINT);
                //echo $this->payload;
                //var_dump($payload);
                //return $payload;
            }
        }
    }

    public function encodeScenes(){
        if(isset($this->scenes)){
            $payload = json_encode($this->scenes);
            //var_dump($payload);
            //echo $payload;
            $this->targetedScenes = $payload;
        }
    }


    public function decodeScenes(){
        unset($this->sceneIds);
        $sceneData = $this->scenes;
        $sceneData = json_decode($sceneData, true);
        foreach($sceneData as $data){
            $this->targetedScenes[] = $data['scene_id'];
        }
    }

    public function createAd($ads_api_url, $campaign_id, $image, $user_id, $application_type, $title, $body_text, $url, $gender){
        //Example URL to generate
        //http://logina.fotam.com/api/ads/add?campaign_id=6020916282398&image=http://onzra.com/img/slideshow/splash2.jpg&user_id=123456&application_type=Facebook&title=OnzraSplash&body_text=OnzraSplashBodyText&url=http://onzra.com&filter[genders][]=m&filter[geo_locations][countries][]=US&filter[geo_locations][countries][]=GB
        $result = "CREATING AD: ";
        if (isset($ads_api_url)&&isset($campaign_id)&&isset($image)&&isset($user_id)&&isset($application_type)&&isset($title)&&isset($body_text)&&isset($url)&&isset($gender)){
            $campaign_id = '?campaign_id='.$campaign_id;
            $image = '&image='.$image;
            $user_id = '&user_id='.$user_id;
            $application_type = '&application_type='.$application_type;
            $title = '&title='.urlencode($title);
            $body_text = '&body_text='.urlencode($body_text);
            $url = '&url='.$url;
            $filter = '&filter[genders][]='; //no filter
            if($gender == 'both'){
                // do nothing
            } elseif($gender=='male') {
                $filter = '&filter[genders][]=1';
            } elseif($gender=='female'){
                $filter = '&filter[genders][]=2';
            }
            // TODO: hard-code the country filter to the US for now, but this should come from admin db
            $filter .= '&filter[geo_locations][countries][]=US';

            $curl_url = $ads_api_url.$campaign_id.$image.$user_id.$application_type.$title.$body_text.$url.$filter;
            //echo '<a href="'.$curl_url.'">'.$curl_url.'</a>';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $curl_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            //$result .= json_decode($result, true);
            $result .= $curl_url;
            // echo $result; //TODO: error handle to log file instead of echo
        }
        return $result;
    }

    public function cleanup(){
        $this->mysqli->close();
    }

    public function displayTargetedScenes(){
        var_dump($this->targetedScenes);
    }

    public function calibrate($layer){
        preg_match_all('/\d+/',$layer,$ffid);
        if(isset($ffid[0][0])){
            $url = $this->api_base_url.'get/'.$ffid[0][0].'?version=skinMask';
            //echo '<br>checking for a skinMask on ffid '.$url;
            //try to get the skinMask, if file not found or 404 then skip calibration steps
            if(file_exists($url)){
                //echo '<br>got a skinMask!';
                return $url;
            }
        }
    }
}






