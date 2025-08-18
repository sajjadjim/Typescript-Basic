
#!/usr/bin/env bash
set -euo pipefail

BLOCK="/etc/squid/blocklist.txt"

if [ $# -lt 1 ]; then
  echo "Usage: sudo ./add_block.sh <domain>"
  exit 1
fi

DOMAIN="$1"
if ! grep -qi "^${DOMAIN}$" "$BLOCK" 2>/dev/null; then
  echo "$DOMAIN" | sudo tee -a "$BLOCK" >/dev/null
  echo "[✓] Added $DOMAIN to blocklist."
else
  echo "[*] $DOMAIN already present."
fi

sudo systemctl reload squid
