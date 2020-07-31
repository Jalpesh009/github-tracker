<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GrahamCampbell\GitHub\Facades\GitHub;
use App\Repository;
use App\Commit;
use App\OwnGitRepository;

class GithubController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function createRepo(Request $request)
  {
    $request->validate([
            'name' => 'required|min:8',
            'description' => 'required',
          ]);
    try {
      $repo = GitHub::api('repo')->create($request->get('name'), $request->get('description'), '', true);
      //dd($repo);
      $flight = new Repository;
      $flight->user_id = \Auth::id();
      $flight->name = $repo['name'];
      $flight->url = $repo['clone_url'];
      $flight->cloned = false;
      $flight->git_res = json_encode($repo);;
      $flight->save();

      return redirect('home')->with('message', 'Repo create Success');
      //return back()->with('success', 'Repo create successfully');
    } catch (\Exception $exception) {
      return back()->withError($exception->getMessage())->withInput();
    }
  }

  public function cloneRepo($id,Request $request)
  {
    try {
      $flight = Repository::find($id);
      $repo = \Cz\Git\GitRepository::cloneRepository($flight->url, storage_path("app/git/{$flight->name}"));
      $flight->local_path="app/git/{$flight->name}";
      $flight->cloned=true;
      $flight->save();
      return redirect('home')->with('message', 'Repo clone Success');
      //return back()->with('success', 'Repo create successfully');
    } catch (\Exception $exception) {
      return back()->withError($exception->getMessage())->withInput();
    }
  }

  public function cloneFromGithub(Request $request)
  {
    $request->validate([
            'name' => 'required',
            'url' => 'required',
            'git_res' => 'required',
          ]);
    try {
      $flight = new Repository;
      $flight->user_id = \Auth::id();
      $flight->name = $request->get('name');
      $flight->url = $request->get('url');
      $flight->git_res = $request->get('git_res');
      $flight->cloned=true;
      $flight->save();
      $repo = \Cz\Git\GitRepository::cloneRepository($flight->url, storage_path("app/git/{$flight->name}"));
      $flight->local_path="app/git/{$flight->name}";
      $flight->save();
      return redirect('home')->with('message', 'Repo clone Success');
      //return back()->with('success', 'Repo create successfully');
    } catch (\Exception $exception) {
      return back()->withError($exception->getMessage())->withInput();
    }
  }

  public function removeFromGithub($name,Request $request)
  {
    try {
      $userName=env('GITHUB_USERNAME', '');
      //dd($userName);
      $repo = GitHub::api('repo')->remove($userName, $name);
      sleep(4);
      return redirect('home')->with('message', 'Repo clone Success');
      //return back()->with('success', 'Repo create successfully');
    } catch (\Exception $exception) {
      return back()->withError($exception->getMessage())->withInput();
    }
  }

  public function pushRepo($id,Request $request)
  {
    $request->validate([
            'msg' => 'required',
          ]);
    try {
      $flight = Repository::find($id);
      $repo = new OwnGitRepository(storage_path($flight->local_path));
      //$repo = \Cz\Git\GitRepository::init(storage_path($flight->local_path));
      $repo->addAllChanges();
      $repo->commit($request->get('msg'));
      $userName=env('GITHUB_USERNAME', '');
      $userPass=env('GITHUB_PASS', '');
      $repo->push(NULL, array('--repo' => "https://{$userName}:{$userPass}@github.com/{$userName}/{$flight->name}.git"));
      //dd($repo->getLastCommitId());
      $co = new Commit;
      $co->massage=$request->get('msg');
      $co->repo_id=$flight->id;
      $co->sha=$repo->getLastCommitId();
      $co->save();
      return redirect('home')->with('message', 'Push Success');
      //return back()->with('success', 'Repo create successfully');
    } catch (\Exception $exception) {
      return back()->withError($exception->getMessage())->withInput();
    }
  }

  public function viewRepo($id,Request $request)
  {
    $flight = Repository::find($id);
    $repo = new OwnGitRepository(storage_path($flight->local_path));
    $chnages=$repo->getChanges();
    return view('repo',['repo'=>$flight,'file_changes'=>$chnages]);
  }

}
