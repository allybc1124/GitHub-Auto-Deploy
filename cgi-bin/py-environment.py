#!/usr/bin/env python3

import os

# Set HTTP headers
print("Cache-Control: no-cache")
print("Content-type: text/html\n")

# Print the HTML header
print("""<!DOCTYPE html>
<html>
<head><title>Environment Variables</title></head>
<body>
<h1 align="center">Environment Variables</h1>
<hr>""")

# Loop through sorted environment variables and print each
for key in sorted(os.environ):
    value = os.environ[key]
    print(f"<b>{key}:</b> {value}<br />")

# Print the HTML footer
print("</body></html>")
