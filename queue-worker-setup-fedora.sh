#!/bin/bash

if [ ! -f "./artisan" ]; then
    echo "Error: Run from Laravel project root"
    exit 1
fi

ARTISAN_PATH=$(readlink -f ./artisan)
PROJECT_DIR=$(basename $(pwd))
SAFE_PROJECT_NAME=$(echo "$PROJECT_DIR" | tr '[:upper:]' '[:lower:]' | sed 's/[^a-z0-9]/-/g')

if [ "$EUID" -ne 0 ]; then 
    echo "Run with sudo"
    exit 1
fi

# Fedora-specific package installation
dnf install -y supervisor
systemctl enable supervisord
systemctl start supervisord

# Configure supervisord
cat > /etc/supervisord.d/supervisord.conf << EOF
[supervisord]
logfile=/var/log/supervisor/supervisord.log
pidfile=/var/run/supervisord.pid
childlogdir=/var/log/supervisor
minfds=10000

[unix_http_server]
file=/var/run/supervisor.sock
chmod=0700

[rpcinterface:supervisor]
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface

[supervisorctl]
serverurl=unix:///var/run/supervisor.sock

[include]
files = /etc/supervisord.d/*.ini
EOF

# Create queue worker config
cat > "/etc/supervisord.d/laravel-queue-${SAFE_PROJECT_NAME}.ini" << EOF
[program:laravel-queue-${SAFE_PROJECT_NAME}]
process_name=%(program_name)s_%(process_num)02d
command=php ${ARTISAN_PATH} queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=nobody
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/supervisor/laravel-queue-${SAFE_PROJECT_NAME}.log
stopwaitsecs=3600
EOF

mkdir -p /var/log/supervisor
chown -R nobody:nobody /var/log/supervisor

supervisorctl reread
supervisorctl update
supervisorctl start "laravel-queue-${SAFE_PROJECT_NAME}:*"
supervisorctl status