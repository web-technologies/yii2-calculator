<?php
/**
 * Created by PhpStorm.
 * User: Рашид
 * Date: 02.07.2019
 * Time: 22:49
 */

namespace webtechnologies\calculator;

interface IMathCalculator {

    /**
     * @param string $expression
     * @return mixed
     */
    function expr($expression);
}