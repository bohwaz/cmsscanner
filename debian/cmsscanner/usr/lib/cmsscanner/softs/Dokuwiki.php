<?php

class Dokuwiki {

    /**
     * search for a dokuwiki in that folder. 
     * if this class think that a dokuwiki is here, returns the version number, normalized.
     */ 
    function search($root) {

        if (is_file($root."/VERSION") && is_dir($root."/inc") && is_file($root."/doku.php")) {
            $f=fopen($root."/VERSION","rb");
            if (!$f) return false;
            $s=fgets($f,1024);
            fclose($f);
            if (preg_match('#^([0-9-]{4}-[0-9a-z-]+) #',$s,$mat)) { 
                return $mat[1];
            }
            return false;
        } else {
            return false;
        }
          
    } // search 
      
} // class Dokuwiki
