#!/usr/bin/ python

import cgi
import cgitb
import smbus
import time
import sys

cgitb.enable()

bus = smbus.SMBus(1)

address = 0x12

rint "Content-type: text/html\n\n"
print """
<html><head><title>Hello World from DomHome<p></p></title></head><body>Allumer Relai$
"""

form=cgi.FieldStorage()

if "1" in form:
    bus.write_byte(address,int(1))
    time.sleep(1)
    reponse = bus.read_byte(address)
    print "etat relais ="+str(reponse)

elif "2" in form:
    bus.write_byte(address,int(2))
    time.sleep(1)
    reponse = bus.read_byte(address)
    print "etat relais ="+str(reponse)

elif "3" in form:
    bus.write_byte(address,int(3))
    time.sleep(1)
    reponse = bus.read_byte(address)
    print "etat relais ="+str(reponse)


