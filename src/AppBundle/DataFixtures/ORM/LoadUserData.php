<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\person;
use AppBundle\Entity\groups;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // create super admin
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername('admin');
        $user->setEmail('admin@admin');
        $user->setPlainPassword('admin');
        $user->setEnabled(true);
        $userManager->updateUser($user, true);

        // creating users
        for ($x = 1; $x <= 100; $x++) {
            $person = new person();
            $person->setFirstName('FirstName ' . $x);
            $person->setLastName('LastName' . $x);

            $manager->persist($person);
        }

        // creating groups
        for ($x = 1; $x <= 100; $x++) {
            $group = new groups();
            $group->setName('Group name ' . $x);

            $manager->persist($group);
        }

        $manager->flush();
    }
}