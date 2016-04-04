<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Addon as Addon;
use GuzzleHttp\Message\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AddonController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $addons = Addon::all();

        return view('addons.index')->with('Addons', $addons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('addons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required',
            ]);

        Addon::create($request->all());
        \Session::flash('flash_message', 'Addon has been created.');
        return redirect('addon');
    }

    public function ajaxCreate(Request $request)
    {
        $v = Validator::make($request->all(), ['name' => 'required']);

        if($v->fails()) {
            $messages = $v->errors();

            return Response()->json([
                'text' => $messages->first('name')
            ]);
        }

        $addon = new Addon();
        $addon->name = $request->name;
        $addon->save();

        return Response()->json([
            'text' => 'Add on has been updated.',
            'id' => $addon->id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $Addons = Addon::findOrFail($id);
        return view('addons.edit', compact('Addons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        $Addons = Addon::findOrFail($id);
        $Addons->update($request->all());

        \Session::flash('flash_message', 'Add on has been updated.');

        return redirect('addon');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function ajaxUpdate(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        $Addons = Addon::findOrFail($request->id);
        $Addons->update($request->all());

        return Response()->json([
            'text' => 'Add on has been updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Addon::find($id)->delete();
        \Session::flash('flash_message', 'Addon has been deleted.');
        return redirect('addon');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function ajaxDestroy(Request $request)
    {
        Addon::find($request->id)->delete();

        return Response()->json([
            'text' => 'Add on has been deleted.'
        ]);
    }

}
