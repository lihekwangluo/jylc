<?php

/**
 * ServiceRedirection short summary.
 *
 * ServiceRedirection description.
 *
 * @version 1.0
 * @author codea
 */
namespace App\Http\Middleware;

use Closure;

class ServiceRedirection
{

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if($response->status() != 200){
            switch (LARAVEL_SERVICE_TYPE)
            {
                case 'WWW':
                    require '../old/index_old.php';
                    break;
                case 'ADMIN':
                    require '../old/admin_old.php';
                    break;
                case 'API':
                    require '../old/api/index_old.php';
                    break;
                case 'WX':
                    require '../old/wap/index_old.php';
                    break;
                case 'API_SECONDARY':
                    require '../../old/api/index_old.php';
                    break;
                case 'WX_SECONDARY':
                    require '../../old/wap/index_old.php';
                    break;
                default:
                    break;

            }
            exit;
        }else{
            return $response;
        }
    }
}