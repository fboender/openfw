OpenFW
======

About
-----

Reasonably secure scripts to modify the firewall to allow access to a port from
the referring IP.

Installation
------------

.   Add the contents of `etc.sudoers` to `/etc/sudoers`
.   Put `fw.php` somewhere on server
.   Change password ($code, SHA256) in `fw.php`
.   Copy `openfw.sh` to /usr/local/sbin/
.   Done
