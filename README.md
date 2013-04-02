OpenFW
======

About
-----

Reasonably secure scripts to modify the firewall to allow access to a port from
the referring IP.

Installation
------------

1.   Add the contents of `etc.sudoers` to `/etc/sudoers`
1.   Put `fw.php` somewhere on server
1.   Change password ($code, SHA256) in `fw.php`
1.   Copy `openfw.sh` to /usr/local/sbin/
1.   Done
