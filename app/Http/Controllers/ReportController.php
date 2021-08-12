<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Http\Resources\ReportResource;
use App\Http\Requests\ReportSendRequest;
use Validator;

class ReportController extends Controller
{
    protected function send(ReportSendRequest $request)
    {
        // dd($request->all());
        // $validator = $request->validate([
		// 	'message' => 'required'
        // ]);
        // $data = json_decode($request, true);
        $rules = [
			'message' => 'required'
        ];

        // $validator = Validator::make($request->all(), $rules);

        // if (!$validator->passes()) {
        //     //TODO Handle your data
        //     return response()->json(['error'=> $validator->errors()->all()], 400);
        // }

        $request->merge(['from_id' => auth()->user()->id]);

        $report = Report::create($request->all());

        $report = new ReportResource($report);

        return response()->json($report);
    }
}
