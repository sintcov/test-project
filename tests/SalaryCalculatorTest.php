<?php

namespace tests;

use app\models\SalaryCalculator;

use PHPUnit\Framework\TestCase;


class SalaryCalculatorTest extends TestCase
{
    /** 
    * @dataProvider addDataProvider
    */
    public function testCalculate()
    {
        $salaryCalculator = new SalaryCalculator();
        $result = $salaryCalculator->calculate(10);
        self::assertEquals(8, $result);
    }



}