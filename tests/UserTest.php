<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
//    public function testCreate()
//    {
//        $users = factory(App\Model\User::class, 50)->create();
//    }

    public function testCreateRelation()
    {
        //the children of 1
        $this->setParent(2, 1);
        $this->setParent(3, 1);
        $this->setParent(9, 1);

        //the children of 2
        $this->setParent(4, 2);
        $this->setParent(5, 2);
        $this->setParent(8, 2);

        //the children of 4
        $this->setParent(6, 4);
        $this->setParent(7, 4);

        // $this->setUserBuy(2);
        // $this->setUserBuy(9);

        // $this->setUserBuy(5);
        // $this->setUserBuy(6);
        return true;
    }

    private function setParent($userId, $parentId)
    {
        $this->existUser($userId);
        $this->existUser($parentId);
        if(! \App\Model\UserRelation::hasParent($userId)) {
            $userRelation = new \App\Model\UserRelation();
            $userRelation->parent_id = $parentId;
            $userRelation->children_id = $userId;
            $userRelation->save();
            return true;
        }

        return false;
    }

    private function existUser($userId)
    {
        $user = \App\Model\User::findOrNew($userId);
        $user->nickname = "test{$userId}";
        $user->save();
        return true;
    }

    private function setUserBuy($userId)
    {
        $user = \App\Model\User::find($userId);

        if(is_null($user)) {
            throw new \App\Exceptions\NotFoundException("{$userId} NOT FOUND");
        }

        $user->can_qrcode = 1;
        $user->save();
    }

//    public function testCount()
//    {
//        $this->assertEquals(3, \App\Model\User::getChildrenCount(1));
//        $this->assertEquals(2, \App\Model\User::getChildrenBuyCount(1));
//
//        $this->assertEquals(3, \App\Model\User::getSecondCount(1));
//        $this->assertEquals(1, \App\Model\User::getSecondBuyCount(1));
//
//        $this->assertEquals(2, \App\Model\User::getThreeCount(1));
//        $this->assertEquals(1, \App\Model\User::getThreeBuyCount(1));
//    }
}
