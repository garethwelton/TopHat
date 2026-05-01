#!/usr/bin/env bash
# Sync standalone/index.html from plugin canonical source.
# The plugin's game.html is the source of truth for all game logic.
# Run this after editing game.html to keep the standalone copy in sync.
set -e
cp plugin/headsup-mob/assets/game.html standalone/index.html
echo "Synced plugin/headsup-mob/assets/game.html → standalone/index.html"
