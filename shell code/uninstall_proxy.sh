
#!/usr/bin/env bash
set -euo pipefail

read -rp "This will remove Squid and configs. Continue? (yes/no): " ans
if [[ "$ans" != "yes" ]]; then
  echo "Aborted."
  exit 0
fi

echo "[*] Stopping squid..."
sudo systemctl stop squid || true

echo "[*] Removing packages..."
sudo apt-get remove -y --purge squid
sudo apt-get autoremove -y

echo "[*] Leaving logs in /var/log/squid and backups of squid.conf in place."
echo "[✓] Uninstall complete."
