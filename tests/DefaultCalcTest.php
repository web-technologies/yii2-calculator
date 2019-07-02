<?php
/**
 * Created by PhpStorm.
 * User: Рашид
 * Date: 02.07.2019
 * Time: 22:22
 */

namespace tests\unit;

use webtechnologies\calculator\Math;

class DefaultCalcTest extends \Codeception\Test\Unit {

    /**
     * @dataProvider provider
     * @param string $expression
     * @param int|float $validResult
     */
    public function testExpr($expression, $validResult) {
        $this->assertEquals((new Math())->expr($expression), $validResult);
    }

    /**
     * @return array
     */
    public function provider() {
        return [
            ['2 * 2', 4],
            ['2 + 3', 5],
            ['8 / 2', 4],
            ['3 - 2', 1],
            ['3 ^ 3', 27],
            ['( 5 + (5 * 6) - 3 + 2 ^ 4 * ( -3 * -5 * 4 + ( 3 / 34 + 1 * 3 + 6 - 3 + ( 4 / 2 ) ) ) ) * -1', -1121.4117647059],
        ];
    }
}
