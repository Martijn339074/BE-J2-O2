<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magazijn;

class MagazijnController extends Controller
{
    private $magazijnModel;

    // Constructor to inject MagazijnModel
    public function __construct(Magazijn $magazijnModel)
    {
        $this->magazijnModel = $magazijnModel;
    }

    public function index()
    {
        // Fetch all magazijns
        $magazijns = $this->magazijnModel->getMagazijns();
    
        $data = [
            'title' => 'Overzicht Magazijn Jamin',
            'message' => null,
            'messageColor' => null,
            'messageVisibility' => 'display: none;',
            'magazijns' => $magazijns,
        ];
    
        return view('magazijn.index', $data);
    }

    public function leveringInfo($productId)
    {
        // Get product and levering information
        $productInfo = $this->magazijnModel->getProductDetails($productId);
        $leveringInfo = $this->magazijnModel->getLeveringInfo($productId);

        // If product is out of stock
        if (!$productInfo || $productInfo->AantalAanwezig <= 0) {
            $nextDelivery = $this->magazijnModel->getNextExpectedDelivery($productId);
            $data = [
                'title' => 'Levering Informatie',
                'message' => "Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende levering is: " . 
                            ($nextDelivery ? date('d-m-Y', strtotime($nextDelivery)) : 'onbekend'),
                'messageColor' => 'warning',
                'messageVisibility' => 'display: block;',
                'redirect' => true,
                'redirectUrl' => route('magazijn.index'),
                'redirectTime' => 4000
            ];
        } else {
            $data = [
                'title' => 'Levering Informatie',
                'product' => $productInfo,
                'leverancier' => $leveringInfo['leverancier'],
                'leveringen' => $leveringInfo['leveringen'],
                'messageVisibility' => 'display: none;',
            ];
        }

        return view('magazijn.leveringinfo', $data);
    }

    public function allergenenInfo($productId)
    {
        // Get allergenen info for the product
        $allergenenInfo = $this->magazijnModel->getAllergenenInfo($productId);

        // If no allergens are found
        if (empty($allergenenInfo['allergenen'])) {
            $data = [
                'title' => 'Overzicht Allergenen',
                'product' => $allergenenInfo['product'],
                'message' => "In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken",
                'redirect' => true,
                'redirectUrl' => route('magazijn.index'),
                'redirectTime' => 4000
            ];
        } else {
            $data = [
                'title' => 'Overzicht Allergenen',
                'product' => $allergenenInfo['product'],
                'allergenen' => $allergenenInfo['allergenen']
            ];
        }

        return view('magazijn.allergeneninfo', $data);
    }
}
