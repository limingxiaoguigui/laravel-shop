<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-19 09:22:01
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-19 09:49:10
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_REPAYING = 'repaying';
    const STATUS_FINISHED = 'finished';

    public static $statusMap = [
        self::STATUS_PENDING => '未执行',
        self::STATUS_REPAYING => '还款中',
        self::STATUS_FINISHED => '已完成'
    ];

    protected $fillable = ['no', 'total_amount', 'count', 'fee_rate', 'fine_rate', 'status'];
    /**
     * 初始化
     * @return void
     */
    protected  static  function boot()
    {
        parent::boot();
        //监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            //如果模型的no字段为空
            if (!$model->no) {
                //调用findAvailableNo生成分期流水号
                $model->no = static::findAvailableNo();
                //如果失败，则终止创建订单
                if (!$model->no) {
                    return false;
                }
            }
        });
    }
    /**
     * 和用户的关联关系
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * 和订单的关联关系
     * @return void
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    /**
     * 和分期子订单的关联关系
     * @return void
     */
    public function items()
    {
        return $this->hasMany(InstallmentItem::class);
    }
    /**
     * 生成单号
     * @return void
     */
    public function findAvailableNo()
    {
        //分期流水号的前缀
        $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            //随机生成6为数字
            $no = $prefix . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            //判断是否已经存在
            if (!static::query()->where('no', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning(sprintf('find installment no failed'));

        return false;
    }
}