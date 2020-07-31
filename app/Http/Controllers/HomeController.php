<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GrahamCampbell\GitHub\Facades\GitHub;
use App\Repository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     function searcharray($value, $key, $array) {
       foreach ($array as $k => $val) {
           if ($val[$key] == $value) {
               return $k;
           }
       }
       return null;
    }

    public function index()
    {
        $dbRepos = Repository::all();
        $plucked = $dbRepos->pluck('url')->toArray();
        // dd($plucked->toArray());

        // $client = new \Github\Client();
        // $organizationApi = $client->api('organization');
        // $paginator  = new \Github\ResultPager($client);
        // $parameters = array('github', 'all', 1);
        // $result     = $paginator->fetchAll($organizationApi, 'repositories', $parameters);
        // dd($paginator->hasNext());

        $repos = GitHub::api('user')->myRepositories(['visibility'=>'public','sort'=>'created','direction'=>'desc','per_page'=>100]);
        if($dbRepos->isNotEmpty()){
          foreach ($repos as $key => $value) {
            if (in_array($value['clone_url'], $plucked)){
              $repos[$key]['db_row']=$dbRepos->toArray()[array_search($value['clone_url'], $plucked)];
            }
          }
        }

        //dd($repos);

        return view('home',['repos'=>$repos]);
    }
}
