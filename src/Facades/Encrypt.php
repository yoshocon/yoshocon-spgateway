<?php
/**
 *
 *
 * User: Chu
 * Date: 2018/1/9
 * Time: 下午3:53
 */

namespace Yoshocon\Spgateway\Facades;

use Illuminate\Support\Facades\Facade;

class Encrypt extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'encrypt';
    }
}
