#!/usr/bin/env python3
import os
import sys
import http.cookies
import uuid
import shelve
from urllib.parse import parse_qs

cookie = http.cookies.SimpleCookie(os.environ.get("HTTP_COOKIE"))
session_id = cookie.get("SESSIONID")
if session_id is None:
    session_id = str(uuid.uuid4())
else:
    session_id = session_id.value

with shelve.open("/tmp/python_sessions") as db:
    session = db.get(session_id, {})

content_length = int(os.environ.get("CONTENT_LENGTH", 0))
post_data = sys.stdin.read(content_length)
form = parse_qs(post_data)
username = form.get("username", [None])[0]  
destroy = form.get("destroy", [""])[0]

cookie_out = http.cookies.SimpleCookie()
cookie_out["SESSIONID"] = session_id
cookie_out["SESSIONID"]["path"] = "/"

if destroy.lower() == "true":
    with shelve.open("/tmp/python_sessions") as db:
        if session_id in db:
            del db[session_id]
    session = {}
    cookie_out["SESSIONID"]["expires"] = "Thu, 01 Jan 1970 00:00:00 GMT"

else:
    if username is not None and username != "":
        session["username"] = username

    with shelve.open("/tmp/python_sessions") as db:
        db[session_id] = session

print("Content-Type: text/html")
print(cookie_out.output())
print()  

print("<html><head><title>Session Page 1</title></head><body>")
print("<h1>Python CGI Session Page 1</h1>")
print(f"<p>Username: {session.get('username', 'Not set')}</p>")
print('<a href="/py-state-demo.html">CGI-Form</a>')
print('<form method="POST">')
print('<input type="hidden" name="destroy" value="true">')
print('<input type="submit" value="Destroy Session">')
print('</form>')
print("</body></html>")
