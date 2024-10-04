<?php

class Dolibarr {

    /**
     * search for a dokuwiki in that folder. 
     * if this class think that a dokuwiki is here, returns the version number, normalized.
     */ 
    function search($root) {

        if (is_file($root."/filefunc.inc.php") && is_dir($root."/install")) {
            $f=fopen($root."/filefunc.inc.php","rb");
            if (!$f) return false;
            $s=fgets($f,1024);
            fclose($f);
            if (preg_match('#define\([\'"]DOL_VERSION[\'"]\s*,\s*[\'"]([^\'"]+)[\'"]\);#',$s,$mat)) { 
                return $mat[1];
            }
            return false;
        } else {
            return false;
        }
          
    } // search 
      
} // class Dolibarr
