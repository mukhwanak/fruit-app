<?php

namespace App\Command;

use App\Entity\Fruit;
use App\Entity\Nutrition;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FruitsFetchCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private $emailService;
    private string $adminEmail;

    public function __construct(EntityManagerInterface $entityManager, EmailService $emailService)
    {
        $this->entityManager = $entityManager;
         $this->emailService = $emailService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('fruits:fetch')
            ->setDescription('Fetches fruits data from external source')
            ->setHelp('This command fetches fruits data from external source and updates the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $httpClient = new GuzzleClient([
            'verify' => false,
        ]);

        try {
            $response = $httpClient->request('GET', 'https://fruityvice.com/api/fruit/all');

            if ($response->getStatusCode() == 200) {
                $fruitsData = json_decode($response->getBody(), true);

                foreach ($fruitsData as $fruitData) {
                    $fruit = $this->entityManager->getRepository(Fruit::class)->findOneBy(['name' => $fruitData['name']]);

                    if (!$fruit) {
                        // Create a new fruit if it does not exist
                        $fruit = new Fruit();
                        $fruit->setName($fruitData['name']);
                        $fruit->setFamily($fruitData['family']);
                        $fruit->setOrder($fruitData['order']);
                        $fruit->setGenus($fruitData['genus']);

                        $this->entityManager->persist($fruit);
//                        $this->entityManager->flush();
                    }else {
                    // Update the properties of an existing fruit
                    $fruit->setFamily($fruitData['family']);
                    $fruit->setOrder($fruitData['order']);
                    $fruit->setGenus($fruitData['genus']);
                }

                    // Add or update nutritions for the fruit
                    $nutritions = $fruit->getNutritions();
                    if ($nutritions->isEmpty()) {
                        $nutrition = new Nutrition();
                        $nutrition->setFruit($fruit);
                        $fruit->addNutrition($nutrition);

                        $this->entityManager->persist($nutrition);
                    } else {
                        $nutrition = $nutritions->first();
                    }
                    $nutrition->setCalories($fruitData['nutritions']['calories']);
                    $nutrition->setFat($fruitData['nutritions']['fat']);
                    $nutrition->setSugar($fruitData['nutritions']['sugar']);
                    $nutrition->setCarbohydrates($fruitData['nutritions']['carbohydrates']);
                    $nutrition->setProtein($fruitData['nutritions']['protein']);

                    $this->entityManager->flush();
                }

                $output->writeln('Fruit data fetched and updated in the database successfully!');
                // Send email notification
//                $this->emailService->sendEmailNotification('Fruit data fetched and updated in the database successfully!');

                 // Send email notification
//                $recipientEmail = getenv('NOTIFICATION_EMAIL');
                $subject = 'Fruit data fetched and updated in the database';
                $body = 'Fruit data fetched and updated in the database successfully!';

            } else {
                $output->writeln('Failed to fetch fruits data from external source. HTTP status code: ' . $response->getStatusCode());

                 // Send email notification
                 // Send email notification
//                $recipientEmail = getenv('NOTIFICATION_EMAIL');
                $subject = 'Failed to fetch fruits data from external source';
                $body = 'Failed to fetch fruits data from external source. HTTP status code: ' . $response->getStatusCode();

            }

            $this->emailService->sendEmail($subject, $body);
        } catch (\Exception $e) {
            // Handle exceptions that may occur during the HTTP request or database update
            $output->writeln('Failed to fetch or update fruits data. Exception: ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
