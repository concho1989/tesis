<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Speciality;
use Datatables;

class SpecialityController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(TagStoreRequest $request) {
		if ($request->ajax()) {
			$data = Speciality::orderBy('id', 'DESC');
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function ($row) {
					$btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Editar</a>';

					$btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Eliminar</a>';
					return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}
		return view('admin.specialities.index', compact('data'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.specialities.create');
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(TagStoreRequest $request) {
		Speciality::updateOrCreate(['id' => $request->speciality_id],
			['name' => $request->name, 'slug' => $request->slug]);

		return response()->json(['success' => 'Especialidad creada correctamente.']);
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$speciality = Speciality::find($id);
		return view('admin.specialities.show', compact(speciality));
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$speciality = Speciality::find($id);
		return response()->json($speciality);
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(TagUpdateRequest $request, $id) {
		$speciality = Speciality::find($id);
		$speciality->fill($request->all())->save();
		return redirect()->route('specialities.edit', $speciality->id)->with('info', 'Especialidad actualizada con éxito');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		Speciality::find($id)->delete();
		return response()->json(['success' => 'Especialidad eliminada correctamente.']);
	}
}