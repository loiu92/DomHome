// I2C RELAIS BETA
// by Loiu92 (Lucas Ruelle) <http://loiu92.com>
// Copyright -- Ne pas Redistribuer sans l'Accord de l'Auteur

// Ce programme a été crée par moi pour mon projet de Terminale STI2D SIN, appellé DomHome.
// Ce programme permet de définir l'Arduino en tant que "Slave" I2C du Raspberry PI,
// et de controler les sorties de l'Arduino qui sont reliés à une carte Relais.

// Quand l'Arduino reçoit 1, il allume la lampe 1 en laissant passer le courant dans le Relais 1.
// Quand l'Arduino reçoit 11, il éteint la lampe 1 en ne laissant pas passer le courant dans le Relais 1.
// Quand l'Arduino reçoit 2, il allume la lampe 2 en laissant passer le courant dans le Relais 2.
// Quand l'Arduino reçoit 22, il allume la lampe 2 en ne laissant pas passer le courant dans le Relais 2.
// Ainsi de suite...

#include <Wire.h>

#define SLAVE_ADDRESS 0x12
int dataReceived = 0;       // Set de la variable dataReceived à 0
int dataReponse=0;          // Set de la variable dataResponse à 0
int relais1 = 13;           // Set de la variable relais1 à 13
int relais2 = 12;           // Set de la variable relais2 à 7
int relais3 = 11;           // Set de la variable relais3 à 8



void setup() {
    Serial.begin(9600);
    Wire.begin(SLAVE_ADDRESS);
    Wire.onReceive(receiveData);
    Wire.onRequest(sendData);
    pinMode(relais1, OUTPUT);      // Initialise la variable relais1 comme pin digital et donc comme sortie.
    pinMode(relais2, OUTPUT);      // Initialise la variable relais2 comme pin digital et donc comme sortie.
    pinMode(relais3, OUTPUT);      // Initialise la variable relais3 comme pin digital et donc comme sortie.
    
}

void loop() {                      // Sous-Programme boucle
  delay(100);                      // de 100 ms
}

void receiveData(int byteCount){
    while(Wire.available()) {
        dataReceived = Wire.read();
        relais(dataReceived);
    }
}

void EditReponse(int addrRelai){
  if (addrRelai!=100){
   dataReponse=digitalRead(addrRelai);
  }
  else{
    dataReponse=EtatTot();
  }
}
void sendData(){
    int envoi = dataReponse;
    Wire.write(envoi);

}

int EtatTot(){
    return digitalRead(relais1)+digitalRead(relais2)*10+digitalRead(relais3)*100;
  
}

int Etat(int relai){
  int res=digitalRead(relai);
  if (res==1){
    return relai;
  }
  else{
    return relai*11;
  }
  
}

void relais(int commande){ 
  switch(commande){                 // Fonction Appellé Switch qui permet de créer des "conditions".
   case 1:                          // Cas 1 (Quand la variable commande est égale à 1)
     digitalWrite(relais1, HIGH);   // Ferme le relais 1 et allume la lampe 1
     EditReponse(relais1);
  break;                            // Arret du sous-programme
  case 11:                          // Cas 11 (Quand la variable commande est égale à 11)
     digitalWrite(relais1, LOW);    // Ferme le relais 1 et allume la lampe 1
     EditReponse(relais1);
  break;                            // Arret du sous-programme               
  case 2: 
     digitalWrite(relais2, HIGH);   // Ferme le relais 1 et allume la lampe 1
     EditReponse(relais2);
  break;
  case 22:
     digitalWrite(relais2, LOW);   // Ferme le relais 1 et allume la lampe 1
     EditReponse(relais2);
  break;
  case 3:
     digitalWrite(relais3, HIGH);   // Ferme le relais 1 et allume la lampe 1
      EditReponse(relais3);
  break;
  case 33:
     digitalWrite(relais3, LOW);   // Ferme le relais 1 et allume la lampe 1
     EditReponse(relais3);
  break;
  case 100:
    EditReponse(100);
  break;
  }
  
}
