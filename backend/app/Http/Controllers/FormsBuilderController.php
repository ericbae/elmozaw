<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request, DB,
    App\Models\Form,
    App\Models\FormElement;

/**
    @Description
*/
class FormsBuilderController extends Controller
{
    /**
	 * This API endpoint is to create a new form and the elements inside it
	 *
	 *  {POST} /forms
	 *
	 * apiSampleRequest http://api.elmozaw-survey.test/api/build-forms/build
	 *
	 */
    public function create(Request $req, $formId = null) {
        // if form ID is not passed in, the request is to initiate the form without the elements in it yet.
        if (empty($formId)) {
            $form = new Form();
            $form->name = 'Placeholder name';
            $form->save();
            // return the ID of newly initiated form to FE so that elements can be added to that form
            return response()->json($form->id);
        } else {
            // otherwise, request is to add elements to the existing form
            $formElement = new FormElement();
            // if form name is to be updated in request
            if ($req->formName) {
                Form::where('id', $formId)->update(['name' => $req->formName]);
            }
            // prepare the data to store into DB
            $formElement->form_id = $formId;
            $formElement->label = $req->label;
            $formElement->type = $req->type;
            $formElement->save();
            return response()->json('Successfully saved!');
        }
    }
}
