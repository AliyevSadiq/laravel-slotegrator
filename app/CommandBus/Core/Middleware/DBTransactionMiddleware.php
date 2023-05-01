<?php
declare(strict_types=1);

namespace App\CommandBus\Core\Middleware;

use Exception;
use Illuminate\Support\Facades\DB;
use League\Tactician\Middleware;
use Throwable;

class DBTransactionMiddleware implements Middleware
{

    /**
     * @throws Throwable
     */
    public function execute($command, callable $next)
    {
        DB::beginTransaction();

        try {
            $next($command);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            logger()->error('Error occurred while storing.', compact('e'));
            throw $e;
        }
    }
}
