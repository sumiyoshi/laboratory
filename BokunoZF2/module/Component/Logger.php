<?php
namespace Component;

use Zend\Log\Writer\Stream;
use Zend\Log\Logger as ZendLogger;
use Zend\Log\Filter\Priority;

/**
 * Class Logger
 *
 * @package Component\Service
 */
class Logger
{

    private static $logger;

    /**
     * @param $log_path
     * @return ZendLogger
     */
    public static function getLogger($log_path)
    {
        if (!self::$logger) {
            #region ディレクトリ生成
            $date = date('Ym');
            $error_dir = $log_path . 'error/' . $date . '/';
            $info_dir = $log_path . 'info/' . $date . '/';

            if (!file_exists($error_dir)) {
                @mkdir($error_dir, 0777);
            };

            if (!file_exists($info_dir)) {
                @mkdir($info_dir, 0777);
            };
            #endregion

            #region log初期設定

            $logger = new ZendLogger();

            $writer_err = new Stream($error_dir . date('Y-m-d') . '.log');
            $writer_info = new Stream($info_dir . date('Y-m-d') . '.log');
            //エラーログの出力レベル変更
            $filter = new Priority(ZendLogger::WARN);
            $writer_err->addFilter($filter);

            $logger->addWriter($writer_err);
            $logger->addWriter($writer_info);
            #endregion

            self::$logger = $logger;
        }

        return self::$logger;
    }


}