<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Client;
use App\Models\Collection;
use App\Models\User;
use App\Models\UserAppData;

class ClientRepository
{
    public function createClient($collectionId, $clientData)
    {
        $worker = auth()->user();
        $collection = $worker->collections()->find($collectionId);
        if (!$collection) {
            return;
        }

        $client = new Client();
        $client->id = $clientData['id'];
        $client->cupo = $clientData['cupo'];
        $client->collection_id = $collectionId;
        $client->available_cupo = $clientData['available_cupo'];
        $client->identity_number = $clientData['identity_number'];
        $client->name = $clientData['name'];
        $client->surname = $clientData['surname'];
        $client->phone = $clientData['phone'];
        $client->address = $clientData['address'];
        $client->business = $clientData['business'];
        $client->guarantor_name = $clientData['guarantor_name'];
        $client->guarantor_phone = $clientData['guarantor_phone'];
        $client->guarantor_address = $clientData['guarantor_address'];
        $client->latitude = $clientData['latitude'] ?? null;
        $client->cos_lat = $clientData['cos_lat'] ?? null;
        $client->sin_lat = $clientData['sin_lat'] ?? null;
        $client->longitude = $clientData['longitude'] ?? null;
        $client->cos_lng = $clientData['cos_lng'] ?? null;
        $client->sin_lng = $clientData['sin_lng'] ?? null;
        $client->created_by = $worker->id;
        $client->assigned_to = $worker->id;
        $client->save();

        return $client;
    }

    public function updateClient($collectionId, Client $client, $clientData)
    {
        $worker = auth()->user();
        $collection = $worker->collections()->find($collectionId);
        if (!$collection) {
            return;
        }
        $client->available_cupo = $clientData['available_cupo'];
        $client->save();
    }
}
