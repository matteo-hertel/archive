<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\Helpers;

class HelpersTest extends TestCase
{

    public function testIntegration()
    {
        $valid = 0;
        for($i = 1; $i <= 100; $i++){
            $rangeArray = Helpers::createArrayRange($i);
            $missingNumber = Helpers::findMissingNumber($rangeArray);
            if($i === $missingNumber){
                $valid ++;
                continue;
            }
                $valid --;
        }
        $this->assertTrue($valid === 100);
        
    }
}
