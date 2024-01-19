<?php

namespace App\Imports;

use App\Models\OldPartNumber;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PartsImport implements ToCollection, WithChunkReading, ShouldQueue
{
    /**
     * Set the chunk size
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $rows->shift();
        $rows->filter();

        try {
            DB::beginTransaction();
            foreach ($rows as $key => $row) :
                $oldNumbers = collect(explode(',', $row[1]))
                    ->map(fn ($d) => trim($d))
                    ->filter(fn ($d) => $d != '' || $d != null)
                    ->toArray();

                $machines = collect(explode(',', $row[3]))
                    ->map(fn ($d) => trim($d))
                    ->filter(fn ($d) => $d != '' || $d != null)
                    ->toArray();
                    // dd($machines);

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
                        ->where('name', $row[4])
                        ->value('id');

                    if (!$part_heading)
                        $part_heading = DB::table('part_headings')->insertGetId(['name' => $row[4], 'machine_id' => $machine]);

                    /**
                     * Check the Part is exists or not . If it's not exist then insert into database
                     */

                    $has_alias = DB::table('part_aliases')
                        ->where('name', $row[0])
                        ->first();

                        $alias = DB::table('part_aliases')
                        ->where('name', $row[0])
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
                                'unit' => $row[8] ?? 'piece',
                                'arm' => $row[5] ?? 0,
                                'description' => null
                            ]);

                            $has_alias = DB::table('part_aliases')->insertGetId([
                                'name' => $row[0],
                                'part_number' => $row[2],
                                'machine_id' => $machine,
                                'part_id' => $part,
                                'part_heading_id' => $part_heading
                            ]);
                        } else {
                            $part = DB::table('parts')->find($has_alias->part_id)->id;

                            $has_alias = DB::table('part_aliases')->insertGetId([
                                'name' => $row[0],
                                'part_number' => $row[2],
                                'machine_id' => $machine,
                                'part_id' => $part,
                                'part_heading_id' => $part_heading
                            ]);
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
                            ], []);
                        endforeach;
                    endif;

                    // $ware_house = DB::table('warehouses')
                    //     ->where('name', $row[5])
                    //     ->value('id');

                    // $unique_id = DB::table('parts')->where('unique_id', $row[11])->value('unique_id');
                    // if (!$unique_id)
                    //     $unique_id = DB::table('parts')->insertGetId(['unique_id' => $row[11]]);

                    // // barcode create

                    // $barcode = DB::table('parts')->where('unique_id', $unique_id)->value('barcode');


                    /**
                     * Check the Part is exists or not . If it's not exist then insert into database
                     */
                // $part_stocks = DB::table('part_stocks')->where('part_id',$part->id)->value('id');

                // if ($part_stocks) {
                //     $ware_house = DB::table('warehouses')->where('name',$row[5])->value('id');
                // }

                // if (!$ware_house)
                //     $ware_house = DB::table('warehouses')->insertGetId(['name' => $row[5]]);


                // $stocks = DB::table('part_stocks')->where('warehouse_id',$ware_house->id)->value('id');
                // if ($row[7])
                //     DB::table('part_stocks')->insert([
                //         'part_id' => $part,
                //         'part_heading_id' => $part_heading,
                //         'warehouse_id' => $ware_house,
                //         'unit_value' => $row[7],
                //         'yen_price' => $row[8],
                //         'formula_price' => $row[9],
                //         'selling_price' => $row[10],
                //     ]);

                endforeach;
            endforeach;

            DB::commit();

            return "All good";
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            // something went wrong


        }
    }
}
