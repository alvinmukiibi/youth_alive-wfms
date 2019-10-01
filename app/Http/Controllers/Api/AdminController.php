<?php

namespace App\Http\Controllers\Api;

use App\Asset;
use App\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Project;
use App\User;
use App\Vendor;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
class AdminController extends BaseController
{
    public function addProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'accountant' => ['required', 'exists:users,id'],
            'manager' => ['required', 'exists:users,id'],
            'description' => ['nullable', 'max:1000'],
        ], [
            'name.required' => 'Project Acronym field is required',
            'accountant.required' => 'Please assign a project accountant. Note that the list of accountants contains all users with designation of \'Project Accountant\'',
            'manager.required' => 'Please assign a project manager. Note that the list of managers contains all users whose list of system roles includes the role of \'manager\''
        ]);

        if($validator->fails()){
            return $this->sendError('Validation errors', ['error' => $validator->errors()->first()], 429);
        }

        $project = [
            'name' => $request->name,
            'description' => $request->description ? $request->description : null,
            'accountant' => $request->accountant ? $request->accountant : null,
            'manager' => $request->manager ? $request->manager : null,
        ];

        $project = Project::create($project);

        if($request->accountant){
            User::find($request->accountant)->projects()->attach($project->id);
        }
        if($request->manager){
            User::find($request->manager)->projects()->attach($project->id);
        }

        return $this->sendResponse($project, 'New project saved!');


    }

    public function editProject(Project $project, Request $request){

        $project->name = $request->name;
        $project->description = $request->description;
        $project->accountant = $request->accountant ? $request->accountant : $project->accountant;
        // $project->supervisor = $request->supervisor ? $request->supervisor : $project->supervisor;
        $project->manager = $request->manager ? $request->manager : $project->manager;
        $project->save();

        // $count = DB::table('project_user')->where(['user_id' => $request->supervisor, 'project_id' => $request->id])->count();
        // if($count > 0){
        //     return $this->sendError('', 'Project already attached to user');
        // }else{
        //     $user = User::find($request->supervisor);
        //     $user->projects()->attach($request->id);
        // }
        $count = DB::table('project_user')->where(['user_id' => $request->accountant, 'project_id' => $request->id])->count();
        if($count > 0){
            return $this->sendError('error', ['error' => 'Project already attached to user']);
        }else{
            $user = User::find($request->accountant);
            $user->projects()->attach($request->id);
        }
        $count = DB::table('project_user')->where(['user_id' => $request->manager, 'project_id' => $request->id])->count();
        if($count > 0){
            return $this->sendError('error', ['error' => 'Project already attached to user']);
        }else{
            $user = User::find($request->manager);
            $user->projects()->attach($request->id);
        }
        return response()->json('Success', 200);

    }

    public function getAssets(Request $request){
        $assets = Asset::all();

        return response()->json($assets, 202);
    }
    public function getVendors(Request $request){
        $assets = Vendor::all();

        return response()->json($assets, 202);
    }
    public function processAndStoreImage(Request $request, $location = "assets"){
        $file = $request->file('image');
        $image = Image::make($request->file('image'));
        $image->fit(150, 150, null, 'top');
        $image_name = str_replace(' ', '_', $request->firstname).time().'.'.$file->getClientOriginalExtension();
        $destination = public_path().DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.$location.DIRECTORY_SEPARATOR.$image_name;
        $image->save($destination);
        return $image_name;
    }
    public function addAsset(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            // 'quantity' => ['nullable', 'numeric'],
            // 'cost' => ['nullable', 'numeric'],
        ]);

        if($validator->fails()){
            return $this->sendError('Validation errors', $validator->errors(), 422);
        }

        $image = null;
        if($request->hasFile('image')){
            $validator =  Validator::make($request->all(), [
                'image' => ['mimes:jpeg,jpg,png,webp', 'max:10240']
            ]);
            if($validator->fails()){
                return $this->sendError('Validation errors', $validator->errors(), 422);
            }
            $image = $this->processAndStoreImage($request);
        }

        $asset = [
            'name' => $request->name,
            'identity' => $request->identity ? $request->identity : null,
            'quantity' => $request->quantity ? $request->quantity : null,
            'cost' => $request->cost ? $request->cost : null,
            'description' => $request->description ? $request->description : null,
            'image' => $image
        ];

        $asset = Asset::create($asset);

        return response()->json($asset, 202);
    }
    public function addVendor(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'location' => ['required'],
            'contact' => ['required'],
            'email' => ['nullable', 'email'],
        ]);

        if($validator->fails()){
            return $this->sendError('Validation errors', $validator->errors(), 422);
        }

        $logo = null;
        if($request->hasFile('image')){
            $validator =  Validator::make($request->all(), [
                'image' => ['mimes:jpeg,jpg,png,webp', 'max:10240']
            ]);
            if($validator->fails()){
                return $this->sendError('Validation errors', $validator->errors(), 422);
            }
            $logo = $this->processAndStoreImage($request, 'vendors');
        }

        $vendor = [
            'name' => $request->name,
            'location' => $request->location,
            'contact' => $request->contact,
            'type' => $request->type ? $request->type : null,
            'mobile' => $request->mobile ? $request->mobile : null,
            'email' => $request->email ? $request->email : null,
            'representative' => $request->representative ? $request->representative : null,
            'logo' => $logo
        ];

        $vendor = Vendor::create($vendor);

        return response()->json($vendor, 202);
    }
    public function updateVendor(Vendor $vendor, Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'location' => ['required'],
            'contact' => ['required'],
            'email' => ['nullable', 'email'],
        ]);

        if($validator->fails()){
            return $this->sendError('Validation errors', $validator->errors(), 422);
        }

        if($request->hasFile('image')){
            $validator =  Validator::make($request->all(), [
                'image' => ['mimes:jpeg,jpg,png,webp', 'max:10240']
            ]);
            if($validator->fails()){
                return $this->sendError('Validation errors', $validator->errors(), 422);
            }
            $logo = $this->processAndStoreImage($request, 'vendors');
        }else{
            $logo = $vendor->logo;
        }

        $vendor->name = $request->name;
        $vendor->location = $request->location;
        $vendor->contact = $request->contact;
        $vendor->type = $request->type ? $request->type : null;
        $vendor->mobile = $request->mobile ? $request->mobile : null;
        $vendor->email = $request->email ? $request->email : null;
        $vendor->representative = $request->representative ? $request->representative : null;
        $vendor->logo = $logo;

        $vendor->save();

        return response()->json($vendor, 202);
    }
    public function updateAsset(Asset $asset, Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'quantity' => ['nullable', 'numeric'],
            'cost' => ['nullable', 'numeric'],
        ]);

        if($validator->fails()){
            return $this->sendError('Validation errors', $validator->errors(), 422);
        }

        $image = null;
        if($request->hasFile('image')){
            $validator =  Validator::make($request->all(), [
                'image' => ['mimes:jpeg,jpg,png,webp', 'max:10240']
            ]);
            if($validator->fails()){
                return $this->sendError('Validation errors', $validator->errors(), 422);
            }
            $image = $this->processAndStoreImage($request);
        }else{
            $image = $asset->image;
        }

        $asset->name = $request->name;
        $asset->identity = $request->identity ? $request->identity : null;
        $asset->quantity = $request->quantity ? $request->quantity : null;
        $asset->cost = $request->cost ? $request->cost : null;
        $asset->description = $request->description ? $request->description : null;
        $asset->image = $image;

        $asset->save();

        return response()->json($asset, 202);
    }

    public function deleteAsset(Asset $asset){
        $asset->delete();

        return response()->json($asset, 202);
    }
    public function deleteVendor(Vendor $vendor){
        $vendor->delete();

        return response()->json($vendor, 202);
    }

}
