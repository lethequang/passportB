<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

Route::get('/',function(){
	return view('welcome');
});
Route::get('/redirect', function () {
	$query = http_build_query([
		'client_id' => '4',
		'redirect_uri' => 'http://127.0.0.1:8001/callback',
		'response_type' => 'code',
		'scope' => '',
	]);

	return redirect('http://127.0.0.1:8000/oauth/authorize?'.$query);
})->name('get.token');

Route::get('/callback', function (Request $request) {

	//$https = new GuzzleHttp\Client;
	$https = new Client();
	$response = $https->post('http://127.0.0.1:8000/oauth/token', [
		'form_params' => [
			'grant_type' => 'authorization_code',
			'client_id' => '4',
			'client_secret' => 'JKAyONSstMXtL7vCbJoPPApVPBwgMRHsDMQoyHoZ	',
			'redirect_uri' => 'http://127.0.0.1:8001/callback',
			'code' => $request->code,
		],
	]);

	return json_decode((string) $response->getBody(), true);
});

