<?php
//session_start();
//if(empty($_SESSION['username'])){
//    print '{Error" : "Not Signed In"}';
//} else {
    $configFile = fopen("globalSettings.php", "w") or die("Unable to open file!");
    $header = "<?php\n";
    fwrite($configFile,$header);
    foreach($_POST as $key => $value) {
        $line = '$setting["' . $key . '"] = "' . $value . '";' . "\n";
        fwrite($configFile,$line);
    }
    fclose($configFile);
//}