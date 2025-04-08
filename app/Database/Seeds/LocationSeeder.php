<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $countries = [
            ['name' => 'India'],
            ['name' => 'United States'],
            ['name' => 'Canada'],
            ['name' => 'Australia'],
            ['name' => 'Germany']
        ];

        $countryIDs = [];

        // Insert countries
        foreach ($countries as $country) {
            $this->db->table('country')->insert($country);
            $countryIDs[] = $this->db->insertID();
        }

        $states = [
            ['country_id' => $countryIDs[0], 'name' => 'Gujarat'],
            ['country_id' => $countryIDs[1], 'name' => 'California'],
            ['country_id' => $countryIDs[2], 'name' => 'Ontario'],
            ['country_id' => $countryIDs[3], 'name' => 'New South Wales'],
            ['country_id' => $countryIDs[4], 'name' => 'Bavaria'],
        ];

        $stateIDs = [];

        // Insert states
        foreach ($states as $state) {
            $this->db->table('state')->insert($state);
            $stateIDs[] = $this->db->insertID();
        }

        $cities = [
            ['state_id' => $stateIDs[0], 'name' => 'Ahmedabad'],
            ['state_id' => $stateIDs[1], 'name' => 'Los Angeles'],
            ['state_id' => $stateIDs[2], 'name' => 'Toronto'],
            ['state_id' => $stateIDs[3], 'name' => 'Sydney'],
            ['state_id' => $stateIDs[4], 'name' => 'Munich'],
        ];

        // Insert cities
        $this->db->table('city')->insertBatch($cities);
    }
}
