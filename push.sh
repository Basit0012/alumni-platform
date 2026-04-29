#!/bin/bash
MSG=${1:-"Auto update: $(date '+%Y-%m-%d %H:%M:%S')"}
git add .
git commit -m "$MSG"
git push origin main
echo "Pushed: $MSG"
