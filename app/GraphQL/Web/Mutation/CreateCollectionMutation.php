<?php

namespace App\GraphQL\Web\Mutation;

use App\Models\Collection;
use App\Models\CollectionData;
use GraphQL;
use Illuminate\Validation\Rule;
use Rebing\GraphQL\Support\Mutation;

class CreateCollectionMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateCollectionMutation'
    ];

    public function type()
    {
        return GraphQL::type('Collection');
    }

    public function args()
    {
        return [
            'collection' => [
                'type' => GraphQL::type('CreateCollectionInput')
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $data = $args['collection'];
        $collection = new Collection();
        $collection->name = $data['name'];
        $collection->default_installment_number = $data['default_installment_number'];
        $collection->default_interest = $data['default_interest'];
        $collection->currency = $data['currency'];
        $collection->company_id = $data['company'];
        if (isset($data['worker'])) {
            $collection->worker_id = $data['worker'];
        }
        $collection->save();
        $collectionData = new CollectionData(
            [
                'minimunQuota'=>14,
                'lockClientChoosed'=> true,
                'requireApprovalCredit'=>false,
                'considerQuota'=>10,
                'weekPay'=>true,
                'requireApproval' =>true, 
                'quotaActivated'=>true,
                'quotaVisible'=>true,
                'defaultQuota'=>500,
                'lockLaterDates'=>true,
                'lockChangeInteres'=>true,
                'showComission'=>true,
                'percentComission'=>0,03,
                'showLastDate'=>true,
                'showBox'=>true,
                'showCollectionLiquid'=> true,
                'showCollectionDay'=> true,
                'showSales'=> true,
                'showWithoutConexion'=>false,
                'guaranteeClient'=>true,
                'interesCalculation'=>true,
                'yellow'=>'Amarillo',
                'blue'=>'PRESTAR IGUAL VALOR',
                'red'=>'CLIENTE MALO',
                'green'=>'CLIENTE EXCELENTE',
                'orange'=>'BAJAR CREDITO',
                'applyColorToClient'=>true,
                'visibleColors'=>true,
                'highPrecision'=>true,
                'collection_id'=>$collection->id,
            ]);
            $collectionData->save();
       
        return $collection;
    }
}
