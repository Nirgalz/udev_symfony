<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use AppBundle\Entity\Article;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Faker\Factory;



class CreateArticleCommand extends ContainerAwareCommand
{
    protected function configure()
    {

        $this
            ->setName('udev:create-article')
            ->setDescription('creates new Article')
            ->addOption(
                'number',
                'N',
                InputOption::VALUE_REQUIRED,
                'number to add'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getManager();

        $faker = Factory::create();

        $date = new \DateTime();

        //creates one entry if number option not used
        $num = 1;
        if (!empty($input->getOption('number')))
        {
            $num = (int)$input->getOption('number');
        }

            for ($i = 0; $i < $num; $i++) {

                $article = new Article();

                $article->setTitle($faker->firstName);
                $article->setContent($faker->sentence);
                $article->setDateWritten($date);
                $article->setUser(1);

                $entityManager->persist($article);
                $entityManager->flush();
                $output->writeln('Saved new article with id '.$article->getId());
            }

    }
}
