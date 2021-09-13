<?php
namespace Spirit1086\Restfull\Traits;

trait ApiMessage
{
    public static $NOTFOUND = 'The item not found';
    public static $DELETED = 'The item deleted';
    public static $SUCCESS = 'The request has been processed successfully';
    public static $UNAUTH = 'Unauthorized';

    /**
     * @return array
     */
    public static function notFoundResponse():object
    {
        $response = new \stdClass();
        $response->success = false;
        $response->message = static::$NOTFOUND;
        return $response;
    }

    public static function unAuth():object
    {
        $response = new \stdClass();
        $response->success = false;
        $response->message = static::$UNAUTH;
        return $response;
    }
}
