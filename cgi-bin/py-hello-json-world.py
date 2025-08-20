#!/usr/bin/env python3

import os
import json
import datetime

print("Cache-Control: no-cache")
print("Content-type: application/json\n")

current_time = datetime.datetime.now().strftime("%a %b %d %H:%M:%S %Y")
ip_address = os.environ.get("REMOTE_ADDR", "Unknown")

message = {
    "title": "Hello, Python!",
    "heading": "Hello, Python!",
    "message": "This page was generated with the Python programming language",
    "time": current_time,
    "IP": ip_address
}

print(json.dumps(message))
