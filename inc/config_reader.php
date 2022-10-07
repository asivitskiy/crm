<?  $config_array = mysql_query("SELECT * FROM `admix_config`");
    global $cfg;
        while ($config_data = mysql_fetch_array($config_array)) {
            $cfg[$config_data['parameter']] =  $config_data['value'];
        }
        $br = '%0A';

$mng_words_array['Ю'] = 'Юлия';
$mng_words_array['Н'] = 'Наталья';
$mng_words_array['А'] = 'Анна';
$mng_words_array['Е'] = 'Екатерина';
$mng_words_array['Марина'] = 'Марина';
$mng_words_array['П'] = 'Юрий';
$mng_words_array['Ч'] = 'Юлия Казакова';
$mng_words_array['Л'] = 'Елена';

$mng_phones_array['Ю'] = '79059452334';
$mng_phones_array['Н'] = '79831376945';
//$mng_phones_array['А'] = 'Анна';
//$mng_phones_array['Е'] = 'Екатерина';
$mng_phones_array['Марина'] = '79138957956';
$mng_phones_array['П'] = '79232489441';
$mng_phones_array['Ч'] = '79538730867';
$mng_phones_array['Л'] = '79833026301';
?>