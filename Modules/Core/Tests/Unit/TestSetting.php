<?php

namespace Modules\Core\Tests\Unit;

use Modules\Core\Entities\setting;
use Tests\TestCase;

class TestSetting extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testASettingAValue()
    {
        $setting = Setting::where('code' , 1025)->first();
        $this->assertNotEmpty( $setting );
    }

}
