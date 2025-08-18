
#!/usr/bin/env bash
set -euo pipefail
echo "Enter proxy credentials for testing:"
read -rp "Username: " U
read -rsp "Password: " P; echo
PROXY="http://${U}:${P}@localhost:3128"

echo "[*] Testing HTTP (example.com)..."
curl -sS -I --proxy "$PROXY" http://example.com | sed -n '1,10p'

echo
echo "[*] Testing HTTPS IP check (ifconfig.me)..."
curl -sS --proxy "$PROXY" https://ifconfig.me ; echo

echo
echo "[✓] Tests completed."
