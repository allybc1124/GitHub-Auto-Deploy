#!/usr/bin/env python3

import os
import sys
import urllib.parse

print("Cache-Control: no-cache")
print("Content-type: text/html\n")

print("""<!DOCTYPE html>
<html>
<head><title>POST Request Echo</title></head>
<body>
<h1 align="center">POST Request Echo</h1>
<hr>""")

# Read the POST data from stdin
content_length = int(os.environ.get('CONTENT_LENGTH', 0))
post_data = sys.stdin.read(content_length) if content_length > 0 else ""

# Parse the POST data (application/x-www-form-urlencoded)
params = urllib.parse.parse_qs(post_data)

print("<b>Message Body:</b><br />")
print("<ul>")

# Print out each key=value pair (showing first value if multiple)
for key, values in params.items():
    value = values[0] if values else ''
    print(f"<li>{key} = {value}</li>")

print("</ul>")
print("</body></html>")
