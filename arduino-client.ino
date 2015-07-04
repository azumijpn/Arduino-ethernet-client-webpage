
#include <Ethernet.h>
#include <SPI.h>
#include <OneWire.h>
#include <DallasTemperature.h>
#include "DHT.h"

// Definition of ONE Wire
#define ONE_WIRE_BUS 2
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);

// Definition of DHT11
#define DHTPIN 3
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

byte mac[] = { 0x00, 0xAA, 0xBB, 0xCC, 0xDE, 0x02 }; // RESERVED MAC ADDRESS
EthernetClient client;

long previousMillis = 0;
long interval = 10000; // READING & sending INTERVAL

String data;
int t = 0;
int temp0, temp1, LastTemp0, LastTemp1 = 0;
int wrongTemp85 = 850;
int wrongTemp127 = -1270;

void setup() {
  Serial.begin(9600);
  Serial.println("Ethernet begin");
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
  }
  data = "";
  sensors.begin();
  dht.begin();

}

void loop() {
  if (millis() - previousMillis >= interval) { // READ ONLY ONCE PER INTERVAL
    previousMillis = millis();
    sensors.requestTemperatures();
    

    temp0 = sensors.getTempCByIndex(0) * 10;
    temp1 = sensors.getTempCByIndex(1) * 10;
    if (temp0 != wrongTemp127 || temp1 != wrongTemp127 || temp1 != wrongTemp85 || temp1 != wrongTemp85) { //checking for bad temperatures (errors)

      if (LastTemp0 != temp0 || LastTemp1 != temp1 )
      {
        LastTemp0 = temp0;
        LastTemp1 = temp1;
        int h = dht.readHumidity();

        data = "pwd=";
        data += "password"; //your password
        data += "&temp0=";
        data += temp0;
        data += "&temp1=";
        data += temp1;
        data += "&hum=";
        data += h;

        //Serial.println(data); //for debugging
        if (client.connect("www.your webserver ", 80)) {          // REPLACE WITH YOUR SERVER ADDRESS
          client.println("POST /link/to/your/add.php HTTP/1.1");  //where is php code saved
          client.println("Host:<your webserver>");                // SERVER ADDRESS HERE TOO
          client.println("Content-Type: application/x-www-form-urlencoded");
          client.print("Content-Length: ");
          client.println(data.length());
          client.println();
          client.print(data);
          Serial.println("-------------");
          Serial.println("Data sent: ");	Serial.println(data);
        } else {
          Serial.print("Not connected");
        }

        if (client.connected()) {
          Serial.println("Disconecting");
          client.stop();	// DISCONNECT FROM THE SERVER
        }

        Serial.println("-------------");
      } else {
        Serial.println("-------------");
        Serial.println("10s elapsed but no changes in temperatures");
      }
    } else {
      Serial.println("Error: -127 or 85");
    }
  }
}


