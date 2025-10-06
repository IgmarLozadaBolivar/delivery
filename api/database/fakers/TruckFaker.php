<?php

namespace Database\Fakers;

use App\Services\TruckImportService;
use Faker\Provider\Base;

class TruckFaker extends Base
{
    protected static array $trucks = [];
    public function __construct($generator)
    {
        parent::__construct($generator);

        if (empty(self::$trucks))
        {
            $service = new TruckImportService();
            self::$trucks = $service->import();
        }
    }

    public function truck(): array
    {
        return static::randomElement(self::$trucks);
    }

    public function truckBrand(): string
    {
        $truck = $this->truck();
        return $truck['marca'] ?? 'Unknown';
    }

    public function truckModel(): string
    {
        $truck = $this->truck();
        return $truck['modelo'] ?? 'Unknown';
    }
}
