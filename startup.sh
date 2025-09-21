#!/bin/bash
set -euo pipefail

cd /home/site/wwwroot/internet-banking
exec node .next/standalone/server.js
