<?php

class Adcloud_Client
{
    /**
     * @var Adcloud_Backend
     */
    private $backend;

    /**
     * @var string
     */
    private $requestClass = "Adcloud_Request_Http";

    /**
     * @param string $code
     * @param strign $secret
     */
    public function __construct($code, $secret)
    {
        $backend = new Adcloud_Backend_Curl($code, $secret);
        $this->setBackend($backend);
    }

    /**
     * @param Adcloud_Backend $backend
     * @return Adcloud_Client
     */
    public function setBackend(Adcloud_Backend $backend)
    {
        $this->backend = $backend;
        return $this;
    }

    /**
     * @return Adcloud_Backend
     */
    public function getBackend()
    {
        return $this->backend;
    }

    /**
     * @return Adcloud_Client
     */
    public function authorize()
    {
        $this->backend->authorize();
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAuthorized()
    {
        return $this->backend->isAuthorized();
    }

    /**
     * @param string $method
     * @return Adcloud_Request
     */
    public function request($method)
    {
        return new $this->requestClass($method, $this);
    }

    /**
     * @param Adcloud_Request $request
     * @return Adcloud_Response
     */
    public function execute(Adcloud_Request $request)
    {
        return $this->backend->execute($request);
    }
}
