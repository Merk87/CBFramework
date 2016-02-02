<?php

namespace Merkury\Url;

class Route
{
    private static $_get = [];
    private static $_post = [];

    /**
     * @var \Merkury\Url\Uri
     */
    private static $_uri;

    /**
     * @param string $uri
     * @param string $controller
     * @param string $action
     * @return \Merkury\Url\Uri
     */
    public static function get($uri, $controller, $action)
    {
        return self::$_get[] = new \Merkury\Url\Uri($uri, $controller, $action);
    }

    /**
     * @param string $uri
     * @param string $controller
     * @param string $action
     * @return \Merkury\Url\Uri
     */
    public static function post($uri, $controller, $action)
    {
        return self::$_post[] = new \Merkury\Url\Uri($uri, $controller, $action);
    }

    /**
     *
     * @param \Merkury\Http\Request $request
     * @return \Merkury\Url\Uri
     */
    public static function match(\Merkury\Http\Request $request)
    {
        $method = $request->isPost() ? '_post' : '_get';

        try {
            foreach (self::${$method} as self::$_uri) {
                if (self::$_uri->match($request->server('REQUEST_URI'))) {
                    return self::$_uri;
                }
                // else{
                //     throw new \Exception('Page not found');
                // }

            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }

        return false;
    }



}
