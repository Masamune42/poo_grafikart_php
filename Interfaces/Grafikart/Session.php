<?php

namespace Grafikart;

/**
 * ArrayAccess => Permet d'accéder à un objet comme si c'était un tableau
 */
class Session implements SessionInterface, \Countable, \ArrayAccess
{
    public function __construct()
    {
        session_start();
    }

    public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

    // On redéfini la méthode count() implémentée par Countable
    public function count()
    {
        return 4;
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetExists($offset)
    {
        return isset($_SESSION[$offset]);
    }

    public function offsetUnset($offset)
    {
        return $this->delete($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
}
