<?php

class Nextcloud {

    /**
     * search for a nextcloud in that folder. 
     * if this class think that a nextcloud is here, returns the version number, normalized.
     */ 
    function search($root) {
        // skip update folder of nextcloud: they are enclosed in a data folder.
        if (strpos($root,"/updater-oc")!==false) return false;
        if (is_file($root."/remote.php") && is_dir($root."/ocs") && is_dir($root."/core") && is_file($root."/version.php")) {
            $f=fopen($root."/version.php","rb");
            if (!$f) return false;
            $vendor=""; $version="";
            while($s=fgets($f,1024)) {
                if (preg_match('#\$OC_VersionString\s+=\s+[\'"](.*)[\'"];#',$s,$mat)) { 
                    $version=$mat[1];
                }
                if (preg_match('#\$vendor\s+=\s+[\'"](.*)[\'"];#',$s,$mat)) { 
                    $vendor=$mat[1];
                }
            }
            fclose($f);
            if ($vendor && $version) {
                if ($vendor=="nextcloud")
                    return $version;
                else
                    return $vendor."-".$version;
            }
            return false;
        } else {
            return false;
        }
          
    } // search 
      
} // class Nextcloud
