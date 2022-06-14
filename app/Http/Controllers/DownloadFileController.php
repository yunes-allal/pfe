<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Illuminate\Http\Request;

class DownloadFileController extends Controller
{
    function getCertificate($filename){
        $path = public_path('storage/candidats/certificates/'.$filename);
        return response()->download($path);
    }
    function getArticle($filename){
        $path = public_path('storage/candidats/articles/'.$filename);
        return response()->download($path);
    }
}
