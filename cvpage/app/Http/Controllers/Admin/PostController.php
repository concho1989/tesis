<?php
namespace App\Http\Controllers\Admin;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Mail\UserMail;
use App\Post;
use App\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mail;

class PostController extends Controller {
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
	public function index() {
		$posts = Post::orderBy('id', 'ASC')
			->paginate();
		return view('admin.posts.index', compact('posts'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');
		$tags = Speciality::orderBy('name', 'ASC')->get();
		return view('admin.posts.create', compact('categories', 'tags'));
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(PostStoreRequest $request) {
		$post = Post::create($request->all());
		//$this->authorize('pass', $post);
		//IMAGE
		if ($request->file('file')) {
			$path = Storage::disk('public')->put('image', $request->file('file'));
			$post->fill(['file' => asset($path)])->save();
		}
		//TAGS
		$post->tags()->attach($request->get('tags'));
		return redirect()->route('posts.edit', $post->id)->with('info', 'Entrada creada con éxito');
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Post $slug) {
		/*$post = Post::find($slug);
			//$comments = $post->comments()->get();
			$this->authorize('pass', $post);
		*/
		//dd($slug->name);
		return view('admin.posts.show', compact('slug'));
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$post = Post::find($id);
		$this->authorize('pass', $post);
		$categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');
		$tags = Speciality::orderBy('name', 'ASC')->get();

		return view('admin.posts.edit', compact('post', 'categories', 'tags'));
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(PostUpdateRequest $request, $id) {
		$post = Post::find($id);
		$this->authorize('pass', $post);
		$post->fill($request->all())->save();
		//IMAGE
		if ($request->file('file')) {
			$path = Storage::disk('public')->put('image', $request->file('file'));
			$post->fill(['file' => asset($path)])->save();
		}
		//TAGS
		$post->tags()->sync($request->get('tags'));
		return redirect()->route('posts.edit', $post->id)->with('info', 'Entrada actualizada con éxito');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$post = Post::find($id);
		$this->authorize('pass', $post);
		$post->delete();
		return back()->with('info', 'Eliminado correctamente');
	}

	public function sendEmail(Request $request) {
		/*dd($request->all());*/
		Mail::to($request->email)->send(new UserMail($request->name,$request->content, $request->title));
		//echo "si jala";
	}

	public function sendEmailPerfil(Request $request) {
		dd($request->all());
		//Mail::to($request->email)->send(new UserMail($request->message, $request->subject, $request->name));
		echo "si jala";
	}
}