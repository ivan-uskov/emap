<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SessionUserProvider implements UserProviderInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        /** @var null|User $user */
        $user = $this->em->getRepository(User::class)->findOneBy(['username' => $username]);
        if ($user === null)
        {
            throw new UsernameNotFoundException('');
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User)
        {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        /** @var null|User $updatedUser */
        $updatedUser = $this->em->getRepository(User::class)->findOneBy(['username' => $user->getUsername()]);
        if ($updatedUser === null)
        {
            throw new UsernameNotFoundException('');
        }

        return $updatedUser;
    }
}