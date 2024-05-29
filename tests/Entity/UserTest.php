<?php
// tests/Entity/UserTest.php
namespace App\Tests\Entity;

use App\Entity\Subscription;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetterAndSetter()
    {
        // Création d'une instance de l'entité User
        $user = new User();
        $subscription = new Subscription();
        $datetime = new \DateTimeImmutable();

        // Définition de données de test
        $email = 'test@test.com';
        $firstname = 'prénom';
        $lastname = 'nom';
        $password = random_bytes(12);
        $createdAt = $datetime->format('d/m/Y');
        $updatedAt = $datetime->format('d/m/Y');

        // Utilisation des setters
        $user->setEmail($email);
        $user->setSubscription($subscription);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPassword($password);
        $user->setCreatedAt($createdAt);
        $user->setUpdatedAt($updatedAt);

        // Vérification des getters
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($subscription, $user->getSubscription());
        $this->assertEquals($firstname, $user->getFirstname());
        $this->assertEquals($lastname, $user->getLastname());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($createdAt, $user->getCreatedAt());
        $this->assertEquals($updatedAt, $user->getUpdatedAt());

    }
}