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

namespace TASoft\Util\UOO;

interface BitwiseOperationOverloadingInterface
{
	/**
	 * Enables the bitwise or operation
	 * $obj1 | $obj2
	 *
	 * @param $op1
	 * @param $op2
	 * @return mixed
	 */
	public static function __or($op1, $op2);

	/**
	 * Enables the bitwise and operation
	 * $obj1 & $obj2
	 *
	 * @param $op1
	 * @param $op2
	 * @return mixed
	 */
	public static function __and($op1, $op2);

	/**
	 * Enables the bitwise xor operation
	 * $obj1 ^ $obj2
	 *
	 * @param $op1
	 * @param $op2
	 * @return mixed
	 */
	public static function __xor($op1, $op2);

	/**
	 * Enables the bitwise not operation
	 * ~$obj1
	 *
	 * @param $op1
	 * @return mixed
	 */
	public static function __not($op1);

	/**
	 * Enables the bitwise shift right operation
	 * $obj1 >> $obj2
	 *
	 * @param $op1
	 * @param $op2
	 * @return mixed
	 */
	public static function __sr($op1, $op2);

	/**
	 * Enables the bitwise shift left operation
	 * $obj1 << $obj2
	 *
	 * @param $op1
	 * @param $op2
	 * @return mixed
	 */
	public static function __sl($op1, $op2);
}