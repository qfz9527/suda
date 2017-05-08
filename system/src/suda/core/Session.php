<?php
namespace suda\core;

class Session
{
    protected static $instance;
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance=new  self;
        }
        return self::$instance;
    }
    
    protected function __construct()
    {
        $path=DATA_DIR.'/session';
        Storage::mkdirs($path);
        session_save_path($path);
        session_name(conf('session.name', 'session'));
        session_cache_limiter(conf('session.limiter', 'private'));
        session_cache_expire(conf('session.expire', 0));
        session_start();
    }
    public static function set(string $name, $value)
    {
        $_SESSION[$name]=$value;
        return isset($_SESSION[$name]);
    }

    public static function get(string $name='', $default=null)
    {
        if ($name) {
            return isset($_SESSION[$name])?$_SESSION[$name]:$default;
        } else {
            return $_SESSION;
        }
    }

    public static function has(string $name)
    {
        return isset($_SESSION[$name]);
    }
    public static function destroy()
    {
        session_unset();
    }
}
