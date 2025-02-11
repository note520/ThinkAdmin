<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\queue\task;

use library\command\Task;
use think\console\Input;
use think\console\Output;

/**
 * 检查并创建异步任务监听主进程
 * Class Start
 * @package app\admin\queue\task
 */
class Start extends Task
{

    /**
     * 指令属性配置
     */
    protected function configure()
    {
        $this->setName('xtask:start')->setDescription('创建异步任务监听守护主进程');
    }

    /**
     * 执行启动操作
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        $this->cmd = "{$this->bin} xtask:listen";
        if (($pid = $this->checkProcess()) > 0) {
            $output->info("异步任务监听主进程{$pid}已经启动！");
        } else {
            $this->createProcess();
            if (($pid = $this->checkProcess()) > 0) {
                $output->info("异步任务监听主进程{$pid}启动成功！");
            } else {
                $output->error('异步任务监听主进程创建失败！');
            }
        }
    }
}
