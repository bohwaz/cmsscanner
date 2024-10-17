# CMS Scanner

This is a small php program that scans a folder and its subfolders for any known PHP program.
It just echoes the software + version + path found.

(next, you can use the [cmschecker](https://octoforge.fr/octopuce/cmschecker) micro-service to check the checksums of files for the program.)

# Usage:

```
cmsscanner <root path>
```

This will scan <root path> (which must be a directory that the current Linux user can access).

the output is

```
software name <space> version <space> path where it has been found.
```

If a sub directory can't be opened or has been removed while scanning, the first word on the line will be "ERROR:"

# Known software:

The currently recognized software are in src/softs/ folder, and are the following :

Dokuwiki  Dolibarr  Drupal  Joomla  Nextcloud  Phpmyadmin  Prestashop  Roundcube  Spip  Wordpress

# Developpment:

If you want to add another free software (ideally we'd like to focus on PHP-based software, mostly used in shared hosting), feel free to send a pull-request.

Please note that the scanner will, by default, not cross filesystem boundaries. Typically, if your server has a NFS share mounted in a folder below the scanned <root path>, it will not be scanned inside the NFS.

The License for this software is GPL v3+. Please see debian/Copyright





