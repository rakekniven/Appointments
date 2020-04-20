<?php
namespace OCA\Appointments\Migration;

use OCA\Appointments\Backend\BackendUtils;
use OCP\IConfig;
use OCP\Migration\IOutput;
use OCP\Migration\IRepairStep;

class InstallHook implements IRepairStep{

    private $config;
    private $appName;
    private $userId;

    /**
     * @param $AppName
     * @param $UserId
     * @param IConfig $config
     */
    public function __construct($AppName,
                                $UserId,
                                IConfig $config){
        $this->config=$config;
        $this->appName=$AppName;
        $this->userId=$UserId;
    }

    /**
     * @inheritDoc
     */
    public function getName(){
        return 'Install hook for Appointments app';
    }

    /**
     * @inheritDoc
     */
    public function run(IOutput $output)
    {
        if(empty($this->config->getAppValue($this->appName,'hk'))){
            $this->config->setAppValue($this->appName, 'hk',
                bin2hex(openssl_random_pseudo_bytes(32, $is_good)));
        }
        if(empty($this->config->getAppValue($this->appName,'tiv'))) {
            $this->config->setAppValue($this->appName, 'tiv',
                bin2hex(openssl_random_pseudo_bytes(
                    openssl_cipher_iv_length(BackendUtils::CIPHER),
                    $is_good)));
        }
        $output->info("appointments InstallHook finished");
    }
}