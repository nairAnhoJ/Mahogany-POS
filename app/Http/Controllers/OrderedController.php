<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class OrderedController extends Controller
{
    public function index(){
        $tables = DB::table('tables')->orderBy('id', 'asc')->where('id', '!=', '1')->get();

        return view('user.cashier.orders', compact('tables'));
    }

    public function getMenu(Request $request){
        $id = $request->id;
        $trans = DB::table('transactions')->where('table', $id)->where('order_status', '!=', 'CANCELLED')->where('order_status', '!=', 'COMPLETED')->get();
        $res = '';
        $co = '0';
        $pd = '1';

        if($trans->count() < 1){
            $co = '1';
        }

        foreach($trans as $tran){
            if($tran->status == 'UNPAID'){
                $pd = 0;
            }

            $m = '';
            $orders = DB::table('ordered')
                ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                ->select('ordered.tran_id', 'ordered.menu_id', 'menus.name', 'ordered.quantity', 'ordered.slug', 'ordered.status')
                ->where('ordered.tran_id', $tran->id)
                ->get();

            foreach($orders as $order){
                if($order->quantity > 1){
                    if($order->status != 'SERVED'){
                        $m .= '
                            <div class="flex justify-between items-center mb-5">
                                <div>
                                    <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                </div>
                                <div style="margin-right: 20px;" class="">
                                    <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="reduceButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50 mr-4"><i class="uil uil-minus text-xl text-red-500 hover:text-red-600 mr-2"></i>Reduce</button>
                                    <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                                </div>
                            </div>
                        ';
                    }else{
                        $m .= '
                            <div class="flex justify-between items-center mb-5">
                                <div>
                                    <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                </div>
                            </div>
                        ';
                        $co = 1;
                    }
                }else{
                    if($order->status != 'SERVED'){
                        $m .= '
                            <div class="flex justify-between items-center mb-5">
                                <div>
                                    <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                </div>
                                <div style="margin-right: 20px;" class="">
                                    <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                                </div>
                            </div>
                        ';
                    }else{
                        $m .= '
                            <div class="flex justify-between items-center mb-5">
                                <div>
                                    <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                </div>
                            </div>
                        ';
                        $co = 1;
                    }
                }
            }

            if($tran->status == 'PAID'){
                $sColor = 'rgb(16 185 129)';
            }else{
                $sColor = 'rgb(240 82 82)';
            }

            $res .= '
                <div class="relative h-auto mb-5">
                    <span style="border-color: rgb(209 213 219 / var(--tw-border-opacity)); margin-left: 20px;" class="relative text-gray-500 font-bold text-xl border px-4 py-2 w-auto bg-white z-50 rounded-lg">'.$tran->number.' - <span style="color: '.$sColor.';"> '.$tran->status.'</span></span>
                    <div style="top: -13px; border-color: rgb(209 213 219 / var(--tw-border-opacity));" class="relative border border-gray-500 z-10 w-full pt-6 pl-2 text-xl font-semibold text-gray-500 tracking-wide rounded-lg">'.$m.'</div>
                </div>
            ';
        }

        $response = array(
            'allOrders' => $res,
            'co' => $co,
            'pd' => $pd,
        );

        echo json_encode($response);
    }

    public function reduce(Request $request){
        $slug = $request->slug;

        DB::table('ordered')->where('slug', $slug)->decrement('quantity', 1);

        $menu_id = (DB::table('ordered')->where('slug', $slug)->first())->menu_id;
        DB::table('menus')->where('id', $menu_id)->increment('current_quantity', 1);
        DB::table('menus')->where('id', $menu_id)->increment('quantity', 1);

        $id = $request->table;
        $trans = DB::table('transactions')->where('table', $id)->where('order_status', '!=', 'CANCELLED')->where('order_status', '!=', 'COMPLETED')->get();
        $res = '';
        $co = '0';

        foreach($trans as $tran){
            $m = '';
            $orders = DB::table('ordered')
                ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                ->select('ordered.tran_id', 'ordered.menu_id', 'menus.name', 'ordered.quantity', 'ordered.slug', 'ordered.status')
                ->where('ordered.tran_id', $tran->id)
                ->get();

            foreach($orders as $order){
                if($order->quantity > 1){
                    if($order->status != 'SERVED'){
                        $m .= '
                            <div class="flex justify-between items-center mb-5">
                                <div>
                                    <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                </div>
                                <div style="margin-right: 20px;" class="">
                                    <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="reduceButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50 mr-4"><i class="uil uil-minus text-xl text-red-500 hover:text-red-600 mr-2"></i>Reduce</button>
                                    <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                                </div>
                            </div>
                        ';
                    }else{
                        $m .= '
                            <div class="flex justify-between items-center mb-5">
                                <div>
                                    <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                </div>
                            </div>
                        ';
                        $co = 1;
                    }
                }else{
                    if($order->status != 'SERVED'){
                        $m .= '
                            <div class="flex justify-between items-center mb-5">
                                <div>
                                    <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                </div>
                                <div style="margin-right: 20px;" class="">
                                    <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                                </div>
                            </div>
                        ';
                    }else{
                        $m .= '
                            <div class="flex justify-between items-center mb-5">
                                <div>
                                    <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                </div>
                            </div>
                        ';
                        $co = 1;
                    }
                }
            }

            if($tran->status == 'PAID'){
                $sColor = 'rgb(16 185 129)';
            }else{
                $sColor = 'rgb(240 82 82)';
            }

            $res .= '
                <div class="relative h-auto mb-5">
                    <span style="border-color: rgb(209 213 219 / var(--tw-border-opacity)); margin-left: 20px;" class="relative text-gray-500 font-bold text-xl border px-4 py-2 w-auto bg-white z-50 rounded-lg">'.$tran->number.' - <span style="color: '.$sColor.';"> '.$tran->status.'</span></span>
                    <div style="top: -13px; border-color: rgb(209 213 219 / var(--tw-border-opacity));" class="relative border border-gray-500 z-10 w-full pt-6 pl-2 text-xl font-semibold text-gray-500 tracking-wide rounded-lg">'.$m.'</div>
                </div>
            ';
        }

        $response = array(
            'allOrders' => $res,
            'co' => $co,
        );

        echo json_encode($response);
    }

    public function remove(Request $request){
        $slug = $request->slug;

        $ordered = DB::table('ordered')->where('slug', $slug)->first();
        DB::table('menus')->where('id', $ordered->menu_id)->increment('current_quantity', $ordered->quantity);
        DB::table('menus')->where('id', $ordered->menu_id)->increment('quantity', $ordered->quantity);

        DB::table('ordered')->where('slug', $slug)->delete();

        $id = $request->table;
        $trans = DB::table('transactions')->where('table', $id)->where('order_status', '!=', 'CANCELLED')->where('order_status', '!=', 'COMPLETED')->get();
        $res = '';
        $co = '0';

        foreach($trans as $tran){
            $m = '';
            $orders = DB::table('ordered')
                ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                ->select('ordered.tran_id', 'ordered.menu_id', 'menus.name', 'ordered.quantity', 'ordered.slug', 'ordered.status')
                ->where('ordered.tran_id', $tran->id)
                ->get();

            if($orders->count() < 1){
                DB::table('transactions')->where('id', $tran->id)->update(['order_status' => 'CANCELLED']);
            }else{
                foreach($orders as $order){
                    if($order->quantity > 1){
                        if($order->status != 'SERVED'){
                            $m .= '
                                <div class="flex justify-between items-center mb-5">
                                    <div>
                                        <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                    </div>
                                    <div style="margin-right: 20px;" class="">
                                        <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="reduceButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50 mr-4"><i class="uil uil-minus text-xl text-red-500 hover:text-red-600 mr-2"></i>Reduce</button>
                                        <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                                    </div>
                                </div>
                            ';
                        }else{
                            $m .= '
                                <div class="flex justify-between items-center mb-5">
                                    <div>
                                        <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                    </div>
                                </div>
                            ';
                            $co = 1;
                        }
                    }else{
                        if($order->status != 'SERVED'){
                            $m .= '
                                <div class="flex justify-between items-center mb-5">
                                    <div>
                                        <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                    </div>
                                    <div style="margin-right: 20px;" class="">
                                        <button data-slug="'.$order->slug.'" data-table="'.$id.'" class="removeButton border border-gray-300 shadow py-2 px-4 rounded-lg hover:bg-gray-50"><i class="uil uil-multiply text-xl text-red-500 hover:text-red-600 mr-2"></i>Remove</button>
                                    </div>
                                </div>
                            ';
                        }else{
                            $m .= '
                                <div class="flex justify-between items-center mb-5">
                                    <div>
                                        <h1 class="whitespace-nowrap max-w-xs overflow-hidden">&nbsp;&nbsp;'.$order->quantity.'x&nbsp;&nbsp;&nbsp;<span>'.$order->name.'</span>&nbsp;&nbsp;</h1>
                                    </div>
                                </div>
                            ';
                            $co = 1;
                        }
                    }
                }
    
                if($tran->status == 'PAID'){
                    $sColor = 'rgb(16 185 129)';
                }else{
                    $sColor = 'rgb(240 82 82)';
                }
    
                $res .= '
                    <div class="relative h-auto mb-5">
                        <span style="border-color: rgb(209 213 219 / var(--tw-border-opacity)); margin-left: 20px;" class="relative text-gray-500 font-bold text-xl border px-4 py-2 w-auto bg-white z-50 rounded-lg">'.$tran->number.' - <span style="color: '.$sColor.';"> '.$tran->status.'</span></span>
                        <div style="top: -13px; border-color: rgb(209 213 219 / var(--tw-border-opacity));" class="relative border border-gray-500 z-10 w-full pt-6 pl-2 text-xl font-semibold text-gray-500 tracking-wide rounded-lg">'.$m.'</div>
                    </div>
                ';
            }
        }

        $response = array(
            'allOrders' => $res,
            'co' => $co,
        );

        echo json_encode($response);
    }

    public function cancel(Request $request){
        $table = $request->id;

        $trans = DB::table('transactions')->where('table', $table)->where('order_status', '!=', 'CANCELLED')->where('order_status', '!=', 'COMPLETED')->get();

        foreach($trans as $tran){
            $ordereds = DB::table('ordered')->where('tran_id', $tran->id)->get();
    
            foreach($ordereds as $ordered){
                DB::table('menus')->where('id', $ordered->menu_id)->increment('current_quantity', $ordered->quantity);
                DB::table('menus')->where('id', $ordered->menu_id)->increment('quantity', $ordered->quantity);
            }
    
            DB::table('ordered')->where('tran_id', $tran->id)->delete();
            DB::table('transactions')->where('id', $tran->id)->update([
                'order_status' => 'CANCELLED'
            ]);
        }

        DB::table('tables')->where('id', $table)->update([
            'status' => 0
        ]);
    }

    public function open(Request $request){
        $table = $request->id;

        $trans = DB::table('transactions')->where('table', $table)->where('order_status', '!=', 'CANCELLED')->where('order_status', '!=', 'COMPLETED')->get();

        foreach($trans as $tran){
            DB::table('transactions')->where('id', $tran->id)->update(['order_status' => 'COMPLETED']);
            $ordered = DB::table('ordered')->where('tran_id', $tran->id)->update([ 'status' => 'COMPLETED' ]);
        }

        DB::table('tables')->where('id', $table)->update([
            'status' => 0
        ]);
    }

    public function occupy(Request $request){
        $id = $request->id;

        DB::table('tables')->where('id', $id)->update(['status' => '1']);
    }

    public function getAmount(Request $request){
        $id = $request->id;
        $trans = DB::table('transactions')
            ->where('table', $id)
            ->where('status', 'UNPAID')
            ->where('order_status', '!=', 'CANCELLED')
            ->where('order_status', '!=', 'COMPLETED')
            ->first();

        echo $trans->total;
    }

    public function paid(Request $request){
        $id = $request->id;
        $mop = $request->mop;
        $amountInput = $request->amountInput;


        DB::table('transactions')
            ->where('table', $id)
            ->where('status', 'UNPAID')
            ->update([
                'mode_of_payment' => $mop,
                'amount' => $amountInput,
                'status' => 'PAID'
            ]);
    }

    public function print($id){
        $trans = DB::table('transactions')
                    ->select('transactions.*', 'tables.name as table_name')
                    ->join('tables', 'transactions.table', '=', 'tables.id')
                    ->where('transactions.table', $id)
                    ->where('transactions.status', '=', 'UNPAID')
                    ->where('transactions.order_status', '!=', 'CANCELLED')
                    ->where('transactions.order_status', '!=', 'COMPLETED')
                    ->first();

        $orders = DB::table('ordered')
                    ->select('ordered.*', 'menus.name')
                    ->join('menus', 'ordered.menu_id', '=', 'menus.id')
                    ->where('tran_id', $trans->id)
                    ->get();


        $settings = DB::table('settings')->where('id', 1)->first();


        return view('user.cashier.bill', compact('orders', 'trans', 'settings'));
    }
}
