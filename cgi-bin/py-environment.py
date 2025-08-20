#!/usr/bin/env python3

import os

print("Cache-Control: no-cache")
print("Content-type: text/html\n")

print("""<!DOCTYPE html>
<html>
<head><title>Environment Variables</title></head>
<body>
<h1 align="center">Environment Variables</h1>
<hr>""")

for key in sorted(os.environ):
    value = os.environ[key]
    print(f"<b>{key}:</b> {value}<br />")

print("</body></html>")
