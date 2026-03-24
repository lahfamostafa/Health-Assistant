<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doctor::create([
            'name' => 'Dr. Ahmed Benali',
            'specialty' => 'Généraliste',
            'city' => 'Casablanca',
            'years_of_experience' => 10,
            'consultation_price' => 200,
            'available_days' => ['Lundi', 'Mercredi', 'Vendredi']
        ]);

        Doctor::create([
            'name' => 'Dr. Sara Amrani',
            'specialty' => 'Cardiologue',
            'city' => 'Rabat',
            'years_of_experience' => 8,
            'consultation_price' => 300,
            'available_days' => ['Mardi', 'Jeudi']
        ]);

        Doctor::create([
            'name' => 'Dr. Youssef Alaoui',
            'specialty' => 'Dermatologue',
            'city' => 'Marrakech',
            'years_of_experience' => 12,
            'consultation_price' => 250,
            'available_days' => ['Lundi', 'Samedi']
        ]);
    }
}
