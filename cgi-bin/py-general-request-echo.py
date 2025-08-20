#!/usr/bin/env python3

import os
import sys

print("Cache-Control: no-cache")
print("Content-type: text/html\n")

print("""<!DOCTYPE html>
<html>
<head><title>General Request Echo</title></head>
<body>
<h1 align="center">General Request Echo</h1>
<hr>""")

server_protocol = os.environ.get("SERVER_PROTOCOL", "Unknown")
request_method = os.environ.get("REQUEST_METHOD", "Unknown")
query_string = os.environ.get("QUERY_STRING", "")

print(f"<p><b>HTTP Protocol:</b> {server_protocol}</p>")
print(f"<p><b>HTTP Method:</b> {request_method}</p>")
print(f"<p><b>Query String:</b> {query_string}</p>")

content_length = int(os.environ.get("CONTENT_LENGTH", 0))
form_data = sys.stdin.read(content_length) if content_length > 0 else ""

print(f"<p><b>Message Body:</b> {form_data}</p>")

print("</body></html>")
