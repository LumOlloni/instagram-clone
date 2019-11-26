<?php

namespace App\Traits;

use App\Models\Profile;
use Intervention\Image\Facades\Image;
use File;

use App\Http\Requests\ProfileValidation;
use App\Models\Image as ImageModel;

trait ImageService
{

  public  function uploadEditImage($file, Profile $profile, ProfileValidation  $request)
  {

    if ($request->hasFile($file)) {

      $files = $request->file($file);

      // for save original image
      $ImageUpload = Image::make($files);
      $originalPath = public_path('/storage/image_users/');
      $ImageUpload->resize(340, 340);

      $ImageUpload->save($originalPath . time() . $files->getClientOriginalName());

      // for save thumnail image
      $thumbnailPath = public_path('/storage/thumbnail/');
      $ImageUpload->resize(250, 125);
      $ImageUpload = $ImageUpload->save($thumbnailPath . time() . $files->getClientOriginalName());

      $this->deleteImage($profile);
      // dd($profile->image_id);
      $image = ImageModel::find($profile->image_id);

      $image->path = time() . $files->getClientOriginalName();
      $image->update();
      $profile->images()->associate($image);

      return $image->path;
      
    }
  }




  public function uploadCreateImage($file, Profile $profile, ProfileValidation  $request)
  {

    if ($request->hasFile($file)) {

      $files = $request->file($file);

      // for save original image
      $ImageUpload = Image::make($files);
      $originalPath = public_path('/storage/image_users/');
      $ImageUpload->resize(340, 340);



      $ImageUpload->save($originalPath . time() . $files->getClientOriginalName());

      // for save thumnail image
      $thumbnailPath = public_path('/storage/thumbnail/');
      $ImageUpload->resize(250, 125);
      $ImageUpload = $ImageUpload->save($thumbnailPath . time() . $files->getClientOriginalName());

      // Insert Image name in database
      $img = new  ImageModel;

      $img->path = time() . $files->getClientOriginalName();
      $img->section = 'profile';
      $profile->image_id = $img->id;
      $img->save();
      $profile->images()->associate($img);

      return $img->path;
    }
  }


  public function deleteImage(Profile $profile)
  {

    $oldImage = $profile->images->path;
    $image_path = public_path('/storage/images/' . $oldImage);
    $image_thumbnail = public_path('/storage/thumbnail/' . $oldImage);

    if (File::exists($image_path) && File::exists($image_thumbnail)) {
      File::delete($image_path);
      File::delete($image_thumbnail);
    }
  }
}
