<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //$this->call(UserTableSeeder::class);
        $this->call('UserTableSeeder');
        $this->call('CategoryTableSeeder');
        $this->call('FoodTableSeeder');

        Model::reguard();
    }
}

class UserTableSeeder extends Seeder
{
    public function run()
    {
        App\User::truncate();
        App\User::create(['twtid'=>72907 ,'twtuname'=>'miss976885345','studentid'=>'3015204342','realname'=>'冀辰阳','remember_token' => str_random(10)]);
        //factory(App\User::class, 20)->create();
    }
}

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        App\Category::truncate();
        App\Category::create(['cid'=>1 ,'campus' => 1 , 'canteen'=> '学一','floor' => '二楼']);
    }
}

class FoodTableSeeder extends Seeder
{
    public function run()
    {
        App\Food::truncate();
        factory(App\Food::class, 20)->create();
    }
}