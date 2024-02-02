<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HolidaysModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{

    protected int $ActiveUserId;

    protected array|object $ActiveUser;

    public function __construct(){

        $this->middleware(function ($request, $next) {

            $this->ActiveUser    = Auth::user();
            $this->ActiveUserId  = $this->ActiveUser->id;
            return $next($request);

        });

    }


    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {

        try {

            return response()->json(HolidaysModel::get(), 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), $e->status ?? 500);

        }


    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {

            $request->validate([
                'data' => 'required',
            ]);

            $data = json_decode($request->data);

            foreach ($data as $key => $dataLoop) {

                if(!$dataLoop->name || !$dataLoop->date || HolidaysModel::where('name', '=', $dataLoop->localName)->where('date', '=', $dataLoop->date)->count()) continue;

                $Holiday = HolidaysModel::create([
                    'name' => $dataLoop->localName,
                    'date' => $dataLoop->date,
                    'created_by' => $this->ActiveUserId,
                    'original_data' => json_encode($dataLoop),
                    'history' => json_encode([
                        'action' => 'create',
                        'description' => 'created new holiday',
                        'created_by' => $this->ActiveUserId
                    ])
                ]);

            }

            return response()->json($Holiday, 201);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), $e->status ?? 500);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            return response()->json(HolidaysModel::find($id), 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), $e->status ?? 500);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $validate = $request->validate([
                'date'  =>  'required',
                'name'  =>  'required',
                'note'  =>  'nullable',
            ]);
            $history = [
                    'action' => 'update',
                    'description' => 'updated holiday',
                    'original_data' => json_encode($validate),
                    'updated_by' => $this->ActiveUserId
                ];

            HolidaysModel::where('id', $id)->update([
                'name' => $validate['name'],
                'date' => $validate['date'],
                'note' => $validate['note'] ?? null,
                'history' => json_encode($history)
            ]);

            return response()->json(true, 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), $e->status ?? 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {

            $history = [
                    'action' => 'delete',
                    'description' => 'deleted holiday',
                    'deleted_by' => $this->ActiveUserId
                ];

            HolidaysModel::where('id', $id)->update([
                'deleted_at' => now(),
                'history' => json_encode($history)
            ]);

            return response()->json(true, 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), $e->status ?? 500);

        }


    }
}
