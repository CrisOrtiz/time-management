<?php

namespace App\Providers;

use App\Interfaces\UserRepositoryInterface;
use App\Repositories\ClientRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\ExpenseRepository;
use App\Repositories\LoanRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    private $menuAdded = false;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register repository interfaces
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(ClientRepository::class, ClientRepository::class);
        $this->app->bind(ExpenseRepository::class, ExpenseRepository::class);
        $this->app->bind(LoanRepository::class, LoanRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (!$this->menuAdded) {
                $this->menuAdded = true;

                $mystring = $this->app->request->getRequestUri();
                $collectionId = $this->app->request->route('collectionId');

                if (strrpos($mystring, "collection") !== false && $collectionId) {
                    $event->menu->add(
                        [
                            'text' => 'Clientes',
                            'icon' => 'fas fa-users',
                            'submenu' => [
                                [
                                    'text' => 'Listado de Clientes',
                                    'url' => '/collection/' . substr($mystring, strpos($mystring, 'collection') + 11, 32) . '/clients',
                                ]
                            ],
                        ],
                        [
                            'text' => 'Informacion cobro',
                            'icon' => 'fas fa-fw fa-indent',
                            'submenu' => [
                                [
                                    'text' => 'Reporte diario',
                                    'url' => '/collection/' . $collectionId . '/daily-report',
                                ],
                                [
                                    'text' => 'Lugar ultimo registro',
                                    'url' => '/collection/' . $collectionId . '/last-payment',
                                ],
                                [
                                    'text' => 'Posicion de clientes',
                                    'url' => '/collection/' . $collectionId . '/client-position',
                                ]
                            ]
                        ],
                        [
                            'text' => 'Notas',
                            'icon' => 'fas fa-fw fa-hand-holding-usd',
                            'submenu' => [
                                [
                                    'text' => 'Notas Cobro',
                                    'url' => '/collection/' . substr($mystring, strpos($mystring, 'collection') + 11, 32) . '/notes',
                                ],
                                [
                                    'text' => 'Notas cobro socio',
                                    'url' => '/collection/' . substr($mystring, strpos($mystring, 'collection') + 11, 32) . '/notes-partner',
                                ]
                            ]
                        ],
                        [
                            'text' => 'Nueva liquidada',
                            'icon' => 'fas fa-fw fa-hand-holding-usd',
                            'url' => '/collection/' . substr($mystring, strpos($mystring, 'collection') + 11, 32) . '/liquidation',
                        ],
                        [
                            'text' => 'Configuracion del cobro',
                            'icon' => 'fas fa-fw fa-cog',
                            'url' => '/collection/' . $collectionId . '/configuration',
                        ]
                    );
                }
            }
        });
    }
}
