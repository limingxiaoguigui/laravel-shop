<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Order;
// 代表这个类需要被放到队列中执行，而不是触发时立即执行
class CloseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, $delay)
    {
        $this->order = $order;
        // 设置延迟时间，delay方法的参数代表多少秒之后执行
        $this->delay($delay);
    }

    /**
     *定义这个任务类具体的执行逻辑
     *当对列处理器从队列中取出任务时，会调用这个方法
     * @return void
     */
    public function handle()
    {
        //判断对应的订单是否已经被支付
        // 如果已经支付则不需要关闭订单，直接退出
        if ($this->order->paid_at) {
            return;
        }
        //通过事务执行sql
        \DB::transaction(function () {
            //将订单的closed字段标记为true，及关闭订单
            $this->order->update(['closed' => true]);
            // 循环遍历订单商品中sku，将订单的数量加回到sku库存中
            foreach ($this->order->items as $item) {
                $item->productSku->addStock($item->amount);
            }
        });
    }
}