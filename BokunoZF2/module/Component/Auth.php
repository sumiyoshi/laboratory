<?php

namespace Component;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Component\Data\Base\AbstractModel;

class Auth implements ServiceLocatorAwareInterface
{
    use \Component\Library\Traits\ServiceLocator;

    /** @var  AuthenticationService */
    protected $auth;

    /** @var \Component\Data\Base\AbstractTable */
    protected $table;

    /** @var  string */
    private $identity_name;

    /** @var  string */
    private $password_name;

    public function init($name_space, $identity_name, $password_name, $table_name)
    {
        $this->identity_name = $identity_name;
        $this->password_name = $password_name;
        $this->table = $this->getServiceLocator()->get($table_name);

        // 認証情報を取得する
        $this->auth = new AuthenticationService(new SessionStorage($name_space));

    }

    /**
     * ログイン処理
     *
     * @param $key
     * @param $pass
     * @return bool
     */
    public function login($key, $pass)
    {

        $select = $this->table->getSelectSql();

        //条件
        $select->where->equalTo($this->identity_name, $key);
        $select->where->equalTo($this->password_name, $pass);

        //データ取得
        /** @var  AbstractModel $user */
        $user = $this->table->find(array(), $select);

        if ($user) {
            /** @var \Zend\Authentication\Storage\Session $storage */
            $storage = $this->auth->getStorage();

            $storage->write($user->toArray());

            return true;
        } else {
            return false;
        }
    }

    /**
     * ログアウト
     */
    public function logout()
    {
        // ストレージと認証情報を破棄する
        $this->auth->getStorage()->clear();
        $this->auth->clearIdentity();
    }

    /**
     * ログインチェック
     *
     * @return bool
     */
    public function hasLogin()
    {
        // ログイン確認
        if ($this->auth->hasIdentity()) {
            return true;
        }
        return false;
    }

    /**
     * ログイン情報取得
     *
     * @return AbstractModel
     */
    public function getLoginUser()
    {
        // ログイン確認
        if ($this->auth->hasIdentity()) {
            // ログイン情報を取得する
            $identity = $this->auth->getIdentity();

            $keys = [];
            foreach ($this->table->getPrimaryKeys() as $key) {
                $keys[$key] = $identity[$key];
            }

            return $this->table->findByPrimaryKey($keys);
        }
        return false;
    }
}