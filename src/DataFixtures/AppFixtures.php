<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Snippet;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        
        $user = new User();
        $user->setName('Test User');
        $user->setEmail('i@test.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));

        $manager->persist($user);
        $manager->flush();

        $snippet1 = new Snippet();
        $snippet1->setTitle('Test Snippet');
        $snippet1->setDescription('This is a test snippet content.');
        $snippet1->setCode('echo "Hello World!";');
        $snippet1->setAuthor($user);

        $snippet2 = new Snippet();
        $snippet2->setTitle('Another Test Snippet');
        $snippet2->setDescription('This is other test snippet content.');
        $snippet2->setCode('print_r($data)');
        $snippet2->setAuthor($user);

        $snippet3 = new Snippet();
        $snippet3->setTitle('Third Snippet with parent');
        $snippet3->setDescription('This is the third test snippet content.');
        $snippet3->setCode('var_dump($variable)');
        $snippet3->setAuthor($user);
        $snippet3->setParent($snippet1);

        $comment1 = new Comment();
        $comment1->setContent('This is a comment on the first snippet.');
        $comment1->setSnippet($snippet1);
        $comment1->setAuthor($user);

        $comment2 = new Comment();
        $comment2->setContent('This is a comment on the second snippet.');
        $comment2->setSnippet($snippet2);
        $comment2->setAuthor($user);

        $manager->persist($user);
        $manager->persist($snippet1);
        $manager->persist($snippet2);
        $manager->persist($snippet3);
        $manager->persist($comment1);
        $manager->persist($comment2);

        $manager->flush();
    }
}
