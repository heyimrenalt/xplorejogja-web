#!/usr/bin/env bash
# =============================================================================
# UAT Tabel 4.9 — API /api/search Endpoint Test Script
# XploreJogja.com | Laravel Backend
#
# Usage:
#   chmod +x test_api.sh
#   ./test_api.sh [BASE_URL]
#
# Default BASE_URL: http://127.0.0.1:8000
# =============================================================================

BASE_URL="${1:-http://127.0.0.1:8000}"
ENDPOINT="${BASE_URL}/api/search"

# ANSI color codes
GREEN="\033[0;32m"
RED="\033[0;31m"
YELLOW="\033[1;33m"
CYAN="\033[0;36m"
BOLD="\033[1m"
RESET="\033[0m"

PASS=0
FAIL=0

# -----------------------------------------------------------------------------
# Helper functions
# -----------------------------------------------------------------------------

print_header() {
    echo ""
    echo -e "${CYAN}${BOLD}=================================================================${RESET}"
    echo -e "${CYAN}${BOLD}  UAT Tabel 4.9 — /api/search Endpoint Tests${RESET}"
    echo -e "${CYAN}${BOLD}  Target: ${ENDPOINT}${RESET}"
    echo -e "${CYAN}${BOLD}=================================================================${RESET}"
    echo ""
}

run_test() {
    local TEST_NUM="$1"
    local DESCRIPTION="$2"
    local URL="$3"
    local EXPECTED_HTTP="$4"
    local CHECK_TYPE="$5"   # "contains", "not_contains", "equals", "is_array", "is_empty_array"
    local CHECK_VALUE="$6"

    echo -e "${BOLD}--- Skenario ${TEST_NUM}: ${DESCRIPTION} ---${RESET}"
    echo -e "    URL: ${URL}"
    echo -e "    Expected HTTP: ${EXPECTED_HTTP}"

    # Execute curl request
    HTTP_RESPONSE=$(curl -s -o /tmp/uat_body.txt -w "%{http_code}" \
        -H "Accept: application/json" \
        -H "X-Requested-With: XMLHttpRequest" \
        --max-time 10 \
        "${URL}" 2>/dev/null)

    CURL_EXIT=$?
    BODY=$(cat /tmp/uat_body.txt 2>/dev/null)

    # Check curl connectivity
    if [ $CURL_EXIT -ne 0 ]; then
        echo -e "    ${RED}[ERROR] Could not connect to ${BASE_URL} (curl exit: ${CURL_EXIT})${RESET}"
        echo -e "           Make sure the Laravel server is running: php artisan serve"
        echo ""
        FAIL=$((FAIL + 1))
        return
    fi

    # HTTP status check
    HTTP_PASS=false
    if [ "$HTTP_RESPONSE" = "$EXPECTED_HTTP" ]; then
        HTTP_PASS=true
    fi

    # Content check
    CONTENT_PASS=false
    case "$CHECK_TYPE" in
        "contains")
            if echo "$BODY" | grep -qF "$CHECK_VALUE"; then
                CONTENT_PASS=true
            fi
            ;;
        "not_contains")
            if ! echo "$BODY" | grep -qF "$CHECK_VALUE"; then
                CONTENT_PASS=true
            fi
            ;;
        "equals")
            if [ "$BODY" = "$CHECK_VALUE" ]; then
                CONTENT_PASS=true
            fi
            ;;
        "is_array")
            # JSON array starts with [
            if echo "$BODY" | grep -qE '^\s*\['; then
                CONTENT_PASS=true
            fi
            ;;
        "is_empty_array")
            # Body is exactly [] or [ ]
            TRIMMED=$(echo "$BODY" | tr -d ' \n\r\t')
            if [ "$TRIMMED" = "[]" ]; then
                CONTENT_PASS=true
            fi
            ;;
        "is_not_empty_array")
            # JSON array with at least one element
            if echo "$BODY" | grep -qE '^\s*\[\s*\{'; then
                CONTENT_PASS=true
            fi
            ;;
        "no_500")
            if [ "$HTTP_RESPONSE" != "500" ]; then
                CONTENT_PASS=true
            fi
            ;;
    esac

    # Overall result
    if $HTTP_PASS && $CONTENT_PASS; then
        echo -e "    ${GREEN}[PASS]${RESET} HTTP ${HTTP_RESPONSE} | Content check: OK"
        echo -e "    Expected: ${CHECK_TYPE} ${CHECK_VALUE:+(\"${CHECK_VALUE}\")}"
        echo -e "    Actual body: $(echo "$BODY" | tr -d '\n' | cut -c1-120)"
        PASS=$((PASS + 1))
    else
        echo -e "    ${RED}[FAIL]${RESET}"
        if ! $HTTP_PASS; then
            echo -e "    ${RED}HTTP mismatch: expected ${EXPECTED_HTTP}, got ${HTTP_RESPONSE}${RESET}"
        fi
        if ! $CONTENT_PASS; then
            echo -e "    ${RED}Content check failed: expected ${CHECK_TYPE} ${CHECK_VALUE:+(\"${CHECK_VALUE}\")}${RESET}"
        fi
        echo -e "    Actual body: $(echo "$BODY" | tr -d '\n' | cut -c1-200)"
        FAIL=$((FAIL + 1))
    fi
    echo ""
}

# -----------------------------------------------------------------------------
# Main test sequence
# -----------------------------------------------------------------------------

print_header

echo -e "${YELLOW}NOTE: This script tests the live API. Ensure:${RESET}"
echo -e "${YELLOW}  1. Laravel server is running: php artisan serve${RESET}"
echo -e "${YELLOW}  2. The database has at least one wisata with nama_wisata containing 'Pantai'${RESET}"
echo -e "${YELLOW}  3. APP_ENV is NOT set to 'testing' (use your dev .env)${RESET}"
echo ""

# -----------------------------------------------------------------------------
# UAT Tabel 4.9 - Skenario 1
# Search dengan keyword yang cocok → HTTP 200, JSON array valid
# -----------------------------------------------------------------------------
run_test \
    "1" \
    "Search keyword cocok dengan destinasi yang ada" \
    "${ENDPOINT}?q=Pantai" \
    "200" \
    "is_not_empty_array" \
    ""

# -----------------------------------------------------------------------------
# UAT Tabel 4.9 - Skenario 2
# Search dengan keyword yang tidak cocok → HTTP 200, empty array []
# -----------------------------------------------------------------------------
run_test \
    "2" \
    "Search keyword tidak cocok dengan destinasi apapun" \
    "${ENDPOINT}?q=xyzabcnotexistingkeyword999" \
    "200" \
    "is_empty_array" \
    ""

# -----------------------------------------------------------------------------
# UAT Tabel 4.9 - Skenario 3
# Search dengan query kosong → HTTP 200, JSON valid, tidak 500
# Controller returns [] for keyword < 2 chars
# -----------------------------------------------------------------------------
run_test \
    "3" \
    "Search dengan query string kosong (q=)" \
    "${ENDPOINT}?q=" \
    "200" \
    "is_empty_array" \
    ""

# Also test with single char (still < 2 chars threshold)
run_test \
    "3b" \
    "Search dengan query satu karakter (q=P)" \
    "${ENDPOINT}?q=P" \
    "200" \
    "is_empty_array" \
    ""

# Also test with no q parameter at all
run_test \
    "3c" \
    "Search tanpa parameter q sama sekali" \
    "${ENDPOINT}" \
    "200" \
    "is_empty_array" \
    ""

# -----------------------------------------------------------------------------
# UAT Tabel 4.9 - Skenario 4
# Struktur JSON response konsisten (ada field: nama, slug, kategori, parent_id, gambar)
# -----------------------------------------------------------------------------
echo -e "${BOLD}--- Skenario 4: Struktur JSON response AJAX konsisten ---${RESET}"
echo -e "    URL: ${ENDPOINT}?q=Pantai"
BODY4=$(curl -s \
    -H "Accept: application/json" \
    -H "X-Requested-With: XMLHttpRequest" \
    --max-time 10 \
    "${ENDPOINT}?q=Pantai" 2>/dev/null)

HTTP4=$(curl -s -o /dev/null -w "%{http_code}" \
    -H "Accept: application/json" \
    --max-time 10 \
    "${ENDPOINT}?q=Pantai" 2>/dev/null)

echo -e "    Actual body: $(echo "$BODY4" | tr -d '\n' | cut -c1-300)"

FIELDS_OK=true
for FIELD in '"nama"' '"slug"' '"kategori"' '"parent_id"' '"gambar"'; do
    if ! echo "$BODY4" | grep -qF "$FIELD"; then
        FIELDS_OK=false
        echo -e "    ${RED}Missing field: ${FIELD}${RESET}"
    fi
done

if [ "$HTTP4" = "200" ] && $FIELDS_OK; then
    echo -e "    ${GREEN}[PASS]${RESET} HTTP 200 | All expected JSON fields present: nama, slug, kategori, parent_id, gambar"
    PASS=$((PASS + 1))
else
    echo -e "    ${RED}[FAIL]${RESET} HTTP ${HTTP4} | Some fields missing or request failed"
    FAIL=$((FAIL + 1))
fi
echo ""

# -----------------------------------------------------------------------------
# UAT Tabel 4.9 - Skenario 5
# SQL Injection → tidak ada data leak, tidak 500, response aman
# Payload: ' OR 1=1 --
# -----------------------------------------------------------------------------
SQL_INJECT_ENCODED=$(python3 -c "import urllib.parse; print(urllib.parse.quote(\"' OR 1=1 --\"))" 2>/dev/null \
    || printf "%%27%%20OR%%201%%3D1%%20--")

run_test \
    "5" \
    "SQL Injection attempt: ' OR 1=1 -- (tidak bocorkan data, tidak 500)" \
    "${ENDPOINT}?q=${SQL_INJECT_ENCODED}" \
    "200" \
    "is_empty_array" \
    ""

# -----------------------------------------------------------------------------
# UAT Tabel 4.9 - Skenario 6
# XSS attempt → response aman, tidak ada tag <script> yang tidak di-escape
# Payload: <script>alert(1)</script>
# -----------------------------------------------------------------------------
XSS_ENCODED=$(python3 -c "import urllib.parse; print(urllib.parse.quote('<script>alert(1)</script>'))" 2>/dev/null \
    || printf "%%3Cscript%%3Ealert%%281%%29%%3C%%2Fscript%%3E")

echo -e "${BOLD}--- Skenario 6: XSS payload dalam query → response tidak mengeksekusi script ---${RESET}"
echo -e "    URL: ${ENDPOINT}?q=${XSS_ENCODED}"

BODY6=$(curl -s \
    -H "Accept: application/json" \
    -H "X-Requested-With: XMLHttpRequest" \
    --max-time 10 \
    "${ENDPOINT}?q=${XSS_ENCODED}" 2>/dev/null)

HTTP6=$(curl -s -o /dev/null -w "%{http_code}" \
    -H "Accept: application/json" \
    --max-time 10 \
    "${ENDPOINT}?q=${XSS_ENCODED}" 2>/dev/null)

echo -e "    Actual body: $(echo "$BODY6" | tr -d '\n' | cut -c1-200)"

# JSON response is inherently safe — check no raw unescaped <script> tag appears
XSS_SAFE=true
if echo "$BODY6" | grep -qF '<script>alert(1)</script>'; then
    XSS_SAFE=false
fi

if [ "$HTTP6" = "200" ] && $XSS_SAFE; then
    echo -e "    ${GREEN}[PASS]${RESET} HTTP 200 | No unescaped <script> tag in response (JSON context is safe)"
    PASS=$((PASS + 1))
else
    echo -e "    ${RED}[FAIL]${RESET} HTTP ${HTTP6} | XSS payload found unescaped in response body"
    FAIL=$((FAIL + 1))
fi
echo ""

# -----------------------------------------------------------------------------
# Summary
# -----------------------------------------------------------------------------
TOTAL=$((PASS + FAIL))
echo -e "${CYAN}${BOLD}=================================================================${RESET}"
echo -e "${CYAN}${BOLD}  TEST SUMMARY${RESET}"
echo -e "${CYAN}${BOLD}=================================================================${RESET}"
echo -e "  Total  : ${TOTAL}"
echo -e "  ${GREEN}Passed : ${PASS}${RESET}"
echo -e "  ${RED}Failed : ${FAIL}${RESET}"
echo ""

if [ $FAIL -eq 0 ]; then
    echo -e "${GREEN}${BOLD}  SEMUA TEST LULUS! API /api/search berfungsi dengan benar.${RESET}"
else
    echo -e "${RED}${BOLD}  ADA ${FAIL} TEST GAGAL. Periksa error di atas.${RESET}"
fi

echo -e "${CYAN}${BOLD}=================================================================${RESET}"
echo ""

# Exit with failure code if any test failed
[ $FAIL -eq 0 ]
