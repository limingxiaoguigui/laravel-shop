<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-18 20:33:37
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-18 21:33:00
 */

namespace App\Console\Commands\Cron;

use App\Jobs\RefundCrowdfundingOrders;
use App\Services\OrderService;
use App\Models\CrowdfundingProduct;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FinishCrowdfunding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:finish-crowdfunding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '结束众筹';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        CrowdfundingProduct::query()
            //众筹结束时间早于当前时间
            ->where('end_at', '<=', Carbon::now())
            //众筹状态为众筹中
            ->where('status', CrowdfundingProduct::STATUS_FUNDING)
            ->get()
            ->each(function (CrowdfundingProduct $crowdfunding) {
                //如果众筹目标金额大于实际金额
                if ($crowdfunding->target_amount > $crowdfunding->total_amount) {
                    //调用众筹失败逻辑
                    $this->crowdfundingFailed($crowdfunding);
                } else {
                    $this->crowdfundingSucceed($crowdfunding);
                }
            });
    }
    /**
     * 众筹成功
     * @param \App\Models\CrowdfundingProduct $crowdfunding
     * @return void
     */
    protected function crowdfundingSucceed(CrowdfundingProduct $crowdfunding)
    {
        //只需将众筹状态改为众筹成功即可
        $crowdfunding->update(['status' => CrowdfundingProduct::STATUS_SUCCESS]);
    }
    /**
     * 众筹失败
     * @param \App\Models\CrowdfundingProduct $crowdfunding
     * @return void
     */
    protected function crowdfundingFailed(CrowdfundingProduct $crowdfunding)
    {
        //将众筹状态改为失败
        $crowdfunding->update(['status' => CrowdfundingProduct::STATUS_FAIL]);
        dispatch(new RefundCrowdfundingOrders($crowdfunding));
    }
}