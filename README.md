# php user operation overloading

Did you ever want to add, subtract or multiply objects?  
This is a rfc on https://wiki.php.net/rfc/userspace_operator_overloading

I've created an extension that enables this functionality.

### Installation
```bin
$ cd ~
$ git clone https://github.com/tasoftch/php-extension-operation-overload.git
$ cd php-extension-operation-overload/ext
$ phpize
$ ./configure --enable-tasoft_usr_op_overload
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
```extension=tasoft_usr_op_overload```
```php
<?php
var_dump( extension_loaded('tasoft_usr_op_overload') ); // Should be true
```

### Usage

This package ships with a header class
```php
<?php
use TASoft\Util\OperationOverloadingObject;
```
All of its child classes may implement static method to the common operations in PHP.  
If the extension is not installed, the class exists anyway, but it will trigger a warning and the operation overloading won't work.

There are PHP interfaces declared which describe the implemented operation overloading.

- [ArithmeticOperationOverloadingInterface.php (optional)](src%2FUOO%2FArithmeticOperationOverloadingInterface.php)
- [BitwiseOperationOverloadingInterface.php (optional)](src%2FUOO%2FBitwiseOperationOverloadingInterface.php)
- [CompareOperationOverloadingInterface.php (required)](src%2FUOO%2FCompareOperationOverloadingInterface.php)
- [StringOperationOverloadingInterface.php (optional)](src%2FUOO%2FStringOperationOverloadingInterface.php)

The objects don't need to implement the interfaces. If the requested method exists, they get called otherwise the zend engine produces a fatal error.

### Example
```php
<?php
use TASoft\Util\OperationOverloadingObject as OpOv;

class Number extends OpOv {
    private $number;
    public function __construct($number) {
        $this->number = $number;
    }
    
    public static function __add($op1,$op2){
        if($op1 instanceof Number)
            $op1 = $op1->number;
        if($op2 instanceof Number)
            $op2 = $op2->number;
        
        return $op1 + $op2;
    }
}

$n1 = new Number(23);
$n2 = new Number(18);

echo $n1 + $n2; // 41
```