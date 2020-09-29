<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_blogHome;
use App\Models\tb_blogEvents;
use App\Models\tb_blogNews;
use App\Models\tb_blogAssociates;

use Storage;
use File;
use Illuminate\Support\Facades\Response;

use Exception;

class BlogController extends Controller
{
    public function getHome()
    {
        return tb_blogHome::all();
    }

    public function storeHome(Request $request, tb_blogHome $home)
    {
        try {
            $home->description = $request->get('description');
            $home->mission = $request->get('mission');
            $home->vision = $request->get('vision');
            $home->our_group = $request->get('our_group');
            $home->address = $request->get('address');
            $home->ubication_maps = $request->get('ubication_maps');
            $home->email = $request->get('email');
            $home->phone_1 = $request->get('phone_1');
            $home->phone_2 = $request->get('phone_2');
            $home->time_start = $request->get('time_start');
            $home->time_end = $request->get('time_end');
            $home->url = $request->get('url');
            $home->save();
            return response()->json($home, 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function showHome($id)
    {
        try {
            $home = tb_blogHome::where('id', $id)->get();
            if ($home == null) {
                throw new Exception('Registro no encontrado');
            }
            return $home;
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateHome(Request $request, $id)
    {
        try {
            $home = tb_blogHome::find($id);

            if ($request->has('description')) {
                $home->description = $request->get('description');
            }

            if ($request->has('mission')) {
                $home->mission = $request->get('mission');
            }

            if ($request->has('vision')) {
                $home->vision = $request->get('vision');
            }

            if ($request->has('our_group')) {
                $home->our_group = $request->get('our_group');
            }

            if ($request->has('address')) {
                $home->address = $request->get('address');
            }
            if ($request->has('ubication_maps')) {
                $home->ubication_maps = $request->get('ubication_maps');
            }
            
            if ($request->has('email')) {
                $home->email = $request->get('email');
            }

            if ($request->has('phone_1')) {
                $home->phone_1 = $request->get('phone_1');
            }

            if ($request->has('phone_2')) {
                $home->phone_2 = $request->get('phone_2');
            }

            if ($request->has('time_start')) {
                $home->time_start = $request->get('time_start');
            }

            if ($request->has('time_end')) {
                $home->time_end = $request->get('time_end');
            }

            if ($request->has('url')) {
                $home->url = $request->get('url');
            }

            $home->save();

            return response()->json(['type' => 'success', 'message' => 'Actualizado correctamente'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyHome($id)
    {
        try {
            $home = tb_blogHome::find($id);
            if ($home == null) {
                throw new Exception('Registro no encontrado');
            }
            $home->delete();
            return response()->json(['type' => 'success', 'message' => 'Eliminado correctamente'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    /* Noticias */
    public function getNews()
    {
        return tb_blogNews::orderBy('created_at', 'desc')->take(5)->get();
        
    }

    public function storeNews(tb_blogNews $news, Request $request)
    {
        try {
            $news->author = $request->get('author');
            $news->title = $request->get('title');
            $news->description = $request->get('description');
            $news->source = $request->get('source');
            $news->url = $request->get('url');

           if($request->hasFile('image') && $request->file('image')->isValid())
    		{
        		$image = $request->file('image');
        		$filename = $request->file('image')->getClientOriginalName();
        		
        		Storage::disk('blog')->put($filename,  File::get($image));
        		
        		$news->image = $filename;
    		}
    		$news->date_news = $request->get('date_news');
    		$news->time_news = $request->get('time_news');
    		
            $news->save();

            return response()->json(['type' => 'success', 'message' => 'Se ha registrado', 'id' => $news->id], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function showNews($id)
    {
        try {
            $news = tb_blogNews::where('id', $id)->get();

            if ($news == null)
                throw new Exception('Registro no encontrado');

            return $news;
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateNews(Request $request, $id)
    {
        try {

            $news = tb_blogNews::find($id);
            
            if ($request->get('author')) {
                $news->author = $request->get('author');
            }

            if ($request->get('title')) {
                $news->title = $request->get('title');
            }

            if ($request->get('description')) {
                $news->description = $request->get('description');
            }

            if ($request->get('source')) {
                $news->source = $request->get('source');
            }

            if ($request->get('url')) {
                $news->url = $request->get('url');
            }


            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                
                Storage::disk('blog')->delete($news->image);
                
                $image = $request->file('image');
        		$filename = $request->file('image')->getClientOriginalName();
        		
        		Storage::disk('blog')->put($filename,  File::get($image));
        		
        		$news->image = $filename;
            }

            if ($request->get('date_news')) {
                $news->date_news = $request->get('date_news');
            }
    	
    	    if ($request->get('time_news')) {
                $news->time_news = $request->get('time_news');
            }

            $news->save();

            return response()->json(['type' => 'success', 'message' => 'Actualización registrada'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyNews($id)
    {
        try {
            $news = tb_blogNews::find($id);
            if ($news == null){
                throw new Exception('Registro no encontrado');
            }

            $news->delete();
            Storage::disk('blog')->delete($news->image);

            return response()->json(['type' => 'success', 'message' => 'Registro eliminado'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function eventsAll(){
        return tb_blogEvents::orderBy('date_event', 'desc')->get();
    }

    /* EVENTOS */
    public function getEvents()
    {
        //return tb_blogEvents::orderBy('updated_at', 'desc')->take(5)->get();
        //return tb_blogEvents::where('state', '0')->get();
        return tb_blogEvents::where('state', '0')->orderBy('date_event', 'desc')->take(5)->get();
    }

    public function eventsPast()
    {
        return tb_blogEvents::where('state', '1')->orderBy('date_event', 'desc')->get();
    }
    
    public function storeEvents(tb_blogEvents $event, Request $request)
    {
        try {
            $event = new tb_blogEvents();

            /* IMG1 */
            if ($request->hasFile('img_1') && $request->file('img_1')->isValid()) {
                $imagen = $request->file('img_1');
                $filename = $request->file('img_1')->getClientOriginalName();

               Storage::disk('blog')->put($filename,  File::get($imagen));

                $event->img_1 = $filename;
            }

            /* IMG2 */
            if ($request->hasFile('img_2') && $request->file('img_2')->isValid()) {
                $imagen = $request->file('img_2');
                $filename = $request->file('img_2')->getClientOriginalName();

               Storage::disk('blog')->put($filename,  File::get($imagen));
                $event->img_2 = $filename;
            }

            /* IMG3 */
            if ($request->hasFile('img_3') && $request->file('img_3')->isValid()) {
                $imagen = $request->file('img_3');
                $filename = $request->file('img_3')->getClientOriginalName();

                Storage::disk('blog')->put($filename,  File::get($imagen));

                $event->img_3 = $filename;
            }

            $event->name = $request->get('name');
            $event->description = $request->get('description');
            $event->date_event = $request->get('date_event');
            $event->save();

            return response()->json(['type' => 'success', 'message' => 'Registro completo', 'id' => $event->id], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function showEvents($id)
    {
        try {

            $event = tb_blogEvents::where('id', $id)->get();

            if ($event == null) {
                throw new Exception('Registro no encontrado');
            }

            return $event;
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateEvents(Request $request, $id)
    {
        try {

            $event = tb_blogEvents::find($id);

            if ($request->has('state')) {
                $event->state = $request->get('state');
            }

            if ($request->has('name')) {
                $event->name = $request->get('name');
            }

            if ($request->has('description')) {
                $event->description = $request->get('description');
            }

            if ($request->has('date_event')) {
                $event->date_event = $request->get('date_event');
            }

            /* IMG1 */
            if ($request->hasFile('img_1') && $request->file('img_1')->isValid()) {
                Storage::disk('blog')->delete($event->img_1);

                $imagen = $request->file('img_1');
                $filename = $request->file('img_1')->getClientOriginalName();

                Storage::disk('blog')->put($filename,  File::get($imagen));

                $event->img_1 = $filename;
            }

            /* IMG2 */
            if ($request->hasFile('img_2') && $request->file('img_2')->isValid()) {
                Storage::disk('blog')->delete($event->img_2);

                $imagen = $request->file('img_2');
                $filename = $request->file('img_2')->getClientOriginalName();

                Storage::disk('blog')->put($filename,  File::get($imagen));

                $event->img_2 = $filename;
            }

            /* IMG3 */
            if ($request->hasFile('img_3') && $request->file('img_3')->isValid()) {
                Storage::disk('blog')->delete($event->img_3);

                $imagen = $request->file('img_3');
                $filename = $request->file('img_3')->getClientOriginalName();

                Storage::disk('blog')->put($filename,  File::get($imagen));

                $event->img_3 = $filename;
            }

            $event->save();

            return response()->json(['type' => 'success', 'message' => 'Actualización registrada'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyEvents($id)
    {
        try {
            $event = tb_blogEvents::find($id);
            if ($event == null){
                throw new Exception('Registro no encontrado');
            }
            Storage::disk('blog')->delete($event->img_1);
            Storage::disk('blog')->delete($event->img_2);
            Storage::disk('blog')->delete($event->img_3);
            $event->delete();

            return response()->json(['type' => 'success', 'message' => 'Registro eliminado'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function image($fileName)
    {
        $path = public_path() . '/images/Blog/' . $fileName;
        return Response::download($path);
    }
    
   public function getAssociate()
    {
        return tb_blogAssociates::all();
    }

    public function storeAssociate(Request $request, tb_blogAssociates $associate)
    {
        try {
            $associate = new tb_blogAssociates();
            $associate->name = $request->get('name');
            $associate->website = $request->get('website');
            $associate->address = $request->get('address');

           if($request->hasFile('img') && $request->file('img')->isValid())
    		{
        		$image = $request->file('img');
        		$filename = $request->file('img')->getClientOriginalName();
        		
        		Storage::disk('blog')->put($filename,  File::get($image));
        		
        		$associate->img = $filename;
    		}

            $associate->save();
            
            return response()->json(['type' => 'success', 'message' => 'Se ha registrado', 'id' => $associate->id], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function showAssociate($id)
    {
        try {
            $associate = tb_blogAssociates::where('id', $id)->first();
            
            if ($associate == null){
                throw new Exception('Registro no encontrado');
            }
            
            return $associate;
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateAssociate(Request $request, $id)
    {
        try {
            $associate = tb_blogAssociates::find($id);

            if ($request->has('name')) {
                $associate->name = $request->get('name');
            }

            if ($request->has('website')) {
                $associate->website = $request->get('website');
            }
            if ($request->has('address')) {
                $associate->address = $request->get('address');
            }

            if ($request->hasFile('img') && $request->file('img')->isValid()) {
                Storage::disk('blog')->delete($associate->img);
                
        		$imagen = $request->file('img');
        		$filename = $request->file('img')->getClientOriginalName();
        		
        		Storage::disk('blog')->put($filename,  File::get($imagen));
        		
        	    $associate->img = $filename;
            }

            $associate->save();

            return response()->json(['type' => 'success', 'message' => 'Actualización registrada'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function destroyAssociate($id)
    {
        try {
            $associate = tb_blogAssociates::find($id);

            if ($associate == null){
                throw new Exception('Registro no encontrado');
            }
            Storage::disk('blog')->delete($associate->img);

            $associate->delete();
            return response()->json(['type' => 'success', 'message' => 'Registro eliminado'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }   
}
