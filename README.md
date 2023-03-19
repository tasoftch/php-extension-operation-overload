# php user operation overloading
I've created this extension to get access to the i2c bus on my raspberry pi.

### Installation
```bin
$ cd ~
$ git clone https://github.com/tasoftch/php-extension-operation-overload.git
$ cd php-i2c-extension
$ phpize
$ ./configure --enable-php-i2c
$ make
$ sudo make install
```
This compiles the source on your machine.  
Next find the php.ini file
```bin
$ php --ini
```
Will list scanned ini files.  
Add the following line to that php.ini file:
```extension=php_i2c```
```php
<?php
var_dump( extension_loaded('php_i2c') ); // Should be true
```

### Usage
The extension adds five function to the global scope:
1. ```i2c_open```  
   This opens the device bus.
1. ```i2c_select```  
   This selects an address of a connected chip.
1. ```i2c_read```  
   Reads data from the i2c bus.
1. ```i2c_write```  
   Writes data to the i2c bus
1. ```i2c_close```  
   Closes the bus.

### Example
I've tested with a Raspberry Pi Model B 3+ and the Adafruit ADS1115 analog to digital converter.
It's default i2c address is 0x48.
```php
<?php
$fd = i2c_open("/dev/i2c-1");
i2c_select($fd, 0x48);

for($e=0;$e<30;$e++) {
    // Read for 30 times the value between channel AIN_0 and GND, 4.096 V, 128 samples/s
    i2c_write($fd, 1, [0xc3, 0x85]);
    // Wait for conversion completed
    usleep(9000);
    i2c_write($fd, 0);
    $data = i2c_read($fd, 2);
    
    $value = $data[0]*256 + $data[1];
    printf("Hex: 0x%02x%02x - Int: %d - Float, converted: %f V\n",
        $data[0], $data[1], $value, (float)$value*4.096/32768.0);
    
    usleep(500000);
}

i2c_close($fd);
```

# Usage PHP
The package also contains a php wrapper class for i2c.
````bin
$ composer require tasoft/php-i2c-extension
````
Please note that the composer installation does not compile the extension!  
For compilation use the installation guide described before.

Now the same example can be rewritten as:
```php
<?php
use TASoft\Bus\I2C;

$i2c = new I2C(0x48, 1);
for($e=0;$e<30;$e++) {
    // Read for 30 times the value between channel AIN_0 and GND, 4.096 V, 128 samples/s
    $i2c->write16(1, 0xC385);
    // Wait for conversion completed
    usleep(9000);
    $i2c->writeRegister(0);
    $value = $i2c->read2Bytes();

    printf("Hex: 0x%04x - Int: %d - Float, converted: %f V\n",
        $value, $value, (float)$value*4.096/32768.0);
    
    usleep(500000);
}
```