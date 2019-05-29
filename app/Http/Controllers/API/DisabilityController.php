<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Disability;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;

class DisabilityController extends BaseController
{
    public function index()
    {
        return $this->responseSuccess(200, Disability::all());
    }

    public function show($id)
    {
        $disability = Disability::find($id);
        if (empty($disability)) {
            return $this->responseErrors(404, 'Disability not found');
        } else {
            return $this->responseSuccess(200, $disability);
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== Admin::CITY_ADMIN) {
            return $this->responseErrors(401, 'Unauthorized');
        }

        $data = $request->all();
        $messages = [
            'name.required' => 'Giá trị tên dạng tật không được trống.',
            'name.string' => 'Giá trị tên dạng tật phải là chuỗi kí tự.',
            'name.max' => 'Giá trị tên dạng tật tối đa :max kí tự.',
            'unique' => 'Tên dạng tật đã được sử dụng',
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:disabilities,name'],
        ], $messages);

        if ($validator->fails()) {
            return $this->responseErrors(400, $validator->errors());
        }

        $disability = Disability::create([
            'name' => $data['name']
        ]);
        return $this->responseSuccess(200, $disability);
    }

    public function edit(Request $request, $id)
    {
        if (Auth::user()->role !== Admin::CITY_ADMIN) {
            return $this->responseErrors(401, 'Unauthorized');
        }

        $data = $request->all();
        $disability = Disability::find($id);
        if (empty($disability)) {
            return $this->responseErrors(404, 'Disability not found');
        }

        $messages = [
            'name.required' => 'Giá trị tên dạng tật không được trống.',
            'name.string' => 'Giá trị tên dạng tật phải là chuỗi kí tự.',
            'name.max' => 'Giá trị tên dạng tật tối đa :max kí tự.',
            'unique' => 'Tên dạng tật đã được sử dụng',
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:disabilities,name,'. $id],
        ], $messages);

        if ($validator->fails()) {
            return $this->responseErrors(400, $validator->errors());
        }

        $disability->update([
            'name' => $data['name']
        ]);
        return $this->responseSuccess(200, $disability);
    }

    public function delete($id)
    {
        if (Auth::user()->role !== Admin::CITY_ADMIN) {
            return $this->responseErrors(401, 'Unauthorized');
        }

        $disability = Disability::find($id);
        if (empty($disability)) {
            return $this->responseErrors(404, 'Disability not found');
        }

        $count = User::where('disability_id', $id)->get()->count();
        if ($count > 0) {
            $messageBag = new MessageBag;
            $messageBag->add('user_has_disability', "Cannot delete. Disability being used by user.");
            return $this->responseErrors(500, $messageBag->getMessages());
        }

        $disability->delete();
        return $this->responseSuccess(200, 'Delete success');
    }
}
