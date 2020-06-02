<?php

namespace App\GraphQL\Web\Mutation;

use App\Models\CollectionData;
use GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;

class CreatePermissionCollectionMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreatePermissionCollectionMutation'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function type()
    {
        return Type::boolean() ;
    }

    public function args()
    {
        return [
            'collection_id' => [
                'type' => Type::string()
            ],
            'value' => [
                'type' => Type::string()
            ],
            'attribute' => [
                'type' => type::string()
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $collectionId = $args['collection_id'];
        $attribute = $args['attribute'];
        $value = $args['value'];
        $ColectionData = CollectionData::where('collection_id',$collectionId)->first();
        $ColectionData->$attribute = $value === "0"|| $value === "1" ? intval($value):$value; 
        $ColectionData->save();
        return true;
    }

    public function rules(array $args = [])
    {
        return [];
    }


}
