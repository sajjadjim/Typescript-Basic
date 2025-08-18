
#!/usr/bin/env bash
set -euo pipefail
echo "[*] Rotating squid logs safely..."
sudo squid -k rotate
echo "[✓] Rotation signal sent. Old logs will be suffixed with numbers."
