<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 30.08.2018
 * Time: 11:32
 */

namespace Popov\Variably\Helper;

use __;

class FilterGet extends HelperAbstract implements FilterInterface
{
    public function filter($value)
    {
        $params = $this->getConfig('params');
        $path = $params[0];


        /*$result = null;
        if (iseet()) {

        } elseif (is_array($value)) {
            foreach ($value as $elm) {
                $result[] = $this->getting(explode('.', $path), $elm);
            }
        } else {
            $result = $this->getting(explode('.', $path). $value);
        }*/

        $result = __::get($value, $path);

        return $result;
    }

    protected function getting($path, $resolved)
    {
        foreach ($path as $part) {
            if (isset($resolved[$part])) {
                $resolved = $resolved[$part];
            } else if (property_exists($resolved, $part)) {
                $resolved = $resolved->{$part};
            } elseif (isset($resolved[$part])) {
                $resolved = null;
                break;
            }
        }

        //$resolved = ($resolved instanceof  \SimpleXMLElement && count($resolved->children())) ? (array) $resolved : (string) $resolved;

        return $resolved;
    }
}