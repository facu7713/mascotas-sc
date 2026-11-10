<?php

namespace App\Command;

use App\Entity\Persona;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-particular',
    description: 'Crea un usuario particular de prueba.'
)]
class CreateParticularCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = 'particular@mascotassc.com';
        $dni = '23456789';

        // Verificar que el correo no esté registrado.
        if ($this->em->getRepository(User::class)->findOneBy(['email' => $email])) {
            $output->writeln('<error>Ya existe un usuario con ese correo.</error>');
            return Command::FAILURE;
        }

        // Verificar que el DNI no esté registrado.
        if ($this->em->getRepository(Persona::class)->findOneBy(['dni' => $dni])) {
            $output->writeln('<error>Ya existe una persona con ese DNI.</error>');
            return Command::FAILURE;
        }

        $persona = new Persona();
        $persona->setNombre('Usuario');
        $persona->setApellido('Particular');
        $persona->setDni($dni);
        $persona->setDireccion('Calle Falsa 456');
        $persona->setTelefono('3498123457');
        $persona->setFechaAlta(new \DateTimeImmutable());
        $persona->setActivo(true);

        $user = new User();
        $user->setEmail($email);
        $user->setPersona($persona);
        $user->setRoles(['ROLE_USER']);

        $password = $this->hasher->hashPassword($user, 'ParticularPrueba123');
        $user->setPassword($password);

        $this->em->persist($persona);
        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('<info>Usuario particular creado correctamente.</info>');
        $output->writeln('Correo: ' . $email);
        $output->writeln('Contraseña: ParticularPrueba123');

        return Command::SUCCESS;
    }
}
