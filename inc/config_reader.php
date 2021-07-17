<?
    $config_array = mysql_query("SELECT * FROM `admix_config`");
    global $cfg;
        while ($config_data = mysql_fetch_array($config_array)) {
            $cfg[$config_data['parameter']] =  $config_data['value'];
            echo '1';
        }
   
            ?>