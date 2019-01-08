<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exemplary;
use App\Models\Publication;
use App\Http\Resources\PublicationResource;
use Symfony\Component\HttpFoundation\Response;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = Publication::with('exemplaries')->get();

        return PublicationResource::collection($publications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $publication = Publication::create($request->all());

        // Inserting Exemplaries join with Publications
        $qtd_exemplaries = $request->qtd_exemplaries;
        for ($i=0; $i < $qtd_exemplaries; $i++) {
            Exemplary::create([
                'publication_id' => $publication->id,
            ]);
        }

        return new PublicationResource($publication);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Publication $publication)
    {
        return new PublicationResource($publication);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publication $publication)
    {
        $publication->update($request->all());

        return new PublicationResource($publication);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publication $publication)
    {
        $publication->delete();

        return response()->json($publication, Response::HTTP_NO_CONTENT);
    }
}
