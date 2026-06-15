#!/bin/bash

REPO="https://raw.githubusercontent.com/navid/xboxdns/main"
LOCAL_VERSION="/etc/xboxdns/version"
REMOTE_VERSION=$(curl -s $REPO/version.json | grep version | cut -d '"' -f4)

if [ ! -f "$LOCAL_VERSION" ]; then
    echo "0" > $LOCAL_VERSION
fi

CURRENT_VERSION=$(cat $LOCAL_VERSION)

if [ "$REMOTE_VERSION" != "$CURRENT_VERSION" ]; then
    echo "Updating to version $REMOTE_VERSION"

    # Update SmartDNS config
    curl -s $REPO/smartdns.conf -o /etc/smartdns/smartdns.conf
    systemctl restart smartdns

    # Update panel files
    curl -s $REPO/panel/config.php -o /var/www/html/ip-panel/config.php
    curl -s $REPO/panel/login.php -o /var/www/html/ip-panel/login.php
    curl -s $REPO/panel/index.php -o /var/www/html/ip-panel/index.php
    curl -s $REPO/panel/change_pass.php -o /var/www/html/ip-panel/change_pass.php
    curl -s $REPO/panel/add_ip.php -o /var/www/html/ip-panel/add_ip.php
    curl -s $REPO/panel/delete_ip.php -o /var/www/html/ip-panel/delete_ip.php
    curl -s $REPO/panel/apply_rules.php -o /var/www/html/ip-panel/apply_rules.php
    curl -s $REPO/panel/expire.php -o /var/www/html/ip-panel/expire.php

    echo "$REMOTE_VERSION" > $LOCAL_VERSION
fi
