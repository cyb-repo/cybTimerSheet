<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignClientsAndTasks
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        //
        $user = $event->user;
        $clients = ['Cybenergie','Internal'];
          // Assign clients to the user
        foreach ($clients as $clientName) {
            $client = new Client(['name' => $clientName]);
            $user->clients()->save($client);
        }
        //Assign Tasks to the user
        $tasks = ['Bank holiday', 'Vacation', 'Performance Review', 'Training', 'Workday'];
        foreach ($tasks as $task) {
            $client = new Client(['title' => $task,'color' => '', 'client_id' => $client->id,'is_billable' => false]);
            $user->clients()->save($client);
        }
    }
}
