<?php

namespace Blogger\BlogBundle\DataFixtures\ORM;


use BlogBundle\Entity\Users;
use Doctrine\Common\DataFixtures\FixtureInterface;
use BlogBundle\Entity\Role;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class FixtureLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // создание роли ROLE_ADMIN
        $role = new Role();
        $role->setName('ROLE_ADMIN');
        $manager->persist($role);

        // создание пользователя
        $user = new Users();
        $user->setFirstname('John');
        $user->setLastname('Doe');
        $user->setSex('M');
        $user->setAge(new \DateTime("11-11-1990"));
        $user->setEmail('john@example.com');
        $user->setUsername('john.doe');
        $user->setSalt(md5(time()));

        // шифрует и устанавливает пароль для пользователя,
        // эти настройки совпадают с конфигурационными файлами
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword('admin', $user->getSalt());
        $user->setPassword($password);

        $user->getUserRoles()->add($role);

        $manager->persist($user);

        $manager->flush();

    }
}