#!/bin/bash

# Stage all changes
git add .

# Generate timestamp for the commit message
TIMESTAMP=$(date +"%Y-%m-%d %H:%M:%S")

# Commit changes
git commit -m "Auto-commit: $TIMESTAMP"

# Push to the main branch
git push origin main

echo "✅ Successfully pushed to GitHub at $TIMESTAMP"
