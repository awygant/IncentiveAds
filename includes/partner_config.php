<?php

class PartnerConfig{



    public $db_host = "localhost";
    public $db_user = "incentive_dev";
    public $db_password = "flashf0t0";
    public $db_database = "incentive_ads";
    public $db_port = 3306;
    public $dev_mode = false;
    public $partner_data;

    // When the user chooses a partner, we'll load some useful info into these properties.
    public $chosen_partner;
    public $partner_name;
    public $banner_location;
    public $cta_text;
    public $campaign_id;
    public $api_base_url;
    public $partner_username;
    public $partner_apikey;



    function setDatabaseCreds($h, $u, $p, $db){

        if($h)
            $this->db_host = $h;
        if($u)
            $this->db_user = $u;
        if($p)
            $this->db_password = $p;
        if($db)
            $this->db_database = $db;

    }



    function useDefaultCreds(){

        $this->db_host = "localhost";
        $this->db_user = "incentive_dev";
        $this->db_password = "flashf0t0";
        $this->db_database = "incentive_ads";

    }



    function enterDevMode(){

        $this->dev_mode = true;

    }



    /* Makes a database call, narrowing down to either a single partner or to dev partners.
     * Defaults to select all production partners.
     * Returns the data and stores it in $this->partner_data.
     */
    public function get_partner_info(){

        $query = "SELECT * FROM partner_config";
        if(strlen($this->chosen_partner) > 0)
            $query .= " WHERE partner_id = " . $this->chosen_partner;
        else if($this->dev_mode){
            $query .= " WHERE api_base_url like '%dev%'";
        }
        else{
            $query .= " WHERE api_base_url like '%www%'";
        }

        $mysqli = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_database, $this->db_port);
        $result = $mysqli->query($query);
        $partner_display_info = [];

        if($result->num_rows > 0)
        {
            while($partner_row = $result->fetch_array())
            {
                $partner_display_info[] = $partner_row;
            }
        }
        else{
            $partner_display_info[] = "Partner not found.";
        }

        $mysqli->close();
        $this->partner_data = $partner_display_info;
        return $partner_display_info;

    }



    function print_partner_array(){

        $partner_display_data = $this->get_partner_info();
        echo '<pre>' . json_encode($partner_display_data, JSON_PRETTY_PRINT) . '</pre>';

    }



    function print_partner_blocks(){

        foreach($this->partner_data as $partner){

            $partner_name = $partner["partner_name"];
            $partner_banner_location = $partner["banner_location"];
            $partner_cta_text = $partner["cta_text"];
            $partner_id = $partner["partner_id"];

            echo "<a href = 'upload.php?p=" . $partner_id . "'>";
            echo "<div class = 'col-xs-12 col-sm-6 partnerBlock'>";
            echo "<h3>" . $partner_name . "</h3>";
            echo "<p>" . $partner_cta_text . "</p>";
            echo "<div class = 'partnerBlockImage'><img src = '" . $partner_banner_location . "'/></div>";
            echo "</div>";
            echo "</a>";

        }

    }



    function choose($id){

        $this->chosen_partner = $id;
        $this->partner_data = $this->get_partner_info();
        $this->partner_name = $this->partner_data[0]["partner_name"];
        $this->banner_location = $this->partner_data[0]["banner_location"];
        $this->cta_text = $this->partner_data[0]["cta_text"];
        $this->campaign_id = $this->partner_data[0]["campaign_id"];
        $this->api_base_url = $this->partner_data[0]["api_base_url"];
        $this->partner_username = $this->partner_data[0]["partner_username"];
        $this->partner_apikey = $this->partner_data[0]["partner_apikey"];


    }



    // Prints banner data from the first array element
    function print_banner(){

        echo "<div class = \"banner\"><img src = '" . $this->banner_location . "' alt = '" . $this->cta_text . "'/></div>";

    }



}




?>