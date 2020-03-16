<?php

declare(strict_types=1);

namespace Fagai\LineData;

class Company implements Jsonable
{
    /**
     * @var int
     */
    public $companyId;
    /**
     * @var int
     */
    public $railroadId;
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
    public $officialName;
    /**
     * @var string
     */
    public $shortName;
    /**
     * @var string
     */
    public $website;
    /**
     * @var int
     */
    public $companyType;
    /**
     * @var int
     */
    public $status;
    /**
     * @var int
     */
    public $sort;

    public function __construct(
        int $companyId,
        int $railroadId,
        string $name,
        string $katakana,
        string $officialName,
        string $shortName,
        string $website,
        int $companyType,
        int $status,
        int $sort
    ) {
        $this->companyId = $companyId;
        $this->railroadId = $railroadId;
        $this->name = $name;
        $this->katakana = $katakana;
        $this->officialName = $officialName;
        $this->shortName = $shortName;
        $this->website = $website;
        $this->companyType = $companyType;
        $this->status = $status;
        $this->sort = $sort;
    }

    public function getJson(): string
    {
        return json_encode(
            [
                'companyId' => $this->companyId,
                'railroadId' => $this->railroadId,
                'name' => $this->name,
                'katakana' => $this->katakana,
                'officialName' => $this->officialName,
                'shortName' => $this->shortName,
                'website' => $this->website,
                'companyType' => $this->companyType,
                'status' => $this->status,
                'sort' => $this->sort,
            ],
            JSON_UNESCAPED_UNICODE
        );
    }
}
