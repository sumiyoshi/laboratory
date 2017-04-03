<?php

namespace Generator\Controller;

ini_set('display_errors', 0);
error_reporting(0);

define('BUILDER_DIR', dirname(dirname(dirname(dirname(__FILE__)))));
define('CONIFG_DIR', dirname(dirname(dirname(dirname(__FILE__)))) . '/config/');
define('WEBAPP_DIR', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/module/");

use Component\Library\Traits\Builder;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    use Builder;

    /**
     * DB関連Class生成
     */
    public function tableAction()
    {

        //テーブル情報取得
        $list = $this->getFileData(CONIFG_DIR . 'db');

        //twig
        $view = $this->getView();

        #region 設定ファイルごとにClass生成
        foreach ($list as $data) {

            $table = $data['table'];
            $data['primary_key'] = $this->getPrimary($data['columns']);

            #region ディレクトリのパス
            if (trim($table["category"]) != "") {
                $entity_dir = WEBAPP_DIR . "Component/Data/Entity/" . ucfirst(trim($table["category"])) . "/";
                $table_dir = WEBAPP_DIR . "Component/Data/Table/" . ucfirst(trim($table["category"])) . "/";
                $record_dir = WEBAPP_DIR . "Component/Data/Model/" . ucfirst(trim($table["category"])) . "/";
            } else {
                $entity_dir = WEBAPP_DIR . "Component/Data/Entity/";
                $table_dir = WEBAPP_DIR . "Component/Data/Table/";
                $record_dir = WEBAPP_DIR . "Component/Data/Model/";
            }
            #endregion

            #region ディレクトリ生成
            $this->mkDir($entity_dir);
            $this->mkDir($table_dir);
            $this->mkDir($record_dir);
            #endregion

            #region Class名
            $class_entity = $table["php_name"] . "Entity.php";
            $class_table = $table["php_name"] . "Table.php";
            $class_model = $table["php_name"] . "Model.php";
            #endregion

            #region view読み込み
            $entity_view = $this->getTemplate('entity.twig');
            $table_view = $this->getTemplate('table.twig');
            $model_view = $this->getTemplate('record.twig');
            #endregion

            #region ファイル生成
            $this->output($entity_dir . $class_entity, $view->render($entity_view, compact('data')), true);
            $this->output($table_dir . $class_table, $view->render($table_view, compact('data')), false);
            $this->output($record_dir . $class_model, $view->render($model_view, compact('data')), false);
            #endregion
        }

        #endregion

        echo " Build complete!\n";
    }

    /**
     * オペレーション生成
     */
    public function operationAction()
    {
        /** @var \Zend\Console\Request $request */
        $request = $this->getRequest();

        $table = $request->getParam('table');
        $data = $this->getFileData(CONIFG_DIR . 'db', $table);
        $data = $data[0];
        $view = $this->getView();

        $table = $data['table'];
        $data['primary_key'] = $this->getPrimary($data['columns']);

        #region ディレクトリのパス
        if (trim($table["category"]) != "") {
            $operation_dir = WEBAPP_DIR . "Component/Operation/" . ucfirst(trim($table["category"])) . "/" . $this->snakeToCamel(trim($table["name"])) . "/";
        } else {
            $operation_dir = WEBAPP_DIR . "Component/Operation/" . $this->snakeToCamel(trim($table["name"])) . "/";
        }
        #endregion

        //ディレクトリ生成
        $this->mkDir($operation_dir);

        #region Class名
        $class_save = "SaveOperation.php";
        $class_delete = "DeleteOperation.php";
        #endregion

        #region view読み込み
        $save_view = $this->getTemplate('save_op.twig');
        $delete_view = $this->getTemplate('delete_op.twig');
        #endregion

        #region ファイル生成
        $this->output($operation_dir . $class_save, $view->render($save_view, compact('data')), false);
        $this->output($operation_dir . $class_delete, $view->render($delete_view, compact('data')), false);
        #endregion

        echo " Build complete!\n";
    }

    /**
     * スキーマ作成
     */
    public function schemaAction()
    {
        $schema_dir = CONIFG_DIR . 'db/';

        //twig
        $view = $this->getView();

        //ディレクトリ生成
        $this->mkDir($schema_dir);

        #region DBの情報取得
        /** @var \Zend\Db\Adapter\Adapter $adapter */
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $result = $adapter->query('SHOW TABLES', $adapter::QUERY_MODE_EXECUTE);
        $tables = array();
        /** @var \ArrayObject $table */
        foreach ($result as $table) {
            $_table = $table->getArrayCopy();
            $tables[] = array_shift($_table);
        }
        #endregion

        #region 設定ファイル生成
        foreach ($tables as $table) {
            $php_name = $this->snakeToCamel($table);

            $result = $adapter->query("SHOW FULL COLUMNS FROM {$table}", $adapter::QUERY_MODE_EXECUTE);
            $columns = array();
            /** @var \ArrayObject $row */
            foreach ($result as $row) {

                $_row = $row->getArrayCopy();
                preg_match("/(.*)\((.*)\)(.*)/is", $_row['Type'], $retArr);

                if ((bool)$retArr) {
                    $_row['Type'] = $retArr[1];
                    $_row['Size'] = $retArr[2];
                } else {
                    $_row['Size'] = '';
                }
                $columns[] = $_row;
            }

            $xml_name = $table . ".xml";
            $template = $this->getTemplate('schema.twig');
            $this->output($schema_dir . $xml_name, $view->render($template, compact('table', 'php_name', 'columns')), true);
        }
        #endregion

        echo " Build complete!\n";
    }

    /**
     * アプリケーションモジュール追加
     */
    public function appAction()
    {
        /** @var \Zend\Console\Request $request */
        $request = $this->getRequest();

        $module = $request->getParam('module');

        #region ディレクトリのパス
        $module_dir = WEBAPP_DIR . "App/src/" . ucfirst(trim($module));
        $controller_dir = WEBAPP_DIR . "App/src/" . ucfirst(trim($module)) . "/Controller";
        $view_model_dir = WEBAPP_DIR . "App/src/" . ucfirst(trim($module)) . "/ViewModel";
        $view_dir = WEBAPP_DIR . "App/view/" . lcfirst(trim($module));
        $layout_dir = WEBAPP_DIR . "App/view/layout/";
        #endregion

        #region ディレクトリ生成
        $this->mkDir($module_dir);
        $this->mkDir($controller_dir);
        $this->mkDir($view_model_dir);
        $this->mkDir($view_dir);
        #endregion

        #region 生成済みの情報取得
        $config = array();
        if (file_exists(WEBAPP_DIR . 'App/config/namespaces_map.config.php')) {
            $config = include(WEBAPP_DIR . 'App/config/namespaces_map.config.php');

            if (!isset($config[ucfirst(trim($module))])) {
                $config[ucfirst(trim($module))] = true;
            }
        } else {
            $config[ucfirst(trim($module))] = true;
        }
        #endregion

        $name = "namespaces_map.config.php";

        #region view読み込み
        $template = $this->getTemplate('namespaces_map.twig');
        $layout_view = $this->getTemplate('layout.twig');
        #endregion

        #region ファイル生成
        $this->output(WEBAPP_DIR . 'App/config/' . $name, $this->getView()->render($template, ['names' => array_keys($config)]), true);
        $this->output($layout_dir . 'layout_' . trim($module) . '.twig', $this->getView()->render($layout_view, []), false);
        #endregion

        echo " Build complete!\n\n";
    }

    /**
     * コントロラー作成
     */
    public function controllerAction()
    {
        /** @var \Zend\Console\Request $request */
        $request = $this->getRequest();

        $view = $this->getView();

        $namespace = $request->getParam('namespace');
        $_namespace = explode('_', $namespace);

        if (count($_namespace) != 2) {
            echo " させるか!\n";
            exit;
        }

        $module = $_namespace[0];
        $controller = $_namespace[1];

        #region ディレクトリのパス
        $controller_dir = WEBAPP_DIR . "App/src/" . ucfirst(trim($module)) . "/Controller/";
        $view_model_dir = WEBAPP_DIR . "App/src/" . ucfirst(trim($module)) . "/ViewModel/";
        $view_dir = WEBAPP_DIR . "App/view/" . lcfirst(trim($module)) . '/' . lcfirst(trim($controller)) . '/';
        #endregion

        $config_file = WEBAPP_DIR . "App/config/{$module}_router.config.php";

        $this->mkDir($view_dir);

        #region view読み込み
        $controller_view = $this->getTemplate('controller.twig');
        $view_model_view = $this->getTemplate('view_model.twig');
        $config_view = $this->getTemplate('config.twig');
        $twig_view = $this->getTemplate('twig_view.twig');
        #endregion

        #region データ・セット
        $data = array(
            'controller' => ucfirst(trim($controller)),
            '_controller' => trim($controller),
            'module' => ucfirst(trim($module)),
            '_module' => trim($module),
        );
        #endregion

        #region 生成済みの情報取得
        $config = include($config_file);

        $data['_routes'] = $config['routes'];

        if (!isset($config['routes'][trim($module).'_'.$controller])) {
            $data['config']['routes'][trim($module).'_'.$controller] = array(
                'options' => array(
                    "defaults" =>
                        array(
                            "controller" => ucfirst(trim($module)) . '\Controller\\' . ucfirst(trim($controller)),
                        )
                )
            );
        }

        if (!isset($config['controllers'][ucfirst(trim($module)) . '\Controller\\' . ucfirst(trim($controller))])) {
            $config['controllers'][ucfirst(trim($module)) . '\Controller\\' . ucfirst(trim($controller))] = ucfirst(trim($module)) . '\Controller\\' . ucfirst(trim($controller)) . "Controller";
        }

        if (!isset($config[ucfirst(trim($module))])) {
            $config[ucfirst(trim($module))] = true;
        }
        #endregion

        $data['config']['controllers'] = $config['controllers'];

        #region デフォルトのモジュール
        $conf = $this->getServiceLocator()->get('config');
        $default_module = '';
        if (isset($conf['app_module']['default'])) {
            $default_module = $conf['app_module']['default'];
        }
        $data['default_module'] = $default_module;
        #endregion

        #region ファイル生成
        $this->output($controller_dir . ucfirst(trim($controller)) . 'Controller.php', $view->render($controller_view, $data), false);
        $this->output($view_model_dir . ucfirst(trim($controller)) . 'ViewModel.php', $view->render($view_model_view, $data), false);
        $this->output($view_dir . "index.twig", $view->render($twig_view, $data), false);
        $this->output($config_file, $view->render($config_view, $data), true);
        #endregion

        echo " Build complete!\n\n";
    }

}