
#!/usr/bin/env bash
set -euo pipefail

PASSFILE="/etc/squid/passwd"
if [ ! -f "$PASSFILE" ]; then
  echo "[!] Password file $PASSFILE not found. Run setup_proxy.sh first."
  exit 1
fi

if [ $# -lt 1 ]; then
  echo "Usage: sudo ./add_user.sh <username>"
  exit 1
fi

USERNAME="$1"
sudo htpasswd -B "$PASSFILE" "$USERNAME"
echo "[✓] User '$USERNAME' added/updated."
sudo systemctl reload squid
