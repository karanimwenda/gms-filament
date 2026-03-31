<?php

namespace Database\Seeders;

use App\Models\User;
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

        foreach ($this->vehicles as $make => $models) {
            $make = VehicleMake::query()->create(['name' => $make]);

            $models = collect($models)
                ->map(fn (string $model) => new VehicleModel(['name' => $model]))
                ->all();

            $make->vehicleModels()->saveMany($models);
        }
    }

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
}
