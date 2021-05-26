<?php

namespace App\Command;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateSeriesCommand extends Command
{
    protected static $defaultName = 'app:update-series';
    protected static $defaultDescription = 'update last 2 years series';
    private $entityManager;

    public function __construct(string $name = null, EntityManagerInterface  $entityManager)
    {
        parent::__construct($name);
        $this->entityManager= $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
           // ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
           // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
       // $arg1 = $input->getArgument('arg1');

       // if ($arg1) {
          //  $io->note(sprintf('You passed an argument: %s', $arg1));
       // }

      //  if ($input->getOption('option1')) {
            // ...
      //  }


        $io->error("ça ne marche pas !");
        $io ->write("suppresion des series service personnalisé");

        $serieRepository = $this->entityManager->getRepository(Serie::class);
        $series  = $serieRepository->findAll();

        $date= new \DateTime();
        $date->modify('- 1 years');

        /**
         * @var serie $serie
         */

        foreach ($series as $serie)
        {
            if($serie->getLastAirDate()<$date)
            {
                $this->entityManager->remove($serie);
            }

        }

        $this->entityManager->flush();

        $io->success('ça a été supprimé');

        return Command::SUCCESS;
    }
}
