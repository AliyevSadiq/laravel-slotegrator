<?php

namespace App\Providers;

use App\CommandBus\Core\ClassNameLocator;
use App\CommandBus\Core\CommandBus;
use App\CommandBus\Core\Contract\CommandBusInterface;
use App\CommandBus\Core\Middleware\DBTransactionMiddleware;
use Illuminate\Support\ServiceProvider;
use League\Tactician\CommandBus as TacticianCommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;


class CommandBusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CommandBusInterface::class, function () {
            return new CommandBus(new TacticianCommandBus([
                new DBTransactionMiddleware(),
                new CommandHandlerMiddleware(
                    new ClassNameExtractor(),
                    new ClassNameLocator(),
                    new HandleInflector()
                )
            ]));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
