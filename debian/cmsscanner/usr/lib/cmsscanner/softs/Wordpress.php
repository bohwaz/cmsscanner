<?php

class Wordpress {

    /**
     * search for a wordpress in that folder. 
     * if this class think that a wordpress is here, returns the version number, normalized.
     */ 
      function search($root) {

          if (is_file($root."/wp-includes/version.php")) {
              $f=fopen($root."/wp-includes/version.php","rb");
              if (!$f) return false;
              $version=false; $local=false;
              while($s=fgets($f,1024)) {
                  if (preg_match('#\$wp_version\s+=\s+\'(.*)\';#',$s,$mat)) { 
                      $version=$mat[1];
                  }
                  if (preg_match('#\$wp_local_package\s+=\s\'(.*)\';#',$s,$mat)) {
                      $local=$mat[1];
                  }
              }
              fclose($f);
              if ($version && $local) return $version."-".$local; else return $version;
          } else {
              return false;
          }
          
      } // search 
      
} // class Wordpress
