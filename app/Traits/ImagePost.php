<?php
  namespace App\Traits;

  use Intervention\Image\Facades\Image;
  use File;
  use App\Models\Post;
  use App\Models\Image as ImageModel;
  use App\Http\Requests\PostEdit;
  

  trait ImagePost {

    public function uploadEditImage($file , Post $post , PostEdit  $request){
      if ($request->hasFile($file)) {
        $files = $request->file($file);
       
       // for save original image
       $ImageUpload = Image::make($files);
       $originalPath = public_path('/storage/post_image/');
       $ImageUpload->resize(340,340);
     
       $ImageUpload->save($originalPath.time().$files->getClientOriginalName());
        
       // for save thumnail image
       $thumbnailPath = public_path('/storage/thumbnail/post_thumbnail/');
       $ImageUpload->resize(250,125);
       $ImageUpload = $ImageUpload->save($thumbnailPath.time().$files->getClientOriginalName());

       $this->deleteImage($post);

       $image_model  = ImageModel::find($post->image_id);

       $image_model->path = time().$files->getClientOriginalName();
       
       $image_model->update();
       
       $post->images()->associate($image_model);

       return $image_model->path;
      
      }
    }
    

    public function deleteImage(Post $post){

        $oldImage = $post->images->path;
        $image_path = public_path('/storage/images/' . $oldImage);
        $image_thumbnail = public_path('/storage/thumbnail/'.$oldImage);

        if(File::exists($image_path) && File::exists($image_thumbnail) ) {
            File::delete($image_path);
            File::delete($image_thumbnail);
      }

    }

  }