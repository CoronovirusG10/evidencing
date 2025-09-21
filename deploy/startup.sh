#!/bin/bash
set -euo pipefail

cd /home/site/wwwroot
exec node .next/standalone/server.js
