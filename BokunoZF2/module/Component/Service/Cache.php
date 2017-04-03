<?php

namespace Component\Service;

use Component\Library\Core\ServiceInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Class Cache
 * @package Component\Service
 */
class Cache implements ServiceInterface, ServiceLocatorAwareInterface
{
    use \Component\Library\Traits\ServiceLocator;

    private $saveDir;

    private $baseDir;

    private $lifeTime;

    public function init()
    {
        $config = $this->getServiceLocator()->get('config');
        $path = $config['path']['cache'];
        $lifeTime = null;

        $this->lifeTime = ($lifeTime) ? (int)$lifeTime : 60 * 60;

        $this->baseDir = $path;
        if (is_dir($this->baseDir) === false) {
            mkdir($this->baseDir, 0744, true);
        }

        $this->saveDir = $this->baseDir;
    }

    /**
     * @param $path
     * @return $this
     */
    public function setDir($path)
    {
        $this->saveDir = $this->baseDir . $path;

        return $this;
    }

    /**
     * @param $data
     * @param $key
     *
     * @return int
     */
    public function save($data, $key)
    {
        $saveFile = $this->saveDir . "/" . $key;
        $serialData = serialize($data);

        return file_put_contents($saveFile, $serialData);
    }

    /**
     * @param $key
     *
     * @param bool $remove
     * @return bool|mixed
     */
    public function load($key, $remove = true)
    {
        $saveFile = $this->saveDir . "/" . $key;

        if (is_file($saveFile) === false) {
            return false;
        }

        if ($remove && (filemtime($saveFile) + $this->lifeTime < time())) {
            $this->remove($key);
            return false;
        }

        $serialData = file_get_contents($saveFile);
        return unserialize($serialData);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function remove($key)
    {
        return unlink($this->saveDir . "/" . $key);
    }
}