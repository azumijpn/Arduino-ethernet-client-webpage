This is my try to create webpage with actual informations from Arduino

there is Arduino uno with ethernet shield and  DS18B20 sensors + DHT11 as Humidity sensor.

Arduino sends POST to webpage (add.php) which check if password is correct. (I know that password in plain text is bad but its ok for me).

If it is correct sends data to MYSQL. 

In database we created table with 5 rows (ID, timeStamp,temperature0, temperature1, Humidity).


In index.php it shows data as text, also as google chart. At the bottom is table with all recorded data.
