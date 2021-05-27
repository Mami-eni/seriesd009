<?php


namespace App\Upload;


use App\Entity\Serie;

class SerieImage
{
    public function save($file, Serie $serie, $directory)
    {
        $newFileName = $serie->getName().'-'.uniqid().'.'.$file->guessExtension(); // renommage du nom du fichier à sauvegarder
        $file->move($directory, $newFileName);
        $serie->setPoster($newFileName);
    }

}