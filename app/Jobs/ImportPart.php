<?php

namespace App\Jobs;

use Milon\Barcode\DNS1D;
use App\Models\OldPartNumber;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ImportPart implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $row;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($row)
    {
        $this->row = $row;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Skip the blank rows
        if (!$this->row[2])
            return false;

        $oldNumbers = collect(explode(',', $this->row[1]))
            ->map(fn ($d) => trim($d))
            ->filter(fn ($d) => $d != '' || $d != null)
            ->toArray();

        $machines = collect(explode(',', $this->row[3]))
            ->map(fn ($d) => trim($d))
            ->filter(fn ($d) => $d != '' || $d != null)
            ->toArray();

        foreach ($machines as $i => $machineName) :
            /**
             * Check the machines are exists or not . If it's not exist then insert into database
             */
            $machine = DB::table('machines')->where('name', $machineName)->value('id');
            if (!$machine)
                $machine = DB::table('machines')->insertGetId(['name' => $machineName]);

            /**
             * Check the Part heading is exists or not . If it's not exist then insert into database
             */
            $part_heading = DB::table('part_headings')
                ->where('machine_id', $machine)
                ->where('name', $this->row[4])
                ->value('id');

            if (!$part_heading)
                $part_heading = DB::table('part_headings')->insertGetId(['name' => $this->row[4], 'machine_id' => $machine]);

            /**
             * Check the Part is exists or not . If it's not exist then insert into database
             */

            $has_alias = DB::table('part_aliases')
                ->where('name', $this->row[0])
                ->first();

            $alias = DB::table('part_aliases')
                ->where('name', $this->row[0])
                ->where('machine_id', $machine)
                ->first();

            if ($alias) :
                $part = DB::table('parts')
                    ->find($alias->part_id)
                    ->id ?? null;

                //Generate unique ID and barcode for the parts
                $unique_id = str_pad('2022' . $part, 6, 0, STR_PAD_LEFT);
                $barcode = new DNS1D;
                $barcode_data = $barcode->getBarcodePNG($unique_id, 'I25', 2, 60, array(1, 1, 1), true);

                //Update the unique ID
                DB::table('parts')
                    ->where('id', $part)
                    ->update([
                        'unique_id' => $unique_id,
                        'barcode' => $barcode_data
                    ]);
            endif;

            if (!$alias) :
                if (!$has_alias) {
                    $part = DB::table('parts')->insertGetId([
                        'unit' => $this->row[8] ?? 'piece',
                        'arm' => $this->row[5],
                        'description' => null
                    ]);

                    $has_alias = DB::table('part_aliases')->insertGetId([
                        'name' => $this->row[0],
                        'part_number' => $this->row[2],
                        'machine_id' => $machine,
                        'part_id' => $part,
                        'part_heading_id' => $part_heading
                    ]);
                } else {
                    $part = DB::table('parts')->find($has_alias->part_id)->id;
                }

                //Generate unique ID and barcode for the parts
                $unique_id = str_pad('2022' . $part, 6, 0, STR_PAD_LEFT);
                $barcode = new DNS1D;
                $barcode_data = $barcode->getBarcodePNG($unique_id, 'I25', 2, 60, array(1, 1, 1), true);

                //Update the unique ID
                DB::table('parts')
                    ->where('id', $part)
                    ->update([
                        'unique_id' => $unique_id,
                        'barcode' => $barcode_data
                    ]);

                //Add old part numbers
                foreach ($oldNumbers as $i => $number) :
                    OldPartNumber::updateOrCreate([
                        'part_id' => $part,
                        'part_number' => $number
                    ]);
                endforeach;
            endif;

            // $ware_house = DB::table('warehouses')
            //     ->where('name', $this->row[5])
            //     ->value('id');

            // $unique_id = DB::table('parts')->where('unique_id', $this->row[11])->value('unique_id');
            // if (!$unique_id)
            //     $unique_id = DB::table('parts')->insertGetId(['unique_id' => $this->row[11]]);

            // // barcode create

            // $barcode = DB::table('parts')->where('unique_id', $unique_id)->value('barcode');


            /**
             * Check the Part is exists or not . If it's not exist then insert into database
             */
        // $part_stocks = DB::table('part_stocks')->where('part_id',$part->id)->value('id');

        // if ($part_stocks) {
        //     $ware_house = DB::table('warehouses')->where('name',$this->row[5])->value('id');
        // }

        // if (!$ware_house)
        //     $ware_house = DB::table('warehouses')->insertGetId(['name' => $this->row[5]]);


        // $stocks = DB::table('part_stocks')->where('warehouse_id',$ware_house->id)->value('id');
        // if ($this->row[7])
        //     DB::table('part_stocks')->insert([
        //         'part_id' => $part,
        //         'part_heading_id' => $part_heading,
        //         'warehouse_id' => $ware_house,
        //         'unit_value' => $this->row[7],
        //         'yen_price' => $this->row[8],
        //         'formula_price' => $this->row[9],
        //         'selling_price' => $this->row[10],
        //     ]);

        endforeach;

        return true;
    }
}
