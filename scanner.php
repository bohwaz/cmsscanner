<?php

// scan a root folder and all its subfolders for softwares.
// each known software has its own function that we launch to detect it.
// the function returns the detected version of the software.
// then we should check, using the software-checksum-service, that this software's version is unchanged.

if (!isset($argv[1])) {
   echo "Usage: scanner.php <root path>\n";
   exit();
}

$root=$argv[1];

if (!is_dir($root)) {
    echo "Fatal: $root is not a directory\n";
}

$t=stat($root);
$fs=$t["dev"]; // we don't cross filesystems.

$d=opendir(__DIR__."/softs");
if (!$d) die("Can't open softs/ folder !");
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
    $d=opendir($root);
    if (!$d) {
        echo "Can't open folder $root ...\n";
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

