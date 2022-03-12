<?php

namespace App\Http\Controllers;
use App\Role;
use App\User;
use App\Photo;
use App\Http\traits\media;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminUsersController extends Controller
{
    use media;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users=User::all();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
        // return $request->all();

        // $input=$request->all();

        // if ($file=$request->input('photo_id')) {
        //    return 'photo exite';
        // }
        // dd($request->input('photo_id'));


        if (trim($request->password) == "") {
            # code...
            $input=$request->except('password');
        }else {

            $input=$request->all();
            $input['password']=bcrypt($request->password);
        }


        if ($file=$request->file('photo_id')) {
            # code.
            $imageName = $this->uploadMedia($request->photo_id, 'users');

            $photo=Photo::create(['file'=>$imageName]);
            $input['photo_id']=$photo->id;
        }
        // $input['password']=bcrypt($request->password);
        User::create($input);

        // User::create($request->all());
        return redirect('/admin/users');
        //storeAs
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('admin.users.show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user=User::findOrFail($id);
        $roles=Role::pluck('name','id')->all();
        return view('admin.users.edit',compact('user','roles'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request, $id)
    {
        //


        // $input=$request->all();
        if (trim($request->password) == "") {
            # code...
            $input=$request->except('password');
        }else {

            $input=$request->all();
            $input['password']=bcrypt($request->password);
        }



        $user=User::findOrFail($id);
        if ($file=$request->file('photo_id')) {
            # code...
            $imageName = $this->uploadMedia($request->photo_id, 'users');
            $photo=Photo::create(['file' =>$imageName]);
            $input['photo_id']=$photo->id;
        }
        $user->update($input);
        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // User::findOrFail($id)->delete();

        $user=User::findOrFail($id);
        Session::flash('deleted_user','The user has been deleted');

        //delete image from folder
        $this->deleteMedia($user->photo->file, 'users');
        // delete record from database
        $user->delete();
        return redirect('/admin/users');

    }
}
