<?php

use Illuminate\Database\Seeder;

class chatroomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chat_room')->insert([
            'room_name' => 'default',
            'room_type' => 'default',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
