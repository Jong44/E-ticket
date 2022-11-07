<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data['first_name'] = "tanjung";
        $data['last_name'] = "tanjung";
        $data['username'] = "tanjung";
        $data['no_hp'] = "102313";
        $data['alamat'] = "tanjung";
        $data['email'] = "tanjungg@gmail.com";
        $data['password'] = bcrypt('tanjung45');

        Admin::create($data);
    }
}
