/*******
 * AUTHOR : SHEHAN SOORIYAARACHCHI
 * in this version the last order ID is saved in the flash memory and the coordinates will be sent only when there's a new order
 * */

// Libraries
#define led 4
#define EEPROM_SIZE 1
#include <WiFi.h>
#include <Arduino_JSON.h>
#include <EEPROM.h>
//program variables
int max_ = 0;
int x;
int y;
int LastID;
int readID;
JSONVar myObject;

String readingID;
// SSID
const char* ssid = "Dialog 4G 851";
const char* password = "DA4b7EDF";
String line;
// Host
const char* host = "storemate.systems";

void connect(){
   delay(2);


  // Use WiFiClient class to create TCP connections
  WiFiClient client;
  const int httpPort = 80;
  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }
  // We now create a URI for the request
  String url = "/read_last.php";  //"/dweet/for/my-thing-name?value=test";
  // Send request
  /*Serial.print("Requesting URL: ");
  Serial.println(url);*/

  client.print(String("GET ") + url + " HTTP/1.1\r\n" + "Host: " + host + "\r\n" + "Connection: close\r\n\r\n");
  unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 500000) {
      Serial.println(">>> Client Timeout !");
      client.stop();
      return;
    }
  }
  // Read all the lines from the answer
  while (client.available()) {
    line = client.readStringUntil('/r');
  }
   myObject = JSON.parse(line);
  /*Serial.print("LastID is:");
Serial.println(myObject["LastID"]);*/
  readingID = JSON.stringify(myObject["LastID"]);
  readID = readingID.toInt();
}

void setup() {
  pinMode(led, OUTPUT);
  // Serial
  Serial.begin(115200);
  EEPROM.begin(EEPROM_SIZE);
  LastID = EEPROM.read(0);

  // We start by connecting to a WiFi network
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}
void loop() {

  connect();
  if (LastID != readID) {
    Serial.println("yaayyy new order!");
    LastID = readID;
    EEPROM.write(0, LastID);
    EEPROM.commit();
    Serial.println("State saved in flash memory");
    Serial.println("Coordinates are ");
    for (int i = 0; i < 100; i++) {
       x = myObject["units"][i][0];
       y = myObject["units"][i][1];
      if (x == 0 || y == 0) {
        Serial.println("end of the array********");
        break;
      }
      Serial.print("x=");
      Serial.println(x);
      Serial.print("y=");
      Serial.println(y);
    }

  } else {
  }
  
}
