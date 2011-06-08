#!/bin/sh

#
# Add a firewall rule for IP, destionation port 22 (SSH)
#
# Run as root. Sudo line:
# todsah ALL=(root) NOPASSWD: /usr/local/sbin/openfw.sh
#

usage() {
	if [ -n "$1" ]; then
		echo >&2
		echo $1 >&2
		echo >&2
	fi
	echo "Add a rule to the firewall allowing access to SSH (port 22) from IP" >&2
	echo "Usage: $0 <IP>" >&2
	exit 1
}

IP=`echo $1 | grep "^\([0-9]\{1,3\}\.\)\{3\}[0-9]\{1,3\}"`

if [ "$1" = "--help" -o "$1" = "-h" ]; then
	usage
elif [ $# -ne 1 ]; then
	usage "Not enough parameters"
fi
if [ -z "$IP" ]; then
	usage "Invalid IP address: $1"
fi

iptables -A INPUT -p tcp --dport 22 --source $IP -j ACCEPT

echo "iptables -D INPUT -p tcp --dport 22 --source $IP -j ACCEPT" | at now + 1 hour 
