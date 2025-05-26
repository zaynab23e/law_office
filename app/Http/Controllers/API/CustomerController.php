<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\customer\storeCustomerRequest;
use App\Http\Requests\customer\updateCustomerRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    //ده العملاء
    public function index()
    {
        $query = auth()->user()->customers();
        if (request()->has('name')) {
            $query->where('name', 'LIKE', '%' . request('name') . '%');
        }
        $customers = $query->get();
        return response()->json($customers, 200);
    }
    

  

    public function store(storeCustomerRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();
        $customer = Customer::create($validatedData);
        return response()->json('تم إنشاء العميل بنجاح', 201);
        
    }


    public function show(string $id)
    {
        $customer = Customer::find($id);
        if ($customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }
        return response()->json($customer, 200);
        
    }

 
    public function update(updateCustomerRequest $request, string $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json('العميل غير موجود', 404);
        }
        if ($customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }

        $validatedData = $request->validated();
        $customer->update($validatedData);
        return response()->json('تم تحديث العميل بنجاح', 200);
    }

    public function destroy(Customer $customer)
    {
        if ($customer->user_id !== auth()->id()) {
            return response()->json('غير مصرح', 403);
        }
        $customer->delete();
        return response()->json('تم حذف العميل بنجاح', 200);
    }
}
