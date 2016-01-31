<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 22/01/2016
 * Time: 21:29
 */

if (isset($argv[1])) {
    $servers = ["DNSTechpack", "SkyFactory", "Karma", "CrundeeCraft", "HermitcraftModsauce2"];
    if (!in_array($argv[1], $servers)) {
        $argument = "";
        foreach ($servers as $server) {
            if (strpos (strtolower($server), strtolower($argv[1])) !== FALSE){ $argument = $server; }
        }
        if (empty($argument)){ echo "Le serveur n'existe pas"; exit; }
//        else { echo $argument; }
    }else {
        $argument = $argv[1];
    }
    $url = "https://api.atlauncher.com/v1/pack/$argument";
    $case = "__LINK";
    $newUrl = getLink($url, $case);
    $secCase = "serverZipURL";
    $url = escapeshellarg(getLink(getLink($url, $case), $secCase));
    $file = explode("zip", $url);
    $file = explode("/", $file[0]);
    $oldFile = explode("?", $url);
    $oldFile = escapeshellarg(end($file)."zip?".$oldFile[1]);
    $file = escapeshellarg(end($file)."zip");
    shell_exec("wget -O $file " .  $url);

}else { echo "Veuillez entrer le nom du serveur voulu\n"; }
function getLink($url, $case){
    $file = file_get_contents($url);
    file_put_contents("serv.json",$file);
    $file = file("serv.json");
    foreach ($file as $line_num => $line) {
        if(strpos ($line, $case) !== FALSE) {
            $__LINK = explode("\"", $line);
            unlink("serv.json");
            return $__LINK[3];
        }
    }
}
