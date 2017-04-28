<?php

namespace App\Http\Controllers\Dashboard;

use App\Interesting;
use App\Mail\AccountCreated;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('dashboard.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'name' => 'required',
            'email' => 'required|email|unique:users,email'
        ]);
        $request->merge(['password'=>substr(str_shuffle('23456789abcdefghjkmnpqrstuvwxyz'),0,6)]);
       // return $request->all();
        $user = User::create($request->all());
        if($request->hasFile('image')){
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = $user->id.'-user.'. $extension;
            $path = public_path('images/users/');
            $image->move($path, $filename);
            $user->image = $filename;
            $user->save();
        }
        Mail::to($user->email)->send(new AccountCreated($request));
        $user->password = bcrypt($request->input('password'));
        $user->save();
        session()->flash("toastr", ["message" => "Admin user created successfully.", "title" => "Created!", "type" => "success"]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id
        ]);
        $user->update($request->all());
        if($request->hasFile('image')){
            if(!empty($user->image) && file_exists(public_path('images/users/'.$user->image))){
                unlink(file_exists(public_path('images/users/'.$user->image)));
            }
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = $user->id.'-user.'. $extension;
            $path = public_path('images/users/');
            $image->move($path, $filename);
            $user->image = $filename;
            $user->save();
        }

        session()->flash("toastr", ["message" => "Admin account updated successfully.", "title" => "Updated!", "type" => "success"]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->delete()) {
            if(Storage::disk('local')->exists('images/users/'.$user->image) && !empty($user->image)){
                Storage::disk('local')->delete('images/users/'.$user->image);
            }
            session()->flash("toastr", ["message" => "User deleted successfully.", "title" => "Deleted!", "type" => "success"]);
            return redirect()->action('Dashboard\UserController@index');
        }

        session()->flash("toastr", ["message" => "User can not be deleted.", "title" => "Oops!", "type" => "error"]);
        return back();
    }


    /**
     * Display a listing of the interesting users.
     *
     * @return \Illuminate\Http\Response
     */
    public function interesting(){
            $users = Interesting::distinct('email')->orderBy('updated_at','desc')->paginate(20);
            Interesting::whereStatus(0)->update(['status'=>1]);
            Activity::whereLogName('search')->update(['status'=>1]);
            return view('dashboard.users.interesting',compact('users'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Interesting  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_interesting($id)
    {
        $interesting = Interesting::findOrFail($id);
        if($interesting->delete()) {
            session()->flash("toastr", ["message" => "Interested User deleted successfully.", "title" => "Deleted!", "type" => "success"]);
        }else{
            session()->flash("toastr", ["message" => "Interested User can not be deleted.", "title" => "Oops!", "type" => "error"]);
        }

        return back();
    }

}
