<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Occurrence;

class OccurrenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $occurrences = [
            'every Day'=> "everyday",
            'every Monday'=>"Mondays",
            "every Monday, Wednesday and Friday"=>"MondayWednesdayFriday",
            'every 5th of each month'=>'FifthOfEachMonth',
            'every 5th of March of each year'=>'FifthMarchEachYear'
        ];

        foreach($occurrences as $key=> $occurrence) {
            Occurrence::updateOrCreate(
                ['name' => $key,'function_name'=>$occurrence],
                ['name' => $key,'function_name'=>$occurrence]
            );
        }
    }
}
