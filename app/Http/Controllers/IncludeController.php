<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Addons as Addons;
use Illuminate\Http\Request;




class AddonsController extends Controller {

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
				$Addons = Addons::all();
				return view('addons.index')->with('Addons',$Addons);
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
				'price' => 'required|integer',
			]);
			Addons::create($request->all());
			\Session::flash('flash_message', 'Addons has been created.');
			return redirect('addons');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$addons = Addons::findOrFail($id);
		return view('addons.edit',  compact('addons'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request )
	{
		$this->validate($request,
			[
			'name' => 'required',
			'price' => 'required|integer',
		]);
		$addons = Addons::findOrFail($id);
		$addons->update($request->all());
		\Session::flash('flash_message', 'Addons has been Updated.');
		return redirect('addons');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Addons::find($id)->delete();
		\Session::flash('flash_message', 'Addons has been deleted.');
		return redirect('addons');
	}

}
