#!/usr/bin/env python

import smbus
import time
import sys
import cgi

bus = smbus.SMBus(1)
address = 0x12

bus.write_byte(address,100)
print "<h1>Etat des Relais :</h1>"
print "etat relais ="+str(str(bus.read_byte(address)))
mon_fichier = open("etatrelais.txt", "w")
mon_fichier.write(str(bus.read_byte(address)))
mon_fichier.close()


