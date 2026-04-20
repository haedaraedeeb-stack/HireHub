<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferStatusRequest;
use App\Http\Resources\OfferResource;
use App\Http\Services\OfferService;
use App\Models\Offer;
// use Illuminate\Http\Request;

class OfferController extends Controller
{
    protected $offerservice;

    public function __construct(OfferService $offerservice)
    {
        $this->offerservice = $offerservice;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfferRequest $request)
    {
        try {
            $offer = $this->offerservice->proposeOffer(
            $request->validated(),
            auth()->id()
        );
            return $this->success(new OfferResource($offer), 'Offer created successfuly.', 201);
        }catch (\Exception $e) {
            return $this->failed($e->getMessage(), 422);}
    }

    public function updateStatus(UpdateOfferStatusRequest $request, Offer $offer)
    {
        try {
            $updatedOffer = $this->offerservice->updateOfferStatus($offer, $request->status);
            return $this->success(
                new OfferResource($updatedOffer),
                'offer status updated successfuly .'
            );
        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        $offerWithDetails = $this->offerservice->getOfferDetails($offer);
        return $this->success(new OfferResource($offerWithDetails), 'Offer details retrieved.');
    }
}
