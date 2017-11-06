<?php

namespace Mkk\SiteBundle\Command;

use Mkk\SiteBundle\Lib\ContainerAwareCommandLib;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SuperAdminCreateCommand extends ContainerAwareCommandLib
{
    /**
     * Commande qui l'identifie.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('mkk:superadmin:create');
        $this->setDescription('Create a user.');
        $this->setDefinition(
            [
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
            ]
        );
    }

    /**
     * Execution de la commande.
     *
     * @param InputInterface  $input  input
     * @param OutputInterface $output output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->initCommand();
        $username        = $input->getArgument('username');
        $email           = $input->getArgument('email');
        $password        = $input->getArgument('password');
        $userManager     = $this->container->get('bdd.user_manager');
        $userRepository  = $userManager->getRepository();
        $userTable       = $userManager->getTable();
        $groupManager    = $this->container->get('bdd.group_manager');
        $groupRepository = $groupManager->getRepository();
        $superadmin      = $groupRepository->findoneby(['code' => 'superadmin']);
        if (! $superadmin) {
            return;
        }

        $user = $userRepository->findoneby(['username' => $username]);
        if (! $user) {
            $user = new $userTable();
        }

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled(1);
        $user->setRefGroup($superadmin);
        $user->setPlainPassword($password);
        $userManager->persistAndFlush($user);
        $output->writeln('Utilisateur enregistré dans la base de données');
    }
}
