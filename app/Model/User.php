<?php

namespace App\Model;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use DB;
use Config;

class User extends Model
{
    protected $fillable = [
        'can_qrcode',
        'can_buy',
        'openid',
    ];

    protected $table = 'user';

    public function address()
    {
        return $this->hasOne('App\Model\UserAddress', 'user_id');
    }

    public function relation()
    {
        return $this->hasOne('App\Model\UserRelation', 'children_id');
    }

    public function profit()
    {
        return $this->hasMany('App\Model\Profit', 'user_id');
    }

    /**
     * @param $userId
     * @return User
     * @throws NotFoundException
     */
    public static function get($userId)
    {
        $user = User::find($userId);

        if (is_null($user)) {
            throw new NotFoundException("{$userId} Not Found.");
        }

        return $user;
    }

    /**
     * @param $openId
     * @param array $attributes
     * @return User
     */
    public static function findOrNewByOpenid($openId, $attributes = [])
    {
        $user = User::firstOrCreate(['openid' => $openId]);

        unset($attributes['openid']);
        User::where('openid', $openId)->update($attributes);

        return $user;
    }

    /**
     * 可以获得二维码
     */
    public function canQrcode()
    {
        $this->can_qrcode = true;
        $this->save();
    }

    /**
     * 更改为推广用户
     */
    public function changeSuper()
    {
        $this->can_qrcode = true;
        $this->get_qrcode = false;  //禁止扫描其他人的二维码
        $this->save();
    }

    /**
     * 扫描二维码
     * @param $referee
     */
    public function scanQrcode($referee)
    {
        $this->get_qrcode = false;
        $this->can_buy = true;
        $this->referee = $referee;
        $this->save();
    }

    /**
     * 获取 儿子和孙子 [未支付和已取消] 订单的金额
     * @param $userId
     * @return float
     */
    public static function getUnpaidOrderTotal($userId)
    {
        $subOrder = function ($query) use ($userId) {
            $query->select('user.id')
                ->from('user')
                ->leftJoin('user_relation', 'user_relation.children_id', '=', 'user.id')
                ->where('user_relation.parent_id', $userId)
                ->orWhere('user.id', $userId);
        };

        $result = DB::table('order')
            ->whereIn('user_id', function ($query) use ($subOrder) {
                $query->select('children_id')
                    ->from('user_relation')
                    ->whereIn('parent_id', $subOrder);
            })
            ->whereIn('status_id', [
                Config::get('constants.orderStatus.unpaid'),
            ])
            ->sum('total');

        return $result;
    }

    /**
     * 获取 儿子和孙子 [已完成] 订单的金额
     * @param $userId
     * @return mixed
     */
    public static function getFinishOrderTotal($userId)
    {
        $subOrder = function ($query) use ($userId) {
            $query->select('user.id')
                ->from('user')
                ->leftJoin('user_relation', 'user_relation.children_id', '=', 'user.id')
                ->where('user_relation.parent_id', $userId)
                ->orWhere('user.id', $userId);
        };

        $result = DB::table('order')
            ->whereIn('user_id', function ($query) use ($subOrder) {
                $query->select('children_id')
                    ->from('user_relation')
                    ->whereIn('parent_id', $subOrder);
            })
            ->whereIn('status_id', [
                Config::get('constants.orderStatus.finish'),
            ])
            ->sum('total');

        return $result;
    }

    public static function getUnFinishOrderTotal($userId)
    {
        $subOrder = function ($query) use ($userId) {
            $query->select('user.id')
                ->from('user')
                ->leftJoin('user_relation', 'user_relation.children_id', '=', 'user.id')
                ->where('user_relation.parent_id', $userId)
                ->orWhere('user.id', $userId);
        };

        $result = DB::table('order')
            ->whereIn('user_id', function ($query) use ($subOrder) {
                $query->select('children_id')
                    ->from('user_relation')
                    ->whereIn('parent_id', $subOrder);
            })
            ->whereIn('status_id', [
                Config::get('constants.orderStatus.confirm'),
                Config::get('constants.orderStatus.deliver'),
                Config::get('constants.orderStatus.received'),
                Config::get('constants.orderStatus.reject'),
                Config::get('constants.orderStatus.exchange'),
            ])
            ->sum('total');

        return $result;
    }

    public static function getChildrenCount($userId)
    {
        $result = DB::table('user_relation')
            ->where('parent_id', $userId)
            ->count();
        return $result;
    }

    public static function getChildrenBuyCount($userId)
    {
        $result = DB::table('user_relation')
            ->join('user', 'user.id', '=', 'user_relation.children_id')
            ->where('user_relation.parent_id', $userId)
            ->where('user.can_qrcode', 1)
            ->count();
        return $result;
    }

    public static function getSecondCount($userId)
    {
        $subChild = function ($query) use ($userId) {
            $query->select('user_relation.children_id')
                ->from('user_relation')
                ->where('user_relation.parent_id', $userId);
        };

        $result = DB::table('user_relation')
            ->whereIn('user_relation.parent_id', $subChild)
            ->count();

        return $result;
    }

    public static function getSecondBuyCount($userId)
    {
        $subChild = function ($query) use ($userId) {
            $query->select('user_relation.children_id')
                ->from('user_relation')
                ->where('user_relation.parent_id', $userId);
        };

        $result = DB::table('user_relation')
            ->join('user', 'user.id', '=', 'user_relation.children_id')
            ->where('user.can_qrcode', 1)
            ->whereIn('user_relation.parent_id', $subChild)
            ->count();

        return $result;
    }

    public static function getThreeCount($userId)
    {
        $subChild = function ($query) use ($userId) {
            $query->select('user_relation.children_id')
                ->from('user_relation')
                ->whereIn('user_relation.parent_id', function($query) use ($userId){
                    $query->select('user_relation.children_id')
                        ->from('user_relation')
                        ->where('user_relation.parent_id', $userId);
                });
        };

        $result = DB::table('user_relation')
            ->whereIn('user_relation.parent_id', $subChild)
            ->count();

        return $result;
    }

    public static function getThreeBuyCount($userId)
    {
        $subChild = function ($query) use ($userId) {
            $query->select('user_relation.children_id')
                ->from('user_relation')
                ->whereIn('user_relation.parent_id', function($query) use ($userId){
                    $query->select('user_relation.children_id')
                        ->from('user_relation')
                        ->where('user_relation.parent_id', $userId);
                });
        };

        $result = DB::table('user_relation')
            ->join('user', 'user.id', '=', 'user_relation.children_id')
            ->where('user.can_qrcode', 1)
            ->whereIn('user_relation.parent_id', $subChild)
            ->count();

        return $result;
    }

    public static function getConsume($user_id)
    {
        $result = DB::table('order')
            ->where('order.user_id', $user_id)
            ->whereIn('order.status_id', [
                Config::get('constants.orderStatus.paid'),
                Config::get('constants.orderStatus.confirm'),
                Config::get('constants.orderStatus.deliver'),
                Config::get('constants.orderStatus.received'),
                Config::get('constants.orderStatus.finish'),
                Config::get('constants.orderStatus.reject'),
                Config::get('constants.orderStatus.exchange'),
            ])
            ->sum('total');

        return $result;
    }

    public function follow($parentId)
    {
        $parent = User::get($parentId);
        //更新推荐人
        $this->referee = $parent->nickname;
        $this->can_buy = true;
        $this->save();
    }

    public static function create(array $attributes = [])
    {
        $attributes['can_qrcode'] = true;
        $attributes['can_buy'] = true;
        return parent::create($attributes); // TODO: Change the autogenerated stub
    }
}
