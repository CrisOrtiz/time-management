<?php

return [

    'prefix' => 'graphql',

    'routes' => '{graphql_schema?}',

    'controllers' => \Rebing\GraphQL\GraphQLController::class . '@query',

    'middleware' => [],

    'route_group_attributes' => [],

    'default_schema' => 'mobile',

    'schemas' => [
        'mobile' => [
            'query' => [
                'payloads' => \App\GraphQL\Query\AuthPayloadQuery::class
            ],
            'mutation' => [
                'authenticateUser'  => \App\GraphQL\Mobile\Mutation\AuthenticateUserMutation::class,
            ],
            'middleware' => ['api', 'allow.only.mobile.users'],
            'method' => ['get', 'post'],
        ],
        'web' => [
            'query' => [
                'payloads' => \App\GraphQL\Query\AuthPayloadQuery::class,
                'listUser' => \App\GraphQL\Web\Query\ListUserQuery::class,
                'listCompany' => \App\GraphQL\Web\Query\ListCompanyQuery::class,
                'listClient' => \App\GraphQL\Web\Query\ListClientQuery::class,
                'listCollection' => \App\GraphQL\Web\Query\ListCollectionQuery::class,
                'listUserPermission' => \App\GraphQL\Web\Query\ListUserPermissionQuery::class
            ],
            'mutation' => [
                'authenticateUser'  => \App\GraphQL\Web\Mutation\AuthenticateUserMutation::class,
                // User
                'createUser'  => \App\GraphQL\Web\Mutation\CreateUserMutation::class,
                'updateUser'  => \App\GraphQL\Web\Mutation\UpdateUserMutation::class,
                'deleteUser'  => \App\GraphQL\Web\Mutation\DeleteUserMutation::class,
                // Company
                'createCompany'  => \App\GraphQL\Web\Mutation\CreateCompanyMutation::class,
                'updateCompany'  => \App\GraphQL\Web\Mutation\UpdateCompanyMutation::class,
                'deleteCompany'  => \App\GraphQL\Web\Mutation\DeleteCompanyMutation::class,
                //Client
                'createClient'  => \App\GraphQL\Web\Mutation\CreateClientMutation::class,
                'createCollection' => \App\GraphQL\Web\Mutation\CreateCollectionMutation::class,
                //permission
                'updateUserPermissions'  => \App\GraphQL\Web\Mutation\UpdateUserPermissionsMutation::class,
                //collection
                'createPermissionCollection' => \App\GraphQL\Web\Mutation\CreatePermissionCollectionMutation::class,
            ],
            'middleware' => ['api', 'allow.only.web.users'],
            'method' => ['get', 'post'],
        ],
    ],

    'types' => [
        'AuthPayload' => \App\GraphQL\Type\AuthPayloadType::class,
        'Company' => \App\GraphQL\Type\CompanyType::class,
        'User' => \App\GraphQL\Type\UserType::class,
        'Client' => \App\GraphQL\Type\ClientType::class,
        'Collection' => \App\GraphQL\Type\CollectionType::class,
        'UserPermision' => \App\GraphQL\Type\UserPermissionType::class,
        'Permission' => \App\GraphQL\Type\PermissionType::class,
        // Responses
        'ListCompanyResponse' => \App\GraphQL\Web\ResponseType\ListCompanyResponse::class,
        'ListCollectionResponse' => \App\GraphQL\Web\ResponseType\ListCollectionResponse::class,
        'ListUserResponse' => \App\GraphQL\Web\ResponseType\ListUserResponse::class,
        'ListClientResponse' => \App\GraphQL\Web\ResponseType\ListClientResponse::class,
        'ListPermissionResponse' => \App\GraphQL\Web\ResponseType\ListPermissionResponse::class,
        // Inputs
        'CreateCollectionInput' => \App\GraphQL\Web\Inputs\CreateCollectionInput::class,
        'CreateUserInput' => \App\GraphQL\Web\Inputs\CreateUserInput::class,
        'UpdateUserInput' => \App\GraphQL\Web\Inputs\UpdateUserInput::class,
        'GridFiltersInput' => \App\GraphQL\Web\Inputs\GridFiltersInput::class,
        // Ag Grid
        'AgGridColumn' => \App\GraphQL\Inputs\AgGrid\AgGridColumn::class,
        'AgGridFilter' => \App\GraphQL\Inputs\AgGrid\AgGridFilter::class,
        'AgGridSort' => \App\GraphQL\Inputs\AgGrid\AgGridSort::class
    ],

    'error_formatter' => ['\Rebing\GraphQL\GraphQL', 'formatError'],

    'errors_handler' => ['\Rebing\GraphQL\GraphQL', 'handleErrors'],

    'params_key'    => 'variables',

    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false
    ],

    'pagination_type' => \Rebing\GraphQL\Support\PaginationType::class,

    'graphiql' => [
        'prefix' => '/graphiql/{graphql_schema?}',
        'controller' => \Rebing\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => [],
        'view' => 'graphql::graphiql',
        'display' => env('ENABLE_GRAPHIQL', true),
    ],
];
