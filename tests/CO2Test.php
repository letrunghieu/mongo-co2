<?php

class CO2Test extends PHPUnit_Framework_TestCase
{

    public function testGetCarbon()
    {
        $carbon = new \Carbon\Carbon();
        $co2    = new \HieuLe\MongoDateTime\CO2($carbon);

        $this->assertSame($carbon, $co2->getCarbon());
    }

    public function testSetCarbon()
    {
        $carbon = \Carbon\Carbon::createFromDate(2015, 1, 1);
        $co2    = new \HieuLe\MongoDateTime\CO2(\Carbon\Carbon::now());
        $this->assertNotSame($carbon, $co2->getCarbon());

        $co2->setCarbon($carbon);
        $this->assertSame($carbon, $co2->getCarbon());
    }

    public function testBsonSerialize()
    {
        $carbon = \Carbon\Carbon::createFromTimestamp(1450838358, 'Asia/Krasnoyarsk');
        $co2    = new \HieuLe\MongoDateTime\CO2($carbon);

        $output = $co2->bsonSerialize();
        $this->assertSame(1450838358, $output['timestamp']);
        $this->assertSame('Asia/Krasnoyarsk', $output['timezone']);
    }

    public function testBsonUnserialize()
    {
        $bson = [
            'timestamp' => 1450838358,
            'timezone'      => "Asia/Krasnoyarsk",
        ];

        $co2 = new \HieuLe\MongoDateTime\CO2(\Carbon\Carbon::now());
        $co2->bsonUnserialize($bson);

        $carbon = $co2->getCarbon();
        $this->assertSame(1450838358, $carbon->getTimestamp());
        $this->assertSame('Asia/Krasnoyarsk', $carbon->getTimezone()->getName());
    }

}