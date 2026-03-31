<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\FuelType;
use App\Models\Part;
use App\Models\Service;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);

        Employee::factory()
            ->count(20)
            ->create();

        foreach ($this->fuelTypes as $fuelType) {
            FuelType::query()->create(['name' => $fuelType]);
        }

        foreach ($this->services as $service) {
            Service::query()->create($service);
        }

        foreach ($this->parts as $part) {
            Part::query()->create($part);
        }

        foreach ($this->vehicles as $make => $models) {
            $make = VehicleMake::query()->create(['name' => $make]);

            $models = collect($models)
                ->map(fn (string $model) => new VehicleModel(['name' => $model]))
                ->all();

            $make->vehicleModels()->saveMany($models);
        }

        Customer::factory()
            ->count(20)
            ->has(Vehicle::factory()->count(3))
            ->create();
    }

    public array $fuelTypes = [
        'diesel',
        'petrol',
        'electric',
        'hydrogen',
        'ethanol',
    ];

    public array $vehicles = [
        'Toyota' => ['Corolla', 'Camry', 'Vitz', 'Probox', 'Land Cruiser', 'Hilux', 'Rav4', 'Premio'],
        'Nissan' => ['Sunny', 'Sylphy', 'X-Trail', 'Note', 'Tiida', 'Navara', 'Patrol', 'March'],
        'Honda' => ['Civic', 'Accord', 'Fit', 'CR-V', 'Vezel', 'Insight', 'Stream'],
        'Mazda' => ['Demio', 'Axela', 'CX-5', 'Atenza', 'Premacy', 'CX-3'],
        'Subaru' => ['Impreza', 'Forester', 'Legacy', 'Outback', 'XV', 'Levorg'],
        'Mitsubishi' => ['Lancer', 'Pajero', 'Outlander', 'Canter', 'L200', 'Colt'],
        'Volkswagen' => ['Golf', 'Polo', 'Tiguan', 'Passat', 'Touareg', 'Jetta'],
        'Mercedes-Benz' => ['C-Class', 'E-Class', 'S-Class', 'GLC', 'GLE', 'ML350'],
        'BMW' => ['X1', 'X3', 'X5', 'X6', '3 Series', '5 Series', '7 Series'],
        'Audi' => ['A3', 'A4', 'A6', 'Q3', 'Q5', 'Q7'],
        'Ford' => ['Ranger', 'Everest', 'Focus', 'Escape', 'Figo'],
        'Isuzu' => ['D-Max', 'N-Series', 'F-Series', 'Mu-X'],
        'Land Rover' => ['Range Rover', 'Defender', 'Discovery', 'Freelander'],
        'Hyundai' => ['Tucson', 'Santa Fe', 'Elantra', 'Accent', 'I10'],
        'Kia' => ['Sportage', 'Sorento', 'Rio', 'Picanto'],
        'Suzuki' => ['Swift', 'Vitara', 'Jimny', 'Alto', 'Ertiga'],
        'Lexus' => ['RX350', 'LX570', 'NX200', 'IS250'],
        'Peugeot' => ['208', '308', '508', '3008', '5008'],
    ];

    public array $services = [
        [
            'name' => 'Minor Service',
            'description' => 'Includes engine oil change, oil filter replacement, and basic 15-point safety inspection.',
            'selling_price' => 7500.00,
        ],
        [
            'name' => 'Major Service',
            'description' => 'Comprehensive service including spark plugs, fuel filter, air filter, cabin filter, and full system diagnostics.',
            'selling_price' => 25000.00,
        ],
        [
            'name' => 'Brake Pad Replacement (Front)',
            'description' => 'Removal of worn brake pads, cleaning of calipers, and installation of new high-quality pads.',
            'selling_price' => 4500.00,
        ],
        [
            'name' => 'Computerized Diagnostics',
            'description' => 'Full ECU scan to identify engine codes, sensor malfunctions, and electronic system errors.',
            'selling_price' => 3000.00,
        ],
        [
            'name' => 'Suspension Overhaul',
            'description' => 'Inspection and replacement of worn shock absorbers, bushes, and control arms.',
            'selling_price' => 15000.00,
        ],
        [
            'name' => 'Wheel Alignment & Balancing',
            'description' => 'Precision alignment of all four wheels and weight balancing for smoother driving.',
            'selling_price' => 3500.00,
        ],
        [
            'name' => 'Automatic Transmission Fluid (ATF) Change',
            'description' => 'Draining old gearbox oil and refilling with manufacturer-specified transmission fluid.',
            'selling_price' => 12000.00,
        ],
        [
            'name' => 'Engine Steam Cleaning',
            'description' => 'High-pressure steam cleaning of the engine bay to remove grease, dirt, and oil leaks.',
            'selling_price' => 2500.00,
        ],
        [
            'name' => 'AC System Recharge',
            'description' => 'Evacuation of old refrigerant, vacuum leak test, and recharging with R134a gas and oil.',
            'selling_price' => 5500.00,
        ],
        [
            'name' => 'Battery Charging & Health Test',
            'description' => 'Slow charging of depleted batteries and a comprehensive load test to determine remaining life.',
            'selling_price' => 1000.00,
        ],
    ];

    public array $parts = [
        [
            'name' => 'Oil Filter (Toyota Genuine)',
            'description' => 'Genuine spin-on oil filter for 1NZ/2NZ engines (Vitz, Corolla, Premio).',
            'buying_price' => 850.00,
            'selling_price' => 1200.00,
            'quantity_in_stock' => 250,
        ],
        [
            'name' => 'Fully Synthetic Engine Oil (5W-30) - 4L',
            'description' => 'High-performance synthetic oil for modern petrol engines.',
            'buying_price' => 4200.00,
            'selling_price' => 5500.00,
            'quantity_in_stock' => 120,
        ],
        [
            'name' => 'Brake Pads (Front) - Akebono',
            'description' => 'Ceramic brake pads providing low noise and high stopping power.',
            'buying_price' => 3200.00,
            'selling_price' => 4500.00,
            'quantity_in_stock' => 180,
        ],
        [
            'name' => 'Spark Plug (Iridium) - NGK',
            'description' => 'Long-life iridium tipped spark plugs for improved combustion.',
            'buying_price' => 1100.00,
            'selling_price' => 1600.00,
            'quantity_in_stock' => 400,
        ],
        [
            'name' => 'Air Filter (Universal/Japanese)',
            'description' => 'High-flow replacement air filter for improved fuel efficiency.',
            'buying_price' => 900.00,
            'selling_price' => 1400.00,
            'quantity_in_stock' => 215,
        ],
        [
            'name' => 'Fuel Filter (External)',
            'description' => 'Replacement fuel filter to prevent injector clogging.',
            'buying_price' => 1500.00,
            'selling_price' => 2200.00,
            'quantity_in_stock' => 110,
        ],
        [
            'name' => 'Wiper Blade Set (24"/16")',
            'description' => 'All-weather silicone wiper blades for clear visibility.',
            'buying_price' => 1200.00,
            'selling_price' => 1800.00,
            'quantity_in_stock' => 150,
        ],
        [
            'name' => 'Coolant (Pre-mixed) - 5L',
            'description' => 'Pink/Red ethylene glycol based long-life radiator coolant.',
            'buying_price' => 1800.00,
            'selling_price' => 2500.00,
            'quantity_in_stock' => 135,
        ],
        [
            'name' => 'Drive Belt (Fan Belt)',
            'description' => 'Heavy-duty ribbed belt for alternator and AC compressor.',
            'buying_price' => 1400.00,
            'selling_price' => 2000.00,
            'quantity_in_stock' => 105,
        ],
        [
            'name' => 'ATF Fluid (Dexron III) - 1L',
            'description' => 'Transmission fluid suitable for most older automatic gearboxes.',
            'buying_price' => 950.00,
            'selling_price' => 1350.00,
            'quantity_in_stock' => 320,
        ],
    ];
}
