#!/usr/bin/php
<?php

// scan a root folder and all its subfolders for softwares.
// each known software has its own function that we launch to detect it.
// the function returns the detected version of the software.
// (then we could check, using the software-checksum-service, that this software version's files are unchanged.)

if (!isset($argv[1])) {
   echo "Usage: scanner.php <root path>\n";
   exit();
}

$root=realpath($argv[1]);

if (!$root || !is_dir($root)) {
    echo "FATAL: $root is not a directory or can't be opened\n";
}

$t=stat($root);
$fs=$t["dev"]; // we don't cross filesystems.

$d=@opendir(__DIR__."/softs");
if (!$d) die("FATAL: Can't open softs/ folder in the code.");
while (($c=readdir($d))!==false) {
    if (substr($c,-4)==".php") {
        require_once(__DIR__."/softs/".$c);
        $classname=substr($c,0,-4);
        $classes[strtolower($classname)]=new $classname();
    }
}
closedir($d);

scanner($root); 


function scanner($root,$level=0) {
    global $fs,$classes;
    foreach($classes as $class=>$object) {
        if ($version = $object->search($root)) {
            echo "$class $version $root\n";
        }
    }
    $d=@opendir($root);
    if (!$d) {
        echo "ERROR: Can't open folder $root (deleted or permission denied)\n";
        return;
    }
    $root=rtrim($root,"/");
    while (($c=readdir($d))!==false) {
        if ($c=="." || $c=="..") continue;
        if (is_link($root."/".$c)) continue; 	    
        if (is_dir($root."/".$c)) {
            $t=stat($root."/".$c);
            if ($t["dev"]!=$fs) continue; // we skip subfolders in OTHER filesystems (nfs, crossmounts ...)
            scanner($root."/".$c,$level+1); // recursive call.
        }
    }
    closedir($d);
}

