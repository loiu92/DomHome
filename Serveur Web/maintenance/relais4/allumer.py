#!/usr/bin/python



import cgitb

import cgi

import smbus

import time

import sys



# Remplacer 0 par 1 si nouveau Raspberry



cgitb.enable()







print "Content-type: text/html\n\n"

print """

<html><head><title>Hello World from DomHome\n</title></head><body>Allumer Relais 4 </body></html>

"""



bus = smbus.SMBus(1)

address = 0x12

bus.write_byte(address,int(4))



# Pause de 1 seconde pour laisser le temps au traitement de se faire



time.sleep(1)

reponse = bus.read_byte(address)



print "etat relais ="+str(reponse)


