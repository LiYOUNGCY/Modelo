<?php

namespace App\Http\Controllers;

use App\Container\Container;
use App\Model\UserAddress;
use Illuminate\Http\Request;

use App\Http\Requests;

class AddressController extends Controller
{
    public function create()
    {
        return view('address.create');
    }

    public function store(Request $request)
    {
        //@TODO validate

        $contact = $request->get('contact');
        $phone = $request->get('phone');
        $area1 = $request->get('area1');
        $area2 = $request->get('area2');
        $area3 = $request->get('area3');
        $address = $request->get('address');

        $address = $area1 . $area2 . $area3 . $address;

        $userAddress = Container::getUser()->address;
        if (is_null($userAddress)) {
            $userAddress = new UserAddress();
        }
        $userAddress->user_id = Container::getUser()->id;
        $userAddress->contact = $contact;
        $userAddress->phone = $phone;
        $userAddress->address = $address;
        $userAddress->save();

        return redirect('order/create');
    }

    public function edit()
    {
        $userAddress = Container::getUser()->address;

        return view('address.edit', [
            'userAddress' => $userAddress,
        ]);
    }

    public function update(Request $request, $id)
    {
        //@TODO validate

        $contact = $request->get('contact');
        $phone = $request->get('phone');
        $area1 = $request->get('area1');
        $area2 = $request->get('area2');
        $area3 = $request->get('area3');
        $address = $request->get('address');

        $address = $area1 . $area2 . $area3 . $address;

        $userAddress = UserAddress::find($id);
        $userAddress->user_id = Container::getUser()->id;
        $userAddress->contact = $contact;
        $userAddress->phone = $phone;
        $userAddress->address = $address;
        $userAddress->save();

        return redirect('order/create');
    }
}
