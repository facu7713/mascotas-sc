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
    name: 'app:create-admin',
    description: 'Crea un usuario administrador de prueba.'
)]
class CreateAdminCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new \Symfony\Component\Console\Style\SymfonyStyle($input, $output);

        $email = 'admin@mascotassc.com';

        // Evitar crear la misma cuenta dos veces.
        $existente = $this->em->getRepository(User::class)
            ->findOneBy(['email' => $email]);

        if ($existente !== null) {
            $io->warning('La cuenta administradora ya existe.');
            return Command::SUCCESS;
        }

        // Crear Persona.
        $persona = new Persona();
        $persona->setNombre('Administrador');
        $persona->setApellido('Mascotas SC');
        $persona->setDni('12345678');
        $persona->setDireccion('Av. Principal 123');
        $persona->setTelefono('3498123456');
        $persona->setFechaAlta(new \DateTimeImmutable());
        $persona->setActivo(true);

        // Crear User.
        $user = new User();
        $user->setEmail($email);
        $user->setPersona($persona);
        $user->setRoles(['ROLE_ADMIN']);

        // Contraseña de prueba.
        $password = $this->hasher->hashPassword(
            $user,
            'AdminPrueba123'
        );

        $user->setPassword($password);

        // Guardar entidades.
        $this->em->persist($persona);
        $this->em->persist($user);
        $this->em->flush();

        $io->success('Usuario administrador creado correctamente.');

        $io->table(
            ['Dato', 'Información'],
            [
                ['Nombre', 'Administrador Mascotas SC'],
                ['Correo', $email],
                ['Contraseña de prueba', 'AdminPrueba123'],
                ['Rol', 'ROLE_ADMIN'],
            ]
        );

        return Command::SUCCESS;
    }
}
