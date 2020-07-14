<?php

    namespace App\Http\Middleware;

    use Closure;
    use JWTAuth;
    use Exception;
 

    class HttpsMiddleware 
    {

        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {

            $url = parse_url(url());
             if($url['scheme'] !== 'https'){
               return response('Only Https Allowed',400); 
                exit;
                }
          
            return $next($request);
        }
    }