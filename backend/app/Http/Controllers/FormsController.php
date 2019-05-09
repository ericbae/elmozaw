<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    Illuminate\Support\Facades\Storage,
    App\Models\Form,
    App\Models\FormElement;


/**
    @Description
*/
class FormsController extends Controller
{
    /**
	 * This API endpoint is to return the list of all the forms that user have created
	 *
	 *  {GET} /forms
	 *
	 * apiSampleRequest http://api.elmozaw-survey.test/api/forms
	 *
	 */
    public function list() {
        $forms = Form::all();
        return response()->json($forms);
    }

      /**
	 * This API endpoint is to get details of 1 specific form
	 *
	 *  {GET} /forms
	 *
	 * apiSampleRequest http://api.elmozaw-survey.test/api/forms/1
	 *
	 */
    public function view(Request $req, $formId = null) {
        // formID must be passed in
        if (empty($formId)) {
            return response()->json([
                'error' => 'form ID missing'
              ], 400);
        }

        $elements = Form::find($req->formId)->elements;
        return response()->json($elements);
    }

    /**
	 * This API endpoint is to edit the values of the form fields
	 *
	 *  {POST} /forms/{formId}
	 *
	 * apiSampleRequest http://api.elmozaw-survey.test/api/forms/{formId}
	 *
	 */
    public function edit(Request $req, $formId = null) {
         // formID must be passed in to edit it
         if (empty($formId)) {
            return response()->json([
                'error' => 'form ID missing'
            ], 400);
        }
        // first convert json string of data into php array
        $elements = json_decode($req->data,true);
        // after we get the data, lets go through it and update/store into DB
        foreach($elements as $index => $element) {
            // we wont be storing file in this request as file upload is handle seperated via FormsController@fileUpload
            if ($element['type'] == 'file') {
                continue;
            }
            $formElement = FormElement::find($element['id']);
            $formElement->value = $element['value'];
            $formElement->save();
        }
        return response()->json('Successfully updated!.');
    }

     /**
	 * This API endpoint is solely to handle the file upload
	 *
	 *  {POST} /forms/{formId}
	 *
	 * apiSampleRequest http://api.elmozaw-survey.test/api/upload/{formId}
	 *
	 */
    public function fileUpload(Request $req, $formElementId) {
        if (empty($req->file) || empty($formElementId)) {
            return response()->json([
                'error' => 'Required post data missing.'
              ], 400);
        }
        // we will initiate 's3' object here so that, we can use it to upload file to our s3 bucket
        $s3 = Storage::disk('s3');
        /*
            If the input type is 'file', we need to upload to s3 bucket or any file systems we like to use
            i am using s3 here since i am comfortable with it.

            I decided to design the folder structure in following way assuming i have the user_id who is uploading the file
            'env' -> 'hashed user ID' -> uploaded date -> filename.type
            where 'env' is the server environment we are uploading from , in our case 'develop'
                    'hashed user ID' we can do md5 hash version of user ID so that user IDs are not exposed
                    'uploaded date' date of current time that file was uploaded
                    then comes the file

            if our application grows and if the million of files were uploade every minute, we might also further break down the folder
            structure to
                'env' -> 'hashed user ID' -> day -> hour -> mins -> filename.type

            Since my application doess not have actual active user, i will not be using user ID in the folder structure :
            'env' -> uploaded date -> filename.type
        */
        if ($element['type'] == 'file') {
            // build the directory to store to s3
            $s3directory = env('APP_ENV') . '/' . date("Y/m/d") . '/';
        }
        $filename = pathinfo($req->file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = pathinfo($req->file->getClientOriginalName(), PATHINFO_EXTENSION);
        $fullFileName  = $filename . $ext;
        $s3UploadPath = $s3directory . $fullFileName;

        // upload file to S3 bucket, first param: exact path+filename  to store to S3, third param if it is public or private, for now will keep as public
        if (!$s3->put($s3UploadPath, file_get_contents($file), $s3access)) {
            // something went wrong while uploading file to s3
            return response()->json([
                'error' => 'unable to upload file to s3.'
              ], 500);
        }
        // after successfully uploaded to s3 bucket, GET s3 url
        $s3Url = $s3->url($s3UploadPath);
        $formElement = FormElement::find($formElementId);
        /*
            For the sake of the time, i will just be storing the s3url which is the public url to access the file.
            But, i could also do the 'meta' type of json_encoded array fiile related data that involve, filename, filesize, s3 directory, etc.
            we could even keep another file_store table type and keep the record of our files there. So bascially, we will have blue print of file records in our
            database as well as on the s3.
        */
        $formElement->value = $s3Url;
        $formElement->save();

        return response()->json($s3Url);
    }

    /**
	 * This API endpoint is to delete the form and its associated elements in it.
	 *
	 *  {DELETE} /forms/{formId}
	 *
	 * apiSampleRequest http://api.elmozaw-survey.test/api/forms/{formId}
	 */
    public function delete(Request $req, $formId = null) {
        // formID must be passed in to delete it
        if (empty($formId)) {
            return response()->json([
                'error' => 'form ID missing'
            ], 400);
        }
        // first delete the form data
        $res = Form::where(['id' => $formId])->delete();
        // if form is successfully deleted, also delete all the associated elements in it
        if ($res) {
            FormElement::where(['form_id' => $formId])->delete();
        }
        return response()->json("Successfully deleted");
    }

}
