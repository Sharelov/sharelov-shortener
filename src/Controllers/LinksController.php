<?php

namespace Sharelov\Shortener\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Shortener;
use Sharelov\Shortener\Exceptions\NonExistentHashException;

class LinksController extends Controller
{
    //
    
    /*

    * Show the form for creating the new link

    *

    * @return Response

    */

    public function store (Request $request)
    {
        try
        {
            $hash = Shortener::make($request->url);
        }

        catch (ValidationException $e)
        {
            return response()->json(['success' => 'false','hash'=>'','url'=>'']);
        }
        $url = url('sh/'.$hash);
        $value = config('app.sh-domain');
        if($value){
            $url = $value."/".$hash;
        }
        return response()->json(['success' => 'true','hash'=>$hash,'url'=>$url]);
    }
    /*

    * Translate a redirect or return error mesage

    *

    * @return Response

    */

    public function translateHash ($hash)
    {
        try
        {
            $url = Shortener::getUrlByHash($hash);
            return redirect()->to($url);
        }

        catch (NonExistentHashException $e)
        {
            abort(404);
        }


    }
}
