<?php

class Paheko {
    function search($root) {
        if (is_file($root . '/VERSION')
            && is_dir($root . '/include/lib/Paheko')) {
            $version = @file_get_contents($root . '/VERSION');
            return $version ?: false;
        }
    }
}
