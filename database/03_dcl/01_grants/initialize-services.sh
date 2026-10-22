#!/bin/bash
# MySQL sources files from docker-entrypoint-initdb.d into its own shell.
# Do not change the entrypoint's shell options here (notably nounset).
if [[ "${BASH_SOURCE[0]}" == "$0" ]]; then set -e; fi
# Entrypoint MySQL: credentials originate in .env generated locally, never source data.
export MYSQL_PWD="${MYSQL_ROOT_PASSWORD:?Missing MYSQL_ROOT_PASSWORD}"
for service in gateway identity configuration records audit files calendar notifications treasury inventory chat; do
  variable="DB_PASSWORD_${service^^}"
  credential="${!variable:-}"
  [[ "$credential" =~ ^[a-f0-9]{64}$ ]] || { echo 'Invalid generated database credential' >&2; exit 1; }
  mysql --protocol=socket -uroot <<SQL
CREATE DATABASE IF NOT EXISTS srd_${service} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'srd_${service}'@'%' IDENTIFIED BY '${credential}';
GRANT ALL PRIVILEGES ON srd_${service}.* TO 'srd_${service}'@'%';
SQL
done
unset MYSQL_PWD
