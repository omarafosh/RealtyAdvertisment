<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisment;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AdvertismentResource;

class AdvertismentController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }
    public function show_advertisment(Advertisment $advertisment)
    {
        $advertisment_show = Advertisment::find($advertisment->id);

        return new AdvertismentResource($advertisment_show);
    }
    public function update_advertisment(Request $request, Advertisment $advertisment)
    {
        $data = $request->except(['photo']);
        $validator = Validator::make($data, [
            "type"              => "required",
            "salary"            => "required",
            "rooms"             => "required",
            "bath_room"         => "required",
            "area"              => "required|string",
            "evaluation"        => "required",
            "state"             => "required",
            "duration"          => "required",
            "location"          => "required",
            "advertisment_type" => "required",
            "description"       => "required",
        ]);

        $advertisment->update($validator->validate());

        if ($images = $request->file('photo')) {
            $advertisment->clearMediaCollection('advertisment');
            foreach ($images as $image) {
                $advertisment->addMedia($image)->toMediaCollection('advertisment');
            }
        }
        return [
            'message' => 'Advertisment Updated successfully',
            'data' => new AdvertismentResource($advertisment)
        ];
    }
    public function del_advertisment(Advertisment $advertisment)
    {
        $advertisment_del = Advertisment::find($advertisment->id)->delete();
        return [
            'message' => 'Advertisment Deleted successfully',
        ];
    }
    public function save_advertisment(Request $request)
    {
        $data = $request->except(['photo']);
        $validator = Validator::make($data, [
            "type" => "required",
            "salary" => "required",
            "rooms"     => "required",
            "bath_room"     => "required",
            "area"    => "required|string",
            "evaluation" => "required",
            "state" => "required",
            "duration"     => "required",
            "location"    => "required",
            "advertisment_type" => "required",
            "description" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $advertisment = Advertisment::create(array_merge(
            ["user_id" => auth()->user()->id],
            $validator->validate()
        ));
        if ($images = $request->photo) {
            foreach ($images as $image) {
                $advertisment->addMedia($image)->toMediaCollection('advertisment');
            }
        }
        return [
            'message' => 'Advertisment created successfully',
            'data' => new AdvertismentResource($advertisment)
        ];
    }
    public function search_advertisment(Request $request)
    {
        // Builder::macro('whereLike', function($column, $search) {
        //     return $this->where($column, 'LIKE', "%{$search}%");
        //   });
        $type = $request->type;
        $rooms = $request->rooms;
        $bath_room = $request->bath_room;
        $salary = $request->salary;
        $area = $request->area;
        $duration = $request->duration;
        $location = $request->location;
        $array_filter = [];
        if ($type) {
            array_merge($array_filter, ['type', $type]);
        }
        if ($rooms) {
            array_merge($array_filter, ['rooms', $rooms]);
        }
        if ($bath_room) {
            array_merge($array_filter, ['bath_room', $bath_room]);
        }
        if ($salary) {
            array_merge($array_filter, ['salary', $salary]);
        }
        if ($area) {
            array_merge($array_filter, ['area', $area]);
        }
        if ($duration) {
            array_merge($array_filter, ['duration', $duration]);
        }
        if ($location) {
            array_merge($array_filter, ['location', $location]);
        }
        $advertisment = Advertisment::where($array_filter)->first();
        return [
            'data' => new AdvertismentResource($advertisment)
        ];
    }
}
