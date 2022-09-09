<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:profiles', ['except' => ['update']]);
    }

    public function show(User $user, Profile $profile)
    {

        if ($profile->user_id == $user->id) {
            return response()->json(new ProfileResource($profile), Response::HTTP_OK);
        }

        return response()->json([], Response::HTTP_NOT_FOUND);
    }

    public function update(ProfileRequest $request, User $user, Profile $profile)
    {
        extract($request->validated());

        $folder = 'profiles';

        if ($profile->user_id == $user->id) {

            if (auth()->user()->id == $user->id) {

                if ($image = $request->url) {
                    $this->saveRelatedImage($folder, $image, $profile);
                }

                $profile->nickname = $nickname;
                $profile->save();

                return response()->json(new ProfileResource($profile), Response::HTTP_OK);
            }

            return response()->json([], Response::HTTP_FORBIDDEN);
        }

        return response()->json([], Response::HTTP_NOT_FOUND);
    }

    public function saveRelatedImage($folder, $image, $owner_model)
    {
        $path = Storage::disk('s3')->put($folder, $image, 'public');

        $owner_model->image()->updateOrCreate([
            'imageable_id' => $owner_model->id
        ], [
            'url' => $path,
            'size' => $image->getSize(),
            'extension' => $image->extension()
        ]);
    }
}
