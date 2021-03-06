<?php

namespace HieuLe\MongoDateTime;

use Carbon\Carbon;
use MongoDB\BSON\Persistable;

class CO2 implements Persistable
{
    /**
     * @var Carbon
     */
    protected $carbon;

    /**
     * CO2 constructor.
     *
     * @param Carbon $carbon
     */
    public function __construct(Carbon $carbon)
    {
        $this->carbon = $carbon;
    }

    /**
     * @return Carbon
     */
    public function getCarbon()
    {
        return $this->carbon;
    }

    /**
     * @param Carbon $carbon
     */
    public function setCarbon($carbon)
    {
        $this->carbon = $carbon;
    }

    /**
     * Provides an array or document to serialize as BSON
     * Called during serialization of the object to BSON. The method must return an array or stdClass.
     * Root documents (e.g. a MongoDB\BSON\Serializable passed to MongoDB\BSON\fromPHP()) will always be serialized as
     * a BSON document. For field values, associative arrays and stdClass instances will be serialized as a BSON
     * document and sequential arrays (i.e. sequential, numeric indexes starting at 0) will be serialized as a BSON
     * array.
     * @link http://php.net/manual/en/mongodb-bson-serializable.bsonserialize.php
     * @return array|object An array or stdClass to be serialized as a BSON array or document.
     */
    public function bsonSerialize()
    {
        $carbon = $this->getCarbon();

        return [
            'timestamp' => $carbon->getTimestamp(),
            'timezone'  => $carbon->getTimezone()->getName(),
        ];
    }

    /**
     * Constructs the object from a BSON array or document
     * Called during unserialization of the object from BSON.
     * The properties of the BSON array or document will be passed to the method as an array.
     * @link http://php.net/manual/en/mongodb-bson-unserializable.bsonunserialize.php
     *
     * @param array $data Properties within the BSON array or document.
     */
    public function bsonUnserialize(array $data)
    {
        $carbon = Carbon::createFromTimestamp($data['timestamp'], $data['timezone']);
        $this->setCarbon($carbon);
    }

}