#!/bin/sh
#
# Add a firewall rule for IP, destionation port 22 (SSH)
#
# Run as root. Sudo line:
# todsah ALL=(root) NOPASSWD: /usr/local/bin/openfw.sh
#

PORTS="22"
TIMEOUT="2"  # Minutes

usage() {
	if [ -n "$1" ]; then
		echo $1 >&2
	else
        echo "Add / remove firewall access for IP" >&2
	fi
	echo "Usage: $0 (add|remove) <IP>" >&2
	exit 1
}

get_ip() {
    IP=`echo $1 | grep "^\([0-9]\{1,3\}\.\)\{3\}[0-9]\{1,3\}$"`

    if [ -z "$IP" ]; then
        usage "Invalid IP address: $1"
    fi

    echo "$IP"
}

# Parse help arguments
if [ "$1" = "--help" -o "$1" = "-h" ]; then
	usage
elif [ $# -ne 2 ]; then
	usage "Not enough parameters"
fi

# Verify AT is installed
if [ \! -x "/usr/bin/at" ]; then
    echo "'at' command is not installed. Aborting"
    exit 2
fi

# Handle command argument
if [ "$1" = "add" ]; then
    # Adding IP to firewall for configured ports.
    IP=$(get_ip $2) || exit 1

    for PORT in $PORTS; do
        /sbin/iptables -A INPUT -p tcp --dport $PORT --source $IP -j ACCEPT
    done

    # Schedule AT job to remove the IPs after $TIMEOUT
    echo "sudo $0 remove $IP" | /usr/bin/at now +$TIMEOUT minutes
elif [ "$1" = "remove" ]; then
    # Remove IP to firewall for configured ports.
    IP=$(get_ip $2) || exit 1

    for PORT in $PORTS; do
        /sbin/iptables -D INPUT -p tcp --dport $PORT --source $IP -j ACCEPT
    done
else
	usage "Invalid command: $1"
fi
