<?php
/**
 * Created by PhpStorm.
 * User: Рашид
 * Date: 02.07.2019
 * Time: 22:56
 */

namespace webtechnologies\calculator\handlers;

use webtechnologies\calculator\IMathCalculator;

class DefaultCalcHandler implements IMathCalculator {

    private $_operationsMethods = [
        '_pow',
        '_devision',
        '_multiplication',
        '_subtraction',
        '_addition',
    ];

    /**
     * @param string $expression
     * @return mixed
     * @throws \Exception
     */
    public function expr($expression) {
        if (!$this->_isValidBrackets($expression)) {
            throw new \Exception('Не соответствие открывающих и закрывающих скобок');
        }

        if (!$this->_isValidChars($expression)) {
            throw new \Exception('Недопустимое выражение! Разрешенные символы: +,-,*,/,^,.,(,),0-9');
        }

        $expression = str_replace([' ', '()'], '', $expression);
        $expression = "({$expression})";
        $counter = 0;
        $matches = [];
        while(preg_match('#\(([^\(\)]+)\)#', $expression, $matches)){
            if ($counter >= 5000) {
                throw new \Exception("Что-то пошло не так...");
            }
            $expressionWithBracket = $matches[0];
            $expressionInBracket = $matches[1];
            foreach ($this->_operationsMethods as $operationMethod) {
                $expressionInBracket = call_user_func_array([$this, $operationMethod], [$expressionInBracket]);
            }
            $expression = str_replace($expressionWithBracket, $expressionInBracket, $expression);
            $counter++;
        }

        return $expression;
    }

    /**
     * @param string $expression
     * @return bool
     */
    private function _isValidBrackets($expression) {
        $counter = 0;
        for ($i = 0; $i < strlen($expression); $i++) {
            if ($expression[$i] == '(')
                $counter++;
            elseif ($expression[$i] == ')')
                $counter--;
        }
        return $counter === 0;
    }

    /**
     * @param string $expression
     * @return bool
     */
    private function _isValidChars($expression) {
        return !(bool)preg_match('#[^\+\-\*\/\^\.\d\(\)\s]+#', $expression);
    }

    /**
     * @param string $expression
     * @return mixed
     */
    private function _devision($expression){
        return $this->_calculateBinaryOperation($expression, '/', function($currentResultValue, $nextValue){
            if ($nextValue == 0) {
                throw new \Exception('Деление на 0');
            }
            return $currentResultValue / $nextValue;
        });
    }

    /**
     * @param string $expression
     * @return mixed
     */
    private function _multiplication($expression){
        return $this->_calculateBinaryOperation($expression, '*', function($currentResultValue, $nextValue){
            return $currentResultValue * $nextValue;
        });
    }

    /**
     * @param string $expression
     * @return mixed
     */
    private function _addition($expression){
        return $this->_calculateBinaryOperation($expression, '+', function($currentResultValue, $nextValue){
            return $currentResultValue + $nextValue;
        });
    }

    /**
     * @param string $expression
     * @return mixed
     */
    private function _subtraction($expression){
        return $this->_calculateBinaryOperation($expression, '-', function($currentResultValue, $nextValue){
            return $currentResultValue - $nextValue;
        });
    }

    /**
     * @param string $expression
     * @return mixed
     */
    private function _pow($expression){
        return $this->_calculateBinaryOperation($expression, '^', function($currentResultValue, $nextValue){
            return pow($currentResultValue, $nextValue);
        });
    }

    /**
     * @param string $expression
     * @param string $op
     * @param callable $callback
     * @return mixed
     * @throws \Exception
     */
    private function _calculateBinaryOperation($expression, $op, $callback){
        $matches = [];
        $operationForPattern = str_replace(['*', '+', '^'], ['\*', '\+', '\^'], $op);
        if(preg_match_all("#-?(?:\d+(:?\.\d+)?)(?:{$operationForPattern}-?(?:\d+(:?\.\d+)?))+#", $expression, $matches)){
            if($matches) {
                foreach ($matches[0] as $match) {
                    $values = explode($op, $match);
                    $result = $values[0];
                    for ($i = 1; $i < count($values); $i++){
                        $result = $callback($result, $values[$i]);
                    }
                    $expression = str_replace($match, $result, $expression);
                }
            }
        }

        return $expression;
    }
}