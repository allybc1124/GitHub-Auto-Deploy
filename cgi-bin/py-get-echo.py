#!/usr/bin/env python3

import os
import urllib.parse

print("Cache-Control: no-cache")
print("Content-type: text/html\n")

print("""<!DOCTYPE html>
<html>
<head><title>GET Request Echo</title></head>
<body>
<h1 align="center">Get Request Echo</h1>
<hr>""")

query_string = os.environ.get("QUERY_STRING", "")

print(f"<b>Query String:</b> {query_string}<br />")

# Parse the query string into a dictionary
params = urllib.parse.parse_qs(query_string)

# Print each key=value pair, similar to Perl script
for key, values in params.items():
    # values is a list, print all values if multiple (like repeated params)
    for value in values:
        print(f"{key} = {value}<br/>")

print("</body></html>")
