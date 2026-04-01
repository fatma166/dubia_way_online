<?php
namespace App\Traits;
use Illuminate\Http\Request;
trait UploadAttachTrait {
public function Upload($data, $folder, $resize=false) {
    $allowedFileExtensions = ['pdf', 'jpg', 'png', 'docx', 'PNG', 'JPEG', 'jpeg', 'gif', 'pjpeg'];
    $images = [];

    // Ensure the folder exists
    $folderPath = public_path('/images/' . $folder);
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    foreach ($data as $file) {
        $extension = $file->getClientOriginalExtension();

        // Check if the file extension is allowed
        if (in_array($extension, $allowedFileExtensions)) {
            $imagePath = $folderPath . '/' . time() . '.' . $extension;

            // Handle image resizing if requested
            if ($resize && in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                $img = Image::make($file); // Create an image instance from the uploaded file
                $img->resize(1170, 500); // Resize the image
                $img->save($imagePath); // Save the resized image
            } else {
                // Move the file to the destination without resizing
                $file->move($folderPath, time() . '.' . $extension);
            }

            // Store the image path
            $images[] = 'images/' . $folder . '/' . time() . '.' . $extension;
        }
    }

    return $images;
}

    public function UploadFiles($file, $folder){

        $filename = $file->getClientOriginalName();
        $f_name_array = explode('.', $filename);
        $f_file_ext = end($f_name_array);
        $file_name = microtime().'.'.$f_file_ext;
        $file->move('images/'.$folder, $file_name);
        return $folder.'/'.$file_name;
    }
}
