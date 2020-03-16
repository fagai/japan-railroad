<?php

declare(strict_types=1);

namespace Fagai\LineData;

class Station implements Jsonable
{
    /**
     * @var int
     */
    public $stationId;
    /**
     * @var int
     */
    public $stationGroupId;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $katakana;
    /**
     * @var string
     */
    public $romaji;
    /**
     * @var int
     */
    public $lineId;
    /**
     * @var int
     */
    public $prefId;
    /**
     * @var string
     */
    public $zipCode;
    /**
     * @var string
     */
    public $address;
    /**
     * @var float
     */
    public $longitude;
    /**
     * @var float
     */
    public $latitude;
    /**
     * @var string
     */
    public $open;
    /**
     * @var string
     */
    public $close;
    /**
     * @var int
     */
    public $status;
    /**
     * @var string
     */
    private $pref;
    /**
     * @var string
     */
    private $city;
    /**
     * @var string
     */
    private $town;

    public function __construct(
        int $stationId,
        int $stationGroupId,
        string $name,
        string $katakana,
        string $romaji,
        int $lineId,
        int $prefId,
        string $zipCode,
        string $address,
        float $longitude,
        float $latitude,
        ?string $open,
        ?string $close,
        int $status,
        $sort,
        ?string $pref,
        ?string $city,
        ?string $town
    ) {
        $this->stationId = $stationId;
        $this->stationGroupId = $stationGroupId;
        $this->name = $name;
        $this->katakana = $katakana;
        $this->romaji = $romaji;
        $this->lineId = $lineId;
        $this->prefId = $prefId;
        $this->zipCode = $zipCode;
        $this->address = $address;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->open = $open === '0000-00-00' ? null : $open;
        $this->close = $close === '0000-00-00' ? null : $close;;
        $this->status = $status;
        $this->pref = $pref;
        $this->city = $city;
        $this->town = $town;
    }

    /**
     * @return false|string
     */
    public function getJson(): string
    {
        return json_encode(
            [
                'stationId' => $this->stationId,
                'stationGroupId' => $this->stationGroupId,
                'name' => $this->name,
                'lineId' => $this->lineId,
                'zipCode' => $this->zipCode,
                'pref' => $this->pref,
                'prefId' => $this->prefId,
                'city' => $this->city,
                'town' => $this->town,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
                'status' => $this->status,
            ],
            JSON_UNESCAPED_UNICODE
        );
    }
}
