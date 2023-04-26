<?php

namespace App\Command;

//use Symfony\Component\Console\Attribute\AsCommand;
//use Symfony\Component\Console\Command\Command;
//use Symfony\Component\Console\Input\InputArgument;
//use Symfony\Component\Console\Input\InputInterface;
//use Symfony\Component\Console\Input\InputOption;
//use Symfony\Component\Console\Output\OutputInterface;
//use Symfony\Component\Console\Style\SymfonyStyle;

//#[AsCommand(
//    name: 'fruits:fetch',
//    description: 'Add a short description for your command',
//)]
//class FruitsFetchCommand extends Command
//{
//    protected function configure(): void
//    {
//        $this
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//        ;
//    }
//
//    protected function execute(InputInterface $input, OutputInterface $output): int
//    {
//        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');
//
//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }
//
//        if ($input->getOption('option1')) {
//            // ...
//        }
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
//
//        return Command::SUCCESS;
//    }
//}


namespace App\Command;

use App\Entity\Fruits;
use App\Entity\Nutritions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FruitsFetchCommand extends Command
{
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;

		parent::__construct();
	}

	protected function configure()
	{
		$this
			->setName('fruits:fetch')
			->setDescription('Fetches fruits data from external source')
			->setHelp('This command fetches fruits data from external source and updates the database');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$httpClient = HttpClient::create();

		try {
			$response = $httpClient->request('GET', 'https://fruityvice.com/api/fruit/all');
			if ($response->getStatusCode() == 200) {
				$fruitsData = json_decode($response->getContent(), true);

				foreach ($fruitsData as $fruitData) {
					$fruit = new Fruits();
					$fruit->setName($fruitData['name']);
					$fruit->setFamily($fruitData['family']);
					$fruit->setOrder($fruitData['order']);
					$fruit->setGenus($fruitData['genus']);

					// Add or update nutritions for the fruit
					$nutrition = $fruit->getNutritions()->first() ?: new Nutritions();
					$nutrition->setCalories($fruitData['calories']);
					$nutrition->setFat($fruitData['fat']);
					$nutrition->setSugar($fruitData['sugar']);
					$nutrition->setCarbohydrates($fruitData['carbohydrates']);
					$nutrition->setProtein($fruitData['protein']);

					$fruit->setNutritions($nutrition);

					$this->entityManager->persist($fruit);
					$this->entityManager->flush();
				}

				$output->writeln('Fruits data fetched and updated in the database successfully!');
			} else {
				$output->writeln('Failed to fetch fruits data from external source. HTTP status code: ' . $response->getStatusCode());
			}
		} catch (ClientException|TransportException|BadRequestHttpException $e) {
			// Handle exceptions that may occur during the HTTP request
			$output->writeln('Failed to fetch fruits data from external source. Exception: ' . $e->getMessage());
		}

		return Command::SUCCESS;
	}
}
