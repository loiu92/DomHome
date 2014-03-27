#!/usr/bin/env python

import smbus
import time
import sys
import cgi
import cgitb
import os

cgitb.enable()

form = cgi.FieldStorage()

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
            <li><a href=apropos.html>A Propos</a></li>
            <li><a href="http://getbootstrap.com/examples/theme/contact">Contact</a></li>
            <li class="dropdown">
              <a href="http://getbootstrap.com/examples/theme/" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="http://getbootstrap.com/examples/theme/">Action</a></li>
                <li><a href="http://getbootstrap.com/examples/theme/">Another action</a></li>
                <li><a href="http://getbootstrap.com/examples/theme/">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="http://getbootstrap.com/examples/theme/">Separated link</a></li>
                <li><a href="http://getbootstrap.com/examples/theme/">One more separated link</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="row">
          <div class="col-sm-4">
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
          <div class="col-sm-4">
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
          <div class="col-sm-4">
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
<button type="submit" name="relais" class="btn btn-sm btn-default" value="100">Etat Total</button>
      </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./templatebootstrap_files/jquery.min.js"></script>
    <script src="./templatebootstrap_files/bootstrap.min.js"></script>
    <script src="./templatebootstrap_files/docs.min.js"></script>


</body></html>

"""


bus = smbus.SMBus(1)
address = 0x12

if os.environ['REQUEST_METHOD'] == 'POST':
#	mon_fichier = open("fichier.txt", "w")
#        mon_fichier.write(str(form))
#        mon_fichier.close()

	bus.write_byte(address,int(form["relais"].value))
	print "<h1>Etat des Relais :</h1>"
	print "etat relais ="+str(bus.read_byte(address))

bus.write_byte(address, 100)
mon_fichier = open("etatrelais.txt", "w")
mon_fichier.write(str(bus.read_byte(address)))
mon_fichier.close()

mon_fichier = open("etatrelais.txt", "r")
etatrelais = mon_fichier.readlines()
print etatrelais

