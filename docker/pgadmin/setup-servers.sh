#!/bin/sh
cat <<EOF > /pgadmin4/servers.json
{
  "Servers": {
    "1": {
      "Name": "${APP_NAME:-Laravel} Postgres",
      "Group": "Servers",
      "Host": "db_postgres",
      "Port": ${DB_PORT:-5432},
      "MaintenanceDB": "${DB_DATABASE}",
      "Username": "${DB_USERNAME}",
      "SSLMode": "prefer"
    }
  }
}
EOF

exec /entrypoint.sh "$@"