<?php 
/**
 * @package stgsuiteapp
 */
namespace Inc;

final class Init
{
    /**
     * Store array of all list of classes 
     * @return array return array of classes 
     * */
    public static function get_services()
    {
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\EnqueueFrontendscripts::class,
            Base\SettingsLinks::class,
            Base\DomainController::class,
            // Base\SettingsPageController::class
        ];
    }

    /**
     * Loop through classes initialize them
     * and call the register() function if it exsists()
     * @return
     * */
    public static function register_services()
    {
        foreach (self::get_services() as $class) {
            $service = self::instantiate( $class );
            if( method_exists($service, 'register' ) )
            {
                $service->register();
            }
        }
    }

    /**
     * Function that initialize each class under
     * services
     * @return class object
     * */
    public static function instantiate( $class )
    {
        $service = new $class();

        return $service;
    }
}