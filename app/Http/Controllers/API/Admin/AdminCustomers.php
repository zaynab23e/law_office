<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\customer\updateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class AdminCustomers extends Controller
{
    //ده العملاء
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers, 200);
    }
    

    public function show(string $id)
    {
        $customer = Customer::find($id);

        return response()->json($customer, 200);
        
    }
 
    public function update(updateCustomerRequest $request, string $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json('العميل غير موجود', 404);
        }
        $validatedData = $request->validated();
        $customer->update($validatedData);
        return response()->json('تم تحديث العميل بنجاح', 200);
    }

    public function destroy(Customer $customer)
    {
        $customer = Customer::find($customer->id);
        if (!$customer) {
            return response()->json('غير موجود', 404);
        }
        $customer->delete();
        return response()->json('تم حذف العميل بنجاح', 200);
    }
}
