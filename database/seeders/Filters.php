<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Filters extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scope = [
            'name' => 'Players',
            'settings' => array([
                'name' => '0 - 20',
                'code' => '0_20'
            ],[
                'name' => '21 - 40',
                'code' => '21_40'
            ],[
                'name' => '41 - 60',
                'code' => '41_60'
            ],[
                'name' => '61 - 80',
                'code' => '61_80'
            ],[
                'name' => '81 - 100',
                'code' => '81_100'
            ])
        ];

        \App\Models\Filters::firstOrCreate($scope);

    }
}
