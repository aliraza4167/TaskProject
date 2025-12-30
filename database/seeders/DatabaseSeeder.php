<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Thread;
use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $users = User::factory(9)
        ->withoutTwoFactor()
        ->has(Task::factory()->count(10))
        ->create();


        $ali = User::factory()
        ->withoutTwoFactor()
        ->has(Task::factory()->count(10))
        ->create([
            'name' => 'Ali',
            'email' => 'ali@example.com',
        ]);

        // Create threads with messages and participants
        $threads = Thread::factory(5)
        ->create();

        foreach ($threads as $thread) {
            // Add participants
            $thread->participants()->attach($ali->id);
            $thread->participants()->attach($users->random()->id);

            // Create messages
            Message::factory(3)->create([
                'thread_id' => $thread->id,
                'user_id' => $ali->id,
            ]);

            Message::factory(3)->create([
                'thread_id' => $thread->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
