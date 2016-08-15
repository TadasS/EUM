<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Repository;
use AppBundle\Entity\groups;

class createGroupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('group:create')
            ->setDescription('Creates new group.')
            ->addArgument('name', InputArgument::REQUIRED, 'Group name.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $group = new groups();
        $group->setName($input->getArgument('name'));

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($group);
        $em->flush();

        $output->writeln('Created group ' . $input->getArgument('name'));
    }
}