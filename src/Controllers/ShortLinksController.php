<?php

namespace Sharelov\Shortener\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Sharelov\Shortener\Facades\Shortener;

class ShortLinksController extends Controller
{
    /**
     * Show the form for creating the new link.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $hash = Shortener::make($request->url, $request->expires_at);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $domain = trim(rtrim(config('shortener.domain'), '/'));
        $path = trim(rtrim(config('shortener.path'), '/'));

        if (!$domain) {
            throw new ValidationException('Can\'t generate a valid url, check your shortener.php configuration');
        }

        $url = $domain.'/'.$hash;

        if ($path) {
            $url = $domain.'/'.$path.'/'.$hash;
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new ValidationException('Can\'t generate a valid url, check your shortener.php configuration');
        }

        return response()->json([
            'success' => true,
            'hash'    => $hash,
            'url'     => $url,
        ], Response::HTTP_CREATED);
    }

    /**
     * Translate a redirect or return error mesage.
     *
     * @param $hash
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function translateHash($hash)
    {
        $url = Shortener::getUrlByHash($hash);

        abort_unless($url, Response::HTTP_NOT_FOUND);

        return redirect()->to($url);
    }
}
