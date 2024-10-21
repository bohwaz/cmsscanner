<?php

class Drupal {

    /**
     * search for a drupal in that folder. 
     * if this class think that a drupal is here, returns the version number, normalized.
     */ 
    function search($root) {
        
        if (is_file($root."/index.php") && is_dir($root."/modules") && is_dir($root."/sites")) {
            // detect 3 different drupal version spans
            // 5/6/7:
            if (is_file($root."/modules/block/block.info")) {
                $f=fopen($root."/modules/block/block.info","rb");
                if (!$f) return false;
                while($s=fgets($f,1024)) {
                    if (preg_match('#version\s+=\s+[\'"](.*)[\'"]#',$s,$mat)) { 
                        fclose($f);
                        return $mat[1];
                    }
                }
                fclose($f);
            }
            // 8/9/10
            if (is_file($root."/composer.lock") && filesize($root."/composer.lock")<1048576) {
                $f=json_decode(file_get_contents($root."/composer.lock"),true);
                if (!$f) return false;
                foreach($f["packages"] as $one) {
                    if ($one["name"]=="drupal/core")
                        return $one["version"];
                }
            }
            // 4
            if (is_file($root."/CHANGELOG.txt")) {
                $f=fopen($root."/CHANGELOG.txt","rb");
                if (!$f) return false;
                $s=fgets($f,1024);
                if (preg_match('#^Drupal ([^,]+),#',$s,$mat)) {
                    return $mat[1];
                }
            }
            return false; // no case found :/ TODO: spit out a warning?
          } else {
              return false;
          }
          
      } // search 
      
} // class Drupal
