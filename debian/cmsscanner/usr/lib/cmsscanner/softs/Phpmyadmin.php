<?php

class Phpmyadmin {

    /**
     * search for a phpmyadmin in that folder. 
     * if this class think that a phpmyadmin is here, returns the version number, normalized.
     */ 
      function search($root) {

          // <5
          if (is_file($root."/phpmyadmin.css.php") && is_file($root."/libraries/Config.class.php")) {
              //              :        $this->set('PMA_VERSION', '2.11.11');
              $f=fopen($root."/libraries/Config.class.php","rb");
              if (!$f) return false;
              while($s=fgets($f,1024)) {
                  if (preg_match('#\$this->set\([\'"]PMA_VERSION[\'"],\s*[\'"](.*)[\'"]\);#',$s,$mat)) { 
                      fclose($f);
                      return $mat[1];
                  }
              }
              fclose($f);
              return false;
          }
          if (is_dir($root."/libraries") && is_file($root."/package.json") && filesize($root."/package.json")<100000) {
                $f=json_decode(file_get_contents($root."/package.json"),true);
                if (!$f) return false;
                if ($f["name"]=="phpmyadmin")
                        return $f["version"];
          }
          return false;
          
      } // search 
      
} // class Phpmyadmin
