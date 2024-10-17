<?php

class Prestashop {

    /**
     * search for a prestashop in that folder. 
     * if this class think that a prestashop is here, returns the version number, normalized.
     */ 
    function search($root) {

        if (is_dir($root."/modules") && is_dir($root."/override") && is_dir($root."/pdf")) {
            // >=8
            if (is_file($root."/app/metadata.json") && filesize($root."/app/metadata.json")<1048576) {
                $f=json_decode(file_get_contents($root."/app/metadata.json"),true);
                if (isset($f["version"]))
                    return $f["version"];
            }
            // <8
            if (is_file($root."/app/AppKernel.php")) {
                $f=fopen($root."/app/AppKernel.php","rb");
                if (!$f) return false;
                while($s=fgets($f,1024)) {
                    if (preg_match('#const VERSION\s*=\s*[\'"](.*)[\'"];#',$s,$mat)) { 
                        fclose($f);
                        return $mat[1];
                    }
                }
                fclose($f);
            }
            // VERY old ~1.6.1.9
            if (is_file($root."/install/install_version.php")) {
                $f=fopen($root."/install/install_version.php","rb");
                if (!$f) return false;
                while($s=fgets($f,1024)) {
                    if (preg_match('#define\(\'_PS_INSTALL_VERSION_\',\s*[\'"](.*)[\'"]\);#',$s,$mat)) { 
                        fclose($f);
                        return $mat[1];
                    }
                }
                fclose($f);                
            }

        }
        return false;
    } // search 
      
} // class Prestashop
