<?php

namespace Bantenprov\Sekolah\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Sekolah facade.
 *
 * @package Bantenprov\Sekolah
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class SekolahFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sekolah';
    }
}
