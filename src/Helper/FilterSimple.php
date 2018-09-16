<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 30.08.2018
 * Time: 11:32
 */

namespace Popov\Variably\Helper;

use __;

class FilterSimple extends HelperAbstract implements FilterInterface
{
    public function filter($value)
    {
        $params = $this->getConfig('params');
        $path = $params[0];


        $result = [];
        foreach ($value as $val) {

            $res = __::get($val, $path);
            if($res){
                $result[] = $res;
            }
        }

        /*
         *  recourcive searching 'param'
         *
         */
        if($result == null){
            foreach ($value as $key => $val) {
                //$result[] = __::get($val, $path);
                $res = __::get($val, $path);
                if($res){
                    return $res;
                }
                $result[] = $this->filter($value[$key]);
            }


        }

        return $result;
    }

}