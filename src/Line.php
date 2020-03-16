<?php

declare(strict_types=1);

namespace Fagai\LineData;

class Line implements Jsonable
{
    /**
     * @var int
     */
    public $lineId;
    /**
     * @var int
     */
    public $companyId;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $katakana;
    public $colorCode;
    public $colorName;
    /**
     * @var int
     */
    public $lineType;
    /**
     * @var float
     */
    public $longitude;
    /**
     * @var float
     */
    public $latitude;
    /**
     * @var int
     */
    public $status;

    /**
     * @var Station[]
     */
    public $stations = [];

    public function __construct(
        int $lineId,
        int $companyId,
        string $name,
        string $katakana,
        $name_h,
        $colorCode,
        $colorName,
        $lineType,
        float $longitude,
        float $latitude,
        int $status,
        $sort
    ) {
        $this->lineId = $lineId;
        $this->companyId = $companyId;
        $this->name = $name;
        $this->katakana = $katakana;
        $this->colorCode = $colorCode;
        $this->colorName = $colorName;
        $this->lineType = $lineType;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->status = $status;
    }

    public function addStation(Station $station)
    {
        $this->stations[] = $station;
    }

    public function getJson(): string
    {
        $stations = [];
        foreach ($this->stations as $station) {
            $stations[] = [
                'stationId' => $station->stationId,
                'stationGroupId' => $station->stationGroupId
            ];
        }

        return json_encode(
            [
                'lineId' => $this->lineId,
                'name' => $this->name,
                'stations' => $stations
            ],
            JSON_UNESCAPED_UNICODE
        );
    }
}
