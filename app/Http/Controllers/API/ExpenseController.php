<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    //
    public function showAdminExpenses(Request $request){
        $expense =  Expense::all();
        return Response([
            'datas' => $expense
        ], 200);
    }
    public function showAdminExpensesTotal(Request $request){
        $categories = Category::with('expenses')->get();
        $categoryExpenses = [];
        foreach ($categories as $category) {
            $totalExpense = $category->expenses->sum('amount');
            $categoryExpenses[] = [
                'category' => $category->name,
                'totalExpense' => $totalExpense,
            ];
        }
        return $categoryExpenses;
    }
    public function showUserExpensesTotal(Request $request){
        $categories = Category::with('expenses')->get();
        $categoryExpenses = [];
        foreach ($categories as $category) {
            $totalExpense = $category->expenses->where('user_id', Auth::guard('api')->user()->id)->sum('amount');
            $categoryExpenses[] = [
                'category' => $category->name,
                'totalExpense' => $totalExpense,
            ];
        }
        return $categoryExpenses;
    }
    public function showUserExpenses(Request $request){
        $expense = Auth::guard('api')->user()->expenses()->get();
        return Response([
            'datas' => $expense
        ], 200);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), 
            [
                'category_id' => 'required',
                'amount' => 'required|numeric',
                'date' => 'required|date',
            ],
        );
        if ($validator->fails()) {
            return Response([
                'error' => $validator->errors()
            ], 400);
        }else{
            //check if category exist first
            $category = Category::find($request->category_id);
            if($category){
                $expensesUpload = [
                    'category_id' => $request->category_id,
                    'amount' => $request->amount,
                    'date' => $request->date
                ];
                $newExpense = Auth::guard('api')->user()->expenses()->create($expensesUpload);
                return Response([
                    'data' => $newExpense
                ],200);
            }
            else{
                return Response([
                    'error' => 'Category Not Exist',
                ], 400);
            }
        }
    }
    public function edit(Request $request, $id){
        $expense = Expense::find($id);
        if($expense){
            return Response([
                'data' => $expense,
            ], 200);
        }else{
            return Response([
                'error' => 'not found'
            ], 400) ;
        }
    }
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), 
            [
                // 'user_id' => 'required',
                'category_id' => 'required',
                'amount' => 'required|numeric',
                'date' => 'required',
            ],
        );
        if ($validator->fails()) {
            return Response([
                'error' => $validator->errors()
            ], 400);
        }else{
              //check if category exist first
            $category = Category::find($request->category_id);
            if($category){
                $expense = Expense::find($id);
                if($expense){
                    $expensesUpload = [
                        'category_id' => $request->category_id,
                        'amount' => $request->amount,
                        'date' => $request->date
                    ];
                    $expense->update($expensesUpload);
                    return Response([
                        'data' => Expense::find($id)
                    ],200);
                }else{
                    return Response([
                        'error' => 'Expense Not Found'
                    ], 400);
                }
            }else{
                return Response([
                    'error' => 'Category Not Exist',
                ], 400);
            }
        }
    }
    public function editUserExpense(Request $request, $id){
        $expense =  $expense = Auth::guard('api')->user()->expenses()->find($id);
        if($expense){
            return Response([
                'data' => $expense,
            ], 200);
        }else{
            return Response([
                'error' => 'not found'
            ], 400) ;
        }
    }
    public function destroy(Request $request, $id){
        $expense = Expense::find($id);
        if($expense){
            $expense->delete();   
            return Response([
                'message' => 'Delete Successfully'
            ], 200) ;
        }
        else{ 
            return Response([
                'message' => 'expense not found'
            ], 200) ;
        }
    }
    public function destroyUserExpenses(Request $request, $id){
        $expense = Auth::guard('api')->user()->expenses()->first();
        if($expense){
            $expense->delete();   
            return Response([
                'message' => 'Delete Successfully'
            ], 200) ;
        }
        else{ 
            return Response([
                'message' => 'expense not found'
            ], 200) ;
        }
    }
}
