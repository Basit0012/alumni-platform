#!/bin/bash

echo "👀 Watching for file changes in the Alumni Platform directory..."
echo "Press Ctrl+C to stop."

while true; do
    # Check if there are any uncommitted changes
    if [[ -n $(git status -s) ]]; then
        echo "⚡ Changes detected! Triggering auto-push..."
        bash ./push.sh
        echo "👀 Resuming watch..."
    fi
    # Wait for 10 seconds before checking again
    sleep 10
done
