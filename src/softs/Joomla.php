<?php

class Joomla {

    /**
     * search for a joomla in that folder. 
     * if this class think that a joomla is here, returns the version number, normalized.
     */ 
      function search($root) {

          if (is_file($root."/includes/version.php")) {
              $v=$this->parseversion($root."/includes/version.php");
              if ($v) return $v;
          }
          if (is_file($root."/libraries/joomla/version.php")) {
              $v=$this->parseversion($root."/libraries/joomla/version.php");
              if ($v) return $v;
          }
          if (is_file($root."/libraries/cms/version/version.php")) {
              $v=$this->parseversion($root."/libraries/cms/version/version.php");
              if ($v) return $v;
          }

          if (is_file($root."/libraries/src/Version.php")) {
              $version=false; $minor=false; $patch=false;             
              $f=fopen($root."/libraries/src/Version.php","rb");
              if (!$f) return false;
              while($s=fgets($f,1024)) {
                  if (preg_match('#const\s+MAJOR_VERSION\s+=\s+([0-9]+);#',$s,$mat)) { 
                      $version=$mat[1];
                  }
                  if (preg_match('#const\s+MINOR_VERSION\s+=\s+([0-9]+);#',$s,$mat)) { 
                      $minor=$mat[1];
                  }
                  if (preg_match('#const\s+PATCH_VERSION\s+=\s+([0-9]+);#',$s,$mat)) { 
                      $patch=$mat[1];
                  }

              }
              fclose($f);
              if ($version && $minor && $patch) return $version.".".$minor.".".$patch;
          }

          return false;
          
      } // search 

    
    function parseversion($file) {
        $version=false; $patch=false;             
        $f=fopen($file,"rb");
        if (!$f) return false;
        while($s=fgets($f,1024)) {
            if (preg_match('#var\s+\$RELEASE\s+=\s+\'([^\']+)\';#',$s,$mat)) { 
                $version=$mat[1];
            }
            if (preg_match('#var\s+\$DEV_LEVEL\s+=\s+\'([^\']+)\';#',$s,$mat)) { 
                $patch=$mat[1];
            } 
        }
        fclose($f);
        if ($version && $patch) return $version.".".$patch;
        return false;
    }
    
} // class Joomla
