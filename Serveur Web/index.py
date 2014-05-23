#!/usr/bin/env python

import smbus
import time
import sys
import cgi
import cgitb
import os

cgitb.enable()
bus = smbus.SMBus(1) #remplacer le 1 par 0 si vieux raspberry pi
address = 0x12 #adresse i2c
form = cgi.FieldStorage()
bus.write_byte(address, 100)
print "Content-type: text/html\n\n"


print """
<html lang="fr"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Site Web de Domhome">
    <meta name="author" content="Loiu92">
    <link rel="shortcut icon" href="http://getbootstrap.com/assets/ico/favicon.ico">

    <title>Theme Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href=files/bootstrap.min.css rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href=files/bootstrap-theme.min.css rel="stylesheet">
    <link href=files/table.css rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href=files/theme.css rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style type="text/css"></style><style id="holderjs-style" type="text/css"></style></head>

  <body role="document" style="">

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.py">DomHome</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href=index.py>Accueil</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="row">
          <div class="col-sm-3">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Relais 1</h3>
              </div>
              <div class="panel-body">
		<form action=index.py method="POST">
                <button type="submit" name="relais" class="btn btn-sm btn-success" value="1">Allumer</button>
                <button type="submit" name="relais" class="btn btn-sm btn-danger" value="11">Eteindre</button>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Relais 2</h3>
              </div>
              <div class="panel-body">
                <button type="submit" name="relais" class="btn btn-sm btn-success" value="2">Allumer</button>
                <button type="submit" name="relais" class="btn btn-sm btn-danger" value="22">Eteindre</button>
              </div>
            </div>
          </div>
	<div class="col-sm-3">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Relais 3</h3>
              </div>
              <div class="panel-body">
                <button type="submit" name="relais" class="btn btn-sm btn-success" value="3">Allumer</button>
                <button type="submit" name="relais" class="btn btn-sm btn-danger" value="33">Eteindre</button>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Relais 4</h3>
              </div>
              <div class="panel-body">
                <button type="submit" name="relais" class="btn btn-sm btn-success" value="4">Allumer</button>
                <button type="submit" name="relais" class="btn btn-sm btn-danger" value="44">Eteindre</button>
              </div>
            </div>
          </div>
<button type="submit" name="relais" class="btn btn-sm btn-default" value="100">Etat Total</button>
      </div>
    </div>
"""
if os.environ['REQUEST_METHOD'] == 'POST':
        bus.write_byte(address,int(form["relais"].value))

bus.write_byte(address, 100)
mon_fichier = open("etatrelais.txt", "w")
mon_fichier.write(str(bus.read_byte(address)))
mon_fichier.close()
mon_fichier = open("etatrelais.txt","r")
etatrelais = str(mon_fichier.readlines())

if len(etatrelais)!=8:
	etatrelais=etatrelais[:2] + '0' + etatrelais[2:]
if len(etatrelais)!=8:
	etatrelais=etatrelais[:2] + '0' + etatrelais[2:]
	
mon_fichier.close()
print """
<table class="CSSTableGenerator" > 
  <tr> 
 <td> Relais 1 </td> 
 <td> Relais 2 </td> 
 <td> Relais 3 </td> 
  </tr> 
  <tr> 
 <td>
"""

print etatrelais[4]
print """
 </td> 
 <td>
"""
print etatrelais[3]
print """
  </td> 
 <td>
"""
print etatrelais[2]  
print """
</td> 
</tr> 
</table> 



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./templatebootstrap_files/jquery.min.js"></script>
    <script src="./templatebootstrap_files/bootstrap.min.js"></script>
    <script src="./templatebootstrap_files/docs.min.js"></script>


</body></html>

"""
