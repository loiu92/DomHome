import smbus

import time

import sys

# Remplacer 0 par 1 si nouveau Raspberry

bus = smbus.SMBus(1)

address = 0x12



print "Envoi de la valeur "+sys.argv[1]

bus.write_byte(address,int(sys.argv[1]))



# Pause de 1 seconde pour laisser le temps au traitement de se faire

time.sleep(1)

reponse = bus.read_byte(address)

print "Etat de la lampe : ", reponse
