OpenFW
======

## About

Reasonably secure scripts to modify the firewall to allow access to a port from
the referring IP.

## How it works

The PHP script is installed in your webroot. When you visit it and enter the
correct password, it calls the `openfw.sh` shell script using sudo and the
remote IP you're visiting the PHP page from. The `openfw.sh` script adds the
IP to the firewall and schedules an automatic job to remove the IP after a
specified timeout.

The `openfw.sh` script is very strict about what it accepts as parameters. The
only options are to add or remove a valid IP address. It should therefor be
safe to give the webserver user (`www-data`) sudo access to run the script.

## Installation

For Debian / Ubuntu:

    # Install `at` utility
    sudo apt install at

    # Install sudoers permissions
    sudo cp etc.sudoers /etc/sudoers.d/openfw

    # Copy openfw shell script
    sudo cp openfw.sh /usr/local/sbin

    # Copy openfw.php to webroot
    sudo cp openfw.php /var/www/html/
    chown www-data:www-data /var/www/html/openfw.php

    # Edit the openfw.php script to change the password
    # Generate a new password:
    echo -n mysecretpassword | sha256sum
    sudo vi openfw.php
        $password = "94aefb8be78b2b7c344d11d1ba8a79ef087eceb19150881f69460b8772753263";

    # Edit openfw.sh to change the ports and timeout
    sudo vi /usr/local/sbin/openfw.sh
        PORTS="22"
        TIMEOUT="2"  # Minutes

## License

Released under the MIT license:

    Copyright 2017 Ferry Boender, released under the MIT license

    Permission is hereby granted, free of charge, to any person obtaining a
    copy of this software and associated documentation files (the "Software"),
    to deal in the Software without restriction, including without limitation
    the rights to use, copy, modify, merge, publish, distribute, sublicense,
    and/or sell copies of the Software, and to permit persons to whom the
    Software is furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
    THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
    FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
    DEALINGS IN THE SOFTWARE.

