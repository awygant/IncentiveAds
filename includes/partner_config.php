<?php


function overridePartnerDetails($partner_id){
    switch($partner_id){
        case "3":
            setCredentials("lexussc", "gq1FU2USgZf4rvpHhuKbIuO4QHjYCHk7");
            break;
        case "9":
            setCredentials("ltdn", "iq0FU0USQZf0svpRzuSpIuO4QHNYCHk9");
            break;
        case "17":
            setCredentials("Fashion", "FN2Fp0pS66SBZvbR7RBpIuf5iHtoot11");
            break;
        case "18":
            setCredentials("moniquelhuillierinc", "uq8Fg2gP4kkhZvbR5uFwIuf1iH9R3Srq");
            break;
    }
}

function setCredentials($username, $apikey){
    $_SESSION["partner_username"] = $username;
    $_SESSION["partner_apikey"] = $apikey;
}

?>