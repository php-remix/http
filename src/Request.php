<?php

namespace PhpRemix\Http;

use Symfony\Component\HttpFoundation\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * 请注意，该方法并不是获取$_GET的方式
     * 它会遍历所有bag来获取参数
     * 若要获取$_GET，请使用query方法
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return parent::get($key, $default);
    }

    /**
     * 获取$_GET
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function query($key = null, $default = null)
    {
        return $this->retrieveItem('query', $key, $default);
    }

    /**
     * 获取$_POST
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function post($key = null, $default = null)
    {
        return $this->retrieveItem('request', $key, $default);
    }

    /**
     * 获取$_SERVER
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function server($key = null, $default = null)
    {
        return $this->retrieveItem('server', $key, $default);
    }

    /**
     * 获取$_FILES
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function file($key = null, $default = null)
    {
        return $this->retrieveItem('files', $key, $default);
    }

    /**
     * 获取$_COOKIE
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function cookie($key = null, $default = null)
    {
        return $this->retrieveItem('cookies', $key, $default);
    }

    /**
     * 获取header
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function header($key = null, $default = null)
    {
        return $this->retrieveItem('headers', $key, $default);
    }

    /**
     * Retrieve a parameter item from a given source.
     *
     * @param string $source
     * @param string $key
     * @param string|array|null $default
     * @return string|array|null
     */
    protected function retrieveItem(string $source, string $key, $default)
    {
        if (is_null($key)) {
            return $this->$source->all();
        }

        return $this->$source->get($key, $default);
    }

    /**
     * 获取所有参数
     *
     * @return array|null
     */
    public function all(): ?array
    {
        return array_replace_recursive($this->query->all(), $this->request->all(), $this->files->all());
    }

    /**
     * 在一群参数中是否存在某个参数
     *
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->all());
    }

    /**
     * $_GET参数是否存在
     *
     * @param $key
     * @return bool
     */
    public function hasQuery($key): bool
    {
        return $this->query->has($key);
    }

    /**
     * $_POST参数是否存在
     *
     * @param $key
     * @return bool
     */
    public function hasPost($key): bool
    {
        return $this->request->has($key);
    }

    /**
     * $_SERVER参数是否存在
     *
     * @param $key
     * @return bool
     */
    public function hasServer($key): bool
    {
        return $this->server->has($key);
    }

    /**
     * $_FILES参数是否存在
     *
     * @param $key
     * @return bool
     */
    public function hasFile($key): bool
    {
        return $this->files->has($key);
    }

    /**
     * header是否存在
     *
     * @param $key
     * @return bool
     */
    public function hasHeader($key): bool
    {
        return $this->headers->has($key);
    }

    /**
     * $_COOKIE参数是否存在
     *
     * @param $key
     * @return bool
     */
    public function hasCookie($key): bool
    {
        return $this->cookies->has($key);
    }
}