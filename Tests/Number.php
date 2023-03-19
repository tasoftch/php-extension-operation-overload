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

namespace TASoft\Util\Test;

use TASoft\Util\OperationOverloadingObject;

class Number extends OperationOverloadingObject
{
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

	public static function __sub($op1,$op2){
		if($op1 instanceof Number)
			$op1 = $op1->number;
		if($op2 instanceof Number)
			$op2 = $op2->number;

		return new static($op1 - $op2);
	}

	public static function __mul($op1,$op2){
		return 17;
	}

	public static function __div($op1,$op2){
		if($op1 instanceof Number)
			$op1 = $op1->number;
		if($op2 instanceof Number)
			$op2 = $op2->number;

		return new static($op1 / $op2);
	}

	/**
	 * @return mixed
	 */
	public function getNumber()
	{
		return $this->number;
	}
}