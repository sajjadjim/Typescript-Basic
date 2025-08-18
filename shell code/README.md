
# Ubuntu Proxy Server Project (Squid) — Shell-Based Setup

This project lets you **install, configure, and test a secure HTTP/HTTPS forward proxy** on Ubuntu (works great in VirtualBox). It uses **Squid** + **basic auth** + simple allow/deny lists — all automated with Bash scripts.

## What you get
- `setup_proxy.sh`: One-click installer & configurator
- `proxy.conf`: Opinionated Squid config with auth + ACLs
- `allowlist.txt` & `blocklist.txt`: Domain lists you can edit
- `add_user.sh`: Add proxy users (Basic auth)
- `add_block.sh`: Block a domain on-the-fly
- `test_proxy.sh`: Quick connectivity tests
- `show_logs.sh`: Tail and pretty-print access.log
- `rotate_logs.sh`: Safe log rotation
- `uninstall_proxy.sh`: Clean removal

## Quick Start (run as a user with sudo)
```bash
chmod +x setup_proxy.sh add_user.sh add_block.sh test_proxy.sh show_logs.sh rotate_logs.sh uninstall_proxy.sh
sudo ./setup_proxy.sh
# When prompted, enter a username and password for proxy auth
```

## Using the proxy
- Proxy runs on **port 3128** (default).
- Test with:
```bash
./test_proxy.sh
```
- Or manually:
```bash
curl --proxy http://USER:PASS@localhost:3128 http://example.com -I
curl --proxy http://USER:PASS@localhost:3128 https://ifconfig.me
```

## Edit lists
- Allow only certain domains: edit `/etc/squid/allowlist.txt`
- Block domains: edit `/etc/squid/blocklist.txt` or use `./add_block.sh example.com`

## Add users
```bash
sudo ./add_user.sh newstudent
# (you'll be prompted for a password)
```

## Logs
- Live view:
```bash
./show_logs.sh
```
- Rotate logs safely:
```bash
sudo ./rotate_logs.sh
```

## Remove
```bash
sudo ./uninstall_proxy.sh
```

## Notes
- This is a **forward proxy**, not a transparent proxy. Clients must be configured to use it.
- This configuration does **not perform SSL interception** (no SSL bump); HTTPS CONNECT is passed through after auth.
- Default policy: deny all, allow authenticated users; blocklist beats allowlist; allowlist (if non-empty) restricts traffic.
- Works on Ubuntu 20.04/22.04/24.04.
