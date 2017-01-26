<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 26/01/17
 * Time: 11:55
 */

namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserAddRoleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('app:user:role:add')
            ->setDescription('Add role to an user')
            ->addArgument('username', InputArgument::REQUIRED, 'Define username')
            ->addArgument('role', InputArgument::REQUIRED, 'Define role')
        ;

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $role = $input->getArgument('role');

        // Permet d'avoir accès aux services de Symfony et du coup à Doctrine par exemple
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $em = $doctrine->getManager();

        $rcUser = $doctrine->getRepository('AppBundle:User')->findOneBy([
                'username' => $username
            ]);
        $rcRole = $doctrine->getRepository('AppBundle:Role')->findOneBy([
           'name' => 'ROLE_' . strtoupper($role)
            ]);

        $rcUser->addRole($rcRole);

        $em->persist($rcUser);
        $em->flush();

        $output->writeln("$username // $role");

        // En commentaire, car cela hérite de la méthode parent qui dit de tout supprimer
/*        parent::execute($input, $output);*/
    }

}