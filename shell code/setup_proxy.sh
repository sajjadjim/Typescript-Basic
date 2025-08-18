
#!/usr/bin/env bash
set -euo pipefail

echo "[*] Updating package lists..."
sudo apt-get update -y

echo "[*] Installing Squid and utilities..."
sudo apt-get install -y squid apache2-utils

SQUID_CONF="/etc/squid/squid.conf"
PASSFILE="/etc/squid/passwd"
ALLOW="/etc/squid/allowlist.txt"
BLOCK="/etc/squid/blocklist.txt"

PROJECT_DIR="$(cd "$(dirname "$0")" && pwd)"
PROJECT_CONF="$PROJECT_DIR/proxy.conf"
PROJECT_ALLOW="$PROJECT_DIR/allowlist.txt"
PROJECT_BLOCK="$PROJECT_DIR/blocklist.txt"

if [ ! -f "$PROJECT_CONF" ]; then
  echo "[!] proxy.conf not found next to setup_proxy.sh"
  exit 1
fi

echo "[*] Backing up existing squid.conf (if any)..."
if [ -f "$SQUID_CONF" ]; then
  sudo cp -n "$SQUID_CONF" "${SQUID_CONF}.bak.$(date +%s)"
fi

# Determine if allowlist is empty to choose config logic
ALLOWLIST_HAS_CONTENT=false
if [ -s "$PROJECT_ALLOW" ]; then
  # ignore comments and blank lines
  if grep -vE '^(#|\s*$)' "$PROJECT_ALLOW" >/dev/null; then
    ALLOWLIST_HAS_CONTENT=true
  fi
fi

TMP_CONF="$(mktemp)"
if $ALLOWLIST_HAS_CONTENT; then
  echo "[*] Allowlist has domains — proxy will restrict access to those domains only (plus localhost)."
  sed 's|%ALLOWLIST_SWITCH%|http_access allow allowed_sites authenticated|g' "$PROJECT_CONF" > "$TMP_CONF"
else
  echo "[*] Allowlist is empty — proxy will allow all destinations for authenticated users (blocklist still enforced)."
  sed 's|%ALLOWLIST_SWITCH%|# (allowlist empty) skip allow-only rule|g' "$PROJECT_CONF" > "$TMP_CONF"
fi

echo "[*] Installing config to $SQUID_CONF"
sudo cp "$TMP_CONF" "$SQUID_CONF"
rm -f "$TMP_CONF"

echo "[*] Installing domain lists..."
sudo mkdir -p "$(dirname "$ALLOW")"
sudo mkdir -p "$(dirname "$BLOCK")"
sudo cp "$PROJECT_ALLOW" "$ALLOW"
sudo cp "$PROJECT_BLOCK" "$BLOCK"
sudo chown root:root "$ALLOW" "$BLOCK"
sudo chmod 644 "$ALLOW" "$BLOCK"

echo "[*] Creating auth file and first user..."
if [ ! -f "$PASSFILE" ]; then
  sudo touch "$PASSFILE"
  sudo chown proxy:proxy "$PASSFILE" || sudo chown proxy:proxy "$PASSFILE" 2>/dev/null || true
  sudo chmod 640 "$PASSFILE"
fi

read -rp "Enter proxy username to create (e.g., student): " USERNAME
if [ -z "${USERNAME:-}" ]; then
  USERNAME="student"
  echo "[*] Using default username: $USERNAME"
fi
sudo htpasswd -B -c "$PASSFILE" "$USERNAME"

echo "[*] Ensuring directories exist..."
sudo mkdir -p /var/spool/squid
sudo chown -R proxy:proxy /var/spool/squid

echo "[*] Enabling and restarting squid..."
sudo systemctl enable squid
sudo systemctl restart squid

echo "[*] Status:"
systemctl --no-pager --full status squid | sed -n '1,20p'

echo
echo "[✓] Done! Proxy is running on port 3128."
echo "    Test with:  curl --proxy http://$USERNAME:YOURPASS@localhost:3128 http://example.com -I"
echo "    Edit allow/block lists: sudo nano $ALLOW  and  sudo nano $BLOCK"
echo "    Logs: sudo tail -f /var/log/squid/access.log"
