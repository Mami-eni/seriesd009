<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

       $generator=Faker\Factory::create('fr_FR');

        for ( $i =0; $i<10; $i++)
        {
            $serie = new Serie();
            $serie->setBackdrop("frefrgrrtg".$i)
                ->setDateCreated(new \DateTime())
                ->setFirstAirDate(new \DateTime("-1 year"))
                ->setLastAirDate(new \DateTime("-6 month"))
                ->setGenre("western")
                ->setName("alea luke".$i)
                ->setPopularity(100.0)
                ->setPoster("hdezhflhrg")
                ->setStatus("returning")
                ->setTmdbId(125+$i)
                ->setVote(9.8+$i);
            //$manager->persist($serie);
        }

        for ( $i =0; $i<10; $i++)
        {
            $serie1 = new Serie();
            $serie1->setBackdrop($generator->address)
                ->setDateCreated(new \DateTime())
                ->setFirstAirDate(new \DateTime("-1 year"))
                ->setLastAirDate(new \DateTime("-6 month"))
                ->setGenre($generator->word)
                ->setName($generator->lastName)
                ->setPopularity(100.0)
                ->setPoster($generator->imageUrl())
                ->setStatus("returning")
                ->setTmdbId(125+$i)
                ->setVote(9.8+$i);
            //$manager->persist($serie1);
        }



       // $manager->flush();
    }
}
