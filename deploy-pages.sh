#!/usr/bin/env bash
#
# Deploy website publik XPloreJogja ke GitHub Pages (branch gh-pages).
#
# Alur: input/edit data lewat admin lokal -> jalankan script ini.
#   1. Build ulang HTML statis dari database lokal (php artisan site:build)
#   2. Push hasilnya ke branch gh-pages
#   3. GitHub Pages otomatis update -> https://heyimrenalt.github.io/xplorejogja-web/
#
# Branch `main` (source code Laravel/admin) TIDAK disentuh script ini.
#
# Pakai: ./deploy-pages.sh
#
set -e

REPO_URL="https://github.com/heyimrenalt/xplorejogja-web.git"
LIVE_URL="https://heyimrenalt.github.io/xplorejogja-web/"
GIT_NAME="heyimrenalt"
GIT_EMAIL="rikiar04@gmail.com"

cd "$(dirname "$0")"

echo "==> 1/3 Build static site dari database lokal..."
php artisan site:build

echo "==> 2/3 Menyiapkan branch gh-pages..."
TMP="$(mktemp -d)"
trap 'rm -rf "$TMP"' EXIT
cp -a dist/. "$TMP/"
cd "$TMP"
touch .nojekyll
git init -q
git checkout -q -b gh-pages
git add -A
git -c user.name="$GIT_NAME" -c user.email="$GIT_EMAIL" \
    commit -q -m "Deploy static site $(date '+%Y-%m-%d %H:%M')"
git remote add origin "$REPO_URL"

echo "==> 3/3 Push ke GitHub (force)..."
git push -f origin gh-pages

echo ""
echo "Selesai. Website update dalam ~1-2 menit:"
echo "   $LIVE_URL"
