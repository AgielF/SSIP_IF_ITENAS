#!/bin/bash

GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${YELLOW}====================================================${NC}"
echo -e "${YELLOW}     SSIP LAB - SQL INJECTION AUTOMATION SCAN       ${NC}"
echo -e "${YELLOW}====================================================${NC}"

# 1. Nyalakan server testing
echo -e "\n${GREEN}[+] Menjalankan CI4 Server di mode TESTING (Port 8080)...${NC}"
php spark serve --env testing --port 8080 > server_log.txt 2>&1 &
SERVER_PID=$!
sleep 4

# 2. Ambil Cookie (Palsukan Login Admin)
echo -e "${GREEN}[+] Mengambil Cookie Session Admin...${NC}"
COOKIE_FILE="cookie_temp.txt"
curl -s -c $COOKIE_FILE -d "nomor=152022001&password=password123" -X POST http://localhost:8080/api/auth/login > /dev/null
COOKIE_STRING=$(cat $COOKIE_FILE | grep ci_session | awk '{print $6"="$7}')

echo -e "\n${GREEN}[+] Memulai Scanning Berdasarkan target_routes.txt...${NC}"
REPORT_FILE="sqli_report.txt"
echo "Laporan Uji Penetrasi SQLi - $(date)" > $REPORT_FILE
VULN_COUNT=0

# 3. Looping pembacaan file txt
while IFS= read -r line || [[ -n "$line" ]]; do
    if [[ $line == \#* ]] || [[ -z $line ]]; then continue; fi

    URL=$(echo "$line" | cut -d'|' -f1)
    POST_DATA=$(echo "$line" | cut -s -d'|' -f2)

    echo -e "Men-scan: ${YELLOW}$URL${NC}"
    CMD="sqlmap -u \"$URL\" --batch --level=1 --risk=1 --flush-session --cookie=\"$COOKIE_STRING\""
    
    if [[ -n "$POST_DATA" ]]; then
        CMD="$CMD --data=\"$POST_DATA\" --method=POST"
    fi

    RESULT=$(eval $CMD 2>&1)

    if echo "$RESULT" | grep -qE "do not appear to be injectable|all tested parameters do not appear to be injectable"; then
        echo -e "  -> ${GREEN}[AMAN] Tidak ada celah ditemukan.${NC}"
        echo "[AMAN] $URL" >> $REPORT_FILE
    else
        echo -e "  -> ${RED}[BAHAYA] Celah SQLi terdeteksi!${NC}"
        echo "[BAHAYA] $URL" >> $REPORT_FILE
        VULN_COUNT=$((VULN_COUNT + 1))
    fi
done < "target_routes.txt"

# 4. Bersihkan
kill $SERVER_PID
rm -f $COOKIE_FILE server_log.txt

echo -e "===================================================="
if [ $VULN_COUNT -eq 0 ]; then
    echo -e "${GREEN}✅ HASIL AKHIR: APLIKASI 100% AMAN!${NC}"
else
    echo -e "${RED}❌ HASIL AKHIR: Ditemukan $VULN_COUNT rute rentan!${NC}"
fi
echo -e "===================================================="