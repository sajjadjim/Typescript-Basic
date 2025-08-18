
#!/usr/bin/env bash
set -euo pipefail
LOG="/var/log/squid/access.log"
if [ ! -f "$LOG" ]; then
  echo "[!] $LOG not found (is squid installed?)"
  exit 1
fi
echo "[*] Tailing access log (Ctrl+C to exit)..."
sudo tail -f "$LOG" | awk '{
  ts=$1" "$2; ip=$3; action=$4; code=$5; bytes=$6; method=$7; url=$8;
  printf("[%%s] IP=%%s ACTION=%%s CODE=%%s BYTES=%%s METHOD=%%s URL=%%s\n", ts, ip, action, code, bytes, method, url);
}'
