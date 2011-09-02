<?php

namespace Zf2Mvc;

use Zend\EventManager\EventCollection,
    Zend\EventManager\EventManager;

class Application implements AppContext
{
    protected $events;
    protected $locator;

    /**
     * Set the event manager instance used by this context
     * 
     * @param  EventCollection $events 
     * @return AppContext
     */
    public function setEventManager(EventCollection $events)
    {
        $this->events = $events;
        return $this;
    }

    /**
     * Set a service locator object
     *
     * Since the DI DependencyInjection and ServiceLocation objects do not 
     * share a common interface, we will not specify an interface here. That
     * said, both implement the same "get()" method signature, and this is 
     * what we will enforce.
     * 
     * @param  mixed $locator 
     * @return AppContext
     */
    public function setLocator($locator)
    {
        if (!is_object($locator)) {
            throw new Exception\InvalidArgumentException('Locator must be an object');
        }
        if (!method_exists($locator, 'get')) {
            throw new Exception\InvalidArgumentException('Locator must implement a "get()" method');
        }
        $this->locator = $locator;
        return $this;
    }

    /**
     * Set the router used to decompose the request
     *
     * A router should return a metadata object containing a controller key.
     * 
     * @param  Router $router 
     * @return AppContext
     */
    public function setRouter(Router $router)
    {
    }

    /**
     * Get the locator object
     * 
     * @return null|object
     */
    public function getLocator()
    {
        return $this->locator;
    }

    /**
     * Get the router object
     * 
     * @return Router
     */
    public function getRouter()
    {
    }

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     * 
     * @return EventCollection
     */
    public function events()
    {
        if (!$this->events instanceof EventCollection) {
            $this->setEventManager(new EventManager(array(__CLASS__, get_class($this))));
        }
        return $this->events;
    }

    /**
     * Run the application
     * 
     * @return \Zend\Http\Response
     */
    public function run()
    {
    }
}
