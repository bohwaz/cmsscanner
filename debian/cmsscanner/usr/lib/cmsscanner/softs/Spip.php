<?php

class Spip {

    /**
     * search for a spip in that folder. 
     * if this class think that a spip is here, returns the version number, normalized.
     */ 
      function search($root) {

          if (is_file($root."/ecrire/inc_version.php")) {
              $f=fopen($root."/ecrire/inc_version.php","rb");
              if (!$f) return false;
              while($s=fgets($f,1024)) {
                  if (preg_match('#\$spip_version_branche\s+=\s+[\'"](.*)[\'"];#',$s,$mat)) { 
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
      
} // class Spip
