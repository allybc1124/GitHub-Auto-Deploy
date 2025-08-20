#!/usr/bin/env python3

import os
import datetime

print("Cache-Control: no-cache")
print("Content-type: text/html\n")

print("<html>")
print("<head>")
print("<title>Hello, Python!</title>")
print("</head>")
print("<body>")

print("<h1>Hello, Python!</h1>")
print("<p>This page was generated with the Python programming language</p>")

# Current date and time
now = datetime.datetime.now().strftime("%a %b %d %H:%M:%S %Y")
print(f"<p>Current Time: {now}</p>")

# IP Address (from environment variable)
ip_address = os.environ.get("REMOTE_ADDR", "Unknown")
print(f"<p>Your IP Address: {ip_address}</p>")

print("</body>")
print("</html>")
