<?php
/**
 * Created by PhpStorm.
 * User: Рашид
 * Date: 02.07.2019
 * Time: 22:01
 */

namespace webtechnologies\calculator;

class Math extends \yii\base\BaseObject {

    public $handlerClass = handlers\DefaultCalcHandler::class;

    /* @var IMathCalculator $_handlerInstance*/
    private $_handlerInstance;

    public function init(){
        parent::init();
        $this->_handlerInstance = new $this->handlerClass;
    }

    public function expr($expression){
        return $this->_handlerInstance->expr($expression);
    }
}