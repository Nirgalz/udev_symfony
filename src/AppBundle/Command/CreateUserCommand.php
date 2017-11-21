<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Faker\Factory;



class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {

        $this
            ->setName('udev:create-users')
            ->setDescription('creates new Users')
            ->addArgument(
                'username'
            )
            ->addArgument(
                'login'
            )
            ->addArgument(
                'email'
            )
            ->addArgument(
                'password'
            )
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
        //condition for username etc parameters given -> created a custom entry
        if ($input->getArgument('username') != null )
        {
            $user = new User();
            $user->setUsername($input->getArgument('username'));
            $user->setLogin($input->getArgument('login'));
            $user->setEmail($input->getArgument('email'));
            $user->setPassword($input->getArgument('password'));
            $user->setDateReg($date);

            $entityManager->persist($user);
            $entityManager->flush();
            $output->writeln('Saved new product with id '.$user->getId());
        }
        // creates N random entries
        else
        {
            for ($i = 0; $i < $num; $i++) {

                $user = new User();

                $user->setUsername($faker->firstName);
                $user->setLogin($faker->userName);
                $user->setDateReg($date);
                $user->setEmail($faker->email);
                $user->setPassword($faker->password());

                $entityManager->persist($user);
                $entityManager->flush();
                $output->writeln('Saved new product with id '.$user->getId());
            }
        }
    }
}
