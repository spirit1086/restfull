<?php
namespace Spirit1086\Restfull\Modules\Auth\Seed;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spirit1086\Restfull\Modules\Auth\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $data = [
                'name'=>'test',
                'auth_token'=>Str::random(60)
            ];

            $user = new User();
            $user->setData(['name'=>$data['name']],$data);
    }
}
