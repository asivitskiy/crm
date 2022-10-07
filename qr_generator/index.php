<?php    
/*
 * PHP QR Code encoder
 *
 * Exemplatory usage
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
    
    //echo "<h1>PHP QR Code</h1><hr/>";
    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'qr_store'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    

    $errorCorrectionLevel = 'L';

    $matrixPointSize = 4;


    
        //строка которая кодируется (в ней всё кроме суммы - постоянно)
        //$data = "https://sberbank.ru/qr/?uuid=2000044976&amount=5.00";
        $data = $_GET['string'];
        //echo $data;
    
        // user data
        $png_file_name = date("YmdHi").rand(10000,99999).'.png';
        $filename = $PNG_TEMP_DIR.$png_file_name;
        QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        echo $png_file_name;
?>   