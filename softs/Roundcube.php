<?php

class Roundcube {

    /**
     * search for a roundcube in that folder. 
     * if this class think that a roundcube is here, returns the version number, normalized.
     */ 
    function search($root) {

        if (is_dir($root."/vendor") && is_dir($root."/skins") && is_dir($root."/program") && is_file($root."/public_html/index.php")) {
            $f=fopen($root."/public_html/index.php","rb");
            if (!$f) return false;
            $line=0; $found=false;
            while(($s=fgets($f,1024)) && $line<10) {
                $line++;	   
                if (preg_match('#Roundcube Webmail IMAP Client#',$s)) {
                    $found=true;
                }
                if ($found && preg_match('#Version ([0-9\.]+)#',$s,$mat)) {
                    fclose($f);
                    return $mat[1];
                }
            }
            fclose($f);
            return false;
        } else {
            return false;
        }
          
    } // search 
      
} // class Roundcube
