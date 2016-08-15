<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Repository;
use AppBundle\Entity\person;

class createPersonCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('person:create')
            ->setDescription('Creates new person.')
            ->addArgument('firstname', InputArgument::REQUIRED, 'The firstname of the person.')
            ->addArgument('lastname', InputArgument::REQUIRED, 'The lastname of the person.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $person = new person();
        $person->setFirstName($input->getArgument('firstname'));
        $person->setLastName($input->getArgument('lastname'));

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($person);
        $em->flush();

        $output->writeln('Created person ' . $input->getArgument('firstname') . ' ' . $input->getArgument('lastname'));
    }
}