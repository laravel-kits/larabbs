<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TimeOuts
 * @property string $id
 * @property string $data 功能、绑定激活码
 * @property int $time_expire 过期时间
 *
 * @property-read bool $isExpired
 * @package App
 */
class TimeOuts extends Model
{
    protected $fillable = ['id', 'data', 'time_expire'];

    protected $table = 'timeouts';
    public $timestamps = false;

    /**
     * @return bool 是否过期
     */
    public function getIsExpired()
    {
        return time() > $this->time_expire;
    }

    /**
     * 取出数据
     * @param string $id
     * @return bool|mixed 不存在返回 false
     */
    public static function get($id)
    {
        $model = self::query()->find($id);
        if ($model === null || $model->getIsExpired()) {
            return false;
        }

        // return $model->data;
        return true;
    }

    /**
     * 删除数据
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public static function del($id)
    {
        $model = self::query()->find($id);
        return $model->delete();
    }

    /**
     * 存入限时数据
     * @param string $id
     * @param int $ttl
     * @param string $data
     * @param bool $extendOnSame 值相当时延时做处理
     */
    public static function put($id, $ttl, $data = '', $extendOnSame = false)
    {
        $model = self::query()->find($id);
        if ($model === null) {
            $model = self::create([
                'id' => $id,
                'time_expire' => time() + $ttl,
                'data' => $data,
            ]);
        } else {
            $now = time();
            if ($extendOnSame && $data === $model->data && $model->time_expire > $now) {
                $model->time_expire += $ttl;
            } else {
                $model->time_expire = $now + $ttl;
            }
            $model->data = $data;
        }
        $model->save();
    }
}
