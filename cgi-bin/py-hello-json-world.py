#!/usr/bin/env python3

import os
import json
import datetime

# Set HTTP headers
print("Cache-Control: no-cache")
print("Content-type: application/json\n")

# Get current time and client IP
current_time = datetime.datetime.now().strftime("%a %b %d %H:%M:%S %Y")
ip_address = os.environ.get("REMOTE_ADDR", "Unknown")

# Create response dictionary
message = {
    "title": "Hello, Python!",
    "heading": "Hello, Python!",
    "message": "This page was generated with the Python programming language",
    "time": current_time,
    "IP": ip_address
}

# Output JSON
print(json.dumps(message))
