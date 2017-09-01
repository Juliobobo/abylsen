<?php

namespace EasygestionBundle\DataFixtures\ORM;

use EasygestionBundle\Entity\Ia;
use EasygestionBundle\Entity\Besoin;
use EasygestionBundle\Entity\Client;



use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadData
 *
 * @package AppBundle\DataFixtures\ORM
 */
class LoadData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Admin
        $userAdmin = new Ia();
        $userAdmin->setUsername('Julien');
        $userAdmin->setPlainPassword('root');
        $userAdmin->setEmail('julien.diemert@abylsen.com');
        $userAdmin->setEnabled(true);
        $userAdmin->setRoles(array('ROLE_ADMIN'));
        $userAdmin->setInitials('jdi');
        $manager->persist($userAdmin);
        
        $userAdmin1 = new Ia();
        $userAdmin1->setUsername('Pascal');
        $userAdmin1->setPlainPassword('root');
        $userAdmin1->setEmail('pascal.panek@abylsen.com');
        $userAdmin1->setEnabled(true);
        $userAdmin1->setRoles(array('ROLE_ADMIN'));
        $userAdmin1->setInitials('ppa');
        $manager->persist($userAdmin1);

        // User
        /*$user1 = new Ia();
        $user1->setUsername('killian');
        $user1->setPlainPassword('user');
        $user1->setEmail('killian.sublet@abylsen.com');
        $user1->setEnabled(true);
        $user1->setRoles(array('ROLE_USER'));
        $user1->setInitials('ksu');
        $manager->persist($user1);
        
        // Clients
        $client1 = new Client();
        $client1->setName('sncf');
        $manager->persist($client1);
        
        $client2 = new Client();
        $client2->setName('cgi');
        $manager->persist($client2);
        
        $client3 = new Client();
        $client3->setName('groupama');
        $manager->persist($client3);
        
        $client4 = new Client();
        $client4->setName('OBS Lyon');
        $manager->persist($client4);
        
        // Besoins
        $now = new \DateTime();
        for ($i = 1; $i <= 100; $i++) {
            /** @var Post[] $post */
            /*$besoin[$i] = new Besoin();
            $besoin[$i]->setStatus(rand(0, 1));
            $besoin[$i]->setPriority(rand(1, 3));
            $besoin[$i]->setDateCreation($now);
            $besoin[$i]->setStart($now);
            $besoin[$i]->setDuration(rand(1,24));
            $besoin[$i]->setArchive(rand(0,1));
            
            if (rand(0, 1)) {
                if (rand(0, 1)) {
                    $besoin[$i]->setClient($client1);
                } else {
                    $besoin[$i]->setClient($client2);
                }
            } else {
                if (rand(0, 1)) {
                    $besoin[$i]->setClient($client3);
                } else {
                    $besoin[$i]->setClient($client4);
                }
            }
            
            if (rand(0, 1)) {
                $besoin[$i]->setCreatedBy($user1);
            } else {
                $besoin[$i]->setCreatedBy($userAdmin);
            }
            
            $manager->persist($besoin[$i]);
        }*/
        
        $manager->flush();
    }


}
