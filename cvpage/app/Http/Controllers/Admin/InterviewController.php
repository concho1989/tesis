<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\InterviewStoreRequest;
use App\Http\Requests\InterviewUpdateRequest;
use App\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$interviews = Interview::orderBy('id', 'DESC')->paginate();
		return view('admin.interviews.index', compact('interviews'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.interviews.create');
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(InterviewStoreRequest $request) {
		$interview = Interview::create($request->all());
		return redirect()->route('interviews.edit', $interview->id)->with('info', 'Entrevista creada con éxito');
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$interview = Interview::find($id);
		return view('admin.interviews.show', compact('interview'));
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$interview = Interview::find($id);
		return view('admin.interviews.edit', compact('interview'));
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(InterviewUpdateRequest $request, $id) {
		$interview = Interview::find($id);
		$interview->fill($request->all())->save();
		return redirect()->route('interviews.edit', $interview->id)->with('info', 'Entrevista actualizada con éxito');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$interview = Interview::find($id)->delete();
		return back()->with('info', 'Eliminado correctamente');
	}
}