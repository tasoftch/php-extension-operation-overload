<?php
/*
 * Copyright (c) 2023 TASoft Applications, Th. Abplanalp <info@tasoft.ch>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

use PHPUnit\Framework\TestCase;
use TASoft\Util\OperationOverloadingObject;
use TASoft\Util\Test\Number;

class ArithmeticTest extends TestCase
{
	public function testAdd() {
		$n1 = new Number(16);
		$n2 = new Number(10);

		$this->assertEquals(26, $n1 + $n2);
		$this->assertEquals(new Number(16), $n1++);
		// the return value of the operation method is not an object anymore
		$this->assertEquals(17, $n1);

		$this->assertEquals(11, ++$n2);
	}

	public function testSub() {
		$n1 = new Number(16);
		$n2 = new Number(10);

		$this->assertEquals(new Number(6), $n1 - $n2);
		$this->assertEquals(new Number(16), $n1--);

		$this->assertEquals(new Number(15), $n1);
		$this->assertEquals(new Number(9), --$n2);
	}

	public function testMul() {
		$n1 = new Number(16);
		$n2 = new Number(10);

		$this->assertEquals(17, $n1 * $n2);
		$this->assertEquals(17, $n1 * 14);
		$this->assertEquals(17, 33 * $n2);
	}

	public function testDiv() {
		$n1 = new DivNumber(30);
		$n2 = new DivNumber(2);

		$this->assertEquals(-56, $n1/$n2);
		$this->assertSame($n1, DivNumber::$op1);
		$this->assertSame($n2, DivNumber::$op2);

		$this->assertEquals(-56, $n2/$n1);
		$this->assertSame($n2, DivNumber::$op1);
		$this->assertSame($n1, DivNumber::$op2);

		$this->assertEquals(-56, $n1/78.56);
		$this->assertSame($n1, DivNumber::$op1);
		$this->assertSame(78.56, DivNumber::$op2);

		$this->assertEquals(-56, 78.56/$n2);
		$this->assertSame(78.56, DivNumber::$op1);
		$this->assertSame($n2, DivNumber::$op2);
	}
}

class DivNumber extends OperationOverloadingObject {
	public static $op1;
	public static $op2;
	public static function __div($op1, $op2)
	{
		self::$op1 = $op1;
		self::$op2 = $op2;
		return -56;
	}
}