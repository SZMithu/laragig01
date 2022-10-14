<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //show all listing
   public function index()
   {
    return view('listings.index', [
        'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
    ]);
   }
   //show single listing
   public function show(Listing $listing)
   {
    return view('listings.show', [
        'listing' => $listing
    ]);
   }
   //show listing view
   public function create()
   {
     return view('listings.create');
   }
   //Creat listing
   public function store(Request $request)
   {
    $formFields = $request->validate([
        'company' => ['required', Rule::unique('listings', 'company')],
        'title' => ['required', 'string'],
        'location' => ['required', 'string'],
        'email' => ['required', 'email'],
        'website' => ['required', 'string'],
        'tags' => ['required', 'string'],
        'description' => ['required', 'string'],
    ]);
    if($request->hasfile('logo')){
        $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }
    $formFields['user_id'] = auth()->id();
    Listing::create($formFields);
    return redirect('/')->with('message', 'Listing created successfully');
   }
   //Show Edit Form
   public function edit(Listing $listing)
   {
    return view('listings.edit', ['listing' => $listing]);
   }
   //Update Listing
   public function update(Request $request, Listing $listing)
   {
    //Make sure Logged in user is owner
    if($listing->user_id != auth()->id()){
        abort(403, 'Unauthorized Action');
    }
    $formFields = $request->validate([
        'company' => 'required',
        'title' => ['required', 'string'],
        'location' => ['required', 'string'],
        'email' => ['required', 'email'],
        'website' => ['required', 'string'],
        'tags' => ['required', 'string'],
        'description' => ['required', 'string'],
    ]);
    if($request->hasfile('logo')){
        $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $listing->update($formFields);

    return back()->with('message', 'Listing updated successfully');
   }

   //Delete listing
   public function destroy(Listing $listing)
   {
    //Make sure Logged in user is owner
    if($listing->user_id != auth()->id()){
        abort(403, 'Unauthorized Action');
    }
    $listing->delete();
    return redirect('/')->with('message', 'Listing Deleted Successfully');
   }
   //Manage Listing
   public function manage()
   {
    return view('listings.manage', ['listings'=>auth()->user()->listings()->get()]);
   }
}



